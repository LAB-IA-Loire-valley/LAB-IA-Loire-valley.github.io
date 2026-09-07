#!/usr/bin/env python3
"""Scrape les actualités Wix (SSR, sans JS) -> actualites-full.json."""
import html as H
import json
import re
import sys
import urllib.request

ACTU_URL = "https://www.labia-loirevalley.fr/actualit%C3%A9"
UA = {"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/120 Safari/537.36"}

MONTHS = {
    "janvier": 1, "février": 2, "fevrier": 2, "mars": 3, "avril": 4,
    "mai": 5, "juin": 6, "juillet": 7, "août": 8, "aout": 8,
    "septembre": 9, "octobre": 10, "novembre": 11, "décembre": 12, "decembre": 12,
}

SKIP_IMG = ("LOGO_LABIA_Q_S-BASELINE", "PICTO_", "logo-osez-ia")
TAG_RE = re.compile(r"<[^>]+>")


def strip_tags(s):
    return H.unescape(TAG_RE.sub("", s)).strip()


def parse_fr_date(raw):
    d = H.unescape(strip_tags(raw)).strip().lower().replace("1er ", "1 ")
    day, month, year = d.split()
    return f"{int(year):04d}-{MONTHS[month]:02d}-{int(day):02d} 10:00:00"


def clean_html(fragment):
    """Garde p/ul/ol/li/a/br/strong/em, jette spans/styles, ignore paragraphes vides."""
    parts = []
    for m in re.finditer(
        r'<p class="font_8[^"]*"[^>]*>(.*?)</p>|(<ul.*?</ul>)|(<ol.*?</ol>)',
        fragment, re.S,
    ):
        chunk = m.group(0)
        if chunk.startswith("<p"):
            inner = m.group(1)
            inner = re.sub(r"</?(span|font|div)[^>]*>", "", inner)
            inner = re.sub(r"\s(style|class|id|data-[a-z-]+)=\"[^\"]*\"", "", inner)
            text = H.unescape(TAG_RE.sub("", inner)).replace("\u200b", "").replace("\xa0", "").strip()
            if not text:
                continue
            parts.append(f"<p>{inner.strip()}</p>")
        else:
            inner = re.sub(r"</?(span|font)[^>]*>", "", chunk)
            inner = re.sub(r"\s(style|class|id|data-[a-z-]+)=\"[^\"]*\"", "", inner)
            parts.append(inner)
    return "".join(parts)


def original_media_url(wix_url):
    m = re.search(r"(https://static\.wixstatic\.com/media/[^/]+)/v1/", wix_url)
    return m.group(1) if m else wix_url


def main(out_path):
    req = urllib.request.Request(ACTU_URL, headers=UA)
    src = urllib.request.urlopen(req, timeout=60).read().decode("utf-8")
    sections = re.findall(
        r'<section[^>]*class="[^"]*wixui-section"[^>]*>(.*?)</section>', src, re.S
    )
    articles, skipped = [], []
    for s in sections:
        m_date = re.search(r"<h6[^>]*>(.*?)</h6>", s, re.S)
        if not m_date:
            continue  # sections 0-1 = header, sans date
        try:
            date = parse_fr_date(m_date.group(1))
        except (ValueError, KeyError):
            skipped.append(("bad-date", strip_tags(m_date.group(1))[:60]))
            continue
        m_title = re.search(r"<h5[^>]*>(.*?)</h5>", s, re.S)
        if not m_title:
            m_title = re.search(r'<h1[^>]*class="[^"]*font_0[^"]*"[^>]*>(.*?)</h1>', s, re.S)
        if m_title:
            title = strip_tags(m_title.group(1))
        else:
            h6s = re.findall(r"<h6[^>]*>(.*?)</h6>", s, re.S)
            if len(h6s) < 2:
                skipped.append((date, "no-title"))
                continue
            title = strip_tags(h6s[1])
        content = clean_html(s)
        imgs = []
        for u in re.findall(r'<img[^>]+src="(https://static\.wixstatic\.com/media/[^"]+)"', s):
            if any(k in u for k in SKIP_IMG):
                continue
            full = original_media_url(u)
            if full not in imgs:
                imgs.append(full)
        pdfs = sorted(set(
            u for u in re.findall(r'href="([^"]+\.pdf[^"]*)"', s)
            if "_files/ugd" in u
        ))
        articles.append({
            "title": title, "date": date, "content_html": content,
            "images": imgs, "pdfs": pdfs,
        })
    articles.sort(key=lambda x: x["date"], reverse=True)
    with open(out_path, "w", encoding="utf-8") as f:
        json.dump(articles, f, ensure_ascii=False, indent=1)
    print(f"articles={len(articles)} skipped={len(skipped)}")
    for why, info in skipped:
        print(f"  SKIP [{why}] {info}")


if __name__ == "__main__":
    main(sys.argv[1] if len(sys.argv) > 1 else
         "wordpress-dev/theme/import-data/actualites-full.json")

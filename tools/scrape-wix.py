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


def clean_title(raw):
    """Normalise un titre: retire U+200B, U+00A0 -> espace, aplatit les espaces/tabulations."""
    s = strip_tags(raw)
    s = s.replace("\u200b", "")
    s = s.replace("\xa0", " ")
    s = re.sub(r"[ \t]+", " ", s)
    return s.strip()


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
            title = clean_title(m_title.group(1))
        else:
            h6s = re.findall(r"<h6[^>]*>(.*?)</h6>", s, re.S)
            if len(h6s) < 2:
                skipped.append((date, "no-title"))
                continue
            title = clean_title(h6s[1])
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


PRESS_URL = "https://www.labia-loirevalley.fr/presse"

SOURCE_MAP = [
    ("epicentre", "L'Épicentre"), ("actu.fr", "Actu.fr"),
    ("france 3", "France 3 Centre-Val de Loire"), ("france bleu", "France Bleu"),
    ("république du centre", "La République du Centre"),
    ("usine nouvelle", "L'Usine Nouvelle"), ("vibration", "Forum Vibration"),
    ("voxradio", "VoxRadio"), ("chérie fm", "Chérie FM Tours"),
    ("panorama", "Panorama des entreprises du Loiret"),
    ("acteurs de l'éco", "Acteurs de l'Éco"),
]

RANGE_RE = re.compile(r"^([a-zéû]+)\s*-\s*([a-zéû]+)\s+(\d{4})$")


def parse_presse_date(raw):
    d = H.unescape(strip_tags(raw)).strip().lower()
    m = RANGE_RE.match(d)  # ex. "mai - juin 2024" -> 1er du 1er mois
    if m:
        return f"{int(m.group(3)):04d}-{MONTHS[m.group(1)]:02d}-01 10:00:00"
    return parse_fr_date(d)


def scrape_presse(out_path):
    req = urllib.request.Request(PRESS_URL, headers=UA)
    src = urllib.request.urlopen(req, timeout=60).read().decode("utf-8")
    sections = re.findall(
        r'<section[^>]*class="[^"]*wixui-section"[^>]*>(.*?)</section>', src, re.S
    )
    # Sections 2-12 = articles propres (1 h5 + 1 h6 date). Les sections 0-1
    # (header) et 13-18 (articles groupés/anciens vidéos, déjà dans presse.json)
    # ne sont pas scrapées : un titre tronqué créerait des quasi-doublons.
    sections = sections[2:13]
    articles = []
    for s in sections:
        h5s = re.findall(r"<h5[^>]*>(.*?)</h5>", s, re.S)
        m_date = re.search(r"<h6[^>]*>(.*?)</h6>", s, re.S)
        if len(h5s) != 1 or not m_date:
            continue  # header (0 h5) ou sections groupées (13/17/18)
        try:
            date = parse_presse_date(m_date.group(1))
        except (ValueError, KeyError):
            continue
        title = clean_title(h5s[0])
        # Apostrophes courbes (U+2019/U+2018) -> apostrophes droites : les
        # titres existants en base (presse.json/port statique) utilisent le
        # droit, on évite des quasi-doublons ("L'innovation" == post 23).
        title = title.replace("\u2019", "'").replace("\u2018", "'")
        paras = [
            H.unescape(TAG_RE.sub("", p)).replace("\u200b", "").replace("\xa0", "").strip()
            for p in re.findall(r"<p[^>]*>(.*?)</p>", s, re.S)
        ]
        paras = [p for p in paras if p]
        excerpt = (paras[0][:300] + "…") if paras and len(paras[0]) > 300 else (paras[0] if paras else "")
        blob = (title + " " + " ".join(paras)).lower()
        source = ""
        for key, label in SOURCE_MAP:
            if key in blob:
                source = label
                break
        urls = [
            u for u in re.findall(r'href="([^"]+)"', s)
            if u.startswith("http") and "wixstatic" not in u
            and "labia-loirevalley.fr/_files" not in u
        ]
        pdfs = sorted(set(
            u for u in re.findall(r'href="([^"]+\.pdf[^"]*)"', s)
            if "_files/ugd" in u or "static.wixstatic.com/ugd" in u
        ))
        articles.append({
            "title": title, "date": date, "source": source,
            "url": urls[0] if urls else "", "excerpt": excerpt, "pdfs": pdfs,
        })
    with open(out_path, "w", encoding="utf-8") as f:
        json.dump(articles, f, ensure_ascii=False, indent=1)
    print(f"presse articles={len(articles)}")


if __name__ == "__main__":
    if "--presse" in sys.argv:
        scrape_presse("wordpress-dev/theme/import-data/presse-full.json")
    else:
        main(sys.argv[1] if len(sys.argv) > 1 else
             "wordpress-dev/theme/import-data/actualites-full.json")

#!/usr/bin/env python3
"""Upload FTP récursif et résumable vers l'hébergement OVH.

Aucun credential dans le code : tout passe par des variables d'environnement.

    OVH_FTP_HOST    (défaut: ftp.cluster131.hosting.ovh.net)
    OVH_FTP_USER    (défaut: savqafo)
    OVH_FTP_PASS    (obligatoire)
    OVH_FTP_EXCLUDE (optionnel) : motifs fnmatch supplémentaires, séparés par des virgules

Usage:
    OVH_FTP_PASS=... uv run tools/upload.py <local_dir> <remote_dir> [--dry-run]

Exemple (thème seul) :
    OVH_FTP_PASS=... uv run tools/upload.py \
        wordpress-dev/theme www/wp-content/themes/labia-wp

Exclusions par défaut (fichiers de dev du thème, jamais déployés) :
    preview-*.html, import-data/*, inc/import-from-wix.php,
    inc/migrate-news-images.php, assets/css/style.css, *:Zone.Identifier

Le script skippe un fichier si sa taille distante est identique (résumable),
crée les dossiers distants manquants, et n'écrit jamais de secret sur disque.
`--dry-run` liste ce qui serait envoyé, sans connexion FTP.
"""

import fnmatch
import os
import sys
import ftplib
from pathlib import Path

HOST = os.environ.get("OVH_FTP_HOST", "ftp.cluster131.hosting.ovh.net")
USER = os.environ.get("OVH_FTP_USER", "savqafo")
PASS = os.environ.get("OVH_FTP_PASS")

DEFAULT_EXCLUDES = (
    "preview-*.html",
    "import-data/*",
    "inc/import-from-wix.php",
    "inc/migrate-news-images.php",
    "assets/css/style.css",
    "*:Zone.Identifier",
)


def is_excluded(rel, patterns):
    """Vrai si le chemin relatif (posix) matche un motif d'exclusion."""
    for pat in patterns:
        if fnmatch.fnmatch(rel, pat):
            return True
        # "dossier/*" exclut aussi tout le contenu imbriqué
        if pat.endswith("/*") and rel.startswith(pat[:-1]):
            return True
    return False


def connect():
    ftp = ftplib.FTP()
    ftp.connect(HOST, 21, timeout=60)
    ftp.login(USER, PASS)
    ftp.set_pasv(True)
    return ftp


def ensure_dir(ftp, remote_dir):
    """Crée remote_dir (chemin relatif à la racine FTP), laisse le cwd à la racine."""
    parts = [p for p in remote_dir.replace("\\", "/").split("/") if p]
    ftp.cwd("/")
    for part in parts:
        try:
            ftp.cwd(part)
        except ftplib.error_perm:
            try:
                ftp.mkd(part)
            except ftplib.error_perm:
                pass
            ftp.cwd(part)
    ftp.cwd("/")


def remote_size(ftp, remote_path):
    try:
        ftp.cwd("/")
        ftp.voidcmd("TYPE I")
        return ftp.size(remote_path)
    except ftplib.all_errors:
        return None


def remote_exists(ftp, remote_path):
    return remote_size(ftp, remote_path) is not None


def main():
    dry_run = "--dry-run" in sys.argv
    args = [a for a in sys.argv[1:] if a != "--dry-run"]
    if len(args) != 2:
        sys.exit(__doc__)

    local_root = Path(args[0]).resolve()
    remote_root = args[1].rstrip("/")
    if not local_root.is_dir():
        sys.exit(f"Dossier local introuvable: {local_root}")

    patterns = DEFAULT_EXCLUDES + tuple(
        p.strip() for p in os.environ.get("OVH_FTP_EXCLUDE", "").split(",") if p.strip()
    )
    files = []
    excluded = 0
    for path in sorted(p for p in local_root.rglob("*") if p.is_file()):
        rel = path.relative_to(local_root).as_posix()
        if is_excluded(rel, patterns):
            excluded += 1
            continue
        files.append(path)
    print(f"{excluded} fichier(s) dev exclu(s) ; {len(files)} à examiner -> {remote_root}")

    if dry_run:
        for path in files:
            print("  ·", path.relative_to(local_root).as_posix())
        sys.exit(0)

    if not PASS:
        sys.exit("OVH_FTP_PASS manquant dans l'environnement.")

    ftp = connect()
    uploaded = skipped = failed = 0
    for i, path in enumerate(files, 1):
        rel = path.relative_to(local_root).as_posix()
        remote_path = f"{remote_root}/{rel}"
        remote_dir = remote_path.rsplit("/", 1)[0]

        size = path.stat().st_size
        if remote_size(ftp, remote_path) == size and size > 0:
            skipped += 1
            continue

        try:
            ensure_dir(ftp, remote_dir)
            with path.open("rb") as fh:
                ftp.storbinary(f"STOR {remote_path}", fh, blocksize=65536)
            uploaded += 1
            print(f"[{i}/{len(files)}] ↑ {rel}")
        except ftplib.all_errors as exc:
            failed += 1
            print(f"[{i}/{len(files)}] ✗ {rel} -> {exc}")

    ftp.quit()
    print(f"\nTerminé: {uploaded} uploadés, {skipped} skippés, {failed} échecs.")
    sys.exit(1 if failed else 0)


if __name__ == "__main__":
    main()

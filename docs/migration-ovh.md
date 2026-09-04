# Migration LAB'IA Loire Valley vers OVH

Migration du site WordPress (serveur docker `10.0.18.215:8765`) vers l'hébergement mutualisé OVH.
Date : 2026-09-03

## État final

- **URL temporaire** : http://savqafo.cluster131.hosting.ovh.net
- **Hébergement** : OVH, cluster131 — FTP `ftp.cluster131.hosting.ovh.net` (user `savqafo`)
- **Base de données** : `savqafoadmin` (user `savqafoadmin`, host `savqafoadmin.mysql.db` — réseau interne OVH, pas `localhost`)
- **Site vérifié** : 0 erreur PHP, permaliens OK, wp-admin OK, thème + CMB2 actifs
- **Domaine `labia-loirevalley.fr`** : pas encore pointé (en cours) — voir « Reprendre plus tard »

## Ce qui a été fait

### 1. Récupération depuis le serveur docker (10.0.18.215)

```bash
# Fichiers WP (volume docker labia_wp_wpdata), thème exclu (bind mount)
ssh -p 43 -i ~/.ssh/id_monitoring selim@10.0.18.215 \
  "docker exec labia_wp tar czf - -C /var/www/html --exclude=wp-content/themes/labia-wp ." > wpdata.tar.gz

# Dump DB
ssh -p 43 -i ~/.ssh/id_monitoring selim@10.0.18.215 \
  "docker exec labia_wpdb mysqldump -u wp -pwppass wordpress" > labia-import.sql

# Thème : celui du repo git local (plus récent que celui du serveur : footer/spacing)
# Copié dans wp-content/themes/labia-wp, SANS import-data/ ni import-from-wix.php (outils de dev)
```

**Points notables sur l'ancien serveur :**
- Le plugin **CMB2 n'était pas installé** (seulement akismet) → les metaboxes admin ne fonctionnaient pas ; le contenu existait quand même en DB (postmeta)
- Pas de dossier `wp-content/uploads` (aucune médiathèque)

### 2. Préparation du bundle (dossier `/tmp/opencode/labia-ovh/`)

- `wp-config.php` généré depuis le sample avec :
  - `DB_NAME`/`DB_USER` : `savqafoadmin`, `DB_PASSWORD` : mot de passe FTP, `DB_HOST` : **`savqafoadmin.mysql.db`** (⚠️ pas `localhost` ni `127.0.0.1` — échec socket/timeout)
  - Sels d'auth frais via `https://api.wordpress.org/secret-key/1.1/salt/`
  - `WP_DEBUG false`, `WP_MEMORY_LIMIT 256M`
- Plugin **CMB2** téléchargé : `https://downloads.wordpress.org/plugin/cmb2.latest-stable.zip` → `wp-content/plugins/cmb2`
- Dump SQL préparé (`labia-import.sql`) :
  - `siteurl` + `home` : `http://10.0.18.215:8765` → `http://savqafo.cluster131.hosting.ovh.net`
  - 2 `guid` de news corrigés pareillement
  - `active_plugins` : `a:0:{}` → `a:1:{i:0;s:4:"cmb2";}` (activation CMB2)

### 3. Upload FTP

- Script `upload.py` (Python stdlib `ftplib`, exécuté avec **`uv run upload.py`**) : upload récursif, résumable (skip si taille distante identique)
- `www/` contenait un symlink `index.html` (welcome OVH) → supprimé sinon il prend le dessus sur `index.php`
- **Glitch OVH** : le proxy FTP rejette le fichier `wp-includes/js/mediaelement/mediaelement.min.js` (erreur `451 Transfer aborted`, 0 octet stocké, même via curl, contenu pourtant propre). Contournement : ajout d'un préfixe de commentaire `/* upload labia */` (19 octets) — upload OK. Sans impact sur le JS.

### 4. Import DB

- Script temporaire `import.php` uploadé dans `www/` (protégé par token `?key=...`) + `labia-import.sql` à côté
- `mysqli` multi-query → **12 tables, 88 posts importés**
- ⚠️ Découverte : `localhost` = socket inexistant, `127.0.0.1`/`sql.cluster131.hosting.ovh.net` = timeout → seul `savqafoadmin.mysql.db` marche (résolvable uniquement depuis l'hébergement, réseau privé OVH)
- Script + SQL **supprimés du FTP** immédiatement après

### 5. Vérifications

- Homepage : HTTP 200, titre OK, sections CPT rendues (solutions, 6 étapes, témoignages), CSS chargé, 0 erreur PHP
- `/qui-sommes-nous/`, `/actualites/` : 200 (permaliens + `.htaccess` OK)
- `wp-admin` : login OK
- Mise à jour auto WP déclenchée au 1er chargement (`.maintenance` temporaire → WP s'est auto-mis à jour) — normal, ne pas s'inquiéter

## Reprendre plus tard

### Quand `labia-loirevalley.fr` est prêt (DNS)

1. **OVH Manager → Hébergement → Multisite / Domaines** : ajouter `labia-loirevalley.fr` (si le domaine est chez OVH, il s'attache directement)
2. **DNS** : si le domaine est externe, pointer les A records vers `cluster131.hosting.ovh.net` (IP 146.59.209.152) + CNAME si besoin (www, etc.)
3. **Mettre à jour l'URL dans la DB** (sinon les liens internes restent sur l'URL temporaire) :
   ```sql
   UPDATE wp_options SET option_value='https://labia-loirevalley.fr' WHERE option_name IN ('siteurl','home');
   ```
   (via phpMyAdmin OVH : https://phpmyadmin.ovh.net, ou script temporaire comme à l'étape 4)
4. Passer le site en HTTPS : OVH fournit le certificat SSL auto pour le domaine
5. Vérifier la redirection http → https et re-tester wp-admin

### Rappels utiles

- **Admin WP** : identifiants identiques à l'ancien serveur (`admin` / `adminpass` — à changer !)
- **PhpMyAdmin OVH** : https://phpmyadmin.ovh.net (user `savqafoadmin`)
- **Fichiers** : les modifications de thème se font dans le repo (`wordpress-dev/theme/`), puis upload vers `www/wp-content/themes/labia-wp/` via FTP
- **L'ancien serveur (10.0.18.215) tourne toujours** → fallback possible en cas de problème
- Si un jour le FTP rejette un fichier avec `451` : ajouter un préfixe de commentaire inoffensif et re-uploader

## Fichiers de travail (temporaires, dans /tmp/opencode/labia-ovh/)

- `wpdata/` : bundle WP complet prêt à uploader (wp-config OVH inclus)
- `labia-import.sql` : dump nettoyé (URL OVH + CMB2 actif)
- `upload.py` : script d'upload FTP résumable (à relancer avec `uv run upload.py`)
- `wpdata.tar.gz` : archive WP brute du serveur
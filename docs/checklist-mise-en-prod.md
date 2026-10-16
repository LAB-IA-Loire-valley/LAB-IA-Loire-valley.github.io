# Checklist de mise en prod — labia-loirevalley.fr

État au **2026-10-16** — ✅ **site en ligne sur https://labia-loirevalley.fr** (base migrée, thème + durcissement déployés, `www` attaché et redirigé en 301). Reste : mail (SMTP Google), admin, nettoyages mineurs. Canonical : **https://labia-loirevalley.fr** (sans www — `www` redirigé en 301).
Site WordPress sur OVH cluster131 (URL temporaire : `http://savqafo.cluster131.hosting.ovh.net`), thème `labia-wp`.
**DNS / HTTPS / mail : côté Selim.**

---

## ✅ Fait / préparé (vérifié)

### Site & thème
- Thème prod = repo (MD5 `style.css`/`main.js` identiques) ; 0 erreur PHP ; pages principales 200.
- Templates `404` / `page` / `search` / `archive` créés, `index.php` nettoyé ; 404 enrichie et vérifiée (desktop/mobile, 0 débordement horizontal).
- Images Wix sécurisées : badge « Osez l'IA » + 2 bandeaux financeurs en local dans le thème (`assets/img/`, fallbacks `footer.php`/`section-hero.php`).
- 3 PDFs presse prêts dans `wordpress-dev/wix-assets/ugd/`.
- `tools/upload.py` : exclusions dev par défaut + `--dry-run` (testé : 13 exclus / 0 dans le plan).

### Sécurité (préparé le 2026-10-14)
- **Audit du thème : safe to ship** — échappements systématiques, nonce/honeypot/rate-limit OK, pas de SQL direct, pas d'`eval`/`exec`, pas de secret, fichiers dev non exécutables.
- Correctifs appliqués : `absint()` sur les dates de méta (`single.php`, `template-presse.php`) ; champs CMB2 Financeurs/Badge passés en `'url' => false` (cohérents avec les autres champs `file`).
- **`wordpress-dev/mu-plugins/labia-security.php`** (nouveau, testé en local) : bloque l'énumération utilisateurs (REST `/wp/v2/users` → 404, `?author=N` → 301 accueil, sitemap sans auteurs), désactive XML-RPC/pingbacks, retire `X-Pingback`, `DISALLOW_FILE_EDIT`.
- **`.htaccess` durci** (bloc §6, testé en local) : exécution PHP bloquée dans `uploads/`, listing de répertoires bloqué (constat : `/wp-content/uploads/` était **listable** en prod), `xmlrpc.php` + `readme.html`/`license.txt` bloqués, en-têtes de sécurité (nosniff, X-Frame-Options, Referrer-Policy, Permissions-Policy, HSTS, `X-Powered-By` retiré).
- État WP prod : **WordPress 7.1.3 = dernière version** (auto-updates) ; PHP 8.2 ; `xmlrpc.php` était actif (POST 200) et l'utilisateur `admin` était énumérable (REST + `?author=1`) → corrigés par le mu-plugin + `.htaccess`.

### DNS / HTTPS — bascule faite le 2026-10-15 (vérifiée)
- Zone DNS OVH à jour : `A @`/`A www` → `146.59.209.152`, MX Google ×5, SPF + TXT vérif Google, `autodiscover → autodiscover.google.com`, AAAA `2001:41d0:301::31` (ajouté par la config auto OVH) ; anciens enregistrements OVH supprimés.
- NS basculés : `dns13.ovh.net` + `ns13.ovh.net` — **propagation complète** (vérifié sur le résolveur local `10.255.255.254`, `1.1.1.1` et l'autoritaire `dns13.ovh.net`).
- Site attaché (dossier `www`) : `http://labia-loirevalley.fr` sert le WordPress (301 vers l'URL temp tant que `siteurl` n'est pas à jour — normal).
- **`www` attaché le 16/10** (via « Ajouter un domaine », ~6 min de propagation) : `http://www…` → 301 → `https://labia-loirevalley.fr` ✅. **SSL `www` émis automatiquement le 16/10** (~1 h après l'ajout) : cert `CN=www.labia-loirevalley.fr` ✅.

---

## 🔴 Reste à faire

### 0. Déployer (thème + mu-plugin + PDFs) — ✅ fait le 2026-10-15

Déployé via FTP : thème (14 fichiers), `labia-security.php`, 3 PDFs presse — 0 échec. Commandes de référence :

```bash
OVH_FTP_PASS=... uv run tools/upload.py wordpress-dev/theme www/wp-content/themes/labia-wp --dry-run
OVH_FTP_PASS=... uv run tools/upload.py wordpress-dev/theme www/wp-content/themes/labia-wp
OVH_FTP_PASS=... uv run tools/upload.py wordpress-dev/mu-plugins www/wp-content/mu-plugins
OVH_FTP_PASS=... uv run tools/upload.py wordpress-dev/wix-assets www/_files
```

Les fichiers dev (`preview-*.html`, `import-data/*`, `inc/import-from-wix.php`, `assets/css/style.css`) sont exclus automatiquement du déploiement.

### 1. DNS + HTTPS (Selim) — ✅ bascule faite le 15/10, 1 point restant

- [x] Zone DNS OVH mise à jour : `A @`/`A www` → `146.59.209.152`, MX Google ×5 (10/20/30/40/50), SPF + `google-site-verification`, `autodiscover → autodiscover.google.com` ; anciens enregistrements OVH supprimés (MX mx3/mx4, SRV, autoconfig, `"3|welcome"`, `ftp`) — OVH a ajouté `AAAA @ → 2001:41d0:301::31` (config auto).
- [x] Serveurs DNS : `dns13.ovh.net` + `ns13.ovh.net` (délégation OK, propagation complète vérifiée).
- [x] Domaine attaché au site (dossier racine `www`).
- [x] **SSL domaine** : activé le 15/10 — cert Let's Encrypt `CN=labia-loirevalley.fr` (émis le 15/10 11:33, expire le 13/01/2027 ; renouvellement auto OVH). HTTPS vérifié ✅.
- [x] **`www` attaché le 16/10** (Hébergements → Mes sites → ⁝ → « Ajouter un domaine » → associer `labia-loirevalley.fr` — `www` auto-ajouté ; ne PAS passer par « Créer un sous-domaine »). Vérifié : `http://www…` → 301 `https://labia-loirevalley.fr` ✅ et `https://www…` → 301 ✅ (règle `.htaccess`).
- [x] **SSL `www`** — émis **automatiquement** le 16/10 (~1 h après l'ajout, Let's Encrypt) : cert `CN=www.labia-loirevalley.fr` ; `https://www…` → 301 → `https://labia-loirevalley.fr` → 200 ✅ (chaîne complète vérifiée, plus d'alerte navigateur).
- [ ] (Option) Firewall OVH ; (option) activer DKIM dans Google Workspace (absent aujourd'hui).

### 2. Base de données (canonical non-www) — ✅ fait le 2026-10-15

- [x] **Sauvegarde complète** avant modification : dump SQL généré côté serveur, téléchargé en local (`/tmp/opencode/prod-backup-20261015.sql`, 2,26 Mo), puis supprimé du serveur. (Les sauvegardes OVH quotidiennes restent dispo.)
- [x] `siteurl` + `home` → `https://labia-loirevalley.fr` — **le domaine sert désormais le site directement** (plus de redirection).
- [x] **Search-replace serialization-safe** (script temporaire, testé en local d'abord, supprimé après) : 629 remplacements (621 URL temp dont 614 GUIDs + 8 URL `www` → non-www). Post-vérif : 0 occurrence restante, 0 valeur sérialisée invalide (identique avant/après).
- [x] `blog_public` : déjà à 1.
- [x] `dash-fix.sql` appliqué : ~66 corrections ciblées + 261 titres de médias + 1 alt + 5 titres presse → **0 tiret cadratin restant** (hors révisions).
- [ ] (Mineur) article presse ID 35 « Frédéric Ros sur ChatGPT » : `pub_date` manquant (n'apparaît pas dans la liste presse datée).

### 3. Mail

- [x] Boîte `contact@labia-loirevalley.fr` (MX = Google Workspace) — ✅ réception confirmée le 16/10 (mail de test « Notre Offre » vu par Selim) ; dossier exact (boîte/spam) à préciser.
- [x] Test technique d'envoi le 16/10 : les 2 formulaires (Contact + Notre Offre) → `form_status=success` (envoi accepté par `wp_mail`/PHP `mail()`). Destinataire configuré vérifié côté serveur : `contact@labia-loirevalley.fr` ✅.
- [x] Test de délivrabilité objectif (mail-tester, 16/10) : **5,8/10** — SPF **OK** (OVH réécrit l'enveloppe en SRS : `…@mail-out.cluster131.hosting.ovh.net` → SPF pass) mais **DKIM absent** + **DMARC absent** + From ≠ domaine d'enveloppe (`HEADER_FROM_DIFFERENT_DOMAINS`) → « certaines boîtes peuvent encore refuser ».
- [ ] **SMTP Google — action requise : mot de passe d'application Workspace** (compte `contact@` ou boîte dédiée, validation en 2 étapes requise). Domaine en Workspace **Business Starter** — mots de passe d'application supportés pour SMTP ✅ (confirmé doc Google, oct. 2026). Envoi via `smtp.gmail.com` → SPF+DKIM Google, From = `contact@labia-loirevalley.fr` → ~10/10. Déployable par FTP (mu-plugin `phpmailer_init`), sans accès wp-admin.
- [ ] (Option, plus tard) DKIM Workspace (console admin + TXT dans la zone OVH) + DMARC.

### 4. Admin WordPress

- [ ] Récupérer les identifiants (gestionnaire de secrets) et tester ; sinon reset phpMyAdmin.
- [ ] Mot de passe **fort et unique** ; installer **Limit Login Attempts Reloaded** (limitation des tentatives) et **WP 2FA** (double authentification).
- [ ] `admin_email` sur une boîte consultée (**constaté le 16/10 : `admin@example.com` — placeholder par défaut ⚠️**) ; mettre à jour CMB2/Akismet ; supprimer les extensions inutiles.
- [ ] Après SSL : `define( 'FORCE_SSL_ADMIN', true );` dans `wp-config.php`.
- [ ] (Option) renommer le compte `admin` ; séparer mot de passe FTP et DB (identiques aujourd'hui).
- [ ] Supprimer `www/wp-config-docker.php` (résidu dev uploadé sur la prod — visible dans la racine FTP).

### 5. `.htaccess` — ✅ déployé le 2026-10-15 (bloc complet)

**En ligne :** sections 1 / 2 / 2b / 2c / 2d / 3 insérées avant `# BEGIN WordPress` + `www/.user.ini` (`expose_php = Off`). La section 1 (http→https + www→non-www) a été ajoutée après l'activation SSL — vérifié : `http://labia-loirevalley.fr/…` → 301 `https://labia-loirevalley.fr/…` ✅.

Bloc complet de référence (testé en local le 2026-10-14) :

```apache
# ═══ LAB'IA : bascule domaine + durcissement (AVANT # BEGIN WordPress) ═══

# 1) http → https et www → non-www (uniquement pour le domaine cible)
RewriteEngine On
RewriteCond %{HTTP_HOST} ^(www\.)?labia-loirevalley\.fr$ [NC]
RewriteCond %{HTTPS} off [OR]
RewriteCond %{HTTP_HOST} ^www\. [NC]
RewriteRule ^ https://labia-loirevalley.fr%{REQUEST_URI} [R=301,L]

# 2) Sécurité — pas d'exécution PHP dans les uploads
RewriteRule ^wp-content/uploads/.*\.php$ - [F,L,NC]

# 2b) Sécurité — pas de listing des répertoires sans fichier d'index
RewriteCond %{REQUEST_FILENAME} -d
RewriteCond %{REQUEST_FILENAME}/index.php !-f
RewriteCond %{REQUEST_FILENAME}/index.html !-f
RewriteRule ^ - [F,L]

# 2c) Sécurité — bloquer xmlrpc.php et masquer les fichiers d'info WP
<Files "xmlrpc.php">
  Require all denied
</Files>
<FilesMatch "^(readme\.html|license\.txt|wp-config-sample\.php)$">
  Require all denied
</FilesMatch>

# 2d) Sécurité — en-têtes (HSTS effectif une fois le HTTPS actif)
<IfModule mod_headers.c>
  Header always set X-Content-Type-Options "nosniff"
  Header always set X-Frame-Options "SAMEORIGIN"
  Header always set Referrer-Policy "strict-origin-when-cross-origin"
  Header always set Permissions-Policy "camera=(), microphone=(), geolocation=()"
  Header always set Strict-Transport-Security "max-age=31536000"
  Header unset X-Powered-By
  Header unset X-Pingback
</IfModule>

# 3) Anciennes URLs Wix → WordPress
Redirect 301 /actualit%C3%A9 /actualites/
Redirect 301 /actualité /actualites/
Redirect 301 /quisommesnous /qui-sommes-nous/
Redirect 301 /ilsnousfontconfiance /ils-nous-font-confiance/
Redirect 301 /notreoffre /notre-offre/
Redirect 301 /mentions-l%C3%A9gales /mentions-legales/
Redirect 301 /mentions-légales /mentions-legales/
Redirect 301 /politique-de-confidentialit%C3%A9 /politique-de-confidentialite/
Redirect 301 /politique-de-confidentialité /politique-de-confidentialite/
Redirect 301 /politique-en-mati%C3%A8re-de-cookies /politique-en-matiere-de-cookies/
Redirect 301 /politique-en-matière-de-cookies /politique-en-matiere-de-cookies/
Redirect 301 /about-3 /actualites/
```

### 6. Vérifications post-bascule

- [x] `http://labia-loirevalley.fr` → 301 `https://labia-loirevalley.fr` ✅ ; `https://labia-loirevalley.fr` → **200 direct** ✅. `http://www…` → 301 → `https://labia-loirevalley.fr` → **200** ✅ ; `https://www…` → 301 → **200** ✅ — chaînes complètes vérifiées le 16/10, cert `www` émis (plus d'alerte navigateur).
- [x] Sécurité (vérifié le 15/10) : `/wp-content/uploads/` → 403 ; `/xmlrpc.php` → 403 ; `/readme.html` → 403 ; `/wp-json/wp/v2/users` → 404 ; `?author=1` → 301 ; en-têtes présents (nosniff, X-Frame-Options, Referrer-Policy, Permissions-Policy, HSTS) ; `x-powered-by` / `x-pingback` absents.
- [x] `wp-login.php` https 200 ✅ ; pages principales 200 ✅ ; PDFs presse 200 ✅ ; 0 image `wixstatic` sur `/` ✅ ; `/feed/` 200 ; `wp-admin` → 302 vers `wp-login` sur le domaine.
- [ ] Envoi réel des 2 formulaires : test technique du 16/10 → `form_status=success` sur les 2 ; ⏳ confirmer la réception (pas en spam) — cf. §3.
- [ ] `wp-sitemap.xml` sur le domaine + Search Console ; garder Wix quelques jours (rollback).

### 7. Améliorations faites le 16/10

- [x] **Balises de partage** (Open Graph + Twitter + meta description) : nouveau `inc/seo-meta.php` — accueil, pages, articles ; visuel de marque `assets/img/og-default.png` (1200×630), image à la une si ≥ 600 px. Corrige l'aperçu de lien (Teams/LinkedIn/WhatsApp) qui tombait sur l'oEmbed « Sample Page ».
- [x] **Page d'accueil nettoyée en base** : « Sample Page » → « Accueil », contenu d'exemple vidé, modèle de page invalide retiré — l'oEmbed renvoie désormais « Accueil ».
- [x] **Mail de notification des formulaires en HTML** stylé (charte du site, bouton « Répondre au visiteur ») + repli texte brut (`AltBody`). Test réel contact le 16/10 → `form_status=success`.
- [x] Vérifié : **0 occurrence** de « hello » / « nouveau site en production » en base → l'aperçu Teams vu par Selim était un **cache** (il se rafraîchira).

## Ordre de bascule — état

1. ✅ **Fait** : §0 (thème + mu-plugin + PDFs), §1 (DNS + SSL domaine), §2 (DB migrée + dash-fix), §5 (`.htaccess` complet + `.user.ini`).
2. **Reste** : §3 (mail : SMTP Google — mot de passe d'application ; confirmation dossier boîte/spam), §4 (admin : 2FA, mot de passe, extensions), nettoyages (`wp-config-docker.php`, article ID 35).
3. **J+** : Search Console, surveillance, suppression Wix après quelques jours.

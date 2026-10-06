# LAB'IA Loire Valley

Site WordPress du LAB'IA Loire Valley — centre de ressources IA pour les entreprises de la région Centre-Val de Loire.

## Quick start

```bash
cd wordpress-dev
docker compose up -d
```

**Site** : http://localhost:8765
- **Admin WordPress** : récupérer les identifiants depuis le gestionnaire de secrets de l’équipe. S’ils sont absents, réinitialiser le compte via un canal d’administration autorisé avant tout accès.

## Structure

wordpress-dev/
├── docker-compose.yml            # WordPress 6.6 + MariaDB 10.6 + phpMyAdmin
└── theme/                        # Thème monté en volume bind (modifications immédiates)
    ├── style.css                 # Design system complet (~1900 lignes)
    ├── header.php / footer.php   # Nav + footer dynamiques
    ├── functions.php             # Setup thème + favicon
    ├── front-page.php            # Page d'accueil
    ├── page-templates/           # Templates pour chaque page
    ├── inc/                      # Fonctionnalités
    │   ├── enqueue.php           # Chargement CSS/JS
    │   ├── options-general.php   # Options Page + helper labia_opt()
    │   ├── cpt-team.php          # CPT Équipe
    │   ├── cpt-client.php        # CPT Clients
    │   ├── cpt-testimonial.php   # CPT Témoignages
    │   ├── cpt-formation.php     # CPT Formations
    │   ├── cpt-solution.php      # CPT Solutions
    │   ├── cpt-presse.php        # CPT Presse (taxonomie press_type, filtres JS)
    │   └── cpt-news.php          # CPT Actualités (news_article)
    └── assets/                   # JS, logos
        └── js/main.js            # Navigation, filtres presse, animations

## Contenu éditable

Depuis l'admin WordPress :
- **Équipe** → Membres équipe (13 membres, photo/rôle/bio/pôle) + **couleur par pôle** (colorpicker, Équipe → Pôles)
- **Clients** → Clients & Partenaires (17 logos)
- **Témoignages** → Témoignages (6 case-studies)
- **Presse** → Articles presse (14, timeline par année, filtres par type)
- **Actualités** → Articles d'actualité (format article plein écran)
- **Solutions** → Solutions (3, tags + features)
- **Formations** → Formations (6)
- **Paramètres globaux** → Réglages > Paramètres LAB'IA

## Pages dynamiques vs statiques

| Page | Contenu | Éditable depuis WP |
|------|---------|-------------------|
| Accueil | Hero (Options), solutions (CPT), témoignages (CPT) | ✅ Partiellement |
| Qui sommes-nous | 13 membres depuis CPT team_member | ✅ Oui |
| Ils nous font confiance | 17 clients + 6 témoignages | ✅ Oui |
| Presse | 14 articles en timeline + filtres par type | ✅ Oui |
| Actualités | Articles format article plein écran (CPT news_article) | ✅ Oui |
| Nos Solutions | 3 solutions | ✅ Oui |
| Notre Offre | Contenu 1-to-1 statique | ❌ Non (HTML) |
| Partenariat | Contenu 1-to-1 statique | ❌ Non (HTML) |
| Contact | Formulaire HTML statique | ❌ Non |

## WP-CLI / Accès DB

```bash
# Option 1 — installer WP-CLI dans le conteneur
docker compose exec wordpress bash -c "curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp"

# Ensuite : docker compose exec wordpress wp <commande>

# Option 2 — PHP inline (sans wp-cli)
docker compose exec -T wordpress php -r "
\$_SERVER['HTTP_HOST'] = 'localhost';
\$_SERVER['REQUEST_URI'] = '/';
require_once '/var/www/html/wp-load.php';
// tes fonctions WP ici
"
```

## Port

Le port 8765 est utilisé car les ports 8080/8082 sont bloqués par un bug connu du proxy Docker Desktop (GitHub #12474). Si le site ne répond pas après une mise en veille : `wsl --shutdown` (PowerShell admin) puis relancer Docker Desktop.

## Stack

- WordPress 6.6.2, PHP 8.2, MariaDB 10.6
- Thème custom sans page builder
- CMB2 (champs custom, gratuit)
- Docker Desktop 4.71.0 (WSL2)

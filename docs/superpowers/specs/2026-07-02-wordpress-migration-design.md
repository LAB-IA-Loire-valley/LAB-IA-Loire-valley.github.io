# Migration LAB'IA Loire Valley vers WordPress — Design

**Date** : 2026-07-02
**Statut** : Brouillon — en attente de revue
**Auteur** : Brainstorming avec l'utilisateur

## 1. Contexte et objectifs

Le site actuel de LAB'IA Loire Valley (centre de ressources IA pour les entreprises de la région Centre-Val de Loire) est un site statique HTML/CSS/JS sans backend. L'objectif est de le migrer vers WordPress pour :

1. **Permettre à l'équipe éditoriale** de gérer le contenu directement depuis l'admin WordPress, sans intervention développeur
2. **Ouvrir un blog** pour publier des articles d'actualités, témoignages, et contenus éditoriaux
3. **Faciliter la maintenance** : ajout de membres, partenaires, formations, témoignages sans toucher au code
4. **Garder l'identité visuelle actuelle** : pixel-perfect avec le design "Signal — Editorial · Tech · Confident" existant

### Pages actuelles à migrer

| URL actuelle | Type de contenu | Devient dans WP |
|--------------|----------------|-----------------|
| `index.html` | Page d'accueil (hero, stats, offre, solutions, méthode, témoignages, CTA) | Template `front-page.php` (utilisé quand "Une page statique" est cochée dans Réglages > Lecture) |
| `notre-offre.html` | Offre de services | Template `template-notre-offre.php` |
| `nos-solutions.html` | Solutions IA | Template `template-nos-solutions.php` |
| `qui-sommes-nous.html` | Équipe + mission + consortiums + localisation | Template `template-qui-sommes-nous.php` |
| `ils-nous-font-confiance.html` | Clients + témoignages détaillés | Template `template-clients.php` |
| `partenariat.html` | Partenaires institutionnels | Template `template-partenariat.php` |
| `actualites.html` | Articles d'actualités | Archive WordPress native |
| `presse.html` | Articles de presse + timeline | Template `template-presse.php` |
| `contact.html` | Coordonnées + formulaire | Template `template-contact.php` |
| `badge.html` | Label ambassadeur IA | Redirection vers une section de l'accueil |

## 2. Décisions techniques

### 2.1 Stack technique

- **CMS** : WordPress 6.6+ (PHP 8.2+, MySQL 8.0+ ou MariaDB 10.6+)
- **Thème** : Custom theme `labia-wp` (PHP templates standards, pas de Twig/Timber)
- **Plugin de champs** : **CMB2** (gratuit, open-source, actif et maintenu)
- **Formulaires** : **WPForms Lite** ou **Contact Form 7** (gratuit)
- **Pas de page builder** : le thème contrôle tout le layout, l'admin gère le contenu
- **Pas de Gutenberg pour le contenu principal** : les pages ont des sections fixes éditables via CMB2

### 2.2 Pourquoi CMB2 et pas ACF Pro ?

CMB2 est l'alternative gratuite complète à ACF Pro :
- Options Pages natives (paramètres globaux du site)
- Groupes de champs répétables (formations, témoignages, etc.)
- Field types avancés : wysiwyg, file, image, select, taxonomy, etc.
- Testé jusqu'à WordPress 7.0 et PHP 8.3
- 91 avis 5★ sur wordpress.org
- Carbon Fields a été fermé définitivement en 2019, donc éliminé
- ACF Pro coûte ~49$/an — non nécessaire pour ce projet

### 2.3 Sections fixes vs drag-and-drop

**Décision** : **Sections fixes** (layout prédéfini, contenu éditable).

- Chaque page a un layout pré-établi (hero → stats → offre → solutions → etc.)
- L'utilisateur WP édite le **contenu** de chaque section (texte, image, lien, etc.)
- L'utilisateur ne peut **pas réordonner** les sections elles-mêmes
- Garantit le pixel-perfect : impossible de casser le design
- Le drag-and-drop de sections serait possible avec ACF Flexible Content (payant) ou Gutenberg, mais cela dégraderait l'expérience d'édition et le contrôle visuel

## 3. Architecture du thème

```
labia-wp/
├── style.css              # Header thème + CSS complet porté depuis le site actuel
├── functions.php          # Autoload, CPT registration, CMB2 config, nav menus
├── header.php             # Nav + mobile menu (dynamic via wp_nav_menu)
├── footer.php             # Footer + financeurs (dynamic via Options Page)
├── front-page.php         # Template page d'accueil
├── index.php              # Fallback
├── page.php               # Template pages statiques
├── single.php             # Article blog/presse single
├── archive.php            # Archive blog/presse
├── page-templates/
│   ├── template-notre-offre.php
│   ├── template-nos-solutions.php
│   ├── template-qui-sommes-nous.php
│   ├── template-clients.php
│   ├── template-partenariat.php
│   ├── template-presse.php
│   └── template-contact.php
├── inc/
│   ├── cmb2-config.php            # Toutes les field groups CMB2
│   ├── cpt-team.php               # CPT Membres équipe
│   ├── cpt-client.php             # CPT Clients/Partenaires
│   ├── cpt-testimonial.php        # CPT Témoignages
│   ├── cpt-formation.php          # CPT Formations
│   ├── cpt-presse.php             # CPT Articles presse
│   ├── cpt-solution.php           # CPT Solutions IA
│   ├── options-general.php        # Options Page Paramètres généraux
│   ├── nav-walker.php             # Walker navigation custom
│   └── enqueue.php                # CSS/JS enqueues
├── assets/
│   ├── css/style.css              # Port direct du CSS actuel (1283 lignes)
│   ├── js/main.js                 # Port direct du JS actuel
│   └── img/                       # Logos, photos équipe, etc.
└── template-parts/
    ├── card-team.php
    ├── card-client.php
    ├── card-testimonial.php
    ├── card-formation.php
    ├── card-solution.php
    ├── section-hero.php
    ├── section-cta.php
    ├── section-stats.php
    ├── client-ticker.php
    ├── press-timeline.php
    └── team-grid.php
```

## 4. Modèle de données

### 4.1 Custom Post Types (6)

| Slug | Label | Champs CMB2 principaux | Visible sur |
|------|-------|--------------------------|-------------|
| `team_member` | Membres équipe | photo, nom, rôle, bio, pôle (taxo), ordre, linkedin | "Qui sommes-nous" |
| `client` | Clients/Partenaires | logo, nom, secteur, type (taxo), site web, order | Ticker accueil + page clients |
| `testimonial` | Témoignages | citation, auteur, poste, entreprise, logo, secteur | Accueil + page clients |
| `formation` | Formations | titre, description, durée, prérequis, modalité, prix, dates | "Notre Offre" |
| `press_article` | Articles presse | titre, date, source, type, url, excerpt | "Presse" |
| `solution` | Solutions IA | titre, description, tags, features, couleur hero, emoji | "Nos Solutions" |

### 4.2 Taxonomies

| Slug | Pour CPT | Termes |
|------|----------|--------|
| `team_pole` | `team_member` | Pôle opérationnel, Pôle technique, Réseau d'experts, Équipe technopolitaine |
| `client_type` | `client` | Client, Partenaire, Financeur |
| `press_type` | `press_article` | Radio, Presse écrite, Web, Vidéo |

### 4.3 Post types natifs utilisés

- **`post`** (blog WordPress standard) : pour les articles d'actualités
- **`page`** : pour les pages statiques (accueil, contact, etc.)

### 4.4 Options Page (paramètres globaux)

Section admin : **Réglages > Paramètres LAB'IA**

| Champ | Type | Description |
|-------|------|-------------|
| `site_logo` | image | Logo affiché dans nav et footer |
| `phone` | text | Téléphone (02 38 69 80 87) |
| `email` | text | Email (contact@labia-loirevalley.fr) |
| `address_line_1` | text | "Le LAB'O — Village By CA Orléans" |
| `address_line_2` | text | "1 avenue du Champ de Mars, CS 30019" |
| `address_city` | text | "45074 Orléans Cedex 2" |
| `linkedin_url` | text | URL LinkedIn |
| `footer_description` | textarea | Texte description footer |
| `financeur_image_1` | image | Bande financeurs LAB'IA |
| `financeur_image_2` | image | Bande financeurs Technopole |
| `ambassador_badge_image` | image | Logo "Ambassadeur IA" |
| `hero_badge_text` | text | Texte du badge hero |
| `hero_title` | textarea | Titre principal hero (HTML) |
| `hero_lead` | textarea | Sous-titre hero |
| `hero_cta_1_text` | text | Bouton 1 |
| `hero_cta_1_url` | text | URL bouton 1 |
| `hero_cta_2_text` | text | Bouton 2 |
| `hero_cta_2_url` | text | URL bouton 2 |

## 5. Mapping des pages vers les sources de contenu

### 5.1 Page d'accueil (`template-accueil.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page (titre, lead, 2 CTA, badge) |
| Stats strip | Options Page (4 blocs : nombre, label, couleur) |
| Notre offre (4 cards) | Options Page (4 cartes : icône, titre, desc, lien) — en dur dans le code car fixe |
| Nos solutions (3 cards) | Loop CPT `solution` filtré `featured_homepage=true` (limité aux 3 dernières publiées marquées featured) |
| Méthode (6 étapes) | Options Page (6 étapes : numéro, titre, desc) |
| Témoignages (3 cards) | Loop CPT `testimonial` filtré `show_on_homepage=true` |
| CTA final | Options Page (titre, sous-titre, boutons) |

### 5.2 Page "Notre Offre" (`template-notre-offre.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page (par page : titre, lead) |
| 4 sections (Accompagnement, Formations, Sensibilisation, Conseil) | Options Page : 4 groupes avec titre, description, features, CTA |
| Catalogue de formations | Loop CPT `formation` filtré par taxo `formation_category` (formations, ateliers, conférences, masterclass) |
| Encart QUALIOPI | En dur dans le template (info réglementaire) |

### 5.3 Page "Nos Solutions" (`template-nos-solutions.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page par page |
| 3 solutions détaillées | Loop CPT `solution` : titre, description, tags, features list |

### 5.4 Page "Qui sommes-nous" (`template-qui-sommes-nous.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page par page |
| Mission | Options Page par page (titre, texte, 3 points clés repeater) |
| Stats (4 blocs) | Options Page (année, %, étapes, +100) |
| Équipe opérationnelle | Loop CPT `team_member` filtré par taxo `team_pole` |
| Réseau d'experts | Loop CPT `team_member` filtré par taxo `team_pole` |
| Équipe Technopolitaine | Loop CPT `team_member` filtré par taxo `team_pole` |
| Consortiums | Options Page par page (2 cards : titre, org, desc, partenaires, lien) |
| Localisation | Options Page globale (adresse, tél, email) + template static |

### 5.5 Page "Ils nous font confiance" (`template-clients.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page par page |
| Ticker logos | Loop CPT `client` (auto-scrolling, animation) |
| Témoignages détaillés | Loop CPT `testimonial` avec mise en page "case study" |

### 5.6 Page "Partenariat" (`template-partenariat.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page par page |
| Logos partenaires | Loop CPT `client` filtré `client_type=partenaire` |
| Texte présentation | Options Page par page |

### 5.7 Page "Presse" (`template-presse.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page par page |
| Highlight (émissions) | Options Page par page (titre, description, embed URL) |
| Timeline | Loop CPT `press_article` groupé par année |

### 5.8 Page "Contact" (`template-contact.php`)

| Section | Source de contenu |
|---------|-------------------|
| Hero | Options Page par page |
| Infos contact | Options Page globale (tél, email, adresse, LinkedIn) |
| Formulaire | WPForms Lite — shortcode `[wpforms id="1"]` |

### 5.9 Blog / Actualités (WordPress natif)

- Template `archive.php` pour la liste des articles
- Template `single.php` pour un article
- Format de carte `actu-card` (style CSS porté)
- Catégories et tags WordPress natifs

## 6. Design system

**Aucun changement visuel par rapport au site actuel.**

- **Fonts** : Plus Jakarta Sans (display) + DM Sans (body) — import Google Fonts
- **Palette** : magenta `#E2007D`, blue `#4FB0FF`, dark `#0D0D0D`
- **Composants** : tous les composants existants (cards, badges, boutons, grids) sont portés tels quels
- **Responsive** : breakpoints identiques (768px mobile)
- **Animations** : scroll reveal (IntersectionObserver) + canvas hero (porté)
- **CSS** : `style.css` (1283 lignes) est copié tel quel dans le thème, seules les URLs deviennent dynamiques via `get_template_directory_uri()`

## 7. Déploiement et infrastructure

### 7.1 Hébergement recommandé

- **o2switch** (français, illimité, ~75€/an) — meilleur rapport qualité/prix
- Alternatives : Infomaniak, OVH, Hostinger
- Tous compatibles WordPress + PHP 8.2+ + SSL gratuit

### 7.2 Plugins tiers (tous gratuits)

| Plugin | Rôle | Source |
|--------|------|--------|
| CMB2 | Champs custom + CPT + Options Pages | wordpress.org |
| WPForms Lite ou Contact Form 7 | Formulaire de contact | wordpress.org |
| Yoast SEO (optionnel) | Référencement | wordpress.org |
| WP Super Cache ou W3 Total Cache | Cache | wordpress.org |
| UpdraftPlus (optionnel) | Backups | wordpress.org |
| ShortPixel (optionnel) | Compression images | wordpress.org |

### 7.3 Migration Wix → WordPress

- Le contenu actuel (HTML) ne peut pas être "exporté" depuis Wix de manière fiable
- Le contenu doit être recréé dans WordPress via les nouveaux CPTs et Options Pages
- Le domaine existant `labia-loirevalley.fr` est à pointer vers le nouvel hébergement (DNS A record)
- Redirections 301 à mettre en place si les URLs changent
- Durée de coupure estimée : 0-2h (pendant le switch DNS)

### 7.4 Performance cible

- LCP (Largest Contentful Paint) < 2.5s
- Score PageSpeed Insights > 85 sur mobile
- TTFB (Time To First Byte) < 600ms

## 8. Étapes de réalisation (vue d'ensemble)

Le plan d'implémentation (à produire via la skill `writing-plans`) décomposera le travail en **vertical slices** indépendantes :

1. **Setup & infrastructure** — hébergement local, WordPress, plugin CMB2, theme skeleton
2. **Theme shell** — header, footer, navigation dynamique, CSS porté
3. **Page d'accueil** — hero, stats, sections éditables, témoignages
4. **Pages "Notre Offre" + "Nos Solutions"** — avec CPT formation et CPT solution
5. **Pages "Qui sommes-nous" + CPT équipe**
6. **Pages "Ils nous font confiance" + CPT clients + témoignages détaillés**
7. **Page "Partenariat" + page "Presse" + CPT presse**
8. **Blog / Actualités** (WordPress natif)
9. **Page Contact + formulaire**
10. **Contenu initial** — migration manuelle de tous les textes, images, photos équipe
11. **Recette, performance, mise en ligne**

Chaque tranche produit une page visible, testable, et indépendante des autres.

## 9. Hors scope (YAGNI)

Pour cette V1, on NE fait PAS :

- Multilingue (français uniquement)
- E-commerce / paiement
- Espace membre / authentification utilisateur
- Recherche avancée (la recherche native WP suffit)
- Commentaires sur les articles
- Newsletter intégrée (peut être ajoutée plus tard)
- Multisite
- Migration des anciens commentaires / backlinks Wix (Wix n'en a pas de manière portable)
- Versioning / preview de pages (Gutenberg pourrait le faire mais sections fixes choisies)

Ces fonctionnalités pourront être ajoutées en V2 si le besoin se fait sentir.

## 10. Critères d'acceptation

Le projet sera considéré comme livré quand :

1. ✅ Toutes les pages actuelles existent dans WordPress avec contenu identique
2. ✅ Le rendu visuel est pixel-perfect par rapport au site statique actuel
3. ✅ L'équipe peut ajouter un membre, un témoignage, un partenaire, un article, une formation **sans toucher au code**
4. ✅ Le site a un score PageSpeed > 85 sur mobile
5. ✅ Le blog fonctionne : création d'article, catégories, archives
6. ✅ Le formulaire de contact envoie bien les emails
7. ✅ Le site est responsive (mobile, tablette, desktop)
8. ✅ SSL actif, backups automatiques configurés
9. ✅ Une documentation d'utilisation de l'admin est fournie à l'équipe

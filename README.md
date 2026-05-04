# JeweleryStore — Joaillerie Orient

Plateforme e-commerce de joaillerie développée avec **Laravel 12**, **Vue 3**, **Inertia.js**, **FrankenPHP**.  
Le projet inclut un front-office complet, avec gestion des langues, un back-office, un système de paiement Stripe, la gestion des transporteurs, des taxes, des factures PDF et une authentification à deux facteurs (2FA).

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | PHP 8.4 · Laravel 12 · FrankenPHP |
| Frontend | Vue 3 · TypeScript · Inertia.js · Tailwind CSS v4 |
| Base de données | MySQL 8.0 |
| Paiement | Stripe (via Laravel Cashier) |
| Authentification | Laravel Fortify · Sanctum · 2FA (Google2FA) |
| Permissions | Spatie Laravel Permission |
| Messagerie | RabbitMQ 3.9 |
| Serveur web | Caddy (via FrankenPHP) |
| Tests | PHPUnit · Cypress |

## Prérequis

- Docker >= 24
- Docker Compose >= 2.x
- Git

## Installation via Docker

### 1. Cloner le dépôt

```bash
git clone <url-du-repo> jewelery-store
cd jewelery-store
```

### 2. Configurer les variables d'environnement

```bash
cp .env.example .env
```

Renseigner les variables suivantes dans le fichier `.env` :

```env
APP_KEY=                        # Généré automatiquement à l'étape suivante

DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=jewelery_store
DB_USERNAME=your_user
DB_PASSWORD=your_password

MYSQL_ROOT_PASSWORD=your_root_password

STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...

VITE_PORT=5173
```

### 3. Lancer l'environnement

**En environnement de Développement**

```bash
docker compose -f docker-compose.dev.yml up -d --build
```

**En environnement de Production**

```bash
docker compose up -d --build
```

> Au premier démarrage, le conteneur attend automatiquement que MySQL soit prêt, puis exécute les migrations.

### 4. Générer la clé applicative

```bash
docker exec laravel_app php artisan key:generate
```

### 5. Compiler les assets frontend

```bash
docker exec laravel_app npm install
docker exec laravel_app npm run build
```

### 6. (Optionnel) Peupler la base de données

```bash
docker exec laravel_app php artisan db:seed
```

### 7. Accès aux services

| Service | URL |
|---|---|
| Application | http://localhost |
| phpMyAdmin | http://localhost:8081 |
| RabbitMQ (UI) | http://localhost:15672 |
| Vite (dev HMR) | http://localhost:5173 |

## Commandes utiles

```bash
# Voir les logs de l'application
docker logs -f laravel_app

# Lancer les tests PHP
docker exec laravel_app php artisan test

# Lancer les tests Cypress
docker exec laravel_app npx cypress run

# Accéder au shell du conteneur
docker exec -it laravel_app bash

# Vider les caches Laravel
docker exec laravel_app php artisan optimize:clear

# Stopper tous les conteneurs
docker compose down
```

## Structure du projet

```
JeweleryStore/
├── .docker/
│   └── php/
│       └── Dockerfile              # Image FrankenPHP (cibles dev & prod)
├── app/
│   ├── Contracts/                  # Interfaces et contrats
│   ├── DTOs/                       # Data Transfer Objects
│   ├── Exceptions/                 # Gestionnaires d'exceptions
│   ├── Facades/                    # Facades Laravel personnalisées
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Contrôleurs du back-office
│   │   │   ├── Auth/               # Contrôleurs d'authentification
│   │   │   ├── Settings/           # Contrôleurs de paramètres
│   │   │   └── Web/                # Contrôleurs de la boutique
│   │   ├── Helpers/
│   │   ├── Middleware/
│   │   └── Requests/               # Form Requests (validation)
│   ├── Listeners/                  # Écouteurs d'événements
│   ├── Mails/                      # Mailables Laravel
│   ├── Models/                     # Modèles Eloquent
│   ├── Providers/                  # Service Providers
│   ├── Repositories/               # Couche d'accès aux données
│   └── Services/                   # Services métier
│       ├── Carrier/
│       ├── Currency/
│       ├── Image/
│       ├── Order/
│       ├── Payment/
│       ├── Tax/
│       └── PdfService.php
├── database/
│   ├── factories/                  # Factories pour les tests
│   ├── migrations/                 # Migrations SQL
│   └── seeders/                    # Seeders
├── frankenphp/
│   ├── Caddyfile                   # Configuration du serveur Caddy
│   └── conf.d/                     # Configuration PHP (dev/prod)
├── public/                         # Assets publics (images, CSS compilé)
├── resources/
│   ├── js/
│   │   ├── actions/                # Actions Inertia réutilisables
│   │   ├── components/
│   │   │   └── jewellery_store/
│   │   │       ├── admin/          # Composants spécifiques au back-office
│   │   │       ├── auth/           # Composants d'authentification
│   │   │       ├── card/           # Cartes (produit, adresse…)
│   │   │       ├── carousel/
│   │   │       ├── cart/           # Panier
│   │   │       ├── form/           # Formulaires admin et boutique
│   │   │       ├── list/           # Listes (produits, commandes, taxes…)
│   │   │       ├── nav/            # Navigation
│   │   │       ├── section/        # Sections de page
│   │   │       ├── select/         # Composants de sélection
│   │   │       ├── stripe/         # Intégration Stripe
│   │   │       ├── tab/            # Onglets
│   │   │       └── table/          # Tableaux
│   │   ├── composables/            # Composables Vue 3
│   │   ├── layouts/                # Layouts Inertia (AppLayout…)
│   │   ├── lib/                    # Utilitaires frontend
│   │   ├── pages/
│   │   │   ├── admin/              # Pages du back-office
│   │   │   ├── auth/               # Pages d'authentification
│   │   │   ├── settings/           # Pages de paramètres
│   │   │   └── web/                # Pages de la boutique
│   │   ├── routes/                 # Helpers de routes Ziggy/Wayfinder
│   │   ├── types/                  # Types TypeScript
│   │   └── wayfinder/              # Routes générées par Wayfinder
│   └── views/                      # Vues Blade (layout principal)
├── routes/
│   ├── web.php                     # Routes principales (boutique + admin)
│   ├── auth.php                    # Routes d'authentification
│   ├── settings.php                # Routes de paramètres
│   └── console.php
├── scripts/                        # Scripts utilitaires
├── tests/
│   ├── Feature/                    # Tests fonctionnels
│   ├── Unit/                       # Tests unitaires
│   └── cypress/                    # Tests E2E Cypress
```

## Architecture

Le projet suit une architecture **MVC** enrichie de couches supplémentaires :

- **Repositories** — isolation de la logique d'accès aux données (Eloquent)
- **Services** — logique métier (calcul des taxes, génération de PDF, paiement)
- **DTOs** — transfert de données typées entre les couches
- **Form Requests** — validation centralisée des entrées utilisateur
- **Inertia.js** — pont entre les contrôleurs Laravel et les composants Vue 3, sans API REST exposée

Le rendu est assuré côté serveur par **FrankenPHP** (basé sur Caddy), qui sert également les fichiers statiques et gère HTTPS automatiquement.

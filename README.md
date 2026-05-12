# Lumo Core Platform

Plateforme SaaS modulaire (Laravel + nwidart/laravel-modules) orientée **site public + portail d’authentification + backoffice ERP + API** pour chaque module métier.

## Stack actuelle du dépôt

- Laravel Framework: `11.x`
- PHP requis: `8.2`
- Composer: `2.x`
- Node.js: `>=18` + npm `>=9`
- Base de données: SQLite (par défaut) ou MySQL/PostgreSQL
- Front: Blade, Tailwind, Bootstrap, Alpine, JavaScript natif (sans Vue.js)
- Queue: worker Laravel standard (pas de dépendance `ext-pcntl` obligatoire pour l'installation locale)

> ✅ Le dépôt est aligné sur Laravel 11 et PHP 8.2.
> ✅ `composer install` fonctionne en local Windows/XAMPP sans exiger `ext-pcntl`.

## Modules présents

- Core
- Identity
- School
- University
- Companies
- Jobs
- Ecommerce
- Payment
- Logistics
- Communication
- Analytics

## Ce qui est déjà en place

- Architecture modulaire par module (routes web/api, contrôleurs, providers, seeders)
- Authentification web + API (Identity + Sanctum)
- RBAC global via Spatie Permissions
- Middleware global de locale (`SetLocale`)
- Middleware sécurité headers (`SecurityHeaders`)
- Middleware audit (`AuditLog`)
- Entrée auth unifiée ajoutée: `/login`, `/register`, `/forgot-password`
- Entrées portail/ERP ajoutées par module (routes `portal` et `erp` sous auth)

## État d’implémentation vs prompt

Le squelette modulaire est en place, mais le prompt complet décrit un périmètre **très large** (ERP complet par module, PWA offline/push, temps réel avancé, SEO multilingue complet, workflows métiers détaillés School/University/etc.).

Ce dépôt fournit aujourd’hui une **base solide** et structurée, mais il reste du développement fonctionnel important pour atteindre 100% du cahier des charges.

---

## Cloner, installer et démarrer en local

### 1) Cloner

```bash
git clone https://github.com/Lucmoyika/lumo-core-platform.git
cd lumo-core-platform
```

### 2) Prérequis

- PHP 8.2
- Composer 2.x
- Node.js >=18
- npm >=9
- SQLite (par défaut) ou MySQL/PostgreSQL

### 3) Installation

```bash
composer install
cp .env.example .env # Windows (CMD): copy .env.example .env
php artisan key:generate
```

Configurer ensuite `.env` (DB, MAIL, etc.), puis:

```bash
php artisan migrate --seed
npm install
npm run build
```

### 4) Démarrage local

Option simple:

```bash
php artisan serve
npm run dev
```

Option process group (serveur + queue + logs + vite):

```bash
composer run dev
```

### 4.1) Correction du warning `npm WARN EBADENGINE` (captures)

#### Capture 1 — Avant correction

```txt
npm warn EBADENGINE Unsupported engine {
npm warn EBADENGINE   package: undefined,
npm warn EBADENGINE   required: { node: '>=18 <19', npm: '>=9 <10' },
npm warn EBADENGINE   current: { node: 'v22.11.0', npm: '11.6.2' }
npm warn EBADENGINE }
```

#### Capture 2 — Correction appliquée

Fichier modifié: `package.json`

```json
"engines": {
  "node": ">=18",
  "npm": ">=9"
}
```

#### Capture 3 — Vérification après correction

```txt
$ npm install
up to date, audited 57 packages in 628ms

$ npm run build
vite v5.4.21 building for production...
✓ built in 157ms
```

> Note: les messages `npm audit` (vulnérabilités) sont séparés du warning `EBADENGINE`.

### 5) Tests

```bash
php artisan test
```

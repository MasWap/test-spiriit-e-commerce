# LAYRAC Guitar Shop - E-commerce Symfony - Test technique Spiriit

### Application e-commerce développée avec Symfony 6.4 pour la vente de guitares signatures.

L'application comprends :
- Un catalogue de produits
- Une page détaillée pour chaque produit
- Un système de panier (Stocké en session)
- Une interface responsive utilisant Bootstrap

## Informations sur l'application

- **Symfony 6.4** - Framework PHP
- **SQLite** - Base de données
- **Doctrine ORM** - Mapping objet-relationnel
- **Webpack Encore** - Gestion des assets
- **Bootstrap 5.3** - Framework CSS
- **FontAwesome 6** - Icônes
- **PHPUnit** - Tests unitaires et fonctionnels
- **SCSS** - Préprocesseur CSS

## Prérequis

- Système d'exploitation Unix avec Docker
- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- Extension SQLite, Intl, fileinfo pour PHP

## Information

##### Vous disposez d'une version de l'application déployé en production sur mon serveur proxmox à l'adresse suivante :

#### https://test-spiriit.lilol.ovh/

## Installation du projet (Développement)

### 1. Cloner le dépôt

```bash
git clone <url-du-depot>
cd test-spiriit-e-commerce
```

## Déploiement automatique

### 1.1. Exécuter la commande make start pour déployer automatiquement l'application via Docker et le makefile

```bash
make start
```

### 1.2. Une fois le déploiement terminé, rendez-vous sur :

#### http://localhost:9000

## Déploiement manuel

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances Node.js

```bash
npm install
```

### 4. Créer la base de données

```bash
php bin/console doctrine:database:create
```

### 5. Appliquer les migrations

```bash
php bin/console doctrine:migrations:migrate
```

## 6. Charger les fixtures

Pour charger les données de démonstration (12 produits) :

```bash
php bin/console doctrine:fixtures:load
```

**Attention** : Cette commande supprime toutes les données existantes et recharge les fixtures.

## 7. Compiler les assets

### Compilation en mode développement ou watch pour le hot reload

```bash
npm run dev
ou
npm run watch
```

## 8. Lancer le projet

### Avec le serveur Symfony CLI (recommandé)

```bash
symfony server:start
```

L'application sera disponible sur `https://127.0.0.1:8000`

### Avec le serveur PHP intégré (si vous ne disposez pas du Symfony CLI)

```bash
php -S localhost:9000 -t public/
```

L'application sera disponible sur `http://localhost:9000`

## 9. Jouer les tests

### Préparer l'environnement de test

1. **Créer la base de données de test :**
```bash
php bin/console doctrine:database:create --env=test
```

2. **Appliquer les migrations :**
```bash
php bin/console doctrine:migrations:migrate --env=test --no-interaction
```

3. **Charger les fixtures de test :**
```bash
php bin/console doctrine:fixtures:load --env=test --no-interaction
```

### 10. Exécuter les tests

**Tous les tests :**
```bash
php bin/phpunit
```

**Tests unitaires uniquement :**
```bash
php bin/phpunit tests/Unit/
```

**Tests fonctionnels uniquement :**
```bash
php bin/phpunit tests/Functional/
```

**Test spécifique :**
```bash
php bin/phpunit tests/Functional/Controller/AccueilControllerTest.php
```

## Structure du projet

```
assets/
├── app.js                   # Point d'entrée JavaScript
├── styles/           
│   └── app.scss             # Styles principaux
└── js/                      # Modules JavaScript

src/
├── Command/                 # Commandes Symfony
├── Controller/              # Contrôleurs Symfony
│   ├── AccueilController.php
│   └── PanierController.php
├── DataFixtures/            # Fixtures de données
├── Entity/                  # Entités Doctrine
│   ├── Produit.php
│   └── Panier.php
├── EventListener/           # Écouteurs d'événements Symfony
├── Repository/              # Repositories Doctrine
├── Security/                # Gestion de la sécurité
└── Twig/                    # Extensions Twig

templates/
├── accueil/                 # Templates de l'accueil
├── admin/                   # Templates de l'administration
├── panier/                  # Templates du panier
├── partials/                # Composants réutilisables (header & footer)
├── produit/                 # Templates du produit
├── security/                # Templates de la login
└── base.html.twig           # Template de base

tests/
├── Unit/                    # Tests unitaires
└── Functional/              # Tests fonctionnels

translation/
├── messages.fr.yaml         # Traductions en français
└── messages.en.yaml         # Traductions en anglais
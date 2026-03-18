# Vide Grenier en Ligne

Plateforme web pour vendre et acheter des articles d'occasion. Les utilisateurs peuvent créer des annonces, consulter les articles à vendre, et contacter d'autres vendeurs.

## 📋 Table des matières

- [Fonctionnalités](#fonctionnalités)
- [Architecture](#architecture)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Structure du projet](#structure-du-projet)
- [Tests](#tests)
- [Déploiement](#déploiement)
- [API Endpoints](#api-endpoints)

## ✨ Fonctionnalités

- **Authentification sécurisée** : Inscription et connexion avec hash de mots de passe
- **Gestion des annonces** : Créer, consulter, et supprimer des articles
- **Système de contact** : Formulaire pour contacter un vendeur
- **Profil utilisateur** : Consulter les informations de profil
- **Interface responsive** : Design adapté desktop et mobile
- **Deux environnements** : Dev et Production isolés via Docker

## 🏗️ Architecture

### Stack Technique

- **Backend** : PHP 8.1+ (Architecture MVC)
- **Frontend** : HTML5, CSS3 (SCSS), JavaScript
- **Base de données** : MySQL 8.0
- **Web Server** : Nginx
- **Containerisation** : Docker & Docker Compose
- **Tests** : PHPUnit
- **Templating** : Twig

### Architecture MVC

```
App/
├── Controllers/     # Logique métier (Product, User, Auth, etc.)
├── Models/         # Accès à la base de données
├── Views/          # Templates Twig
└── Utilities/      # Fonctions utilitaires (Hash, etc.)

Core/
├── Router.php      # Routage des requêtes
├── Controller.php  # Classe de base pour les contrôleurs
├── View.php        # Gestion des vues Twig
└── Database.php    # Connexion à la base de données
```

## 🚀 Installation

### Prérequis

- Docker et Docker Compose installés
- Git
- Environ 2GB d'espace disque

### Étapes

1. **Cloner le projet**
```bash
git clone https://github.com/kos5454/vide-grenier-en-ligne.git
cd vide-grenier-en-ligne
```

2. **Lancer l'environnement de développement**
```bash
docker compose -f docker-compose.dev.yml up -d
```

3. **Initialiser la base de données**
```bash
docker exec vide-grenier-en-ligne-web-1 php -r "
require 'Core/Database.php';
\$db = new Database();
\$db->query(file_get_contents('sql/schema.sql'));
"
```

4. **Accéder à l'application**
```
http://localhost:8080
```

## ⚙️ Configuration

### Variables d'environnement

Les configurations sont dans `Core/Database.php` :

```php
const DB_HOST = 'db';           // Hôte MySQL
const DB_NAME = 'vide_grenier'; // Nom de la base
const DB_USER = 'root';         // Utilisateur MySQL
const DB_PASSWORD = 'root';     // Mot de passe MySQL
```

### Docker Compose

**Environnement DEV** (`docker-compose.dev.yml`) :
- Volume mounted pour le code (hot reload)
- Port 8080 accessible
- XDebug configuré

**Environnement PROD** (`docker-compose.prod.yml`) :
- Image compilée (pas de volumes)
- Port 8081 accessible
- Performance optimisée

## 💻 Utilisation

### Démarrer l'application

**Développement** :
```bash
docker compose -f docker-compose.dev.yml up -d
```

**Production** :
```bash
docker compose -f docker-compose.prod.yml up -d
```

### Arrêter l'application

```bash
docker compose down
```

### Consulter les logs

```bash
docker compose logs -f web
```

### Accéder au terminal du conteneur

```bash
docker exec -it vide-grenier-en-ligne-web-1 bash
```

## 📁 Structure du projet

```
vide-grenier-en-ligne/
├── App/
│   ├── Controllers/        # Contrôleurs (routing logique)
│   │   ├── Home.php
│   │   ├── Product.php
│   │   ├── User.php
│   │   └── Auth.php
│   ├── Models/            # Modèles (requêtes BD)
│   │   ├── Articles.php
│   │   └── Users.php
│   ├── Views/             # Templates Twig
│   │   ├── base.html
│   │   ├── home.html
│   │   └── Product/
│   └── Utilities/         # Utilitaires
│       └── Hash.php
├── Core/                  # Cœur du framework
│   ├── Router.php
│   ├── Controller.php
│   ├── View.php
│   └── Database.php
├── public/                # Assets (CSS, JS, images)
│   ├── style/
│   ├── js/
│   └── images/
├── style/                 # Source SCSS
│   ├── main.scss
│   ├── _account.scss
│   └── _variables.scss
├── tests/                 # Tests unitaires PHPUnit
│   └── HashTest.php
├── sql/                   # Scripts SQL
│   └── schema.sql
├── docker/                # Configurations Docker
│   ├── php.ini
│   ├── default.conf       # Config Nginx
│   └── Dockerfile
├── Dockerfile             # Image principale
├── docker-compose.dev.yml # Compose dev
├── docker-compose.prod.yml # Compose prod
└── README.md
```

## 🧪 Tests

### Lancer les tests

```bash
docker exec vide-grenier-en-ligne-web-1 ./vendor/bin/phpunit tests/
```

### Test disponible

**HashTest.php** : Teste la fonction de hachage des mots de passe
- Vérifie que `Hash::generate()` retourne une chaîne
- Teste avec un mot de passe simple

### Ajouter des tests

1. Créer un fichier dans `tests/`
2. Étendre la classe `PHPUnit\Framework\TestCase`
3. Lancer `phpunit`

Exemple :
```php
<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Utilities\Hash;

class MonTest extends TestCase {
    public function testExample() {
        $result = Hash::generate("motdepasse");
        $this->assertIsString($result);
    }
}
```

## 🐳 Déploiement

### Environnement Production

L'application est packagée dans une image Docker optimisée :

```bash
# Construire l'image
docker build -t vide-grenier:latest .

# Lancer en production
docker compose -f docker-compose.prod.yml up -d
```

**Différences dev/prod** :
- **Dev** : Code mounté via volume (modifications en temps réel)
- **Prod** : Code copié dans l'image (immuable)
- **Dev** : Port 8080
- **Prod** : Port 8081
- **Prod** : Performance optimisée, cache activé

## 🔌 API Endpoints

### Pages (GET)

| URL | Description |
|-----|-------------|
| `/` | Page d'accueil avec annonces |
| `/login` | Page de connexion |
| `/register` | Page d'inscription |
| `/product/{id}` | Détail d'une annonce |
| `/user/profile` | Profil utilisateur |

### Actions (POST)

| URL | Description |
|-----|-------------|
| `/auth/register` | Créer un compte |
| `/auth/login` | Se connecter |
| `/auth/logout` | Se déconnecter |
| `/product/add` | Créer une annonce |
| `/product/delete` | Supprimer une annonce |

### Sécurité

- Mots de passe hashés avec `Hash::generate()`
- Vérification de propriété avant suppression
- Sessions utilisateur sécurisées
- Protection CSRF (formulaires)

## 📝 Notes de développement

### Hot Reload en Dev

Les modifications de code sont immédiatement visibles grâce aux volumes Docker. Pas besoin de redémarrer.

### SCSS Compilation

Les fichiers SCSS dans `style/` sont compilés en CSS dans `public/style/main.css`. La compilation se fait lors du build de l'image.

### Branchement Git (GitFlow)

- `main` : Production stable
- `develop` : Version de développement
- `feature/*` : Nouvelles fonctionnalités
- `bugfix/*` : Corrections de bugs

## 🤝 Contributeurs

Créé pour le projet CESI.

## 📄 Licence

MIT - Voir LICENSE

# 🎬 Script de Démo - Vide Grenier En Ligne

**Durée : 10-15 minutes**

---

## 🚀 ÉTAPE 0 : Démarrer l'environnement

### Lancer les containers

```bash
cd C:\Users\matte\OneDrive\CESI\Projet\ Docker\vide-grenier-en-ligne

# Démarrer DEV et PROD
docker compose -p dev -f docker-compose.dev.yml up --build -d
docker compose -p prod -f docker-compose.prod.yml up --build -d
```

### Ouvrir les onglets du navigateur

- 🔵 **DEV** → http://localhost:8080
- 🟠 **PROD** → http://localhost:8081

---

## 📁 ÉTAPE 1 : Architecture du projet (2 min)

### Montrer la structure dans VS Code

```
vide-grenier-en-ligne/
├── App/
│   ├── Controllers/   → Home, User, Product, Api
│   ├── Models/        → Articles, User, Cities
│   └── Views/         → Templates Twig
├── Core/
│   ├── Router.php
│   ├── Controller.php
│   └── Model.php      → Connexion PDO
├── tests/             → Tests PHPUnit
├── docker/            → Dockerfile, nginx.conf
├── sql/               → Structure + données
└── docker-compose*.yml
```

### 💡 Points à souligner

✅ **Architecture MVC sans framework** (PHP pur)
✅ **3 environnements Docker** (dev / test / prod)
✅ **Code séparé** : Core (générique) vs App (métier)

---

## 🐳 ÉTAPE 2 : Les 3 environnements Docker (1 min)

### Tableau comparatif

| Environnement | Port | MySQL | Particularité |
|---|---|---|---|
| **DEV** | 8080 | 3306 | Code monté en volume → hot-reload ⚡ |
| **TEST** | 8082 | 3307 | Base isolée pour tester |
| **PROD** | 8081 | 3308 | Code copié dans l'image (standalone) |

### 💡 Explication clé

**DEV** : Modifier le code = changements visibles **immédiatement** sans rebuild
**PROD** : Image autonome déployable n'importe où

---

## 💻 ÉTAPE 3 : Démo fonctionnelle (5 min)

### 3a. Page d'accueil

1. Aller sur **http://localhost:8080**
2. Montrer les annonces
3. Tester le tri par "Popularité" / "Date" (AJAX sans rechargement)

**Explication** : *Les annonces se chargent dynamiquement via /api/products*

---

### 3b. Inscription

1. Cliquer **Inscription**
2. Créer un compte :
   - Email : `demo@test.fr`
   - Mot de passe : `Demo1234`
   - Nom : `Demo User`
3. ✅ Redirection automatique vers "Mon compte"

**Bug corrigé** : *Avant, il fallait se reconnecter après inscription. Maintenant c'est automatique.*

---

### 3c. Déposer une annonce

1. Clicker **Déposer une annonce**
2. Remplir le formulaire :
   - Titre : Ex. "Vélo vintage"
   - Description : Ex. "En bon état"
   - Photo : Choisir une image
   - Ville : Taper (autocomplete avec API réelle)
3. Cliquer **Soumettre**
4. ✅ Annonce créée et visible sur la page d'accueil

**Explication** : *L'autocomplete utilise l'API officielle data.gouv.fr*

---

### 3d. Modifier/Supprimer une annonce

1. Aller dans **Mon compte**
2. Trouver l'annonce créée
3. Cliquer **Modifier** → Changer le titre
4. Sauvegarder → ✅ Notification flash de succès
5. Montrer que la photo reste si on ne la change pas

---

### 3e. Messagerie

1. Se déconnecter
2. Cliquer sur une annonce → **Contacter le vendeur**
3. Remplir et envoyer un message
4. Se reconnecter en tant que `demo@test.fr`
5. Aller dans **Mes messages**
6. ✅ Message reçu avec badge "non lu" (rouge)
7. Cliquer dessus → Message marqué "lu"

---

## 🔒 ÉTAPE 4 : Sécurité (1 min)

### Montrer dans VS Code

**File : App/Utility/Hash.php**
```
✅ Mots de passe en Argon2ID
   (algorithme recommandé par PHP 8)
```

**File : App/Utility/Csrf.php**
```
✅ Token CSRF unique par formulaire
   (protection contre les attaques)
```

**File : App/Controllers/User.php**
```
✅ Cookie "Se souvenir de moi" signé HMAC SHA-256
   (impossible à forger)
```

---

## 🧪 ÉTAPE 5 : Tests unitaires (2 min)

### Lancer les tests

```bash
docker compose -p dev -f docker-compose.dev.yml exec web php vendor/bin/phpunit
```

### Résultat attendu

```
....                                                                4 / 4 (100%)
OK (4 tests, 4 assertions)
```

### Les 4 tests

| Test | Description |
|---|---|
| Test 1 | ✅ Valider un email correct |
| Test 2 | ❌ Rejeter un email invalide |
| Test 3 | ✅ Détecter une chaîne vide |
| Test 4 | ❌ Détecter une chaîne non vide |

---

## 📚 ÉTAPE 6 : Documentation API - Swagger (1 min)

### Fichier `swagger.json`

Le fichier contient la documentation de 2 endpoints :

**GET /api/products**
```
Description : Récupère la liste des annonces
Paramètre : sort (date, prix)
Réponse : Array d'annonces (json)
```

**GET /api/cities**
```
Description : Cherche les villes
Paramètre : query (nom de la ville)
Réponse : Array de villes
```

### Visualiser

1. Aller sur https://editor.swagger.io/
2. **File** → **Import File** → `swagger.json`
3. ✅ Documentation interactive

---

## 🔄 ÉTAPE 7 : Workflow GitFlow (3 min)

### Créer une nouvelle feature

```bash
# 1. Créer branche feature
git checkout develop
git checkout -b feature/ma-nouvelle-feature

# 2. Faire les modifications
# (Les changements s'affichent immédiatement sur 8080 ⚡)

# 3. Commiter et pousser
git add .
git commit -m "feat: description de ma feature"
git push origin feature/ma-nouvelle-feature
```

### Merger en Develop

```bash
# 4. Sur GitHub : créer Merge Request
# Base : develop ← Compare : feature/ma-nouvelle-feature
# Cliquer "Merge pull request"

# 5. En local
git checkout develop
git pull origin develop
```

### Déployer en PROD

```bash
# 6. Merger develop → PROD
git checkout main (ou master)
git pull origin main
git merge develop
git push origin main

# 7. Rebuild PROD
docker compose -p prod -f docker-compose.prod.yml up --build -d
```

### Vérifier

- ✅ DEV : http://localhost:8080
- ✅ PROD : http://localhost:8081

---

## 📋 RÉSUMÉ - Ce qu'on a montré

| ✅ | Fonctionnalité |
|---|---|
| ✅ | Architecture MVC custom (PHP pur) |
| ✅ | 3 environnements Docker (dev/test/prod) |
| ✅ | Tests unitaires PHPUnit |
| ✅ | Workflow GitFlow (feature → dev → prod) |
| ✅ | Documentation API Swagger |
| ✅ | Sécurité (Argon2, CSRF, HMAC) |
| ✅ | AJAX (tri annonces sans rechargement) |
| ✅ | Messagerie interne |
| ✅ | Hot-reload en DEV |

---

## 🎯 Points clés à retenir

> **En DEV** : Le code est monté en volume
> → Modifier un fichier = changements visibles immédiatement ⚡

> **En PROD** : Le code est copié dans l'image Docker
> → Image autonome déployable n'importe où 🚀

> **GitFlow** : feature → develop → main
> → Chaque branche a son utilité 🔀

> **Tests** : 4 tests simples qui passent
> → Validation du code 🧪

---

**Besoin d'aide pour lancer la démo ? 🚀**

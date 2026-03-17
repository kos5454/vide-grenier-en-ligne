# Guide de démonstration

---

## PRÉPARATION (à faire avant la démo)

Ces commandes sont à exécuter **une seule fois** avant le jour de la présentation.

```bash
# 1. Merger les fichiers Docker dans develop et main
git checkout develop
git merge feature/docker-prod

git checkout main
git merge develop

# 2. Merger les tests unitaires dans feature/test-unitaires (déjà fait)
# La branche feature/test-unitaires contient déjà les fichiers Docker

# 3. Installer les dépendances PHPUnit
git checkout feature/test-unitaires
docker compose -f docker-compose.dev.yml up -d
docker compose -f docker-compose.dev.yml exec web composer update
docker compose -f docker-compose.dev.yml down
```

---

## 1. Démonstration des 4 bugs corrigés

### Mise en place
Démarrer l'environnement de dev sur la branche `develop` :

```bash
git checkout develop
docker compose -f docker-compose.dev.yml up -d
```

Site accessible sur : http://localhost:8080

---

### Bug 1 — Photo obligatoire dans une annonce (`bugfix/photo-obligatoire`)
**Ce qui était cassé :** Il était possible de créer une annonce sans photo.
**Comment le montrer :**
1. Se connecter et aller sur "Créer une annonce"
2. Remplir le formulaire sans ajouter de photo
3. Soumettre → un message d'erreur s'affiche, l'annonce n'est pas créée

---

### Bug 2 — Connexion automatique après inscription (`bugfix/connexion-auto-inscription`)
**Ce qui était cassé :** Après l'inscription, l'utilisateur n'était pas connecté automatiquement.
**Comment le montrer :**
1. Créer un nouveau compte
2. Après la soumission du formulaire d'inscription → l'utilisateur est directement connecté et redirigé

---

### Bug 3 — Se souvenir de moi (`bugfix/se-souvenir-de-moi`)
**Ce qui était cassé :** La case "Se souvenir de moi" sur la page de connexion ne fonctionnait pas.
**Comment le montrer :**
1. Se connecter avec la case "Se souvenir de moi" cochée
2. Fermer le navigateur et rouvrir http://localhost:8080
3. L'utilisateur est toujours connecté

---

### Bug 4 — Formulaire de contact sur la page produit (`bugfix/formulaire-contact`)
**Ce qui était cassé :** Le formulaire de contact sur une page d'annonce ne fonctionnait pas.
**Comment le montrer :**
1. Aller sur une annonce
2. Remplir et envoyer le formulaire de contact au vendeur
3. Le message est bien envoyé sans erreur

---

## 2. Démonstration des tests unitaires

### Contexte
Les tests sont sur la branche `feature/test-unitaires` et testent la classe `App\Utility\Hash`.

### Se placer sur la bonne branche
```bash
git checkout feature/test-unitaires
docker compose -f docker-compose.dev.yml up -d 
```

### Lancer les tests
```bash
docker compose -f docker-compose.dev.yml exec web ./vendor/bin/phpunit
```

### Résultat attendu
```
PHPUnit 9.6.34 by Sebastian Bergmann and contributors.

......                                                              6 / 6 (100%)

Time: 00:00.459, Memory: 6.00 MB

OK (6 tests, 6 assertions)
```

### Les 6 tests couverts (fichier `tests/HashTest.php`)
| Test | Ce qu'il vérifie |
|---|---|
| `testGenerateRetourneUneChaine` | `Hash::generate()` retourne bien une string |
| `testGenerateMemeMdpMemeSel` | Même mot de passe + même sel = même hash |
| `testGenerateSelDifferentHashDifferent` | Deux sels différents produisent des hashs différents |
| `testGenerateSaltLongueur` | `Hash::generateSalt(32)` retourne exactement 32 caractères |
| `testGenerateSaltEstAleatoire` | Deux sels générés sont toujours différents |
| `testGenerateUniqueRetourneChaine` | `Hash::generateUnique()` retourne une chaîne non vide |

---

### Gestion des environnements

**Pour supprimer les environnements :**
```bash
# Supprimer le dev
docker compose -f docker-compose.dev.yml down

# Supprimer la prod
docker compose -f docker-compose.prod.yml down
```

**Pour lancer les environnements :**
```bash
# Lancer le dev → http://localhost:8080
./start-dev.sh

# Lancer la prod → http://localhost:80
./start-prod.sh
```

---

## 3. Développement en live avec GitFlow

### Principe
- **Dev** (docker-compose.dev.yml) : port **8080**, volume monté → le code est lu en direct depuis le disque
- **Prod** (docker-compose.prod.yml) : port **80**, pas de volume → le code est figé dans l'image Docker au moment du build

### Étape 1 — Démarrer la prod sur l'ancienne version (main)

Ouvrir un terminal dédié pour la prod :
```bash
git checkout main
docker compose -f docker-compose.prod.yml up -d --build
```

Le site de prod est accessible sur http://localhost:80

---

### Étape 2 — Créer une feature branch et faire la modification (dev)

```bash
git checkout develop
git checkout -b feature/ma-modification
```

Faire la modification de code (exemple : changer un texte, ajouter un champ...).
**Préparer la modification à l'avance pour ne pas perdre de temps.**

Démarrer le dev :
```bash
docker compose -f docker-compose.dev.yml up -d
```

Le dev est accessible sur http://localhost:8080 → **la modification est visible immédiatement** (volume monté).
La prod sur http://localhost:80 → **affiche toujours l'ancienne version**.

---

### Étape 3 — Merger dans develop puis main (GitFlow)

```bash
# Merger la feature dans develop
git checkout develop
git merge feature/ma-modification

# Merger develop dans main
git checkout main
git merge develop
```

---

### Étape 4 — Mettre à jour la production

Rebuilder l'image Docker de prod avec le nouveau code :
```bash
docker compose -f docker-compose.prod.yml up -d --build
```

La prod sur http://localhost:80 → **affiche maintenant la nouvelle version**.

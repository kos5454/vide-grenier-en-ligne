# Guide de démonstration

---

## PRÉPARATION (à faire avant la démo)

Ces commandes sont à exécuter **une seule fois** avant le jour de la présentation.

```bash
# 1. S'assurer que develop a les fichiers Docker et les bugfixes
git checkout develop

# 2. S'assurer que main est à jour avec develop (avec Copyright 2020)
git checkout main
git merge develop --allow-unrelated-histories

# 3. Lancer la prod (doit afficher Copyright 2020)
./start-prod.sh

# 4. Installer PHPUnit pour les tests unitaires
git checkout feature/test-unitaires
./start-dev.sh
docker compose -f docker-compose.dev.yml exec web composer update
docker compose -f docker-compose.dev.yml down
```

**Vérifier avant la démo :**
- http://localhost:8081 → `Copyright 2020` (prod, ancienne version)
- `vendor/bin/phpunit` disponible sur `feature/test-unitaires`

---

## 1. Démonstration des 4 bugs corrigés

### Mise en place
Démarrer l'environnement de dev sur la branche `develop` :

```bash
git checkout develop
./start-dev.sh
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
./start-dev.sh
```

### Lancer les tests
```bash
docker compose -f docker-compose.dev.yml exec web ./vendor/bin/phpunit
```

### Résultat attendu
```
PHPUnit 9.6.34 by Sebastian Bergmann and contributors.

.                                                              1 / 1 (100%)

Time: 00:00.150, Memory: 6.00 MB

OK (1 test, 1 assertion)
```

### Le test couvert (fichier `tests/HashTest.php`)
| Test | Ce qu'il vérifie |
|---|---|
| `testGenerateRetourneUneChaine` | `Hash::generate()` retourne une string |

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

# Lancer la prod → http://localhost:8081
./start-prod.sh
```

---

## 3. Développement en live avec GitFlow

### Principe
- **Dev** (docker-compose.dev.yml) : port **8080**, volume monté → le code est lu en direct depuis le disque
- **Prod** (docker-compose.prod.yml) : port **8081**, pas de volume → le code est figé dans l'image Docker au moment du build

### Modification à préparer à l'avance
Dans `App/Views/base.html`, changer `Copyright 2020` en `Copyright 2026`.

---

### Étape 1 — Démarrer la prod sur l'ancienne version (main)

```bash
git checkout main
./start-prod.sh
```

La prod affiche `Copyright 2020` sur http://localhost:8081

---

### Étape 2 — Créer la feature branch et faire la modification

```bash
git checkout develop
git checkout -b feature/mise-a-jour-copyright
```

Modifier `App/Views/base.html` : `Copyright 2020` → `Copyright 2026`

Démarrer le dev :
```bash
./start-dev.sh
```

- Dev http://localhost:8080 → affiche `Copyright 2026` ✓
- Prod http://localhost:8081 → affiche encore `Copyright 2020` ✓

---

### Étape 3 — Merger dans develop puis main (GitFlow)

```bash
git add App/Views/base.html
git commit -m "mise a jour copyright 2026"

git checkout develop
git merge feature/mise-a-jour-copyright

git checkout main
git merge develop
```

---

### Étape 4 — Mettre à jour la production

```bash
./start-prod.sh
```

La prod http://localhost:8081 → **affiche maintenant `Copyright 2026`** ✓

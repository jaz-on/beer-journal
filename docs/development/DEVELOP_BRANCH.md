# Création et utilisation de la branche develop

Ce document explique comment créer et utiliser la branche `develop` pour le développement.

## Création de la branche develop

### Après merge de docs

Une fois la branche `docs` mergée dans `main`, créer la branche `develop` :

```bash
# 1. S'assurer d'être sur main et à jour
git checkout main
git pull origin main

# 2. Créer la branche develop
git checkout -b develop

# 3. Pousser la branche et configurer le tracking
git push -u origin develop
```

## Utilisation de develop

### Workflow de développement

```
main (production)
  ↑
  └── develop (intégration)
      ├── feature/base-structure
      ├── feature/rss-parser
      ├── feature/scraper
      └── ...
```

### Créer une branche de feature

```bash
# Toujours partir de develop
git checkout develop
git pull origin develop

# Créer la branche de feature
git checkout -b feature/feature-name

# Développer...
git add .
git commit -m "feat: Implement feature"

# Pousser la branche
git push -u origin feature/feature-name
```

### Merger une feature dans develop

```bash
# Sur develop
git checkout develop
git pull origin develop

# Merger la feature
git merge feature/feature-name --no-ff -m "feat: Merge feature-name into develop"

# Pousser
git push origin develop
```

### Merger develop dans main

Après validation et tests :

```bash
# Sur main
git checkout main
git pull origin main

# Merger develop
git merge develop --no-ff -m "chore: Merge develop into main for release"

# Pousser
git push origin main

# Créer un tag si release
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin --tags
```

## Règles de développement

### Branches de feature

- **Nommage** : `feature/feature-name` (kebab-case)
- **Base** : Toujours partir de `develop`
- **Merge** : Dans `develop` après validation
- **Suppression** : Supprimer après merge dans `main`

### Branches de bugfix

- **Nommage** : `bugfix/issue-description`
- **Base** : `develop` (ou `main` pour hotfix)
- **Merge** : Dans `develop` (ou `main` pour hotfix)

### Branches de hotfix

- **Nommage** : `hotfix/issue-description`
- **Base** : `main`
- **Merge** : Dans `main` ET `develop`

## Intégration avec documentation

### Documentation parallèle

Lors du développement d'une feature :

1. **Code** : Sur `feature/feature-name`
2. **Documentation** : Sur `docs/feature-name`
3. **Merge code** : `feature/feature-name` → `develop`
4. **Merge doc** : `docs/feature-name` → `docs`
5. **Merge docs** : `docs` → `main`
6. **Merge develop** : `develop` → `main`

Voir [Workflow de documentation](workflow-documentation.md) pour plus de détails.

## Exemple complet

### Développement d'une feature

```bash
# 1. Créer branche de feature
git checkout develop
git checkout -b feature/rss-parser

# 2. Développer
# ... code ...

# 3. Commiter
git add .
git commit -m "feat(rss): Add RSS parser class"

# 4. Pousser
git push -u origin feature/rss-parser

# 5. Créer PR vers develop
# (via interface GitHub)

# 6. Après merge, supprimer la branche locale
git checkout develop
git pull origin develop
git branch -d feature/rss-parser
```

### Documentation en parallèle

```bash
# 1. Créer branche de documentation
git checkout docs
git checkout -b docs/feature-rss-parser

# 2. Documenter
# ... documentation ...

# 3. Commiter
git add .
git commit -m "docs: Document RSS parser feature"

# 4. Merger dans docs
git checkout docs
git merge docs/feature-rss-parser

# 5. Valider
./scripts/validate-docs.sh

# 6. Merger docs dans main
git checkout main
git merge docs
```

## Bonnes pratiques

1. **Toujours partir de develop** pour les nouvelles features
2. **Valider avant merge** : Tests, linting, validation docs
3. **Messages de commit clairs** : Suivre Conventional Commits
4. **PR descriptives** : Expliquer les changements
5. **Tests** : Ajouter/ mettre à jour les tests
6. **Documentation** : Mettre à jour la doc en parallèle

## Références

- [DEVELOPMENT.md](../../DEVELOPMENT.md) - Guide de développement
- [Workflow de documentation](workflow-documentation.md) - Workflow docs
- [Contributing Guide](contributing.md) - Guide de contribution


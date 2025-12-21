# Workflow de documentation

Ce document décrit le workflow de documentation pour le plugin Beer Journal.

## Structure de branches

```
main (production)
  ↑
  ├── docs (documentation stable)
  │   ├── docs/feature-rss-sync
  │   └── docs/update-api-docs
  │
  └── develop (code en développement)
      └── feature/* (branches de code)
```

## Règles de documentation

### Petites corrections

Pour les petites corrections (typos, liens cassés, clarifications) :

1. Travailler directement sur la branche `docs`
2. Valider avec `scripts/validate-docs.sh`
3. Commiter avec préfixe `docs:`
4. Merger dans `main` après validation

```bash
git checkout docs
# Faire les corrections
./scripts/validate-docs.sh
git commit -m "docs: Fix broken link in architecture overview"
git checkout main
git merge docs
```

### Documentation de feature

Pour documenter une nouvelle feature :

1. Créer une branche `docs/feature-name` depuis `docs`
2. Documenter la feature dans les fichiers appropriés
3. Valider la documentation
4. Merger dans `docs`
5. Merger `docs` dans `main` après validation

```bash
git checkout docs
git checkout -b docs/feature-rss-sync
# Documenter la feature
./scripts/validate-docs.sh
git commit -m "docs: Document RSS sync feature"
git checkout docs
git merge docs/feature-rss-sync
```

### Mises à jour majeures

Pour les mises à jour majeures (refonte, nouvelle structure) :

1. Créer une branche `docs/update-topic` depuis `docs`
2. Effectuer les mises à jour
3. Valider exhaustivement
4. Merger dans `docs`
5. Merger `docs` dans `main` après validation complète

## Cycle de vie

### Développement parallèle code/documentation

1. **Développement de code** sur `develop` ou `feature/*`
2. **Documentation parallèle** sur `docs/feature-name`
3. **Merge code** → `develop`
4. **Merge doc** → `docs`
5. **Validation** et merge `docs` → `main`
6. **Merge `develop`** → `main` (avec documentation à jour)

### Exemple de workflow complet

```bash
# 1. Développer la feature
git checkout develop
git checkout -b feature/rss-parser
# ... développement ...

# 2. Documenter en parallèle
git checkout docs
git checkout -b docs/feature-rss-parser
# ... documentation ...

# 3. Merge code
git checkout develop
git merge feature/rss-parser

# 4. Merge doc
git checkout docs
git merge docs/feature-rss-parser
./scripts/validate-docs.sh

# 5. Merge docs dans main
git checkout main
git merge docs

# 6. Merge develop dans main
git merge develop
```

## Outils de validation

### Script de validation

Valide la structure, les liens et la cohérence :

```bash
./scripts/validate-docs.sh
```

Vérifie :
- Liens markdown valides
- Syntaxe Mermaid correcte
- Cohérence des préfixes (bj_, BJ_, _bj_)
- Présence des fichiers requis

### Script d'analyse

Analyse la documentation et génère un rapport :

```bash
php scripts/analyze-docs.php
```

Extrait :
- Composants documentés (classes BJ_*)
- Fonctions documentées (bj_*)
- Hooks WordPress
- Dépendances

Génère un rapport JSON : `scripts/docs-analysis-report.json`

## Prompts réutilisables

Pour analyser la documentation avec un assistant IA, voir [Prompts réutilisables](prompts-reutilisables.md).

### Utilisation

1. **Planification initiale** : Utiliser Prompt 1 pour créer le plan complet MVP
2. **Développement itératif** : Utiliser Prompt 2 pour chaque module
3. **Validation continue** : Utiliser Prompt 3 pour maintenir la cohérence
4. **Nouvelles features** : Utiliser Prompt 4 pour documenter de nouvelles fonctionnalités

## Template de plan de développement

Pour créer un plan de développement standardisé, utiliser le [Template de plan](template-plan-developpement.md).

## Validation avant merge

### Checklist

- [ ] Tous les liens fonctionnent
- [ ] Diagrammes Mermaid valides
- [ ] Préfixes cohérents (bj_, BJ_, _bj_)
- [ ] Références croisées correctes
- [ ] Script de validation passe
- [ ] Documentation à jour avec le code

### Commandes de validation

```bash
# Validation complète
./scripts/validate-docs.sh

# Analyse de la documentation
php scripts/analyze-docs.php

# Vérification manuelle des liens
find docs -name "*.md" -exec grep -l "\[.*\](.*)" {} \;
```

## GitHub Actions

Un workflow GitHub Actions valide automatiquement la documentation sur les branches `docs` et `main`.

Voir : `.github/workflows/docs-validation.yml`

## Bonnes pratiques

1. **Documenter en parallèle** : Ne pas attendre la fin du développement pour documenter
2. **Valider régulièrement** : Exécuter les scripts de validation souvent
3. **Maintenir la cohérence** : Suivre les conventions de nommage
4. **Mettre à jour les références** : Vérifier les liens après déplacement de fichiers
5. **Utiliser les templates** : Suivre le template pour les plans de développement

## Références

- [DEVELOPMENT.md](../../DEVELOPMENT.md) - Guide de développement général
- [Contributing Guide](contributing.md) - Guide de contribution
- [Coding Standards](coding-standards.md) - Standards de code
- [Prompts réutilisables](prompts-reutilisables.md) - Prompts pour analyse IA
- [Template de plan](template-plan-developpement.md) - Template pour plans de développement


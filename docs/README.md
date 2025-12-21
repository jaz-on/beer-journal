# Dossier `.todo/` - Documentation de travail locale

## ⚠️ Protection et usage

Ce dossier contient des fichiers de documentation et de planification **locaux** qui ne doivent **jamais** être versionnés dans Git.

### Pourquoi ce dossier est protégé ?

- **Contenu sensible** : Peut contenir des notes personnelles, des spécifications en cours, des plans de développement
- **Travail en cours** : Documents qui évoluent fréquemment et ne doivent pas polluer l'historique Git
- **Spécifique au développeur** : Chaque développeur peut avoir ses propres fichiers de travail

### Protection mise en place

1. **`.gitignore`** : Le dossier `.todo/` est ignoré par Git (ne sera jamais commité)
2. **Ce README** : Rappel de l'usage et de la protection

### Contenu typique

- Plans d'audit et de documentation
- Spécifications techniques détaillées
- Notes de développement
- Checklists personnelles
- Documentation en cours de rédaction

### ⚠️ Important

- **Ne jamais** ajouter ce dossier à Git (déjà protégé par `.gitignore`)
- **Ne jamais** supprimer ce dossier par inadvertance
- Les fichiers ici sont **locaux uniquement** - faire des backups si nécessaire

### Backup recommandé

Si vous souhaitez sauvegarder le contenu de ce dossier :
- Utiliser un système de backup local (Time Machine, etc.)
- Ou créer un dépôt Git séparé pour la documentation
- Ou exporter vers un service cloud (Dropbox, Google Drive, etc.)

---

*Ce fichier README est lui-même ignoré par Git pour rester cohérent avec la protection du dossier.*


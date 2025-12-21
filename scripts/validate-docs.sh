#!/bin/bash
# Script de validation de documentation
#
# Vérifie :
# - Les liens markdown
# - La syntaxe Mermaid
# - La cohérence des préfixes (bj_, BJ_, _bj_)
# - Génère un rapport
#
# Usage: ./scripts/validate-docs.sh

set -e

DOCS_DIR="docs"
REPORT_FILE="docs-validation-report.txt"
ERRORS=0
WARNINGS=0

# Couleurs pour le terminal
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo "=== VALIDATION DE LA DOCUMENTATION ===" > "$REPORT_FILE"
echo "Date: $(date)" >> "$REPORT_FILE"
echo "" >> "$REPORT_FILE"

# Fonction pour logger les erreurs
log_error() {
    echo -e "${RED}ERREUR:${NC} $1"
    echo "ERREUR: $1" >> "$REPORT_FILE"
    ((ERRORS++))
}

# Fonction pour logger les avertissements
log_warning() {
    echo -e "${YELLOW}AVERTISSEMENT:${NC} $1"
    echo "AVERTISSEMENT: $1" >> "$REPORT_FILE"
    ((WARNINGS++))
}

# Fonction pour logger les succès
log_success() {
    echo -e "${GREEN}OK:${NC} $1"
    echo "OK: $1" >> "$REPORT_FILE"
}

echo "1. Vérification des liens markdown..."

# Vérifier les liens relatifs dans les fichiers markdown
find "$DOCS_DIR" -name "*.md" -type f | while read -r file; do
    # Extraire les liens markdown [text](path)
    while IFS= read -r line; do
        # Extraire les liens markdown
        if [[ $line =~ \[([^\]]+)\]\(([^)]+)\) ]]; then
            link_path="${BASH_REMATCH[2]}"
            
            # Ignorer les liens externes (http/https)
            if [[ ! $link_path =~ ^https?:// ]]; then
                # Résoudre le chemin relatif
                file_dir=$(dirname "$file")
                resolved_path="$file_dir/$link_path"
                
                # Vérifier si le fichier existe
                if [[ ! -f "$resolved_path" ]] && [[ ! -d "$resolved_path" ]]; then
                    log_error "Lien cassé dans $file : $link_path"
                fi
            fi
        fi
    done < "$file"
done

echo "2. Vérification de la syntaxe Mermaid..."

# Vérifier la présence de blocs Mermaid
find "$DOCS_DIR" -name "*.md" -type f | while read -r file; do
    if grep -q '```mermaid' "$file"; then
        # Vérifier que chaque bloc mermaid a une fermeture
        mermaid_blocks=$(grep -c '```mermaid' "$file" || true)
        mermaid_closes=$(grep -c '```' "$file" || true)
        
        if [ $((mermaid_closes % 2)) -ne 0 ]; then
            log_warning "Bloc Mermaid potentiellement mal fermé dans $file"
        fi
    fi
done

echo "3. Vérification de la cohérence des préfixes..."

# Vérifier les préfixes bj_, BJ_, _bj_
find "$DOCS_DIR" -name "*.md" -type f | while read -r file; do
    # Vérifier que les classes utilisent BJ_
    if grep -qE '\bBJ_[a-zA-Z_]+\b' "$file"; then
        # Vérifier qu'il n'y a pas de classes sans préfixe BJ_
        if grep -qE '\bclass\s+[A-Z][a-zA-Z_]+\s*\{' "$file" 2>/dev/null; then
            log_warning "Classe potentiellement sans préfixe BJ_ dans $file"
        fi
    fi
    
    # Vérifier que les fonctions utilisent bj_
    if grep -qE '\bbj_[a-z_]+\(\)' "$file"; then
        # Vérifier qu'il n'y a pas de fonctions sans préfixe
        if grep -qE '\bfunction\s+[a-z_]+\(\)' "$file" 2>/dev/null; then
            log_warning "Fonction potentiellement sans préfixe bj_ dans $file"
        fi
    fi
done

echo "4. Vérification de la structure des fichiers..."

# Vérifier que les fichiers principaux existent
REQUIRED_FILES=(
    "docs/architecture/overview.md"
    "docs/architecture/components.md"
    "docs/db/schema.md"
    "docs/features/checklist.md"
    "DEVELOPMENT.md"
)

for required_file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$required_file" ]; then
        log_success "Fichier requis présent : $required_file"
    else
        log_error "Fichier requis manquant : $required_file"
    fi
done

# Générer le résumé
echo "" >> "$REPORT_FILE"
echo "=== RÉSUMÉ ===" >> "$REPORT_FILE"
echo "Erreurs: $ERRORS" >> "$REPORT_FILE"
echo "Avertissements: $WARNINGS" >> "$REPORT_FILE"

echo ""
echo "=== RÉSUMÉ ==="
echo -e "${RED}Erreurs: $ERRORS${NC}"
echo -e "${YELLOW}Avertissements: $WARNINGS${NC}"
echo ""
echo "Rapport complet sauvegardé dans : $REPORT_FILE"

if [ $ERRORS -gt 0 ]; then
    exit 1
fi

exit 0


# Identifiants et migration (`jb` → `jt`)

Le code et la base utilisent désormais le préfixe **`jt_`** (options), **`_jt_`** (post meta), **`JT_`** (classes PHP), **`jt_`** (fonctions globales, hooks, actions AJAX, transients).

À l’**activation / `plugins_loaded`**, `JT_Storage_Migration` enchaîne :

1. **`maybe_migrate()`** — import unique depuis beer-journal / `bj_*` vers `jt_*` (sauf si une ancienne version avait déjà posé `jb_storage_migrated_v1`).
2. **`maybe_migrate_jb_prefix_storage_to_jt()`** — copie puis suppression de toutes les options `jb_*` vers `jt_*`, renommage des métas `_jb_*` → `_jt_*`, purge des transients `jb_*`, nettoyage WP-Cron / Action Scheduler pour les noms de hooks `jb_*` et `jt_*` sur les groupes `beer-journal`, `jardin-beer`, `jardin-toasts`.
3. **`maybe_migrate_product_rename()`** — chemins / blocs `jardin-beer` → `jardin-toasts` dans `post_content` (sauf si l’ancien drapeau `jb_jardin_toasts_product_rename_v1` est déjà présent).

Les signets admin obsolètes (`jardin-beer`, `jardin-beer-settings`, `jb_jardin_beer_settings`, …) sont toujours redirigés vers l’écran réglages actuel.

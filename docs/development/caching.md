# Caching Strategy (Transients)

## Overview

Beer Journal utilise les Transients WordPress pour accélérer les opérations coûteuses (scraping, statistiques, requêtes). Les transients stockent des données temporaires avec une date d’expiration.

## Conventions

- Préfixe des clés: `bj_`
- Nommage: `bj_{domaine}_{identifiant}` (court et déterministe)
  - Exemples:
    - `bj_scrape_{checkinId}`
    - `bj_global_stats`
    - `bj_query_archive_{hash}`
- TTL recommandés:
  - Scraping: 3 heures
  - Statistiques globales: 1 heure
  - Requêtes d’archives: 30 minutes

## API WordPress

```php
// Écrire
set_transient('bj_key', $data, 3 * HOUR_IN_SECONDS);

// Lire
$data = get_transient('bj_key'); // false si expiré/absent

// Supprimer
delete_transient('bj_key');
```

## Helper suggéré (contrat)

Sans imposer une implémentation, les appels devraient suivre ce contrat logique:

```php
// Contrat logique recommandé
function bj_get_cached_data($key, callable $producer, int $ttlSeconds = null) {
    $cacheKey = 'bj_' . $key;
    $cached = get_transient($cacheKey);
    if ($cached !== false) {
        return $cached;
    }
    $data = $producer();
    $ttl = $ttlSeconds ?? (3 * HOUR_IN_SECONDS); // défaut 3h
    set_transient($cacheKey, $data, $ttl);
    return $data;
}
```

## Invalidation

- Après import/sync, invalider:
  - Statistiques globales (`bj_global_stats`)
  - Requêtes d’archives liées (clés dérivées)
  - Entrées de scraping si la page a été rafraîchie
- Invalidation ciblée préférable à un “clear all” global.

## Option A (MVP)

- Caching automatique, sans UI.
- TTLs indiqués ci‑dessus.

## Option B (v1.5, future)

- `bj_cache_enabled` (bool) et `bj_cache_hours` (int)
- UI dans Settings > Advanced avec bouton “Clear cache”

## Bonnes pratiques

- Ne pas mettre en cache des données sensibles.
- Toujours prévoir un fallback si `get_transient` retourne `false`.
- Utiliser des TTL raisonnables et documentés.
- Documenter les clés de cache critiques dans cette page.

## Clés de cache (répertoire)

- `bj_global_stats`: statistiques agrégées (1h)
- `bj_top_breweries`: top brasseries (1j)
- `bj_query_archive_{hash}`: résultats d’archives (30min)
- `bj_scrape_{checkinId}`: résultat de scraping (3h)



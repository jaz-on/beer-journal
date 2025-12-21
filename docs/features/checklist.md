# Features Checklist

## Overview

Checklist complète des fonctionnalités de Beer Journal pour la version initiale (1.0.0).

## Version initiale (1.0.0)

### Core Functionality
- [x] Custom Post Type `beer` registration
- [x] Taxonomies: `beer_style`, `brewery`, `venue`
- [x] Meta fields system (`_bj_*` fields)
- [x] RSS synchronization with adaptive polling
- [x] HTML scraping for complete metadata
- [x] Historical import crawler (manual mode)
- [x] Image import to Media Library
- [x] Rating system with mapping and labels
- [x] Deduplication by check-in ID
- [x] Auto-creation of taxonomy terms

### Admin Interface
- [x] Settings page with 5 tabs (WordPress native tab navigation)
- [x] Inline help texts under settings sections
- [x] Synchronization settings
- [x] Historical import interface
- [x] Rating system configuration
- [x] Taxonomies review/merge
- [x] Advanced/Debug settings
  - [x] Schema.org enable/disable option
  - [x] Microformats enable/disable option
- [x] Import progress tracking (AJAX)
- [x] Logs viewer
- [x] Statistics dashboard

### Frontend
- [x] Archive template (grid/table views)
- [x] Single check-in template
- [x] Taxonomy templates (style, brewery, venue)
- [x] Template hierarchy (theme override support)
- [x] Template tags for developers
- [x] Hooks and filters for customization
  - [x] Content filters (`bj_checkin_content`, `bj_rating_display`, `bj_beer_photo`, `bj_venue_info`, `bj_brewery_link`)
- [x] Schema.org structured data (JSON-LD) - enabled by default
- [x] Microformats (h-entry, e-content) - enabled by default
- [x] Responsive design
- [x] Grid and table view toggle
- [x] Filter by rating/notes (in addition to taxonomies)

### Data Management
- [x] Post status management (publish/draft)
- [x] Exclude from sync protection (`_bj_exclude_sync` meta field)
- [x] Retry logic for failed imports
- [x] Error logging system
- [x] Admin notifications
- [x] Email notifications (optional)
- [x] Checkpoint system for imports

### Performance
- [x] GUID comparison optimization
- [x] Database indexes
- [x] Caching (transients) - automatic with documented TTL (3h scraping, 1h stats, 30min queries)
- [x] Cache helper function (`bj_get_cached_data()`)
- [x] Lazy loading images
- [x] Batch processing

### Security
- [x] Data sanitization
- [x] Output escaping
- [x] Nonces for forms/AJAX
- [x] Capability checks
- [x] Input validation

### Internationalization
- [x] Text domain: `beer-journal`
- [x] All strings translatable
- [x] .pot file generation
- [x] Language file structure

---

## Feature Status Legend

- [x] Completed
- [ ] Planned
- [~] In Progress
- [!] Blocked
- [-] Cancelled

---

## Related Documentation

- [Roadmap](roadmap.md)
- [Core Modules](core-modules.md)


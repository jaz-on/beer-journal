# Features Checklist

## Overview

**Phase 1 (MVP)** is **complete** in code for everything listed in [README.md](../../README.md) under “Phase 1 (MVP) - Version 1.0”. Core shipped items are under **[1.0.0](../../CHANGELOG.md#100---2026-04-20)** in [CHANGELOG.md](../../CHANGELOG.md); follow-up polish (stats box, caching helpers, email notifications, archive grid/table, placeholder image, optional DB index) is recorded under **[Unreleased](../../CHANGELOG.md#unreleased)** until you authorize a new version number.

Items below marked **Phase 2** are intentionally out of scope for the first release.

## Version 1.0.x (implemented)

### Core functionality
- [x] Custom Post Type `beer_checkin` registration
- [x] Taxonomies: `beer_style`, `brewery`, `venue`
- [x] Core meta fields (`_bj_*`) on import + REST registration for main keys
- [x] RSS synchronization with adaptive WP-Cron (`sixhourly` / `daily` / `weekly`)
- [x] HTML scraping for check-in pages (DomCrawler + fallbacks)
- [x] Historical import: profile discovery + batched AJAX import; checkpoint in `bj_import_checkpoint`
- [x] Image sideload to Media Library (dedup by hash / source URL) (1.0.0)
- [x] Placeholder attachment when sideload fails (Unreleased)
- [x] Rating mapping via `bj_rating_rules` filter + defaults
- [x] Deduplication by `_bj_checkin_id`
- [x] Auto-creation of taxonomy terms on import (`wp_set_object_terms` with create)
- [x] Transient cache `bj_get_cached_data()` + `bj_invalidate_stats_cache()` (Unreleased)
- [x] Optional index `bj_checkin_meta` on `wp_postmeta` (best-effort) (Unreleased)

### Admin interface
- [x] Top-level **Beer Journal** menu; settings under 5 tabs (query arg `tab`)
- [x] Synchronization + RSS “Run sync now” (AJAX)
- [x] Historical import controls (discover + import batch) (AJAX)
- [x] General / Rating / Advanced options
- [x] Logs viewer (tail of today’s file, Advanced tab)
- [x] **At a glance** stats: published/draft counts + last RSS sync time (Unreleased)
- [x] Email notifications: optional on sync success and on RSS error (Unreleased)
- [ ] **Phase 2:** Dedicated taxonomies merge/review UI
- [ ] **Phase 2:** Advanced statistics with charts (dashboard widget level)

### Frontend
- [x] Default plugin templates: archive, single, taxonomies (`public/templates/`)
- [x] Theme overrides via `beer-journal/` in theme (see `public/class-public.php`)
- [x] Template tags: `bj_the_rating_stars`, getters in `public/template-tags.php`
- [x] Filter `bj_checkin_content`; filter `bj_rating_display` on star markup
- [x] JSON-LD Review block (option `bj_schema_enabled`)
- [x] Microformats classes on templates (option `bj_microformats_enabled`)
- [x] Archive + taxonomy **grid or table** layout (option `bj_archive_layout`) (Unreleased)
- [ ] **Phase 2:** Front-end filters by rating (AJAX / faceted UI)

### Data management
- [x] Publish vs draft when rating missing (draft + `_bj_incomplete_reason`)
- [x] `_bj_exclude_sync` respected on re-import
- [x] Scrape retries (scraper-level)
- [x] File logging + optional debug lines
- [x] Email notifications (sync / errors) — optional (Unreleased)

### Security & i18n
- [x] Sanitization, escaping, capabilities, AJAX nonces on admin actions
- [x] Text domain `beer-journal`; stub `languages/beer-journal.pot` (regenerate with `wp i18n make-pot` when desired)

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

# Historical Import - Detailed

## Overview

Detailed documentation of the historical import system for importing entire Untappd history.

## Import Modes

### Manual Mode

**Recommended for**: ~200 check-ins

**Process**:
1. User clicks "Start Import"
2. Browser stays open
3. Process runs synchronously
4. Progress updates via AJAX every 5 seconds
5. Can pause/resume

**Limitations**:
- Browser timeout (typically 30-60 seconds)
- Limited to ~8 pages (200 check-ins) before timeout

---

### Background Mode

**Recommended for**: Large imports (1000+ check-ins)

**Process**:
1. User clicks "Start Background Import"
2. WP-Cron takes over
3. One batch per hour
4. Email notification when complete

**Advantages**:
- No browser timeout
- Can process thousands of check-ins
- Runs in background

**Disadvantages**:
- Slower (1 batch per hour)
- Requires WP-Cron to be working
- Less real-time feedback

---

## Profile Page Scraping

### URL Structure

**Format**: `https://untappd.com/user/{username}`

**Pagination**: 
- 25 check-ins per page
- Next page: `?next={checkin_id}` or similar

---

### HTML Structure

**Check-in Links**:
```html
<div class="checkin-list">
  <a href="/user/{username}/checkin/{id}">Check-in 1</a>
  <a href="/user/{username}/checkin/{id}">Check-in 2</a>
  <!-- ... 25 check-ins per page -->
</div>
```

---

### Extraction Process

```php
// Fetch profile page
$html = wp_remote_get($profile_url);

// Parse with DomCrawler
$crawler = new Crawler($html);

// Extract check-in URLs
$checkin_urls = $crawler->filter('.checkin-list a[href*="/checkin/"]')
    ->extract(['href']);

// Convert to full URLs
foreach ($checkin_urls as $url) {
    $full_url = 'https://untappd.com' . $url;
    // Process check-in
}
```

---

## Batch Processing

### Batch Size Configuration

**Options**: 25, 50, or 100 check-ins per batch

**Recommendation**:
- Manual mode: 25 (faster feedback)
- Background mode: 50-100 (efficiency)

---

### Batch Processing Loop

```php
$batch_size = get_option('bj_import_batch_size', 25);
$delay = get_option('bj_import_delay', 3);

foreach ($checkin_urls as $index => $url) {
    // Scrape and import
    bj_import_checkin_from_url($url);
    
    // Delay between requests
    if ($index < count($checkin_urls) - 1) {
        sleep($delay);
    }
    
    // Save checkpoint every batch
    if (($index + 1) % $batch_size === 0) {
        bj_save_checkpoint($index + 1);
    }
}
```

---

## Checkpoint System

### Checkpoint Data

**Stored in**: `bj_import_checkpoint` option

**Structure**:
```php
[
    'current_page' => 3,
    'total_imported' => 75,
    'last_checkin_id' => '123456',
    'started_at' => 1699632000, // Unix timestamp
    'checkin_urls' => [...], // Remaining URLs
]
```

---

### Checkpoint Save

**After Each Batch**:
```php
function bj_save_checkpoint($imported_count, $current_page, $remaining_urls) {
    update_option('bj_import_checkpoint', [
        'current_page' => $current_page,
        'total_imported' => $imported_count,
        'last_checkin_id' => $last_checkin_id,
        'started_at' => $started_at,
        'checkin_urls' => $remaining_urls,
    ]);
}
```

---

### Resume from Checkpoint

**Implementation**:
```php
function bj_resume_import() {
    $checkpoint = get_option('bj_import_checkpoint');
    
    if (empty($checkpoint)) {
        return new WP_Error('no_checkpoint', 'No checkpoint found');
    }
    
    // Continue from checkpoint
    $remaining_urls = $checkpoint['checkin_urls'];
    $total_imported = $checkpoint['total_imported'];
    
    // Process remaining URLs
    foreach ($remaining_urls as $url) {
        // Import check-in
        // Skip if already imported (deduplication)
    }
}
```

---

## Progress Tracking

### Real-Time Updates

**AJAX Endpoint**: `bj_get_import_progress`

**Updates**: Every 5 seconds

**Data Returned**:
```php
[
    'total' => 200,
    'imported' => 75,
    'percentage' => 37.5,
    'current_page' => 3,
    'total_pages' => 8,
    'time_elapsed' => 180, // seconds
    'eta' => 300, // seconds
]
```

---

### ETA Calculation

```php
$elapsed = time() - $start_time;
$rate = $imported / $elapsed; // check-ins per second
$remaining = $total - $imported;
$eta = $remaining / $rate; // seconds remaining
```

---

## Error Handling

### Network Errors

**Handling**: Retry up to 3 times, then skip

---

### Scraping Failures

**Handling**: Save as draft, continue with next

---

### Timeout Handling

**Manual Mode**:
- Save checkpoint
- Display "Import paused" message
- Provide "Resume" button

**Background Mode**:
- No timeout (WP-Cron handles)
- Checkpoint saved after each batch

---

## HTML Export Parsing (Alternative Method)

### Overview

Alternative import method using Untappd HTML export file (`[username]-beerlist.html`). This method allows importing entire history without scraping individual pages.

### Export File Structure

**File Location**: User-provided HTML export from Untappd

**HTML Structure** (based on Eleventy implementation analysis):
```html
<div class="beer-item">
  <div class="beer-details">
    <div class="name">
      <a href="/b/beer-name/12345">Beer Name</a>
    </div>
    <div class="brewery">
      <a href="/brewery/brewery-name/6789">Brewery Name</a>
    </div>
    <div class="style">IPA - American</div>
  </div>
  <div class="details">
    <p class="abv">6.5% ABV</p>
    <p class="ibu">40 IBU</p>
    <p class="date">
      <a href="/user/username/checkin/123456">
        <abbr>04/12/25</abbr>
      </a>
    </p>
  </div>
  <div class="feedback">
    <span class="rating s450"></span> <!-- s450 = 4.50 rating -->
  </div>
</div>
```

### Parsing Process

#### Step 1: Extract Beer Data

**Selectors** (Symfony DomCrawler):
```php
$beer_name = $item->filter('.beer-details .name a')->text();
$brewery_name = $item->filter('.beer-details .brewery a')->text();
$style = $item->filter('.beer-details .style')->text();
```

#### Step 2: Extract ABV and IBU

**ABV Extraction**:
```php
$abv_text = $item->filter('.details p.abv')->text(); // "6.5% ABV"
preg_match('/(\d+(?:\.\d+)?)%\s*ABV/', $abv_text, $matches);
$abv = $matches[1] ? (float) $matches[1] : 0.0;
```

**IBU Extraction**:
```php
$ibu_text = $item->filter('.details p.ibu')->text(); // "40 IBU"
preg_match('/(\d+)\s*IBU/', $ibu_text, $matches);
$ibu = $matches[1] ? (int) $matches[1] : 0;
```

#### Step 3: Extract Rating

**Rating from CSS Class**:
```php
$rating_span = $item->filter('.feedback .ratings span.rating');
$rating_class = $rating_span->attr('class');
// Extract class like 's450' (450 = 4.50 rating)
preg_match('/\bs(\d+)\b/', $rating_class, $matches);
$rating_value = $matches[1] ? (int) $matches[1] : 0;
$rating = ($rating_value / 100); // s450 → 4.50
```

**Rating Mapping**:
- `s000` → 0.0
- `s100` → 1.0
- `s250` → 2.50
- `s450` → 4.50
- `s500` → 5.0

#### Step 4: Extract Check-in URL and ID

**URL Extraction**:
```php
$checkin_url = $item->filter('.details p.date a')->attr('href');
// Relative: "/user/username/checkin/123456"
// Convert to absolute: "https://untappd.com/user/username/checkin/123456"
if ($checkin_url && strpos($checkin_url, '/user') === 0) {
    $checkin_url = 'https://untappd.com' . $checkin_url;
}

// Extract check-in ID
preg_match('/\/checkin\/(\d+)/', $checkin_url, $matches);
$checkin_id = $matches[1] ?? '';
```

#### Step 5: Extract and Format Date

**Date Format Conversion** (MM/DD/YY → YYYY-MM-DD):
```php
$date_string = $item->filter('.details p.date a abbr')->text(); // "04/12/25"
preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{2})/', $date_string, $parts);
if ($parts) {
    $month = str_pad($parts[1], 2, '0', STR_PAD_LEFT);
    $day = str_pad($parts[2], 2, '0', STR_PAD_LEFT);
    $year = '20' . $parts[3]; // Assume 20xx
    $checkin_date = "{$year}-{$month}-{$day}"; // "2025-04-12"
}
```

### CSV Generation (Optional Intermediate Step)

**Purpose**: Generate CSV file for batch processing

**CSV Structure**:
```csv
beer_name,brewery_name,beer_style,user_rating,abv,ibu,checkin_date,untappd_url,checkin_id
Beer Name,Brewery Name,IPA - American,4.50,6.5,40,2025-04-12,https://untappd.com/user/username/checkin/123456,123456
```

**Benefits**:
- Review data before import
- Resume from checkpoint
- Debug parsing issues
- Manual corrections

### Implementation Notes

**Library**: Symfony DomCrawler + CSS Selector (already in dependencies)

**Error Handling**:
- Skip items with missing `checkin_id` (critical field)
- Log warnings for missing optional fields
- Continue processing remaining items

**Performance**:
- Process HTML file once
- Generate CSV for batch import
- Avoid repeated HTML parsing

**Validation**:
- Verify `checkin_id` is numeric
- Validate date format (YYYY-MM-DD)
- Check required fields before import

---

## Related Documentation

- [Historical Import Flow](../user-flows/historical-import.md)
- [Scraping Detailed](scraping-detailed.md)
- [Untappd Integration](untappd-integration.md)


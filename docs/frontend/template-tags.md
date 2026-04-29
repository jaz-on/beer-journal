# Template Tags

## Overview

Template tags are helper functions for displaying check-in data in templates. All functions are prefixed with `jb_` and are available in theme templates.

## Core Functions

### Get Check-in Data

```php
/**
 * Get all check-in data as array
 * 
 * @param int $post_id Post ID
 * @return array Check-in data
 */
function jb_get_checkin_data($post_id)
```

**Returns**:
```php
[
    'checkin_id' => '1527514863',
    'beer_name' => 'Meteor Blonde De Garde',
    'brewery_name' => 'Brasserie Meteor',
    'rating_raw' => 4.25,
    'rating_rounded' => 4,
    'beer_style' => 'Blonde Ale',
    'abv' => 5.5,
    'ibu' => 25,
    'venue_name' => 'Home',
    'checkin_date' => '2025-11-10T18:13:18Z',
    // ... etc
]
```

**Usage**:
```php
$data = jb_get_checkin_data(get_the_ID());
echo esc_html($data['beer_name']);
```

---

### Display Rating

```php
/**
 * Display rating with stars and optional label
 * 
 * @param int  $post_id    Post ID
 * @param bool $show_label Show custom label
 * @param bool $show_raw   Show original rating in tooltip
 * @return string HTML output
 */
function jb_display_rating($post_id, $show_label = true, $show_raw = true)
```

**Usage**:
```php
// Display with label and tooltip
echo jb_display_rating(get_the_ID());

// Display stars only
echo jb_display_rating(get_the_ID(), false, false);
```

**Output**:
```html
<div class="jb-rating">
    <span class="jb-stars" title="Original rating: 4.25">⭐⭐⭐⭐</span>
    <p class="jb-rating-label">Great - Now we're talking! A real pleasure</p>
</div>
```

---

### Rating Stars

```php
/**
 * Display stars only
 * 
 * @param int  $rating Rating (0-5)
 * @param bool $echo   Echo or return
 * @return string|void
 */
function jb_rating_stars($rating, $echo = true)
```

**Usage**:
```php
$rating = get_post_meta(get_the_ID(), '_jb_rating_rounded', true);
jb_rating_stars($rating); // Echo
// or
echo jb_rating_stars($rating, false); // Return
```

---

### Beer Style

```php
/**
 * Display beer style with optional link
 * 
 * @param int  $post_id Post ID
 * @param bool $link    Link to style archive
 * @return string HTML output
 */
function jb_beer_style($post_id, $link = true)
```

**Usage**:
```php
// With link
echo jb_beer_style(get_the_ID());

// Without link
echo jb_beer_style(get_the_ID(), false);
```

**Output**:
```html
<a href="/beer-style/ipa/">IPA</a>
```

---

### Brewery Link

```php
/**
 * Display brewery name with link
 * 
 * @param int $post_id Post ID
 * @return string HTML output
 */
function jb_brewery_link($post_id)
```

**Usage**:
```php
echo jb_brewery_link(get_the_ID());
```

**Output**:
```html
<a href="/brewery/brasserie-meteor/">Brasserie Meteor</a>
```

---

### Venue Info

```php
/**
 * Display venue information
 * 
 * @param int $post_id Post ID
 * @return string HTML output
 */
function jb_venue_info($post_id)
```

**Usage**:
```php
echo jb_venue_info(get_the_ID());
```

**Output**:
```html
<span class="jb-venue">Home, Strasbourg, France</span>
```

---

### Beer Image

```php
/**
 * Display beer image
 * 
 * @param int    $post_id Post ID
 * @param string $size    Image size (thumbnail, medium, large, full)
 * @return string HTML output
 */
function jb_beer_image($post_id, $size = 'medium')
```

**Usage**:
```php
// Medium size
echo jb_beer_image(get_the_ID());

// Large size
echo jb_beer_image(get_the_ID(), 'large');

// Full size
echo jb_beer_image(get_the_ID(), 'full');
```

**Output**:
```html
<img src="..." alt="Meteor Blonde De Garde - Brasserie Meteor" class="jb-beer-image" />
```

---

## Helper Functions

### Get Beer Name

```php
/**
 * Get beer name
 * 
 * @param int $post_id Post ID
 * @return string Beer name
 */
function jb_get_beer_name($post_id)
```

---

### Get Brewery Name

```php
/**
 * Get brewery name
 * 
 * @param int $post_id Post ID
 * @return string Brewery name
 */
function jb_get_brewery_name($post_id)
```

---

### Get Rating

```php
/**
 * Get rating (raw or rounded)
 * 
 * @param int  $post_id Post ID
 * @param bool $raw     Get raw rating (true) or rounded (false)
 * @return float|int Rating
 */
function jb_get_rating($post_id, $raw = false)
```

**Usage**:
```php
$raw_rating = jb_get_rating(get_the_ID(), true); // 4.25
$rounded = jb_get_rating(get_the_ID(), false);   // 4
```

---

### Get ABV

```php
/**
 * Get ABV percentage
 * 
 * @param int $post_id Post ID
 * @return float|null ABV or null
 */
function jb_get_abv($post_id)
```

---

### Get IBU

```php
/**
 * Get IBU
 * 
 * @param int $post_id Post ID
 * @return int|null IBU or null
 */
function jb_get_ibu($post_id)
```

---

### Get Check-in Date

```php
/**
 * Get check-in date
 * 
 * @param int  $post_id Post ID
 * @param string $format Date format (default: WordPress date format)
 * @return string Formatted date
 */
function jb_get_checkin_date($post_id, $format = '')
```

**Usage**:
```php
// WordPress format
echo jb_get_checkin_date(get_the_ID());

// Custom format
echo jb_get_checkin_date(get_the_ID(), 'F j, Y');
```

---

### Get Venue

```php
/**
 * Get venue name
 * 
 * @param int $post_id Post ID
 * @return string Venue name
 */
function jb_get_venue($post_id)
```

---

### Get Serving Type

```php
/**
 * Get serving type
 * 
 * @param int $post_id Post ID
 * @return string Serving type (Draft, Bottle, Can, etc.)
 */
function jb_get_serving_type($post_id)
```

---

## Conditional Functions

### Has Rating

```php
/**
 * Check if check-in has rating
 * 
 * @param int $post_id Post ID
 * @return bool
 */
function jb_has_rating($post_id)
```

---

### Has Image

```php
/**
 * Check if check-in has image
 * 
 * @param int $post_id Post ID
 * @return bool
 */
function jb_has_image($post_id)
```

---

### Has Comment

```php
/**
 * Check if check-in has comment
 * 
 * @param int $post_id Post ID
 * @return bool
 */
function jb_has_comment($post_id)
```

---

## Filter Hooks

All template tags are filterable:

```php
// Filter rating display
add_filter('jb_rating_display', function($output, $post_id, $raw, $rounded) {
    // Customize output
    return $output;
}, 10, 4);

// Filter beer name
add_filter('jb_beer_name', function($name, $post_id) {
    // Customize name
    return $name;
}, 10, 2);
```

## Usage Examples

### In Archive Template

```php
<?php while (have_posts()) : the_post(); ?>
    <article class="jb-checkin-card">
        <?php if (jb_has_image(get_the_ID())) : ?>
            <div class="jb-checkin-image">
                <?php echo jb_beer_image(get_the_ID(), 'medium'); ?>
            </div>
        <?php endif; ?>
        
        <div class="jb-checkin-content">
            <h2><?php echo esc_html(jb_get_beer_name(get_the_ID())); ?></h2>
            <p class="jb-brewery"><?php echo jb_brewery_link(get_the_ID()); ?></p>
            
            <div class="jb-rating">
                <?php echo jb_display_rating(get_the_ID(), false); ?>
            </div>
            
            <p class="jb-style"><?php echo jb_beer_style(get_the_ID()); ?></p>
            <p class="jb-date"><?php echo jb_get_checkin_date(get_the_ID()); ?></p>
        </div>
    </article>
<?php endwhile; ?>
```

### In Single Template

```php
<article class="jb-checkin">
    <header>
        <h1><?php echo esc_html(jb_get_beer_name(get_the_ID())); ?></h1>
        <p class="jb-brewery"><?php echo jb_brewery_link(get_the_ID()); ?></p>
    </header>
    
    <div class="jb-checkin-meta">
        <div class="jb-rating">
            <?php echo jb_display_rating(get_the_ID()); ?>
        </div>
        
        <dl class="jb-details">
            <dt>Style:</dt>
            <dd><?php echo jb_beer_style(get_the_ID()); ?></dd>
            
            <?php if ($abv = jb_get_abv(get_the_ID())) : ?>
                <dt>ABV:</dt>
                <dd><?php echo esc_html($abv); ?>%</dd>
            <?php endif; ?>
            
            <?php if ($ibu = jb_get_ibu(get_the_ID())) : ?>
                <dt>IBU:</dt>
                <dd><?php echo esc_html($ibu); ?></dd>
            <?php endif; ?>
            
            <dt>Date:</dt>
            <dd><?php echo jb_get_checkin_date(get_the_ID()); ?></dd>
            
            <?php if ($venue = jb_get_venue(get_the_ID())) : ?>
                <dt>Venue:</dt>
                <dd><?php echo esc_html($venue); ?></dd>
            <?php endif; ?>
        </dl>
    </div>
    
    <?php if (jb_has_comment(get_the_ID())) : ?>
        <div class="jb-comment">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>
</article>
```

## Related Documentation

- [Templates](templates.md)
- [Hooks and Filters](hooks-filters.md)
- [Styling](styling.md)


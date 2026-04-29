<?php
/**
 * Check-in card for archives.
 *
 * @package JardinToasts
 */

$classes = get_option( 'jt_microformats_enabled', true ) ? 'jt-card h-entry' : 'jt-card';
?>
<article <?php post_class( $classes ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="jt-card__thumb"><?php the_post_thumbnail( 'medium' ); ?></a>
	<?php endif; ?>
	<div class="jt-card__body">
		<h2 class="jt-card__title p-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="jt-card__rating"><?php jt_the_rating_stars(); ?></div>
		<div class="jt-card__excerpt"><?php the_excerpt(); ?></div>
	</div>
</article>

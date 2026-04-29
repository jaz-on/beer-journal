<?php
/**
 * Table row for archive (table layout).
 *
 * @package JardinToasts
 */
?>
<tr>
	<td class="jt-row__thumb">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
		<?php endif; ?>
	</td>
	<td class="jt-row__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
	<td class="jt-row__rating"><?php jt_the_rating_stars(); ?></td>
	<td class="jt-row__date"><?php echo esc_html( get_the_date() ); ?></td>
</tr>

<?php
/**
 * Table row for archive (table layout).
 *
 * @package BeerJournal
 */
?>
<tr>
	<td class="bj-row__thumb">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
		<?php endif; ?>
	</td>
	<td class="bj-row__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
	<td class="bj-row__rating"><?php bj_the_rating_stars(); ?></td>
	<td class="bj-row__date"><?php echo esc_html( get_the_date() ); ?></td>
</tr>

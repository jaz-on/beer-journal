<?php
/**
 * Shared archive loop: grid or table (option bj_archive_layout).
 *
 * Expects $bj_empty_message (string) in scope when no posts.
 *
 * @package BeerJournal
 */

if ( ! have_posts() ) {
	$msg = isset( $bj_empty_message ) && is_string( $bj_empty_message )
		? $bj_empty_message
		: __( 'No check-ins found.', 'beer-journal' );
	echo '<p>' . esc_html( $msg ) . '</p>';
	return;
}

$layout = bj_get_archive_layout();

if ( 'table' === $layout ) :
	?>
	<table class="bj-checkin-table">
		<thead>
			<tr>
				<th class="bj-col-thumb"><?php esc_html_e( 'Photo', 'beer-journal' ); ?></th>
				<th class="bj-col-title"><?php esc_html_e( 'Check-in', 'beer-journal' ); ?></th>
				<th class="bj-col-rating"><?php esc_html_e( 'Rating', 'beer-journal' ); ?></th>
				<th class="bj-col-date"><?php esc_html_e( 'Date', 'beer-journal' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ( have_posts() ) :
				the_post();
				include BJ_PLUGIN_DIR . 'public/partials/checkin-row.php';
			endwhile;
			?>
		</tbody>
	</table>
	<?php
else :
	?>
	<div class="bj-checkin-grid">
		<?php
		while ( have_posts() ) :
			the_post();
			include BJ_PLUGIN_DIR . 'public/partials/checkin-card.php';
		endwhile;
		?>
	</div>
	<?php
endif;

the_posts_pagination();

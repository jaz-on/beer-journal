<?php
/**
 * Shared archive loop: grid or table (option jt_archive_layout).
 *
 * Expects $jt_empty_message (string) in scope when no posts.
 *
 * @package JardinToasts
 */

if ( ! have_posts() ) {
	$msg = isset( $jt_empty_message ) && is_string( $jt_empty_message )
		? $jt_empty_message
		: __( 'No check-ins found.', 'jardin-toasts' );
	echo '<p>' . esc_html( $msg ) . '</p>';
	return;
}

$layout = jt_get_archive_layout();

if ( 'table' === $layout ) :
	?>
	<table class="jt-checkin-table">
		<thead>
			<tr>
				<th class="jt-col-thumb"><?php esc_html_e( 'Photo', 'jardin-toasts' ); ?></th>
				<th class="jt-col-title"><?php esc_html_e( 'Check-in', 'jardin-toasts' ); ?></th>
				<th class="jt-col-rating"><?php esc_html_e( 'Rating', 'jardin-toasts' ); ?></th>
				<th class="jt-col-date"><?php esc_html_e( 'Date', 'jardin-toasts' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ( have_posts() ) :
				the_post();
				include JT_PLUGIN_DIR . 'public/partials/checkin-row.php';
			endwhile;
			?>
		</tbody>
	</table>
	<?php
else :
	?>
	<div class="jt-checkin-grid">
		<?php
		while ( have_posts() ) :
			the_post();
			include JT_PLUGIN_DIR . 'public/partials/checkin-card.php';
		endwhile;
		?>
	</div>
	<?php
endif;

the_posts_pagination();

<?php
/**
 * Archive template for beer check-ins.
 *
 * @package BeerJournal
 */

get_header();

$mf = get_option( 'bj_microformats_enabled', true ) ? 'h-feed' : '';
?>
<div id="primary" class="content-area bj-archive <?php echo $mf ? esc_attr( $mf ) : ''; ?>">
	<main id="main" class="site-main">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Beer check-ins', 'beer-journal' ); ?></h1>
		</header>
		<?php
		$bj_empty_message = __( 'No check-ins yet.', 'beer-journal' );
		include BJ_PLUGIN_DIR . 'public/partials/archive-loop.php';
		?>
	</main>
</div>
<?php
get_footer();

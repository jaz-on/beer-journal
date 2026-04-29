<?php
/**
 * Taxonomy archive: brewery.
 *
 * @package JardinBeer
 */

get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<header class="page-header">
			<h1 class="page-title"><?php single_term_title(); ?></h1>
		</header>
		<?php
		$jb_empty_message = __( 'No check-ins found.', 'jardin-beer' );
		include JB_PLUGIN_DIR . 'public/partials/archive-loop.php';
		?>
	</main>
</div>
<?php
get_footer();

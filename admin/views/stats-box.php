<?php
/**
 * At-a-glance stats (dashboard strip).
 *
 * @package JardinToasts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats   = jt_get_global_stats();
$last    = get_option( 'jt_last_rss_sync_at', '' );
$queue   = jt_get_rss_sync_queue();
$pending = is_array( $queue ) ? count( $queue ) : 0;
$draft_i = jt_count_draft_incomplete_checkins();
?>
<div class="jt-stats-strip" role="region" aria-label="<?php esc_attr_e( 'Jardin Toasts summary', 'jardin-toasts' ); ?>">
	<div class="jt-stats-strip__item">
		<span class="jt-stats-strip__value"><?php echo esc_html( number_format_i18n( $stats['publish'] ) ); ?></span>
		<span class="jt-stats-strip__label"><?php esc_html_e( 'Published', 'jardin-toasts' ); ?></span>
	</div>
	<div class="jt-stats-strip__item">
		<span class="jt-stats-strip__value"><?php echo esc_html( number_format_i18n( $stats['draft'] ) ); ?></span>
		<span class="jt-stats-strip__label"><?php esc_html_e( 'Drafts', 'jardin-toasts' ); ?></span>
	</div>
	<div class="jt-stats-strip__item jt-stats-strip__item--wide">
		<span class="jt-stats-strip__value jt-stats-strip__value--small">
			<?php
			if ( is_string( $last ) && '' !== $last ) {
				echo esc_html(
					wp_date(
						get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
						strtotime( $last )
					)
				);
			} else {
				echo '—';
			}
			?>
		</span>
		<span class="jt-stats-strip__label"><?php esc_html_e( 'Last RSS sync', 'jardin-toasts' ); ?></span>
	</div>
	<div class="jt-stats-strip__item">
		<span class="jt-stats-strip__value"><?php echo esc_html( number_format_i18n( $pending ) ); ?></span>
		<span class="jt-stats-strip__label"><?php esc_html_e( 'RSS queue', 'jardin-toasts' ); ?></span>
	</div>
	<div class="jt-stats-strip__item">
		<span class="jt-stats-strip__value"><?php echo esc_html( number_format_i18n( $draft_i ) ); ?></span>
		<span class="jt-stats-strip__label"><?php esc_html_e( 'Incomplete drafts', 'jardin-toasts' ); ?></span>
	</div>
</div>

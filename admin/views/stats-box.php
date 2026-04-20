<?php
/**
 * At-a-glance stats (Phase 1 dashboard).
 *
 * @package BeerJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = bj_get_global_stats();
$last  = get_option( 'bj_last_rss_sync_at', '' );
?>
<div class="bj-stats-box" style="background:#fff;border:1px solid #c3c4c7;padding:12px 16px;margin:1em 0;max-width:640px;">
	<h2 style="margin-top:0;"><?php esc_html_e( 'At a glance', 'beer-journal' ); ?></h2>
	<ul style="margin:0;list-style:disc;padding-left:1.25em;">
		<li>
			<?php
			echo esc_html(
				sprintf(
					/* translators: %s: formatted number of posts */
					_n( '%s published check-in', '%s published check-ins', $stats['publish'], 'beer-journal' ),
					number_format_i18n( $stats['publish'] )
				)
			);
			?>
		</li>
		<li>
			<?php
			echo esc_html(
				sprintf(
					/* translators: %s: formatted number of drafts */
					_n( '%s draft check-in', '%s draft check-ins', $stats['draft'], 'beer-journal' ),
					number_format_i18n( $stats['draft'] )
				)
			);
			?>
		</li>
		<li>
			<?php
			if ( is_string( $last ) && '' !== $last ) {
				echo esc_html(
					sprintf(
						/* translators: %s: localized datetime */
						__( 'Last RSS sync attempt: %s', 'beer-journal' ),
						wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $last ) )
					)
				);
			} else {
				esc_html_e( 'No RSS sync has completed yet (or timestamp not recorded).', 'beer-journal' );
			}
			?>
		</li>
	</ul>
</div>

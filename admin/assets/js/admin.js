( function ( $ ) {
	'use strict';

	function setStatus( el, msg ) {
		$( el ).text( msg );
	}

	$( document ).on( 'click', '#jb-sync-now', function () {
		var $btn = $( this );
		$btn.prop( 'disabled', true );
		setStatus( '#jb-sync-status', bjAdmin.i18n.working );
		$.post(
			bjAdmin.ajaxUrl,
			{
				action: 'jb_sync_now',
				nonce: bjAdmin.nonce,
			}
		)
			.done( function ( res ) {
				if ( res.success ) {
					setStatus( '#jb-sync-status', res.data.message || bjAdmin.i18n.done );
				} else {
					setStatus( '#jb-sync-status', res.data && res.data.message ? res.data.message : 'Error' );
				}
			} )
			.fail( function () {
				setStatus( '#jb-sync-status', 'Request failed.' );
			} )
			.always( function () {
				$btn.prop( 'disabled', false );
			} );
	} );

	$( document ).on( 'click', '#jb-discover', function () {
		var $btn = $( this );
		var username = $( '#jb_untappd_username' ).val();
		var maxPages = $( '#jb-discover-max-pages' ).val() || 10;
		$btn.prop( 'disabled', true );
		setStatus( '#jb-import-status', bjAdmin.i18n.working );
		$.post(
			bjAdmin.ajaxUrl,
			{
				action: 'jb_crawl_discover',
				nonce: bjAdmin.nonce,
				username: username,
				max_pages: maxPages,
			}
		)
			.done( function ( res ) {
				if ( res.success ) {
					setStatus( '#jb-import-status', res.data.message );
				} else {
					setStatus( '#jb-import-status', res.data && res.data.message ? res.data.message : 'Error' );
				}
			} )
			.fail( function () {
				setStatus( '#jb-import-status', 'Request failed.' );
			} )
			.always( function () {
				$btn.prop( 'disabled', false );
			} );
	} );

	$( document ).on( 'click', '#jb-import-batch', function () {
		var $btn = $( this );
		$btn.prop( 'disabled', true );
		setStatus( '#jb-import-status', bjAdmin.i18n.working );
		$.post(
			bjAdmin.ajaxUrl,
			{
				action: 'jb_crawl_batch',
				nonce: bjAdmin.nonce,
			}
		)
			.done( function ( res ) {
				if ( res.success ) {
					var d = res.data;
					setStatus(
						'#jb-import-status',
						'Imported ' +
							d.imported +
							'. Remaining: ' +
							d.remaining +
							'. Total: ' +
							d.total_imported
					);
					if ( d.done ) {
						setStatus( '#jb-import-status', 'Import complete.' );
					}
				} else {
					setStatus( '#jb-import-status', res.data && res.data.message ? res.data.message : 'Error' );
				}
			} )
			.fail( function () {
				setStatus( '#jb-import-status', 'Request failed.' );
			} )
			.always( function () {
				$btn.prop( 'disabled', false );
			} );
	} );

	var $phToggle = $( '#jb_use_placeholder_image' );
	var $phPicker = $( '#jb-placeholder-picker' );
	var $phId = $( '#jb_placeholder_image_id' );
	var $phPreview = $( '#jb-placeholder-preview' );
	var $phSelect = $( '#jb-placeholder-select' );
	var $phClear = $( '#jb-placeholder-clear' );

	function bjTogglePlaceholderPicker() {
		if ( ! $phToggle.length || ! $phPicker.length ) {
			return;
		}
		$phPicker.toggle( $phToggle.is( ':checked' ) );
	}

	if ( $phToggle.length ) {
		$phToggle.on( 'change', bjTogglePlaceholderPicker );
		bjTogglePlaceholderPicker();
	}

	if ( typeof wp !== 'undefined' && wp.media && $phSelect.length ) {
		var frame;
		$phSelect.on( 'click', function ( e ) {
			e.preventDefault();
			if ( frame ) {
				frame.open();
				return;
			}
			frame = wp.media( {
				title: bjAdmin.i18n.chooseImage,
				button: { text: bjAdmin.i18n.chooseImage },
				multiple: false,
				library: { type: 'image' },
			} );
			frame.on( 'select', function () {
				var att = frame.state().get( 'selection' ).first().toJSON();
				$phId.val( att.id );
				var url =
					att.sizes && att.sizes.thumbnail
						? att.sizes.thumbnail.url
						: att.url;
				$phPreview.html( '<img src="' + url + '" alt="" />' );
				$phSelect.text( bjAdmin.i18n.replaceImage );
			} );
			frame.open();
		} );
	}

	$phClear.on( 'click', function ( e ) {
		e.preventDefault();
		$phId.val( '0' );
		$phPreview.empty();
		$phSelect.text( bjAdmin.i18n.chooseImage );
	} );

	if ( bjAdmin.placeholderThumb && $phPreview.length && parseInt( bjAdmin.placeholderId, 10 ) > 0 ) {
		$phPreview.html(
			'<img src="' + bjAdmin.placeholderThumb + '" alt="" />'
		);
		$phSelect.text( bjAdmin.i18n.replaceImage );
	}

	$( '#jb-use-rss-username' ).on( 'click', function ( e ) {
		e.preventDefault();
		if ( bjAdmin.rssUsername ) {
			$( '#jb_untappd_username' ).val( bjAdmin.rssUsername );
		}
	} );
}( jQuery ) );

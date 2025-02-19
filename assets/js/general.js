jQuery( document ).ready( function ( $ ) {
	var fixmeTop = jQuery( '.site-header' ).offset().top;
	jQuery( window ).scroll( function () {
		var currentScroll = jQuery( window ).scrollTop();
		if ( currentScroll >= fixmeTop ) {
			jQuery( '.site-header' ).last().addClass( 'scroll-with' );

			jQuery( '.emclient-fixedheader-placeholder' ).css( {
				display: 'block',
			} );
		} else {
			if ( jQuery( '.scroll-with' ).length ) {
				jQuery( '.site-header' ).removeClass( 'scroll-with' );
			}
			jQuery( '.emclient-fixedheader-placeholder' ).css( {
				display: 'none',
			} );
		}
	} );
} );

( function( $ ) {
	'use strict';

	var wpspCustom = {
		
		/**
		 * Main init function
		 *
		 * @since 1.0.0
		 */
		init : function() {
			this.config();
			this.bindEvents();
		},

		/**
		 * Cache Elements
		 *
		 * @since 1.0.0
		 */
		config : function() {

			this.config = {
				$window                 : $( window ),
				$document               : $( document ),
				$windowWidth            : $( window ).width(),
				$windowHeight           : $( window ).height(),
				$windowTop              : $( window ).scrollTop(),
				$body                   : $( 'body' ),
				$mobileMenuBreakpoint   : 960,
				$siteHeader             : null,
				$siteHeaderHeight       : 0,
				$siteHeaderTop          : 0,
				$siteHeaderBottom       : 0,
				$siteLogo               : null,
				$siteLogoHeight         : 0,
				$siteLogoSrc            : null,
				$siteNavWrap            : null,
				$localScrollOffset      : 0,
				$localScrollSpeed       : 600,
				$localScrollArray       : [],
				$mobileMenuStyle        : null,
				$hasFixedFooter         : false,
				$hasFooterReveal        : false,
				$hasTopBar              : false,
				$hasHeaderOverlay       : false,
				$hasStickyHeader        : false,
				$stickyHeaderBreakPoint : 960,
				$hasStickyMobileHeader  : false,
				$hasStickyTopBar        : false,
				$stickyTopBar           : null,
				$stickyTopBarHeight     : 0,
				$is_rtl                 : false,
				$retinaLogo             : null,
				$isMobile               : false,
				$verticalHeaderActive   : false,
				$isCustomizePreview     : false
			};

		},

		bindEvents: function() {
			var self = this;

			// Run on document ready
			self.config.$document.on( 'ready', function() {
				self.superFish();
			} );
		},

	    superFish: function() {
	        if ( ! $.fn.superfish ) {
				return;
			}

			$( '#site-navigation ul.sf-menu' ).superfish( {
				delay: wpspLocalize.superfishDelay,
				animation: {
					opacity: 'show'
				},
				animationOut: {
					opacity: 'hide'
				},
				speed: wpspLocalize.superfishSpeed,
				speedOut: wpspLocalize.superfishSpeedOut,
				cssArrows: false,
				disableHI: false
			} );
	    },
	} //wpspCustom

	wpspCustom.init();
	

} ) ( jQuery );	
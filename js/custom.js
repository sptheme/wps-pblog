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
				self.inlineHeaderLogo();
				self.initUpdateConfig();
				self.menuSearch();
			} );

			// Run on Window Load
			self.config.$window.on( 'load', function() {
				self.equalHeights();
			} );

			// Run on Window Resize
			self.config.$window.resize( function() {
				// Window width change
				if ( self.config.$window.width() != self.config.$windowWidth ) {
					self.resizeUpdateConfig();
				}
			} );

			// On orientation change
			self.config.$window.on( 'orientationchange',function() {
				resizeUpdateConfig();
				self.inlineHeaderLogo();
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

	    /**
		 * Header 5 - Inline Logo
		 *
		 * @since 1.0.0
		 */
		inlineHeaderLogo: function() {

			// Only needed for header style 5
			if ( 'five' != wpspLocalize.siteHeaderStyle ) {
				return;
			}

			var $headerLogo        = $( '#site-header-inner > .header-five-logo' ),
				$headerNav         = $( '#site-header-inner .navbar-style-five' ),
				$navLiCount        = $headerNav.children( '#site-navigation' ).children( 'ul' ).children( 'li' ).size(),
				$navBeforeMiddleLi = Math.round( $navLiCount / 2 ) - parseInt( wpspLocalize.headerFiveSplitOffset ),
				$centeredLogo      = $( '.menu-item-logo .header-five-logo' );

				// Add logo into menu
				if ( this.config.$windowWidth >= this.config.$mobileMenuBreakpoint && $headerLogo.length && $headerNav.length ) {
					$('<li class="menu-item-logo"></li>').insertAfter( $headerNav.find( '#site-navigation > ul > li:nth( '+ $navBeforeMiddleLi +' )' ) );
						$headerLogo.appendTo( $headerNav.find( '.menu-item-logo' ) );
				}

				// Remove logo from menu and add to header
				if ( this.config.$windowWidth < this.config.$mobileMenuBreakpoint && $centeredLogo.length ) {
					$centeredLogo.prependTo( $( '#site-header-inner' ) );
					$( '.menu-item-logo' ).remove();
				}

			// Add display class to logo (hidden by default)
			$headerLogo.addClass( 'display' );

		},

		/**
		 * Updates config on doc ready
		 *
		 * @since 1.0.0
		 */
		initUpdateConfig: function() {
			// Define header
			if ( $( '#site-header' ).length ) {
				this.config.$siteHeader = $( '#site-header' );
			}

			// Define logo
			if ( $( '#site-logo img' ).length ) {
				this.config.$siteLogo = $( '#site-logo img' );
				this.config.$siteLogoSrc = this.config.$siteLogo.attr( 'src' );
			}

			// Site nav wrap
			if ( $( '#site-navigation-wrap' ).length ) {
				this.config.$siteNavWrap = $( '#site-navigation-wrap' );
			}

			// Mobile menu style
			if ( $( '#site-navigation-wrap' ).length ) {
				this.config.$mobileMenuStyle = wpspLocalize.mobileMenuStyle;
			}

			// Vertical header
			if ( this.config.$body.hasClass( 'wpsp-has-vertical-header' ) ) {
				this.config.$verticalHeaderActive = true;
			}
		},

		/**
		 * Updates config whenever the window is resized
		 *
		 * @since 1.0.0
		 */
		resizeUpdateConfig: function() {

			// Update main configs
			this.config.$windowHeight = this.config.$window.height();
			this.config.$windowWidth  = this.config.$window.width();
			this.config.$windowTop    = this.config.$window.scrollTop();

			// Update header height
			if ( this.config.$siteHeader ) {

				// reset sticky height
				if ( $( '.wpsp-sticky-header-holder' ).length ) {
					$( '.wpsp-sticky-header-holder' ).height( '' );
				}

				// Get header height
				this.config.$siteHeaderHeight = this.config.$siteHeader.outerHeight();

				// Re add sticky height
				if ( $( '.wpsp-sticky-header-holder' ).length ) {
					$( '.wpsp-sticky-header-holder' ).height( this.config.$siteHeaderHeight );
				}

			}

			// Get logo height
			if ( this.config.$siteLogo ) {
				this.config.$siteLogoHeight = this.config.$siteLogo.height();
			}

			// Vertical Header
			if ( this.config.$windowWidth < 960 ) {
				this.config.$verticalHeaderActive = false;
			} else if ( this.config.$body.hasClass( 'wpsp-has-vertical-header' ) ) {
				this.config.$verticalHeaderActive = true;
			}

			// Update Topbar sticky height
			if ( this.config.$stickyTopBar ) {
				this.config.$stickyTopBarHeight = this.config.$stickyTopBar.outerHeight();
				$( '.wpsp-sticky-top-bar-holder' ).height( this.config.$stickyTopBarHeight );
			}

			// Re-stick topbar but check for mobile first
			if ( this.config.$hasStickyTopBar ) {

				// Unstick first
				this.stickyTopBar( 'unstick' );

				// Desktops or mobile enabled
				if ( wpspLocalize.hasStickyTopBarMobile || ( this.config.$windowWidth >= wpspLocalize.stickyTopBarBreakPoint ) ) {
					this.config.$hasStickyTopBar = true;
					this.stickyTopBar();
				}

				// Mobile
				else if ( ! wpspLocalize.hasStickyTopBarMobile ) {
					this.config.$hasStickyTopBar = false;
				}

			}

			// Sticky Header
			if ( this.config.$hasStickyHeader ) {

				// Unstick first
				this.stickyHeader( 'unstick' );
				this.stickyHeaderShrink( 'destroy' );

				// Desktops
				if ( this.config.$hasStickyMobileHeader || ( this.config.$windowWidth >= wpspLocalize.stickyHeaderBreakPoint ) ) {
					this.config.$hasStickyHeader = true;
					this.stickyHeader();
					this.stickyHeaderShrink();
				}

				// Mobile
				else if ( ! this.config.$hasStickyMobileHeader ) {
					this.config.$hasStickyHeader = false;
				}

			}

			// Local scroll offset => update last
			//this.config.$localScrollOffset = this.parseLocalScrollOffset();

		},

		/**
		 * Header Search
		 *
		 * @since 1.0.0
		 */
		menuSearch: function() {

			var self = this;

			/**** Menu Search > Dropdown ****/
			if ( 'drop_down' == wpspLocalize.menuSearchStyle ) {

				var $searchDropdownToggle = $( 'a.search-dropdown-toggle' );
				var $searchDropdownForm   = $( '#searchform-dropdown' );

				$searchDropdownToggle.click( function( event ) {
					// Display search form
					$searchDropdownForm.toggleClass( 'show' );
					// Active menu item
					$( this ).parent( 'li' ).toggleClass( 'active' );
					// Focus
					var $transitionDuration = $searchDropdownForm.css( 'transition-duration' );
					$transitionDuration = $transitionDuration.replace( 's', '' ) * 1000;
					if ( $transitionDuration ) {
						setTimeout( function() {
							$searchDropdownForm.find( 'input[type="search"]' ).focus();
						}, $transitionDuration );
					}
					// Hide other things
					$( 'div#current-shop-items-dropdown' ).removeClass( 'show' );
					$( 'li.wcmenucart-toggle-dropdown' ).removeClass( 'active' );
					// Return false
					return false;
				} );

				// Close on doc click
				self.config.$document.on( 'click', function( event ) {
					if ( ! $( event.target ).closest( '#searchform-dropdown.show' ).length ) {
						$searchDropdownToggle.parent( 'li' ).removeClass( 'active' );
						$searchDropdownForm.removeClass( 'show' );
					}
				} );

			}

			/**** Menu Search > Overlay Modal ****/
			else if ( 'overlay' == wpspLocalize.menuSearchStyle ) {

				if ( ! $.fn.leanerModal ) {
					return;
				}

				var $searchOverlayToggle = $( 'a.search-overlay-toggle' );

				$searchOverlayToggle.leanerModal( {
					'id'      : '#searchform-overlay',
					'top'     : 100,
					'overlay' : 0.8,
				} );

				$searchOverlayToggle.click( function() {
					$( '#site-searchform input' ).focus();
				} );

			}
			
			/**** Menu Search > Header Replace ****/
			else if ( 'header_replace' == wpspLocalize.menuSearchStyle ) {

				// Show
				var $headerReplace = $( '#searchform-header-replace' );
				$( 'a.search-header-replace-toggle' ).click( function( event ) {
					// Display search form
					$headerReplace.toggleClass( 'show' );
					// Focus
					var $transitionDuration =  $headerReplace.css( 'transition-duration' );
					$transitionDuration = $transitionDuration.replace( 's', '' ) * 1000;
					if ( $transitionDuration ) {
						setTimeout( function() {
							$headerReplace.find( 'input[type="search"]' ).focus();
						}, $transitionDuration );
					}
					// Return false
					return false;
				} );

				// Close on click
				$( '#searchform-header-replace-close' ).click( function() {
					$headerReplace.removeClass( 'show' );
					return false;
				} );

				// Close on doc click
				self.config.$document.on( 'click', function( event ) {
					if ( ! $( event.target ).closest( $( '#searchform-header-replace.show' ) ).length ) {
						$headerReplace.removeClass( 'show' );
					}
				} );
			}

		},

		/**
		 * Equal heights function
		 *
		 * @since 1.0.0
		 */
		equalHeights: function() {

			// Make sure equal heights function is defined
			if ( ! $.fn.matchHeight ) {
				return;
			}
			
			// Add equal heights
			$( '.equal-height-column, .match-height-row .match-height-content, .vcex-feature-box-match-height .vcex-match-height, .equal-height-content, .match-height-grid .match-height-content, .blog-entry-equal-heights .blog-entry-inner, .wpsp-vc-row-columns-match-height .wpsp-vc-column-wrapper' ).matchHeight();

		},

	} //wpspCustom

	wpspCustom.init();
	

} ) ( jQuery );	
( function () {
	'use strict';

	var PARENT = $.ui.EditableTemplatedWidget,
		datamodel = require( 'wikibase.datamodel' );

	/**
	 * The node of the `RankSelector` menu to select a `RANK` from.
	 *
	 * @property {jQuery|null} [$menu=null]
	 * @ignore
	 */
	var $menu = null;

	/**
	 * Returns a `RANK`'s serialized string.
	 *
	 * @see datamodel.Statement.RANK
	 * @ignore
	 *
	 * @param {number} rank
	 * @return {string|null}
	 */
	function getRankName( rank ) {
		for ( var rankName in datamodel.Statement.RANK ) {
			if ( rank === datamodel.Statement.RANK[ rankName ] ) {
				return rankName.toLowerCase();
			}
		}

		return null;
	}

	/**
	 * Selector for choosing a `Statement` rank.
	 *
	 * @see datamodel.Statement.RANK
	 * @class jQuery.wikibase.statementview.RankSelector
	 * @extends jQuery.ui.EditableTemplatedWidget
	 * @license GPL-2.0-or-later
	 * @author H. Snater < mediawiki@snater.com >
	 *
	 * @constructor
	 *
	 * @param {Object} [options]
	 * @param {number} [options.value=datamodel.Statement.RANK.NORMAL]
	 *        The `RANK` that shall be selected.
	 * @param {boolean} [options.isRTL=false]
	 *        Whether the widget is displayed in right-to-left context.
	 */
	/**
	 * @event change
	 * Triggered when the snak type got changed.
	 * @param {jQuery.Event} event
	 */
	$.wikibase.statementview.RankSelector = util.inherit( PARENT, {
		namespace: 'wikibase',
		widgetName: 'rankselector',
		widgetFullName: 'wikibase-rankselector',

		/**
		 * @inheritdoc
		 * @protected
		 * @readonly
		 */
		options: {
			template: 'wikibase-rankselector',
			templateParams: [
				'',
				'',
				''
			],
			templateShortCuts: {
				$icon: '.ui-icon-rankselector'
			},
			value: datamodel.Statement.RANK.NORMAL,
			isRtl: false
		},

		/**
		 * The `RANK` currently featured by the `RankSelector`.
		 *
		 * @see datamodel.Statement.RANK
		 * @type {number}
		 */
		_rank: null,

		/**
		 * @inheritdoc
		 */
		_create: function () {
			var self = this;

			PARENT.prototype._create.call( this );

			if ( !$menu ) {
				$menu = this._buildMenu().appendTo( document.body ).hide();

				$menu.on( 'click.' + this.widgetName, function ( event ) {
					var $li = $( event.target ).closest( 'li' ),
						rank = $li.data( self.widgetName + '-menuitem-rank' );

					if ( rank !== undefined ) {
						$.data( this, self.widgetName ).value( rank );
					}
				} );
			}

			this.element
			.addClass( this.widgetFullName )
			.on( 'mouseover.' + this.widgetName, function ( event ) {
				if ( !self.option( 'disabled' ) && self.isInEditMode() ) {
					self.element.addClass( 'ui-state-hover' );
				}
			} )
			.on( 'mouseout.' + this.widgetName, function ( event ) {
				if ( !self.option( 'disabled' ) && self.isInEditMode() ) {
					self.element.removeClass( 'ui-state-hover' );
				}
			} )
			.on( 'click.' + this.widgetName, function ( event ) {
				// TODO: Store visibility in model
				// eslint-disable-next-line no-jquery/no-sizzle
				if ( self.option( 'disabled' ) || !self.isInEditMode() || $menu.is( ':visible' ) ) {
					$menu.hide();
					return;
				}

				$menu.data( self.widgetName, self );
				$menu.show();
				self._updateMenuCss();
				self.repositionMenu();

				self.element.addClass( 'ui-state-active' );

				// Close the menu when clicking, regardless of whether the click is performed on the
				// menu itself or outside of it:
				var degrade = function ( event ) {
					if ( event.target !== self.element.get( 0 ) ) {
						$menu.hide();
						self.element.removeClass( 'ui-state-active' );
					}
					self._unbindGlobalEventListeners();
				};

				$( document ).on( 'mouseup.' + self.widgetName, degrade );
				$( window ).on(
					'resize.' + self.widgetName,
					function ( event ) {
						self.repositionMenu();
					}
				);
			} );

			this._setRank( this.options.value );
		},

		/**
		 * @inheritdoc
		 */
		destroy: function () {
			if ( $( '.' + this.widgetFullName ).length === 0 ) {
				$menu.data( 'menu' ).destroy();
				$menu.remove();
				$menu = null;
			}
			this.$icon.remove();

			this.element.removeClass( 'ui-state-default ui-state-hover ' + this.widgetFullName );

			this._unbindGlobalEventListeners();

			PARENT.prototype.destroy.call( this );
		},

		/**
		 * @inheritdoc
		 * @protected
		 */
		_setOption: function ( key, value ) {
			var response = PARENT.prototype._setOption.apply( this, arguments );
			if ( key === 'rank' ) {
				this._setRank( value );
				this._trigger( 'change' );
			} else if ( key === 'disabled' ) {
				this.draw();
			}
			return response;
		},

		/**
		 * Removes all global event listeners generated by the `RankSelector`.
		 *
		 * @private
		 */
		_unbindGlobalEventListeners: function () {
			$( document ).add( $( window ) ).off( '.' + this.widgetName );
		},

		/**
		 * Generates the menu the `RANK` may be chosen from.
		 *
		 * @private
		 *
		 * @return {jQuery}
		 */
		_buildMenu: function () {
			var self = this,
				$menu = $( '<ul>' ).addClass( this.widgetFullName + '-menu' );

			// eslint-disable-next-line no-jquery/no-each-util
			$.each( datamodel.Statement.RANK, function ( rankName, rank ) {
				rankName = rankName.toLowerCase();

				$menu.append(
					$( '<li>' )
					.addClass( self.widgetFullName + '-menuitem-' + rankName )
					.data( self.widgetName + '-menuitem-rank', rank )
					.append(
						$( '<a>' )
							// The following messages are used here:
							// * wikibase-statementview-rank-preferred
							// * wikibase-statementview-rank-normal
							// * wikibase-statementview-rank-deprecated
							.text( mw.msg( 'wikibase-statementview-rank-' + rankName ) )
							// The following messages are used here:
							// * wikibase-statementview-rank-tooltip-preferred
							// * wikibase-statementview-rank-tooltip-normal
							// * wikibase-statementview-rank-tooltip-deprecated
							.attr( 'title', mw.msg( 'wikibase-statementview-rank-tooltip-' + rankName ) )
							.on( 'click.' + self.widgetName, function ( event ) {
								event.preventDefault();
							} )
					)
				);
			} );

			return $menu.menu();
		},

		/**
		 * Sets the `RANK` if a `RANK` is specified or gets the current `RANK` if parameter is
		 * omitted.
		 *
		 * @param {number} [rank]
		 * @return {number|undefined}
		 */
		value: function ( rank ) {
			if ( rank === undefined ) {
				return this._rank;
			}

			this._setRank( rank );

			this._trigger( 'change' );
		},

		/**
		 * Sets the `RANK` activating the menu item representing the specified `RANK`.
		 *
		 * @private
		 *
		 * @param {number} rank
		 */
		_setRank: function ( rank ) {
			this._rank = rank;

			if ( $menu && $menu.data( this.widgetName ) === this ) {
				this._updateMenuCss();
			}

			this._updateIcon();
		},

		/**
		 * Updates the menu's CSS classes.
		 *
		 * @private
		 */
		_updateMenuCss: function () {
			$menu.children().removeClass( 'ui-state-active' );
			$menu
			.children( '.' + this.widgetFullName + '-menuitem-' + getRankName( this._rank ) )
			.addClass( 'ui-state-active' );
		},

		/**
		 * Updates the rank icon to reflect the rank currently set.
		 *
		 * @private
		 */
		_updateIcon: function () {
			for ( var rankId in datamodel.Statement.RANK ) {
				var rankName = rankId.toLowerCase(),
					selected = this._rank === datamodel.Statement.RANK[ rankId ];

				this.$icon.toggleClass( this.widgetFullName + '-' + rankName, selected );

				if ( selected ) {
					// The following messages are used here:
					// * wikibase-statementview-rank-preferred
					// * wikibase-statementview-rank-normal
					// * wikibase-statementview-rank-deprecated
					this.$icon.attr( 'title', mw.msg( 'wikibase-statementview-rank-' + rankName ) );
				}
			}
		},

		/**
		 * (Re-)positions the menu.
		 */
		repositionMenu: function () {
			$menu.position( {
				of: this.$icon,
				my: ( this.options.isRTL ? 'right' : 'left' ) + ' top',
				at: ( this.options.isRTL ? 'right' : 'left' ) + ' bottom',
				offset: '0 1',
				collision: 'none'
			} );
		},

		/**
		 * @inheritdoc
		 */
		draw: function () {
			if ( this.isInEditMode() ) {
				this.element
				.addClass( 'ui-state-default' )
				.removeClass( 'ui-state-disabled' );
			} else {
				this.element
				.removeClass( 'ui-state-default ui-state-active ui-state-hover' )
				.addClass( 'ui-state-disabled' );
			}

			return $.Deferred().resolve().promise();
		},

		_startEditing: function () {
			return this.draw();
		},

		_stopEditing: function ( dropValue ) {
			// Hide the menu the rank selector currently references to:
			if ( $menu && $menu.data( this.widgetName ) === this ) {
				$menu.hide();
			}
			if ( dropValue ) {
				this._setRank( this.options.value );
			}
			return this.draw();
		}

	} );

}() );

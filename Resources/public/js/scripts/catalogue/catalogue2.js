!function( $ ) {
	$.fn.catalogue2 = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.catalogue2.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( "table.treetable", this )
						.treetable( settings.treetable );
				});
			}
		};

		if ( methods[ method ] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
		}
		else if ( typeof method === "object" || !method ) {
			return methods.init.apply( this, arguments );
		}
		else {
			$.error( "Method " +  method + " does not exist in $.catalogue2." );
		}
	};

	$.fn.catalogue2.defaults = {
		treetable: {
			expandable: true
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( '.catalogue2' ).catalogue2( );
});

!function( $ ) {
	$.fn.cart = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.cart.defaults, options );

				return this.each(function() {
					var $this = $( this );

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.datatables, {
						initComplete: function( settings, json ) {
							$( this ).show();
						}
					} ) );
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
			$.error( "Method " +  method + " does not exist in $.cart." );
		}
	};

	$.fn.cart.defaults = {
		datatables: {
			ordering: false,
			paging: false,
			searching: false
		}
	};
} ( window.jQuery );

// Make sure that a parent element of the table has the class ''.carts'' set so that this plugin can be triggered properly when the page is loaded.
$( document ).ready(function() {
	$( ".cart" ).cart( dzangocart.cart );
});



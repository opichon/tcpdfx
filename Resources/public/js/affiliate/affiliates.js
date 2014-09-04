!function( $ ) {
	$.fn.affiliates = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.affiliates.defaults, options );

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
			$.error( "Method " +  method + " does not exist in $.affiliates." );
		}
	};

	$.fn.affiliates.defaults = {
		datatables: {
			columnDefs: [
				{ orderable: false, targets: [ 0, 4 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "actions", targets: [ 4 ] }
			],
			stripeClasses: [],
			autoWidth: false,
			paging: true,
			destroy:true,
			processing: true,
			serverSide: true,
			orderable: true
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".affiliates" ).affiliates( dzangocart.affiliates );
});
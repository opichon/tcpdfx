!function( $ ) {
	$.fn.promotions = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.promotions.defaults, options );

				return this.each(function() {
					var $this = $( this );

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.datatables, {
						initComplete: function( settings, json ) {
							$( this ).show();
						},
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
			$.error( "Method " +  method + " does not exist in $.promotions." );
		}
	};

	$.fn.promotions.defaults = {
		datatables: {
			autoWidth: false,
			columnDefs: [
				{ orderable: false, targets: [ 0, 5 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "actions", targets: [ 5 ] }
			],
			columns: [
				{ data: "id" },
				{ data: "name" },
				{ data: "code" },
				{ data: "date_from" },
				{ data: "date_to" },
				{ data: "actions" }
			],
			destroy: true,
			orderable: true,
			paging: true,
			processing: true,
			serverSide: true,
			stripeClasses: [],
			language: {
				url: "/bundles/dzangocartcore/datatables/" + dzangocart.locale + ".json"
			}
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".promotions" ).promotions( dzangocart.promotions );
});

!function( $ ) {
	$.fn.customers = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.customers.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( ".filters input" ).keyup(function(event) {
						event.stopPropagation();
						table.fnDraw();
					});

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {
						fnInitComplete: function( oSettings, json ) {
							$( oSettings.nTable ).show();
						},
						fnServerParams: function( data ) {
							$( ".filters input" ).each(function() {
								var value = $( this ).val();
								data.push( {
									"name": $( this ).attr( "name" ),
									"value": value
								});
							});
						}
					}));
				});
			}
		};

		if ( methods[ method ] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		}
		else if ( typeof method === "object" || !method ) {
			return methods.init.apply( this, arguments );
		}
		else {
			$.error( "Method " +  method + " does not exist in $.customers." );
		}
	};

	$.fn.customers.defaults = {
		dataTables: {
			asStripeClasses: [],
			bAutoWidth: false,
			bPaginate: true,
			bProcessing: true,
			bServerSide: true,
			bSortable: true,
			bSortCellsTop: true,
			oLanguage: {
				sUrl: "/bundles/uamdatatables/lang/" + dzangocart.locale + ".txt"
			}
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
    $( ".customers" ).customers( dzangocart.customers );
});






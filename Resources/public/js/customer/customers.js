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

					$( ".filters input" ).keyup(function( event ) {
						event.stopPropagation();
						table.api().draw();
					});

                    $( ".filters select" ).change(function( event ) {
						event.stopPropagation();
						table.api().draw();
					});

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {
						initComplete: function( settings, json ) {
							$( this ).show();
						},
						ajax: {
							data: function( d ) {
								$( ".filters input, .filters select" ).each(function() {
									var name = $( this ).attr( "name" ),
										value = $( this ).attr( "type" ) == "checkbox"
											? ($( this ).is( ":checked" ) ? $( this ).val() : 0)
											: $( this ).val();

									d[name] = value;
								} );
							}
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
			autoWidth: false,
            columnDefs: [
				{ orderable: false, targets: [ 0, 7 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "number", targets: [ 6 ] },
				{ className: "actions", targets: [ 7 ] }
			],
			destroy: true,
            language: {
                url: "/bundles/dzangocartcore/datatables/" + dzangocart.locale + ".json"
            },
			orderable: true,
			orderCellsTop: true,
			paginate: true,
			processing: true,
			saveState: true,
			searching: false,
			serverSide: true,
			stripeClasses: []
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
    $( ".customers" ).customers( dzangocart.customers );
});






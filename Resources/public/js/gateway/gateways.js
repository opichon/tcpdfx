!function( $ ) {
	$.fn.gateways = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.gateways.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( ".filters select" ).change(function(event) {
						event.stopPropagation();
						table.api().draw();
					});

					$( ".filters input", $this ).change(function() {
						event.stopPropagation();
						table.api().draw();
					});

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.datatables, {
						initComplete: function( settings, json ) {
							$( this ).show();
						},
						ajax: {
							data: function( data ) {
								$( ".filters input, .filters select" ).each(function() {
									var name = $( this ).attr( "name" ),
										value = $( this ).attr( "type" ) == "checkbox"
											? ($( this ).is( ":checked" ) ? $( this ).val() : 0)
											: $( this ).val();

									data[name] = value;
								} );
							}
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
			$.error( "Method " +  method + " does not exist in $.gateways." );
		}
	};

	$.fn.gateways.defaults = {
		datatables: {
			autoWidth: false,
			columns: [
				{ data: "id" },
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
						   return "<a href='" + row.urls.show + "'>" + row.name + "</a>"
						}
						
						return "";
					}
				},
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							return "<a href='" + row.urls.store + "'>" + row.store.name + "</a>";
						}
						
						return "";
					}
				},
				{ data: "engine.name" },
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							return row.testing
								? "<i class='fa fa-exclamation-circle'></i>"
								: "";
						}

						return "";
					}
				},
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							return "<label class='label label-" + row.status.class + "'>" + row.status.label + "</label>";
						}

						return "";
					}
				},
				{ data: "actions" }
			],
			columnDefs: [
				{ orderable: false, targets: [ 0, 6 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "testing", targets: [ 4 ] },
				{ className: "actions", targets: [ 6 ] }
			],
			destroy: true,
			language: {
				url: "/bundles/dzangocartcore/datatables/" + dzangocart.locale + ".json"
			},
			orderable: true,
			orderCellsTop: true,
			paging: true,
			processing: true,
			searching: false,
			serverSide: true,
			stateSave: true,
			stripeClasses: []
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
	if ( undefined != dzangocart.gateways ) {
		$( ".gateways" ).gateways( dzangocart.gateways );
	}
});

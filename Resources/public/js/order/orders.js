!function( $ ) {
	$.fn.orders = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.orders.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( ".filters_keyup input" ).keyup(function(event) {
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

					helpers.initCustomerWidget( );
					helpers.initDateFilterWidget( );
				});
			}
		};
		var helpers = {
			initCustomerWidget: function() {

				var widget = $( "[name='order_filters[customer]']" );

				var customers = new Bloodhound({
					datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
					queryTokenizer: Bloodhound.tokenizers.whitespace,
					remote: {
						url: settings.typeahead.remote.url,
						replace: function( url, uriEncodedQuery ) {
							return url.replace( "__query__", uriEncodedQuery );
						}
					}
				});

				customers.initialize();

				widget.typeahead( null, {
					name: "customer",
					displayKey: "value",
					source: customers.ttAdapter()
				})
				.on( "typeahead:selected", function( e, datum ) {
					$( "[name='order_filters[customer_id]']" ).val( datum.id );
						table.api().draw();
				});

				widget.keyup( function( ) {
					if ( $(this).val() === "" ) {
						$( "[name='order_filters[customer_id]']" ).val( "" );
						table.api().draw();
					}

				})
			},

			initDateFilterWidget: function() {
				$("input[name='order_filters[date_range]']")
					.daterangepicker(
						settings.dateRangePicker,
						function( start, end ) {
							$( "input[name='order_filters[date_start]']" ).val( start.format( "YYYY-MM-DD" ) );
							$( "input[name='order_filters[date_end]']" ).val(end.format( "YYYY-MM-DD" ) );
						}
					)
					.on( "cancel.daterangepicker", function( ev, picker ) {
						$( this ).val( "" );

						$( "input[name='order_filters[date_start]']" ).val( "" );
						$( "input[name='order_filters[date_end]']" ).val( "" );

						table.api().draw();
					})
					.on( "apply.daterangepicker", function( ev, picker ) {
						table.api().draw();
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
			$.error( "Method " +  method + " does not exist in $.orders." );
		}
	};

	$.fn.orders.defaults = {
		dataTables: {
			autoWidth: false,
			columnDefs: [
				{ orderable: false, targets: [ 0, 10 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "number", targets: [ 7, 8, 9 ] },
				{ className: "actions", targets: [ 10 ] }
			],
			orderable: true,
			orderCellsTop: true,
			paginate: true,
			processing: true,
			searching: false,
			serverSide: true,
			stateSave: true,
			stripeClasses: []
		},
		dateRangePicker: {
			startDate: moment(),
			locale: { cancelLabel: 'Clear' }
		},
		date_format: "dd.MM.yy"
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".orders" ).orders( dzangocart.orders );
});

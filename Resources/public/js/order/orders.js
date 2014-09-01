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

					moment.lang( dzangocart.locale );

					$( ".filters_keyup input" ).keyup(function(event) {
						event.stopPropagation();
						table.api().draw();
					});

					$( ".filters select" ).change(function(event) {
						event.stopPropagation();
						table.api().draw();
					});

					$( ".filters input", $this ).change(function(event) {
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

					helpers.initCustomerWidget();

					helpers.initDateRangePicker( $this );
				});
			}
		};

		var helpers = {
			initCustomerWidget: function() {

				if ( "undefined" == typeof settings.typeahead ) {
					return;
				}

				var widget = $( "[name='orders_filters[customer]']" );

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
					$( "[name='orders_filters[customer_id]']" ).val( datum.id );
						table.api().draw();
				});

				widget.keyup( function( ) {
					if ( $(this).val() === "" ) {
						$( "[name='orders_filters[customer_id]']" ).val( "" );
						table.api().draw();
					}
				})
			},

			initDateRangePicker: function( elt ) {
				$( "input[name='orders_filters[period]']" ).daterangepicker(
					$.extend( true, {}, settings.daterangepicker,
						{
							startDate: moment( $( "input[name='orders_filters[date_from]']", elt ).val(), "YYYY-MM-DD" ),
							endDate: moment( $( "input[name='orders_filters[date_to]']", elt ).val(), "YYYY-MM-DD" )
						}
					),
					function(start, end) {
						$( "input[name='orders_filters[date_from]']" ).val( start.format( "YYYY-MM-DD" ) );
						$( "input[name='orders_filters[date_to]']" ).val( end.format( "YYYY-MM-DD" ) );
						table.api().draw();
					}
				)
				.data( "daterangepicker" ).updateInputText();
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
		datatables: {
			autoWidth: false,
			columns: [
				{ data: "id" },
				{ data: "date" },
				{
					data: function( row, type, val, meta ) {
						if ( "display" === type ) {
								return Mustache.render( dzangocart.mustache.order.url, row.id );
							}

							return "";
						}
				},
				{
					data: function( row, type, val, meta ) {
						if ("display" === type ) {
								return Mustache.render( dzangocart.mustache.store.url, row.store );
							}

							return "";
					}
				},
				{
					data: function( row, type, val, meta ) {
						if ( "display" === type ) {
								return Mustache.render( dzangocart.mustache.customer.url, row.customer );
							}

							return "";
						}
				},
				{ data: "status" },
				{ data: "amount.excl" },
				{ data: "amount.tax" },
				{ data: "amount.incl" },
				{
					data: function( row, type, val, meta ) {
						if ( "display" === type ) {
								return Mustache.render( dzangocart.mustache.actions.url, row.id );
							}

							return "";
						}
				}
			],
			columnDefs: [
				{ orderable: false, targets: [ 0, 9 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "number", targets: [ 6, 7, 8 ] },
				{ className: "actions", targets: [ 9 ] }
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
		},
		daterangepicker: {
			locale: { cancelLabel: "Clear" },
			maxDate: moment(),
			minDate: moment( "2009-01-01" )
		},
		date_format: "dd.MM.yy"
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".orders" ).orders( dzangocart.orders );
});

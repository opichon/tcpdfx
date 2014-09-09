!function( $ ) {
	$.fn.payments = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.payments.defaults, options );

				return this.each(function() {
					var $this = $( this );

					moment.locale( dzangocart.locale );

					$( ".filters_keyup input" ).keyup(function( event ) {
						event.stopPropagation();
						table.api().draw();
					});

					$( ".filters select" ).change(function( event ) {
						event.stopPropagation();
						table.api().draw();
					});

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.datatables, {
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
					} ) );

					helpers.initDateRangePicker( $this );
					helpers.initCustomerWidget(  );
				});
			}
		};

		var helpers = {
			initCustomerWidget: function() {

				if ( "undefined" == typeof settings.typeahead ) {
					return;
				}

				var widget = $( "[name='payments_filters[customer]']" );

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
					$( "[name='payments_filters[customer_id]']" ).val( datum.id );
						table.api().draw();
				});

				widget.keyup( function( ) {
					if ( $(this).val() === "" ) {
						$( "[name='payments_filters[customer_id]']" ).val( "" );
						table.api().draw();
					}
				})
			},

			initDateRangePicker: function( elt ) {
				$( "input[name='payments_filters[period]']" ).daterangepicker(
					$.extend( true, {}, settings.daterangepicker,
						{
							startDate: moment( $( "input[name='payments_filters[date_from]']", elt ).val(), "YYYY-MM-DD" ),
							endDate: moment( $( "input[name='payments_filters[date_to]']", elt ).val(), "YYYY-MM-DD" )
						}
					),
					function(start, end) {
						$( "input[name='payments_filters[date_from]']" ).val( start.format( "YYYY-MM-DD" ) );
						$( "input[name='payments_filters[date_to]']" ).val( end.format( "YYYY-MM-DD" ) );
						table.api().draw();
					}
				)
				.data( "daterangepicker" ).updateInputText();
			}
		};

		if ( methods[ method ] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
		}
		else if ( typeof method === "object" || !method ) {
			return methods.init.apply( this, arguments );
		}
		else {
			$.error( "Method " +  method + " does not exist in $.payments." );
		}
	};

	$.fn.payments.defaults = {
		datatables: {
			autoWidth: false,
			columns: [
				{ data: "check" },
				{ data: "date" },
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							var url = dzangocart.mustache.store.url.replace( /__id__/g, '{{id}}');
							return Mustache.render( url, row.store );
						}

						return "";
					}
				},
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							var url = dzangocart.mustache.order.url.replace( /__id__/g, '{{id}}');
							return Mustache.render( url, row.order );
						}

						return "";
					}
				},
				{ data: function( row, type, val, meta ) {
						if ( "display" == type ) {
							var url = dzangocart.mustache.customer.url.replace( /__id__/g, '{{id}}');
							return Mustache.render( url, row.customer );
						}

						return "";
					}
				},
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
					   		var url = dzangocart.mustache.gateway.url.replace( /__id__/g, '{{id}}');
							return Mustache.render( url, row.gateway );
						}

						return "";
					}
				},
				{ data: "amount" },
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							return "<label class='label label-" + row.status.class + "'>" + row.status.label + "</label>";
						}

						return "";
					}
				},
				{ data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							var url = dzangocart.mustache.order.actions.replace( /__id__/g, '{{id}}');
							return Mustache.render( url, { id : row.order.id } );
						}

						return "";
					}
				}
			],
			columnDefs: [
				{ orderable: false, targets: [ 0, 8 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "amount", targets: [ 6 ] },
				{ className: "actions", targets: [ 8 ] }
			],
			destroy: true,
			language: {
				url: "/bundles/dzangocartcore/datatables/" + dzangocart.locale + ".json"
			},
			orderable: true,
			orderCellsTop: true,
			paginate: true,
			processing: true,
			saveState: false,
			searching: false,
			serverSide: true,
			stripeClasses: []
		},
		daterangepicker: {
			locale: { cancelLabel: "Clear"  },
			maxDate: moment(),
			minDate: moment( "2009-01-01" )
		},
		date_format: "dd.MM.yy"
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".payments" ).payments( dzangocart.payments );
});

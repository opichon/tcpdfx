!function( $ ) {
	$.fn.sales = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.sales.defaults, options );

				return this.each(function() {
					var $this = $( this );
					
					$( ".filters_keyup input" ).keyup(function(event) {
							event.stopPropagation();
							table.fnDraw();
					});

					$( ".filters select" ).change(function(event) {
							event.stopPropagation();
							table.fnDraw();
					});

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {
						fnInitComplete: function( oSettings, json ) {
							$( oSettings.nTable ).show();
						},
						fnServerParams: function( data ) {
							$( ".filters input, .filters select" ).each(function() {
								var value = $( this ).val();
								data.push( {
									"name": $( this ).attr( "name" ),
									"value": value
								} );
							} );
						}
					} ) );
					helpers.initCustomerWidget( );
					helpers.initDateFilterWidget();

				});
			}
		};
		var helpers = {
			initCustomerWidget: function() {

				var widget = $( "[name='sales_filters[customer]']" );

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

				widget.typeahead(null, {
					name: 'customer',
					displayKey: 'value',
					source: customers.ttAdapter()
					}).on( "typeahead:selected", function( e, datum ) {
						$( "[name='sales_filters[customer_id]']" ).val( datum.id );
							table.fnDraw();
					});

				widget.keyup( function( ) {
					if ( $(this).val() === '' ) {
						$( "[name='sales_filters[customer_id]']" ).val( '' );
						table.fnDraw();
					}

				})
			},

			initDateFilterWidget: function() {
				$('input[name="sales_filters[date_range]"]')
					.daterangepicker(
						settings.dateRangePicker,
						function(start, end) {
							$('input[name="sales_filters[date_start]"]').val(start.format('YYYY-MM-DD'));
							$('input[name="sales_filters[date_end]"]').val(end.format('YYYY-MM-DD'));
						}
					).on('cancel.daterangepicker', function(ev, picker) {
						$(this).val('');

						$('input[name="sales_filters[date_start]"]').val('');
						$('input[name="sales_filters[date_end]"]').val('');

						table.fnDraw();
					}).on('apply.daterangepicker', function(ev, picker){
						table.fnDraw();
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
			$.error( "Method " +  method + " does not exist in $.sales." );
		}
	};

	$.fn.sales.defaults = {
		dataTables: {
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 0, 11 ] },
				{ bVisible: false, aTargets: [ 0 ] },
				{ sClass: "number", aTargets: [ 6 ] },
				{ sClass: "amount", aTargets: [ 8, 9, 10 ] },
				{ sClass: "actions", aTargets: [ 11 ] }
			],
			asStripeClasses: [],
			bAutoWidth: false,
			bDestroy: true,
			bFilter: false,
			bPaginate: true,
			bProcessing: true,
			bServerSide: true,
			bSortCellsTop: true,
			bSortable: true,
			oClasses: {
				sProcessing: "alert alert-warning"
			},
			oLanguage: {
				sUrl: "/bundles/uamdatatables/lang/" + dzangocart.locale + ".txt"
			}
		},
		dateRangePicker: {
			startDate: moment(),
			locale: { cancelLabel: 'Clear' }
		},
		date_format: "dd.MM.yy"
	};
} ( window.jQuery );

$( document ).ready(function() {
	if (undefined != dzangocart.sales) {
		$( ".sales" ).sales( dzangocart.sales );
	}
});



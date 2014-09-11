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

					moment.locale( dzangocart.locale );

					$( ".filters input" ).keyup(function(event) {
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

					helpers.initDateRangePicker( $this );
				});
			}
		};

		var helpers = {
			initDateRangePicker: function( elt ) {
				$( "input[name='promotion[period]']" ).daterangepicker(
					$.extend( true, {}, settings.daterangepicker,
						{
							startDate: moment( $( "input[name='promotion[date_from]']", elt ).val(), "YYYY-MM-DD" ),
							endDate: moment( $( "input[name='promotion[date_to]']", elt ).val(), "YYYY-MM-DD" )
						}
					),
					function(start, end) {
						$( "input[name='promotion[date_from]']" ).val( start.format( "YYYY-MM-DD" ) );
						$( "input[name='promotion[date_to]']" ).val( end.format( "YYYY-MM-DD" ) );
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
			language: {
				url: "/bundles/dzangocartcore/datatables/" + dzangocart.locale + ".json"
			},
			orderable: true,
			orderCellsTop: true,
			paging: true,
			processing: true,
			searching: false,
			serverSide: true,
			stripeClasses: [],
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
	$( ".promotions" ).promotions( dzangocart.promotions );
});

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
					} ) );

					$("input[name='payments_filters[period]']")
					.daterangepicker(
						settings.dateRangePicker,
						function( start, end ) {
							$( "input[name='payments_filters[date_from]']" ).val( start.format( "YYYY-MM-DD" ) );
							$( "input[name='payments_filters[date_to]']" ).val( end.format( "YYYY-MM-DD" ) );
						}
					)
					.on( "cancel.daterangepicker", function( e, picker ) {
						$( this ).val( "" );

						$( "input[name='payments_filters[date_from]']" ).val(  "" );
						$( "input[name='payments_filters[date_to]']" ).val( "" );

						table.api().draw();
					})
					.on( "apply.daterangepicker", function( e, picker ){
						table.api().draw();
					});
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
			$.error( "Method " +  method + " does not exist in $.payments." );
		}
	};

	$.fn.payments.defaults = {
		dataTables: {
			autoWidth: false,
			columnDefs: [
				{ orderable: false, targets: [ 0, 7 ] },
				{ visible: false, targets: [ 0 ] },
				{ className: "amount", targets: [ 5 ] },
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
		},
		daterangepicker: {
            locale: { cancelLabel: "Clear"  },
            maxDate: moment(),
            minDate: moment( "2009-01-01" ),
            ranges: {
                "MTD": [moment().startOf( "month" ), moment()],
                "Last Month": [
                    moment().subtract( "month", 1).startOf( "month" ),
                    moment().subtract( "month", 1).endOf( "month" )
                ],
                "QTD": [
                    moment().month( moment().quarter() * 3 ).subtract( "month", 3).startOf( "month" ),
                    moment()
                ],
                "Last quarter": [
                    moment().month( (moment().quarter() - 1) * 3 ).subtract( "month", 3 ).startOf( "month" ),
                    moment().month( (moment().quarter() - 1) * 3 ).subtract( "month", 1 ).endOf( "month" )
                ],
                "YTD": [moment().startOf( "year" ), moment()],
                "Last Year": [
                    moment().subtract( "year", 1 ).startOf( "year"),
                    moment().subtract( "year", 1 ).endOf( "year" )
                ]
            },
            startDate: moment()
        },
        date_format: "dd.MM.yy"
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".payments" ).payments( dzangocart.payments );
});

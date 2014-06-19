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

					$("input[name='payment_filters[date_range]']")
					.daterangepicker(
						settings.dateRangePicker,
						function( start, end ) {
							$( "input[name='payment_filters[date_start]']" ).val( start.format( "YYYY-MM-DD" ) );
							$( "input[name='payment_filters[date_end]']" ).val( end.format( "YYYY-MM-DD" ) );
						}
					)
					.on( "cancel.daterangepicker", function( e, picker ) {
						$( this ).val( "" );

						$( "input[name='payment_filters[date_start]']" ).val(  "" );
						$( "input[name='payment_filters[date_end]']" ).val( "" );

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
			orderable: true,
			orderCellsTop: true,
			paginate: true,
			processing: true,
			saveState: true,
			searching: false,
			serverSide: true,
			stripeClasses: []
		},
		dateRangePicker: {
			startDate: moment(),
			locale: { cancelLabel: "Clear" }
		},
		date_format: "dd.MM.yy"
	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".payments" ).payments( dzangocart.payments );
});

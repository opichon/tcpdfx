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

                    $( ".filters input" ).keyup(function(event) {
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
                            $( ".filters input, select" ).each(function() {
                                var value = $( this ).val();
                                data.push( {
                                    "name": $( this ).attr( "name" ),
                                    "value": value
                                });
                            });
                        }
                    } ) );

                    $('input[name="payment_filters[date_range]"]')
                    .daterangepicker(
                        settings.dateRangePicker,
                        function(start, end) {
                            $('input[name="payment_filters[date_start]"]').val(start.format('YYYY-MM-DD'));
                            $('input[name="payment_filters[date_end]"]').val(end.format('YYYY-MM-DD'));
                        }
                    ).on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');

                        $('input[name="payment_filters[date_start]"]').val('');
                        $('input[name="payment_filters[date_end]"]').val('');

                        table.fnDraw();
                    }).on('apply.daterangepicker', function(ev, picker){
                        table.fnDraw();
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
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 0, 7 ] },
				{ bVisible: false, aTargets: [ 0 ] },
				{ sClass: "actions", aTargets: [ 7 ] }
			],
			asStripeClasses: [],
			bAutoWidth: false,
			bDestroy: true,
			bPaginate: true,
			bProcessing: true,
			bServerSide: true,
			bSortable: true,
            bSortCellsTop: true,
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
	$( ".payments" ).payments( dzangocart.payments );
});

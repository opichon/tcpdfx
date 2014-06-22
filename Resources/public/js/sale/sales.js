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
                        table.api().draw();
                    });

                    $( ".filters select" ).change(function(event) {
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
                                        value = $( this ).val();

                                    d[name] = value;
                                } );
                            }
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
                            table.api().draw();
                    });

                widget.keyup( function( ) {
                    if ( $(this).val() === '' ) {
                        $( "[name='sales_filters[customer_id]']" ).val( '' );
                            table.api().draw();
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
                    ).on( "show.daterangepicker", function( ev, picker ) {
                        $( ".daterangepicker" ).addClass('show-calendar');
                    }).on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');

                        $('input[name="sales_filters[date_start]"]').val('');
                        $('input[name="sales_filters[date_end]"]').val('');

                        table.api().draw();
                    }).on('apply.daterangepicker', function(ev, picker){
                        table.api().draw();
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
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: [ 0, 11 ] },
                { visible: false, targets: [ 0 ] },
                { className: "number", targets: [ 6 ] },
                { className: "amount", targets: [ 8, 9, 10 ] },
                { className: "actions", targets: [ 11 ] }
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
            stripeClasses: []
        },
        dateRangePicker: {
            ranges: {
                'MTD': [moment().startOf('month'), moment()],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
                'QTD': [moment().month(moment().quarter()*3).subtract('month', 3).startOf('month'), moment()],
                'Last quarter': [moment().month((moment().quarter()-1)*3).subtract('month', 3).startOf('month'), moment().month((moment().quarter()-1)*3).subtract('month', 1).endOf('month')],
                'YTD': [moment().startOf('year'), moment()],
                'Last Year': [moment().subtract('year', 1).startOf('year'), moment().subtract('year', 1).endOf('year')]
            },
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

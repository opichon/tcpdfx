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

                    moment.lang( dzangocart.locale );

                    $( ".filters_keyup input" ).keyup(function(event) {
                        event.stopPropagation();
                        table.api().draw();
                    });

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

                    helpers.initCustomerWidget();

                    helpers.initDateRangePicker( $this );
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
                })
                .on( "typeahead:selected", function( e, datum ) {
                    $( "[name='sales_filters[customer_id]']" ).val( datum.id );
                        table.api().draw();
                });

                widget.keyup( function( ) {
                    if ( $(this).val() === "" ) {
                        $( "[name='sales_filters[customer_id]']" ).val( '' );
                            table.api().draw();
                    }
                })
            },

            initDateRangePicker: function( elt ) {
                $( "input[name='sales_filters[period]']" ).daterangepicker(
                    $.extend( true, {}, settings.daterangepicker,
                        {
                            startDate: moment( $( "input[name='sales_filters[date_from]']", elt ).val(), "YYYY-MM-DD" ),
                            endDate: moment( $( "input[name='sales_filters[date_to]']", elt ).val(), "YYYY-MM-DD" )
                        }
                    ),
                    function(start, end) {
                        $( "input[name='sales_filters[date_from]']" ).val( start.format( "YYYY-MM-DD" ) );
                        $( "input[name='sales_filters[date_to]']" ).val( end.format( "YYYY-MM-DD" ) );
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
            $.error( "Method " +  method + " does not exist in $.sales." );
        }
    };

    $.fn.sales.defaults = {
        datatables: {
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: [ 0, 10 ] },
                { visible: false, targets: [ 0 ] },
                { className: "number", targets: [ 6 ] },
                { className: "amount", targets: [ 7, 8, 9 ] },
                { className: "actions", targets: [ 10 ] }
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
	if (undefined != dzangocart.sales) {
		$( ".sales" ).sales( dzangocart.sales );
	}
});

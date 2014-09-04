!function( $ ) {
    $.fn.carts = function( method ) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.carts.defaults, options );

                return this.each(function() {
                    var $this = $( this );

                    moment.locale( dzangocart.locale );

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

                var widget = $( "[name='carts_filters[customer]']" );

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
                    $( "[name='carts_filters[customer_id]']" ).val( datum.id );
                        table.api().draw();
                });

                widget.keyup( function( ) {
                    if ( $(this).val() === "" ) {
                        $( "[name='carts_filters[customer_id]']" ).val( "" );
                        table.api().draw();
                    }
                })
            },

            initDateRangePicker: function( elt ) {
                $( "input[name='carts_filters[period]']" ).daterangepicker(
                    $.extend( true, {}, settings.daterangepicker,
                        {
                            startDate: moment( $( "input[name='carts_filters[date_from]']", elt ).val(), "YYYY-MM-DD" ),
                            endDate: moment( $( "input[name='carts_filters[date_to]']", elt ).val(), "YYYY-MM-DD" )
                        }
                    ),
                    function(start, end) {
                        $( "input[name='carts_filters[date_from]']" ).val( start.format( "YYYY-MM-DD" ) );
                        $( "input[name='carts_filters[date_to]']" ).val( end.format( "YYYY-MM-DD" ) );
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

    $.fn.carts.defaults = {
        datatables: {
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: [ 0, 8 ] },
                { visible: false, targets: [ 0 ] },
                { className: "number", targets: [ 5, 6, 7 ] },
                { className: "actions", targets: [ 8 ] }
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
	$( ".carts" ).carts( dzangocart.carts );
});

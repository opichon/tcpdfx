!function( $ ) {
    $.fn.transactions = function( method ) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.transactions.defaults, options );

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
                });
            }
        };

        var helpers = {
            initDateRangePicker: function( elt ) {
                $( "input[name='po_filters[period]']" ).daterangepicker(
                    $.extend( true, {}, settings.daterangepicker,
                        {
                            startDate: moment( $( "input[name='po_filters[date_from]']", elt ).val(), "YYYY-MM-DD" ),
                            endDate: moment( $( "input[name='po_filters[date_to]']", elt ).val(), "YYYY-MM-DD" )
                        }
                    ),
                    function(start, end) {
                        $( "input[name='po_filters[date_from]']" ).val( start.format( "YYYY-MM-DD" ) );
                        $( "input[name='po_filters[date_to]']" ).val( end.format( "YYYY-MM-DD" ) );
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
            $.error( "Method " +  method + " does not exist in $.transactions." );
        }
    };

    $.fn.transactions.defaults = {
        datatables: {
            autoWidth: false,
            columns: [
                { data: "check" },
                { data: "date" },
                { data: function( row, type, val, meta ) {
                        if ( "display" === type ) {
                            return "<a href='" + row.urls.store + "'>" + row.store.name + "</a>";
                        }

                        return "";
                    }
                },
                { data: function( row, type, val, meta ) {
                        if ( "display" === type ) {
                            return "<a href='" + row.urls.order + "'>" + row.order.id + "</a>";
                        }

                        return "";
                    }
                },
                { data: "amount" },
                { data: "bank" },
                { data: "type" },
                { data: "cheque" },
                { data: "actions" }
            ],
            columnDefs: [
                { orderable: false, targets: [ 0, 8 ] },
                { visible: false, targets: [ 0 ] },
                { className: "amount", targets: [ 4 ] },
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
            saveState: true,
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
	$( ".po" ).transactions( dzangocart.po );
});

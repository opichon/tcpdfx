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

                    table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {
                        fnInitComplete: function( oSettings, json ) {
                            $( oSettings.nTable ).show();
                        },
                    } ) );
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
            bPaginate: true,
            bProcessing: true,
            bServerSide: true,
            bSortable: true,
            oClasses: {
                sProcessing: "alert alert-warning"
            },
            oLanguage: {
                sUrl: "/bundles/uamdatatables/lang/" + dzangocart.locale + ".txt"
            }
        }
    };
} ( window.jQuery );

$( document ).ready(function() {
    if (undefined != dzangocart.sales) {
        $( ".sales" ).sales( dzangocart.sales );
    }
});



!function( $ ) {
    $.fn.purchases = function( method ) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.purchases.defaults, options );

                return this.each(function() {
                    var $this = $( this );

                    table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {} ) );
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
            $.error( "Method " +  method + " does not exist in $.purchases." );
        }
    };

    $.fn.purchases.defaults = {
        dataTables: {
            aoColumnDefs: [
                { bSortable: false, aTargets: [ 0, 9 ] },
                { bVisible: false, aTargets: [ 0 ] },
                { sClass: "number", aTargets: [ 8 ] },
                { sClass: "actions", aTargets: [ 9 ] }
            ],
            asStripeClasses: [],
            bAutoWidth: true,
            bDestroy: true,
            bPaginate: true,
            bProcessing: true,
            bServerSide: true,
            bSortable: true,
            oLanguage: {
                sUrl: "/bundles/uamdatatables/lang/" + dzangocart.locale + ".txt"
            }
        }
    };
} ( window.jQuery );

$( document ).ready(function() {
    if (undefined != dzangocart.purchases) {
        $( ".purchases" ).purchases( dzangocart.purchases );
    }
});



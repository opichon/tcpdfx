!function( $ ) {
    $.fn.useradmin = function( method ) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.useradmin.defaults, options );

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
            $.error( "Method " +  method + " does not exist in $.useradmin." );
        }
    };

    $.fn.useradmin.defaults = {
        dataTables: {
            aoColumnDefs: [
                { bSortable: false, aTargets: [ 0, 7 ] }, // First column and last column ("actions") are not sortable
                { bVisible: false, aTargets: [ 0 ] }, // Hide the first column
                { sClass: 'actions', aTargets: [ 7 ] } // Set special "actions" class on cells in the last column
            ],
            asStripeClasses: [],
            bAutoWidth: false,
            bPaginate: true,
            bProcessing: true,
            bServerSide: true, // set datatables to use ajax to display content
            bSortable: true
        }
    };
} ( window.jQuery );

$( document ).ready(function() {
    $( ".useradmin" ).useradmin( dzangocart.useradmin );
});

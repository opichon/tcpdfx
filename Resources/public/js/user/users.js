!function( $ ) {
    $.fn.users = function( method ) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.users.defaults, options );

                return this.each(function() {
                    var $this = $( this );

                    table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {
                        initComplete: function( settings, json ) {
                            $( this ).show();
                        }
                    }));
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
            $.error( "Method " +  method + " does not exist in $.users." );
        }
    };

    $.fn.users.defaults = {
        dataTables: {
            columnDefs: [
                { orderable: false, targets: [ 0, 9 ] },
                { visible: false, targets: [ 0 ] },
                { className: 'actions', targets: [ 9 ] }
            ],
            stripeClasses: [],
            autoWidth: false,
            destroy: true,
            paging: true,
            processing: true,
            serverSide: true,
            orderable: true,
            sortCellsTop: true
        }
    };
} ( window.jQuery );

$( document ).ready(function() {
    $( ".users" ).users( dzangocart.users );
});

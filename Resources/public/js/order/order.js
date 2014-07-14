!function( $ ) {
    $.fn.order = function( method ) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.order.defaults, options );

                return this.each(function() {
                    var $this = $( this );

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
            $.error( "Method " +  method + " does not exist in $.order." );
        }
    };

    $.fn.order.defaults = {

    };
} ( window.jQuery );

// Make sure that a parent element of the table has the class ''.orders'' set so that this plugin can be triggered properly when the page is loaded.
$( document ).ready(function() {
    $( ".order" ).order( dzangocart.order );
});


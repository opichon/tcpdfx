!function( $ ) {
    $.fn.catalogue = function( method ) {

        var settings;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.catalogue.defaults , options );
                
                return this.each(function() {
                    $.getJSON(
                        settings.url,
                        function( result ) {   
                            $( '.jqtree' ).tree({
                                data: result.data
                            }); 
                        }
                    );
                });
            }
        };

        // Private methods
        var helpers = {

        };

        if ( methods[ method ] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
        }
        else if ( typeof method === "object" || !method ) {
            return methods.init.apply( this, arguments );
        }
        else {
            $.error( "Method " +  method + " does not exist in $.catalogue." );
        }
    };

    $.fn.catalogue.defaults = {
        catalogue: {

        }
    };

} ( window.jQuery );

// Make sure that a parent element of the table has the class ''.cataloguess'' set so that this plugin can be triggered properly when the page is loaded.
$( document ).ready(function() {
    $( '._catalogue' ).catalogue( dzangocart.catalogue );
});


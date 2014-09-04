!function( $ ) {
	$.fn.pack = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.pack.defaults, options );

				return this.each(function() {
					var $this = $( this );
					
					var checked = $("input[name='catagory_edit[pack]']").is(':checked');
					
					if( checked ) {
						$('.pack_component tbody').hide();
					} else {
						
					}

					$("input[name='catagory_edit[pack]']").change(function(){
						if ($(this).is(':checked')) {
							$('.pack_component').show();
							$('.pack_component tbody').show();
					} else {
							$('.pack_component').hide();
						}	
					});
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
			$.error( "Method " +  method + " does not exist in $.pack." );
		}
	};

	$.fn.pack.defaults = {

	};
} ( window.jQuery );

$( document ).ready(function() {
	$( ".category" ).pack( dzangocart.pack );
});

!function( $ ) {
	$.fn.promotions = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.promotions.defaults, options );

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
			$.error( "Method " +  method + " does not exist in $.promotions." );
		}
	};

	$.fn.promotions.defaults = {
		dataTables: {
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 0, 5 ] },
				{ bVisible: false, aTargets: [ 0 ] },
				{ sClass: "actions", aTargets: [ 5 ] }
			],
			asStripeClasses: [],
			bAutoWidth: false,
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
	$( ".promotions" ).promotions( dzangocart.promotions );
});

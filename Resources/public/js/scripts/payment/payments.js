!function( $ ) {
	$.fn.payments = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.payments.defaults, options );

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
			$.error( "Method " +  method + " does not exist in $.payments." );
		}
	};

	$.fn.payments.defaults = {
		dataTables: {
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 0, 6 ] },
				{ bVisible: false, aTargets: [ 0 ] },
				{ sClass: "actions", aTargets: [ 6 ] }
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
	$( ".payments" ).payments( dzangocart.payments );
});

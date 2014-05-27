!function( $ ) {
	$.fn.orders = function( method ) {

		var settings,
			table;

		// Public methods
		var methods = {
			init: function( options ) {
				settings = $.extend( true, {}, $.fn.orders.defaults, options );

				return this.each(function() {
					var $this = $( this );

					$( ".filters_keyup input" ).keyup(function(event) {
						event.stopPropagation();
                        table.fnDraw();
					});

					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.dataTables, {
						fnInitComplete: function( oSettings, json ) {
							$( oSettings.nTable ).show();
						},
						fnServerParams: function( data ) {
							$( ".filters input" ).each(function() {
								var value = $( this ).val();
								data.push( {
									"name": $( this ).attr( "name" ),
									"value": value
								});
							});
						}
					}));
                    helpers.initCustomerWidget( );
				});
			}
		};
        var helpers = {
			initCustomerWidget: function() {
				var widget = $( "[name='order_filters[customer_id]']" );

                var customers = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: settings.typeahead.remote.url,
                        replace: function( url, uriEncodedQuery ) {
                            return url.replace( "__query__", uriEncodedQuery );
                        }
                    }
                });
                
                customers.initialize();

                widget.typeahead(null, {
                    name: 'customer_id',
                    displayKey: 'value',
                    source: customers.ttAdapter()
                    }).on( "typeahead:selected", function( e, datum ) {
                        $( this ).val( datum.id );
                        table.fnDraw();
                        $( this ).val( datum.value );
                    } );
                }
        };
		if ( methods[ method ] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		}
		else if ( typeof method === "object" || !method ) {
			return methods.init.apply( this, arguments );
		}
		else {
			$.error( "Method " +  method + " does not exist in $.orders." );
		}
	};

	$.fn.orders.defaults = {
		dataTables: {
			aoColumnDefs: [
				{ bSortable: false, aTargets: [ 0, 10 ] },
				{ bVisible: false, aTargets: [ 0 ] },
				{ sClass: "amount", aTargets: [ 7, 8, 9 ] },
				{ sClass: "actions", aTargets: [ 10 ] }
			],
			asStripeClasses: [],
			bAutoWidth: false,
			bPaginate: true,
			bProcessing: true,
			bServerSide: true, // set datatables to use ajax to display content
			bSortable: true,
			bSortCellsTop: true,
            bDestroy: true,
            bRetrieve: true,
			oLanguage: {
				sUrl: "/bundles/uamdatatables/lang/" + dzangocart.locale + ".txt"
			}
		}
	};
} ( window.jQuery );

$( document ).ready(function() {
    $( ".orders" ).orders( dzangocart.orders );
});

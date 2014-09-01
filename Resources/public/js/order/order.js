!function($) {
	$.fn.order = function(method) {

		var settings,
				table;

		// Public methods
		var methods = {
			init: function(options) {
				settings = $.extend(true, {}, $.fn.order.defaults, options);

				helpers.returnLink();
				
				return this.each(function() {
					var $this = $(this);

					table = $("table.table", this).dataTable($.extend(true, {}, settings.datatables, {
						initComplete: function(settings, json) {
							$(this).show();
						}

					}));

				});

			}
		};

		var helpers = {
			returnLink: function() {
                if(dzangocart.mustache.urls.back){
                    var template = Mustache.to_html(dzangocart.mustache.urls.back);

                    $('#return').html(template);
                }
			}
		};

		if (methods[ method ]) {
			return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === "object" || !method) {
			return methods.init.apply(this, arguments);
		}
		else {
			$.error("Method " + method + " does not exist in $.order.");
		}
	};

	$.fn.order.defaults = {
		datatables: {
			ordering: false,
			paging: false,
			searching: false
		}
	};
}(window.jQuery);

// Make sure that a parent element of the table has the class ''.orders'' set so that this plugin can be triggered properly when the page is loaded.
$(document).ready(function() {
	$(".order").order(dzangocart.order);
});



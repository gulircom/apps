/* global jQuery, reduxSearch */

(function ($) {
	$(document).ready(function () {
		$('.redux-container').each(function () {
			if (!$(this).hasClass('redux-no-sections')) {
				$(this).find('.redux-main').prepend('<input class="redux_field_search" type="text" placeholder="' + reduxSearch.search + '"/><span class="option-search-spinner spinner"></span>');
			}
		});

		$('.redux_field_search').on('keypress', function (evt) {
			var charCode = evt.charCode || evt.keyCode;
			if (13 === charCode) {
				return false;
			}
		}).typeWatch({
			callback: function (searchString) {
				var searchArray;
				var parent;
				var expanded_options;

				searchString = searchString.toLowerCase();

				if (searchString.length === 1 || searchString.length === 2) {
					return false;
				}

				$('.option-search-spinner').css('visibility', 'visible');

				searchArray = searchString.split(' ');
				$('.is-match').removeClass('is-match');
				parent = $(this).parents('.redux-container:first');

				expanded_options = parent.find('.expand_options');

				if (searchString !== '') {
					if (!expanded_options.hasClass('expanded')) {
						expanded_options.trigger('click');
						parent.find('.redux-main').addClass('redux-search');
					}
				} else {
					if (expanded_options.hasClass('expanded')) {
						expanded_options.trigger('click');
						parent.find('.redux-main').removeClass('redux-search');
					}
					parent.find('.redux-section-field, .redux-info-field, .redux-notice-field, .redux-container-group, .redux-section-desc, .redux-group-tab h3')
						.removeClass('is-hide');
				}

				parent.find('.redux-field-container').each(function () {
					if (searchString !== '') {
						$(this).parents('tr:first').addClass('is-hide');
					} else {
						$(this).parents('tr:first').removeClass('is-hide');
					}
				});

				parent.find('.form-table tr').filter(function () {
					var isMatch = true;
					var text = $(this).find('.redux_field_th').text().toLowerCase();

					if (!text) {
						return false;
					}

					$.each(searchArray, function (i, searchStr) {
						if (text.indexOf(searchStr) === -1) {
							isMatch = false;
						}
					});

					if (isMatch) {
						$(this).removeClass('is-hide');
						$(this).parents('.redux-group-tab').addClass('is-match');
					} else {
						$(this).addClass('is-hide');
					}
					return isMatch;
				});

				setTimeout(function () {
					$(".redux-group-tab:visible").find(".redux-field-init:visible").each(
						function () {
							var type = $(this).attr('data-type');
							if (type in redux.field_objects && typeof redux.field_objects[type].init == 'function') {
								redux.field_objects[type].init();
							}
						}
					);
					$('.option-search-spinner').css('visibility', 'hidden');
				}, 100); // short delay to ensure DOM changes complete
			},
			wait: 500,
			highlight: false,
			captureLength: 0
		});

		// Bind click handler to re-trigger group tab link and clear search
		$(document).on('click', '.redux-search .redux-group-tab.is-match > h2', function () {

			var rel = $(this).parent().data('rel');
			// Clear the search input
			$('.option-search-spinner').css('visibility', 'visible');

			$('.redux_field_search').val('').trigger('input');
			$('html, body').animate({ scrollTop: 0 }, 150); // 300ms for smooth scroll

			// Trigger the corresponding tab link
			setTimeout(function () {
				$('.redux-group-tab[data-rel="' + rel + '"]').show();
				$('.redux-group-tab-link-a[data-rel="' + rel + '"]').trigger('click');
			}, 200)
		});

	});
})(jQuery);

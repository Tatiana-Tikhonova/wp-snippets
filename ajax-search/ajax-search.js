jQuery(function ($) {
	// $('.search__form input[name="s"]').on('input', function () {

	// 	$(this).next('.search-form__reset').css('opacity', 1);
	// 	var search = $(this).val();
	// 	if (search.length < 3) {
	// 		$(this).parent().next('.search__result').empty();
	// 		$(this).next('.search-form__reset').css('opacity', 0);
	// 		return false;
	// 	}

	// 	var data = {
	// 		s: search,
	// 		action: 'search_action',
	// 		nonce: search - form.nonce

	// 	};
	// 	$.ajax({
	// 		url: search - form.url,
	// 		data: data,
	// 		type: 'POST',
	// 		dataType: 'json',

	// 		success: function (data) {
	// 			$('.search__form .search__result').html(data.out);
	// 		}
	// 	});

	// });
	if ($('.search-form input[name="s"]').attr('value') != '') {
		$('.search-form input[name="s"]').next('.search-form__reset').css('opacity', 1);

	}


	$('.search-form__reset').click(function () {
		$('.search-form').next('.search__result').empty();
		$('.search-form input[name="s"]').attr('value', '');
		$(this).css('opacity', 0);
	});

	$('.search-form input[name="s"]').on('input', function () {

		$(this).next('.search-form__reset').css('opacity', 1);
		var search = $(this).val();
		var fm = $(this).parent();


		if (search.length < 3) {
			$(fm).next('.search__result').empty();
			$(this).next('.search-form__reset').css('opacity', 0);
			return false;
		}

		var data = {
			s: search,
			action: 'search_action',
			nonce: search__form.nonce

		};
		$.ajax({
			url: search__form.url,
			data: data,
			type: 'POST',
			dataType: 'json',

			success: function (data) {
				data.out = data.out.slice(1, -1);
				if ($(fm).next('.search__result').length > 0) {
					$(fm).next('.search__result').html(data.out);
				}


			}
		});


	});

});

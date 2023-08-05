function productItemHeight(element) {
	$(element).each(function() {
		var itemHeight = $(this).height();
		$(this).css({
			"height": itemHeight
		});
	});
}

$(window).load(function() {
	productItemHeight(".product-item");
});


$('.btn-opendata').click(function() {
	$('.box-howto').hide().removeClass('hidden').slideDown(); 
	// $(this).hide();
	return false;
});

$('button.close').click(function() {
	$(this).parents('.box').slideUp();
	return false;
});

var functions = {}

functions._showErrorBannerTimeout = setTimeout(function () {}, 0);

functions.showErrorBanner = function (msg, timeout) {
	timeout = timeout || 3000;
	if ($('.alert-danger').length) {
		$('.alert-danger').remove();
		clearTimeout(functions._showErrorBannerTimeout);
	} 
	$('#page-top').before('<div class="alert alert-danger">' + msg + '</div>');
	$('.alert-danger').delay(timeout).slideUp(600);
	functions._showErrorBannerTimeout = setTimeout(function () {
		$('.alert-danger').remove();
	}, timeout + 600);
}

functions._showSuccessBannerTimeout = setTimeout(function () {}, 0);


functions.showSuccessBanner = function (msg, timeout) {
	timeout = timeout || 3000;
	if ($('.alert-success').length) {
		$('.alert-success').remove();
		clearTimeout(functions._showErrorBannerTimeout);
	} 
	$('#page-top').before('<div class="alert alert-success">' + msg + '</div>');
	$('.alert-success').delay(timeout).slideUp(600);
	functions._showErrorBannerTimeout = setTimeout(function () {
		$('.alert-success').remove();
	}, timeout + 600);
}
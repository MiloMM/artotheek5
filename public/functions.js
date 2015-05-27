var functions = {}

functions._showErrorBannerTimeout = setTimeout(function () {}, 0);

functions.showErrorBanner = function (msg, timeout) {
	timeout = timeout || 3000;
	if ($('.alert-danger').length) {
		$('.alert-danger').remove();
		clearTimeout(functions._showErrorBannerTimeout);
	} 
	$('#page-top').before('<div class="alert alert-danger" style="position: fixed; top: 0px; left: 0px; z-index: 9001; width: 100%;">' + msg + '</div>');
	$('.alert-danger').hide().slideDown(600).delay(timeout).slideUp(600);
	functions._showErrorBannerTimeout = setTimeout(function () {
		$('.alert-danger').remove();
	}, timeout + 1200);
}

functions._showSuccessBannerTimeout = setTimeout(function () {}, 0);


functions.showSuccessBanner = function (msg, timeout) {
	timeout = timeout || 3000;
	if ($('.alert-success').length) {
		$('.alert-success').remove();
		clearTimeout(functions._showSuccessBannerTimeout);
	} 
	$('#page-top').before('<div class="alert alert-success" style="position: fixed; top: 0px; left: 0px;  z-index: 9001; width: 100%;">' + msg + '</div>');
	$('.alert-success').hide().slideDown(600).delay(timeout).slideUp(600);
	functions._showSuccessBannerTimeout = setTimeout(function () {
		$('.alert-success').remove();
	}, timeout + 1200);
}
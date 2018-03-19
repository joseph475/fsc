$(document).ready(function () {
	$('#edit-profile-btn').click(function () {
		$('#tab-about').tab('show');
		$('#edit-btn').trigger('click');
	});
});
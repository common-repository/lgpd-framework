var lgpd_function_name = 'openpopup_' + lgpd_seal_var.lgpd_imagecode;

this[lgpd_function_name] = function (params) {
	var left = (screen.width / 2) - (550 / 2);
	var top  = (screen.height / 2) - (450 / 2);
	window.open( "https://orders.data443.com/seal/status.php?params=" + lgpd_seal_var.lgpd_imageparams, "Verify", "toolbar=0,location=0, directories=0, status=0, menubar=0, width=550, height=450, top=" + top + ", left=" + left );
	return false;
}
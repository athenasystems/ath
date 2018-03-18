
$(document).ready(function() {

	$("#smscontent").keyup(function() {
		var contid = document.getElementById('contactsid');
		if ((contid.options[contid.selectedIndex].value > 0) && (document.getElementById('smscontent').value != '')) {
			document.getElementById('sendbutt').disabled = false;
		} else {
			document.getElementById('sendbutt').disabled = true;
		}
	});


});

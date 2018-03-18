

function showHideRecur(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = 'block';
	} else {
		document.getElementById(id).style.display = 'none';
	}
};

function openQuoteMail(id) {
	now = ko.getTime();
	URL = "/mail/quote.php?id=" + id + "&now=" + now;
	myRef = window.open(URL, 'mywin',
			'left=20,top=20,width=500,height=300,toolbar=0,resizable=0');
	myRef.focus();
}

function openInvoiceMail(id) {
	URL = "/mail/invoice.php?id=" + id;
	myRef = window.open(URL, 'mywin',
			'left=20,top=20,width=500,height=300,toolbar=0,resizable=0');
	myRef.focus();
}

function openPurchaseOrderMail(id) {
	now = ko.getTime();
	URL = "/mail/purchase.order.php?id=" + id + "&now=" + now;
	myRef = window.open(URL, 'mywin',
			'left=20,top=20,width=500,height=300,toolbar=0,resizable=0');
	myRef.focus();
}
function refreshContact() {
	loadStr = "/ajax/extcontacts.php?q="
			+ document.getElementById('custid').value;
	$("#contactlist").load(loadStr);

}

function refreshSMSContact() {
	loadStr = "/ajax/extcontact_sms.php?q="
			+ document.getElementById('custid').value;
	$("#contactlist").load(loadStr);
	$('#smscontent').keyup();
}

function refreshTextBox() {

	$('#smscontent').keyup();
}

function openJobCard(id) {
	url = '/tcard/jobs_view.php?id=' + id;
	myRef = window
			.open(url, 'mywin',
					'left=20,top=20,width=660,height=700,toolbar=0,scrollbars=1,resizable=0');
}

function printJobSheet() {

	window.print();
}

function addSupp() {

	res_div = document.getElementById('suppres');
	supp_select = document.getElementById('suppid');

	if (supp_select.options[supp_select.selectedIndex].value == 0) {
		return;
	}

	suppid = supp_select.options[supp_select.selectedIndex].value;
	suppname = supp_select.options[supp_select.selectedIndex].text;
	suppids.push(suppid);
	suppnames.push(suppname);

	writeOutSupps();
}

function writeOutSupps() {

	var html = '<ol>';
	var i;
	for (i = 0; i < suppids.length; i++) {
		html += '<li><label for=""><input type=button value=Remove onclick="removeSupp('
				+ suppids[i]
				+ ')"  style="font-size:70%;width:70px;"></label>'
				+ suppnames[i]
				+ '<input type=hidden name="suppids['
				+ i
				+ ']" value="' + suppids[i] + '"></li>';
	}
	html += '</ol>';

	res_div.innerHTML = html;
}

function removeSupp(suppid) {

	var i;
	for (i = 0; i < suppids.length; i++) {
		if (suppid == suppids[i]) {
			suppids.splice(i, 1);
			suppnames.splice(i, 1);

			writeOutSupps();
			return;
		}
	}
}

function dropdown(mySel) {
	var myWin, myVal;
	myVal = mySel.options[mySel.selectedIndex].value;
	if (myVal) {
		if (mySel.form.target)
			myWin = parent[mySel.form.target];
		else
			myWin = window;
		if (!myWin)
			return true;
		myWin.location = "/costs/add.php?costsid=" + myVal;
	}
	return false;
}

function job_del_refresh() {
	
	jobselect = document.getElementById('jobsid');
	jobsid = jobselect.options[jobselect.selectedIndex].value;
	
	
	location = "/jobs/delivered.php?id=" + jobsid;
}
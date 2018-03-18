

function showSubNav(block) {
	var divBlock = document.getElementById(block);
	divBlock.style.display = 'block';
};

function hideSubNav(block) {
	document.getElementById(block).style.display = 'none';
};

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
	loadStr = "/contacts/extcontacts.php?q="
			+ document.getElementById('custid').value;
	$("#contactlist").load(loadStr);

}

function refreshInvoiceContact() {
	location = "/invoices/add?id=" + document.getElementById('custid').value;

}
function refreshQuotesContact() {
	location = "/quotes/add?id=" + document.getElementById('custid').value;

}

function refreshTextBox() {

	$('#smscontent').keyup();
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

function swapToHoursType(i) {
	clearQuantity(i);
	clearPrice(i);
	showHide('hourlyBlock' + i);
	invoiceTotal();

}
function swapToQuantityType(i) {
	clearHourly(i);
	clearPrice(i);
	showHide('quantityBlock' + i);
	invoiceTotal();

}
function swapToPriceType(i) {
	clearHourly(i);
	clearQuantity(i);
	showHide('priceBlock' + i);
	invoiceTotal();

}

function clearQuantity(i) {
	document.getElementById('itemquantity' + i).value = '';
	document.getElementById('itemprice' + i).value = '';
	document.getElementById('qlinetotal' + i).innerHTML = '';
	document.getElementById('quantityBlock' + i).style.display = 'none';
}
function clearHourly(i) {
	document.getElementById('itemhours' + i).value = '';
	document.getElementById('itemrate' + i).value = '';
	document.getElementById('hlinetotal' + i).innerHTML = '';
	document.getElementById('hourlyBlock' + i).style.display = 'none';
}
function clearPrice(i) {
	document.getElementById('itemsingleprice' + i).value = '';
	document.getElementById('priceBlock' + i).style.display = 'none';
}

function updateQLinePrice(i) {
	quantity = document.getElementById('itemquantity' + i).value;
	price = document.getElementById('itemprice' + i).value;
	if ((quantity * price) > 0) {
		document.getElementById('qlinetotal' + i).innerHTML = quantity * price;
		invoiceTotal();
	}
}
function updateHLinePrice(i) {
	hours = document.getElementById('itemhours' + i).value;
	rate = document.getElementById('itemrate' + i).value;
	if ((hours * rate) > 0) {
		document.getElementById('hlinetotal' + i).innerHTML = hours * rate;
		invoiceTotal();
	}
}
function invoiceTotal() {
	var i;
	total = 0;
	hlinetotal = 0;
	for (i = 0; i < 21; i++) {
		if (document.getElementById('hlinetotal' + i).innerHTML != '') {
			hlinetotal += parseFloat(document.getElementById('hlinetotal' + i).innerHTML);
			total += hlinetotal*100;
		}
	}
	qlinetotal = 0;
	for (i = 0; i < 21; i++) {
		if (document.getElementById('qlinetotal' + i).innerHTML != '') {
			qlinetotal += parseFloat(document.getElementById('qlinetotal' + i).innerHTML);
			total += qlinetotal*100;
			}
	}
	singleprice = 0;
	for (i = 0; i < 21; i++) {
		if (document.getElementById('itemsingleprice' + i).value != '') {
			singleprice += parseFloat(document.getElementById('itemsingleprice'
					+ i).value);
			total += singleprice*100;
			}
	}
	total = (Math.ceil(total))/100;

	document.getElementById('pagetotal').innerHTML = 'Total &pound;' + total;
}

function refreshInvoice() {
	var i;
	for (i = 0; i < 21; i++) {
		if (document.getElementById('itemquantity' + i).value != '') {
			updateQLinePrice(i);
		}
		if (document.getElementById('itemhours' + i).value != '') {
			updateHLinePrice(i);
		}
	}

}

function addStockToItem(i) {

	var stock_select = document.getElementById('stockid' + i);
	var name = stock_select.options[stock_select.selectedIndex].text;
	var price = stock_select.options[stock_select.selectedIndex].value;
	var radiotag = 'swapToQuantityType' + i;
	var nametag = 'itemcontent' + i;
	var pricetag = 'itemprice' + i;
	if (document.getElementById('quantityBlock' + i).style.display == 'none') {
		document.getElementById(radiotag).checked = true;
		swapToQuantityType(i);
	}
	document.getElementById(nametag).value = name;
	document.getElementById(pricetag).value = price;

}

function doInitialSearch() {
	types = new Array();
//"fullsearch", "orderssearch","invoicesearch","itemsearch",  "ncrsearch", "quotesearch","smssearch", "stocksearch", "jobstagessearch","jobsearch", "custsearch","diarysearch", "suppsearch", "contactsearch"
	for ( var i = 0; i < types.length; i++) {
		if (document.getElementById(types[i])) {
			document.getElementById(types[i]).click();
		}
	}
}


$(document).ready(function() {

//	$("#quotesearch").click(function() {
//		present = new Date();
//		now = present.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		from = document.getElementById('from').value;
//		perpage = document.getElementById('perpage').value;
//		custid = document.getElementById('custid').value;
//
//
//		loadStr = "/ajax.quotes.php?q=" + q + "&from=" + from + "&perpage=" + perpage + "&now=" + now + "&custid=" + custid;
//
//
//		var contacts = document.getElementById("contactsid");
//		if (contacts){
//		loadStr += "&contactsid=" + contacts.value;
//		}
//		
//		$("#searchres p").load(loadStr);
//	});

//	$("#jobsearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		from = document.getElementById('from').value;
//		perpage = document.getElementById('perpage').value;
//		custid = document.getElementById('custid').value;
//		loadStr = "/ajax.jobs.php?q=" + q + "&from=" + from + "&perpage=" + perpage + "&now=" + now + "&custid=" + custid;
//		$("#searchres p").load(loadStr);
//	});

//	$("#jobstagessearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		from = document.getElementById('from').value;
//		perpage = document.getElementById('perpage').value;
//		loadStr = "/ajax.job.stages.php?q=" + q + "&from=" + from + "&perpage=" + perpage + "&now=" + now;
//		$("#searchres p").load(loadStr);
//	});

//	$("#suppsearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		from = document.getElementById('from').value;
//		perpage = document.getElementById('perpage').value;
//		q = document.getElementById('q').value;
//		loadStr = "/ajax.supp.php?q=" + q + "&from=" + from + "&perpage=" + perpage + "&now=" + now;
//		$("#searchres p").load(loadStr);
//	});
//
//	$("#custsearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		from = document.getElementById('from').value;
//		perpage = document.getElementById('perpage').value;
//		q = document.getElementById('q').value;
//		loadStr = "/ajax.cust.php?q=" + q + "&from=" + from + "&perpage=" + perpage + "&now=" + now;
//		$("#searchres p").load(loadStr);
//	});

//	$("#contactsearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		from = document.getElementById('from').value;
//		perpage = document.getElementById('perpage').value;
//		q = document.getElementById('q').value;
//		loadStr = "/ajax.contacts.php?q=" + q + "&from=" + from + "&perpage=" + perpage + "&now=" + now;
//		$("#searchres p").load(loadStr);
//	});

//	$("#itemsearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		loadStr = "/ajax.items.php?q=" + q + "&now=" + now;
//		$("#searchres p").load(loadStr);
//	});
//
//	$("#invoicesearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		from = document.getElementById('from').value;
//		perpage = document.getElementById('perpage').value;
//		custid = document.getElementById('custid').value;
//		loadStr = "/ajax.invoices.php?q=" + q + "&from=" + from + "&perpage=" + perpage + "&now=" + now + "&custid=" + custid;
//		$("#searchres p").load(loadStr);
//	});

//	$("#stocksearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		suppid = document.getElementById('suppid').value;
//		loadStr = "/ajax.stock.php?q=" + q + "&now=" + now + "&suppid=" + suppid;
//		$("#searchres p").load(loadStr);
//	});
	
//	$("#orderssearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		suppid = document.getElementById('suppid').value;
//		loadStr = "/ajax.orders.php?q=" + q + "&now=" + now + "&suppid=" + suppid;
//		$("#searchres p").load(loadStr);
//	});
//
//	$("#smssearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		custid = document.getElementById('custid').value;
//		loadStr = "/ajax.sms.php?q=" + q + "&now=" + now + "&custid=" + custid;
//		$("#searchres p").load(loadStr);
//	});
//
//	$("#diarysearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		from = document.getElementById('from').value;
//		staffid = document.getElementById('staffid').value;
//		loadStr = "/ajax.diary.php?q=" + q + "&from=" + from + "&now=" + now + "&staffid=" + staffid;
//		$("#searchres p").load(loadStr);
//	});
	
//	$("#ncrsearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		custid = document.getElementById('custid').value;
//		loadStr = "/ajax.ncr.php?q=" + q + "&now=" + now + "&custid=" + custid;
//		$("#searchres p").load(loadStr);
//	});
//
//	$("#fullsearch").click(function() {
//		now = ko.getTime();
//		document.getElementById('recent').style.display = 'none';
//		document.getElementById('searchres').style.display = 'block';
//		q = document.getElementById('q').value;
//		loadStr = "/ajax.full.php?q=" + q + "&now=" + now;
//		$("#searchres p").load(loadStr);
//	});

	$("#smscontent").keyup(function() {
		var contid = document.getElementById('contactsid');
		if ((contid.options[contid.selectedIndex].value > 0) && (document.getElementById('smscontent').value != '')) {
			document.getElementById('sendbutt').disabled = false;
		} else {
			document.getElementById('sendbutt').disabled = true;
		}
	});

	if (!document.getElementById('doinit')) {
		doInitialSearch();
	}

	putFocus();

});


function doInitialSearch() {
	types = new Array();
//"fullsearch", "orderssearch","invoicesearch","itemsearch",  "ncrsearch", "quotesearch","smssearch", "stocksearch", "jobstagessearch","jobsearch", "custsearch","diarysearch", "suppsearch", "contactsearch"
	for ( var i = 0; i < types.length; i++) {
		if (document.getElementById(types[i])) {
			document.getElementById(types[i]).click();
		}
	}
}
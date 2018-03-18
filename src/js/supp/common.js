

function openJobCard(id){
url = '/tcard/jobs_view.php?id=' + id;
myRef = window.open(url,'mywin','left=20,top=20,width=660,height=700,toolbar=0,resizable=0');
}


function openPurchaseOrderMail(id) {
	ko = new Date();
	now = ko.getTime();
	URL = "/mail/purchase.order.php?id=" + id + "&now=" + now;
	myRef = window.open(URL, 'mywin', 'left=20,top=20,width=500,height=300,toolbar=0,resizable=0');
	myRef.focus();
}


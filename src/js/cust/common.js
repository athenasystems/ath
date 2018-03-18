$j( function() {

	$j("form[@class='focusfirst'] input:first").focus();

	// Turns a link into a popup if the link has a class of 'popup'
	$j("a[class*='popup']").click( function() {
		window.open($j(this).attr('href'), 'popup', 'status=1,toolbar=1,location=1,menubar=1,resizable=1,scrollbars=1');

		return false;
	});

	// Turns 'cancel' links into a JS confirm
	$j("a[class*='cancel']").click( function() {
		return confirm('Are you sure?');
	});

});

function highlight_id(id) {

	$j('#id-'+ id +' a').effect('highlight', {
		color: 'green'
	}, 1000);

};

function doMatch(){
url = 'lot.match.php?aid1=' + document.getElementById('auctionid1').value + '&aid2=' + document.getElementById('auctionid2').value;
location = url;
};


function openJobCard(id){
url = '/tcard/jobs_view.php?id=' + id;
myRef = window.open(url,'mywin','left=20,top=20,width=660,height=700,toolbar=0,resizable=0');
}


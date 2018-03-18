var i = 0;
var markers = Array();

function createMarker(point, index, html, icon) {

	if(icon != undefined) {
		var marker = new GMarker(point, {icon: icon});
	} else {
		var marker = new GMarker(point);
	};

	marker.id = i;

	var opts = new Object();
	opts.maxWidth = 280;

	GEvent.addListener(marker, "click", function() {
		
		marker.openInfoWindowHtml(html, opts);
		
	});

	markers[i] = marker;

	i++;

	return marker;
}

function show(id) {
	GEvent.trigger(markers[id], 'click');

	return false;
};
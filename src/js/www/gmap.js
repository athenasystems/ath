function showMap() {
  if (GBrowserIsCompatible()) {
	var map = new GMap2(document.getElementById("map"));
		map.setCenter(new GLatLng(52.585985,-1.127558), 11);
		var point = new GLatLng(52.585985,-1.127558);
		map.addOverlay(new GMarker(point));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		var marker = createMarker(point);
		map.addOverlay(marker);		
		marker.openInfoWindowHtml('<font color="000000">Tower Tool Co Ltd.<br>Tower Manufactory, Radnor Road, Wigston,<br> Leicester, UK. LE18 4XY</font>');
	};
  };
  
   function createMarker(point) {
	  var homeHTML = '<font color="000000">Tower Tool Co Ltd.<br>Tower Manufactory, Radnor Road, Wigston,<br> Leicester, UK. LE18 4XY</font>';
        var marker = new GMarker(point, {draggable: false});
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(homeHTML);
		});
        return marker;
      }
	  
window.onload = function() { showMap() };
window.onunload = function() { GUnload() };

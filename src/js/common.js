ko = new Date();

$(document).ready(function() {
	  $(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });
	});

function nav_refresh() {

	navselect = document.getElementById('navsel');
	navsel = navselect.options[navselect.selectedIndex].value;

	location = navsel;
};

function showHide(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = 'block';
	} else {
		document.getElementById(id).style.display = 'none';
	}
};

function showHideDetail(id) {
	fbBolck = 'fb' + id;
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = 'block';
		document.getElementById(fbBolck).innerHTML = '<a href="javascript:void(0);" onclick="showHideDetail(\''
				+ id + '\')">Hide Detail</a>';
	} else {
		document.getElementById(id).style.display = 'none';
		document.getElementById(fbBolck).innerHTML = '<a href="javascript:void(0);" onclick="showHideDetail(\''
				+ id + '\')">Show Detail</a>';
	}
};

function showHideHelp(id) {
	fbBolck = 'fb' + id;
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = 'block';
		document.getElementById(fbBolck).innerHTML = '<a href="javascript:void(0);" onclick="showHideHelp(\''
				+ id + '\')">Hide Help</a>';
	} else {
		document.getElementById(id).style.display = 'none';
		document.getElementById(fbBolck).innerHTML = '<a href="javascript:void(0);" onclick="showHideHelp(\''
				+ id + '\')">Show Help</a>';
	}
};

function goNextPage(from) {
	q = document.getElementById('q').value;
	perpage = document.getElementById('perpage').value;

	custid = '';
	if (document.getElementById('custid')) {
		custid = document.getElementById('custid').value;
	}

	contactsid = '';
	if (document.getElementById('contactsid')) {
		contactsid = document.getElementById('contactsid').value;
	}
	sd = '';
	if (document.getElementById('sd')) {
		if (document.getElementById('sd').checked == true) {
			sd = document.getElementById('sd').value;
		}
	}

	if (custid == 0) {
		contactsid = '';
	}

	webpage = window.location.pathname;
	url = webpage + "?from=" + from + "&perpage=" + perpage;

	if (q != '') {
		url += "&q=" + q;
	}
	if (custid != '') {
		url += "&custid=" + custid;
	}
	if (contactsid != '') {
		url += "&contactsid=" + contactsid;
	}

	if (sd != '') {
		url += "&sd=" + sd;
	}

	location = url;

};

function goBackAPage(from) {
	q = document.getElementById('q').value;
	perpage = document.getElementById('perpage').value;
	backto = from - perpage;
	custid = '';
	if (document.getElementById('custid')) {
		custid = document.getElementById('custid').value;
	}

	contactsid = '';
	if (document.getElementById('contactsid')) {
		contactsid = document.getElementById('contactsid').value;
	}
	sd = '';
	if (document.getElementById('sd')) {
		if (document.getElementById('sd').checked == true) {
			sd = document.getElementById('sd').value;
		}
	}
	if (custid == 0) {
		contactsid = '';
	}
	webpage = window.location.pathname;
	url = webpage + "?from=" + backto + "&perpage=" + perpage;

	if (q != '') {
		url += "&q=" + q;
	}
	if (custid != '') {
		url += "&custid=" + custid;
	}
	if (contactsid != '') {
		url += "&contactsid=" + contactsid;
	}

	if (sd != '') {
		url += "&sd=" + sd;
	}

	location = url;

};

function subSearch() {
	if (document.getElementById('custid') == 0) {

		var contid = document.getElementById('contactsid');
		contid.options[contid.selectedIndex].value = 0;

	}

	document.getElementById('from').value = 0;
	document.getElementById('searchform').submit();
};

function refreshJobs() {
	if (document.getElementById('custid').value > 0) {

		webpage = window.location.pathname;
		url = webpage + "?cid=" + document.getElementById('custid').value;

		location = url;

	}

	document.getElementById('from').value = 0;
	document.getElementById('searchform').submit();
};

function refreshItems() {
	loadStr = "/items/ajaxitems";
	$("#itemlist").load(loadStr);

}
function refreshChat() {
	lines = 20;
	loadStr = "/chat/getchat.php?l=" + lines + '&nocache='
			+ new Date().getTime();
	;
	$("#chatroom").load(loadStr);
	$("#chatroom").scrollTop($("#chatroom")[0].scrollHeight);
	// $("#chatroom").animate({
	// scrollTop : $("#chatroom")[0].scrollHeight
	// }, "fast");
}
function putChat(txt) {
	loadStr = "/chat/putchat.php?qchat=" + txt;
	$("#fb").load(loadStr);

}

function doChat() {
	// Create Base64 Object
	var Base64 = {
		_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
		encode : function(e) {
			var t = "";
			var n, r, i, s, o, u, a;
			var f = 0;
			e = Base64._utf8_encode(e);
			while (f < e.length) {
				n = e.charCodeAt(f++);
				r = e.charCodeAt(f++);
				i = e.charCodeAt(f++);
				s = n >> 2;
				o = (n & 3) << 4 | r >> 4;
				u = (r & 15) << 2 | i >> 6;
				a = i & 63;
				if (isNaN(r)) {
					u = a = 64;
				} else if (isNaN(i)) {
					a = 64;
				}
				t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o)
						+ this._keyStr.charAt(u) + this._keyStr.charAt(a);
			}
			return t;
		},
		decode : function(e) {
			var t = "";
			var n, r, i;
			var s, o, u, a;
			var f = 0;
			e = e.replace(/[^A-Za-z0-9\+\/\=]/g, "");
			while (f < e.length) {
				s = this._keyStr.indexOf(e.charAt(f++));
				o = this._keyStr.indexOf(e.charAt(f++));
				u = this._keyStr.indexOf(e.charAt(f++));
				a = this._keyStr.indexOf(e.charAt(f++));
				n = s << 2 | o >> 4;
				r = (o & 15) << 4 | u >> 2;
				i = (u & 3) << 6 | a;
				t = t + String.fromCharCode(n);
				if (u != 64) {
					t = t + String.fromCharCode(r);
				}
				if (a != 64) {
					t = t + String.fromCharCode(i);
				}
			}
			t = Base64._utf8_decode(t);
			return t;
		},
		_utf8_encode : function(e) {
			e = e.replace(/\r\n/g, "\n");
			var t = "";
			for ( var n = 0; n < e.length; n++) {
				var r = e.charCodeAt(n);
				if (r < 128) {
					t += String.fromCharCode(r);
				} else if (r > 127 && r < 2048) {
					t += String.fromCharCode(r >> 6 | 192);
					t += String.fromCharCode(r & 63 | 128);
				} else {
					t += String.fromCharCode(r >> 12 | 224);
					t += String.fromCharCode(r >> 6 & 63 | 128);
					t += String.fromCharCode(r & 63 | 128);
				}
			}
			return t;
		},
		_utf8_decode : function(e) {
			var t = "";
			var n = 0;
			var r = c1 = c2 = 0;
			while (n < e.length) {
				r = e.charCodeAt(n);
				if (r < 128) {
					t += String.fromCharCode(r);
					n++;
				} else if (r > 191 && r < 224) {
					c2 = e.charCodeAt(n + 1);
					t += String.fromCharCode((r & 31) << 6 | c2 & 63);
					n += 2;
				} else {
					c2 = e.charCodeAt(n + 1);
					c3 = e.charCodeAt(n + 2);
					t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6
							| c3 & 63);
					n += 3;
				}
			}
			return t;
		}
	};

	// Define the string
	var string = document.getElementById('qchat').value;

	// Encode the String
	var encodedString = Base64.encode(string);

	putChat(encodedString);
	document.getElementById('qchat').value = '';
	document.getElementById('qchat').focus();
	refreshChat();
};

function showHideChatPanel() {
	if (document.getElementById('chatpanel').style.height == '320px') {
		document.getElementById('chatpanel').style.height = '27px';
		document.getElementById('chatpanel').style.width = '120px';
		clearInterval(chatInterval);
	} else {
		document.getElementById('chatpanel').style.height = '320px';
		document.getElementById('chatpanel').style.width = '280px';
		chatInterval = setInterval(function() {
			refreshChat();
		}, 6000);
		refreshChat();
	}
};
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + "; " + expires + '; path=/';
};

function goPerPage(extra_search) {
	var ppIndex = document.getElementById('perpage').selectedIndex;
	var pp = document.getElementById('perpage').options[ppIndex].value;
	setCookie('ATHENAPP', pp, 30);
	url = window.location.pathname + '?from=0&perpage=' + pp + extra_search;
	location = url;

}

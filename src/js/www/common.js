// function $() {
	// var elements = new Array();
	// for (var i = 0; i < arguments.length; i++) {
		// var element = arguments[i];
		// if (typeof element == 'string')
			// element = document.getElementById(element);
		// if (arguments.length == 1)
			// return element;
		// elements.push(element);
	// }
	// return elements;
// }

function showSubNav(block){
var divBlock = document.getElementById(block);
//$('subnav')
divBlock.style.display = 'block';
//$('#nav').css('z-index','1000');

}

function hideSubNav(block){

document.getElementById(block).style.display = 'none';

}

function checkEmail() {
	var email = document.getElementById('email');
	var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email.value)) {
		return false;
	}else{
		return true;
	}
}

function signup(){
			document.getElementById('signupdone').innerHTML = '<p>Saving your address .. please wait ...</p>';
			document.getElementById('signupform').style.display= 'none';
			document.getElementById('signupdone').style.display= 'block';
			}
			
function tryagain(){
			document.getElementById('signupform').style.display= 'block';
			document.getElementById('signupdone').style.display= 'none';
			document.getElementById('signupdone').innerHTML = '<p></p>';
			}
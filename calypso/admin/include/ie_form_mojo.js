// Add an event function
function addEvent(obj, evType, fn) {
	if (obj.addEventListener) {
		obj.addEventListener(evType, fn, true);
		return true;
	} else if (obj.attachEvent) {
		var r = obj.attachEvent("on"+evType, fn);
		return r;
	} else {
		return false;
	}
}

// Define what we do on input focus
function oninputfocus(e) {
	/* Cookie-cutter code to find the source of the event */
	if (typeof e == 'undefined') {
		var e = window.event;
	}
	var source;
	if (typeof e.target != 'undefined') {
		source = e.target;
	} else if (typeof e.srcElement != 'undefined') {
		source = e.srcElement;
	} else {
		return;
	}

	source.style.border='2px solid #993300';
}

// Define what we do on input unfocus
function oninputblur(e) {
	/* Cookie-cutter code to find the source of the event */
	if (typeof e == 'undefined') {
		var e = window.event;
	}
	var source;
	if (typeof e.target != 'undefined') {
		source = e.target;
	} else if (typeof e.srcElement != 'undefined') {
		source = e.srcElement;
	} else {
		return;
	} 

	source.style.border='2px solid #ffe6ce';
}

// Call oninputfocus for every input and textarea
addEvent(window, 'load', function() {
	var input, textarea;
	var inputs = document.getElementsByTagName('input');
	for (var i = 0; (input = inputs[i]); i++) {
		addEvent(input, 'focus', oninputfocus);
		addEvent(input, 'blur', oninputblur); 
	}
	var textareas = document.getElementsByTagName('textarea');
	for (var i = 0; (textarea = textareas[i]); i++) {
		addEvent(textarea, 'focus', oninputfocus);
		addEvent(textarea, 'blur', oninputblur); 
	}
});

// Focus the first entry
addEvent (window, 'load', function() {
	document.getElementById('form_item_one').focus()
}); 

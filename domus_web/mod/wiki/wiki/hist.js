/**
 * Functions to handle NWiki history diff version selection.
 *
 * @author Gonzalo Serrano, adaptation from MediaWiki code
 * @author David Castro, Ferran Recio, Jordi Piguillem, UPC,
 * and members of DFWikiteam listed at http://morfeo.upc.edu/crom
 * @version  $Id: hist.js,v 1.1 2008/05/26 12:06:43 gonzaloserrano Exp $
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

function historyRadios(parent) {
	var inputs = parent.getElementsByTagName('input');
	var radios = [];
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].name == "diff" || inputs[i].name == "oldid") {
			radios[radios.length] = inputs[i];
		}
	}
	return radios;
}

// check selection and tweak visibility/class onclick
function diffcheck() {
	var dli = false; // the li where the diff radio is checked
	var oli = false; // the li where the oldid radio is checked
	var hf = document.getElementById('historytable');
	if (!hf) {
		return true;
	}
	var lis = hf.getElementsByTagName('tr');
	for (var i=0;i<lis.length;i++) {
		var inputs = historyRadios(lis[i]);
		if (inputs[1] && inputs[0]) {
			if (inputs[1].checked || inputs[0].checked) { // this row has a checked radio button
				if (inputs[1].checked && inputs[0].checked && inputs[0].value == inputs[1].value) {
					return false;
				}
				if (oli) { // it's the second checked radio
					if (inputs[1].checked) {
						oli.className = "selected";
						return false;
					}
				} else if (inputs[0].checked) {
					return false;
				}
				if (inputs[0].checked) {
					dli = lis[i];
				}
				if (!oli) {
					inputs[0].style.visibility = 'hidden';
				}
				if (dli) {
					inputs[1].style.visibility = 'hidden';
				}
				lis[i].className = "selected";
				oli = lis[i];
			}  else { // no radio is checked in this row
				if (!oli) {
					inputs[0].style.visibility = 'hidden';
				} else {
					inputs[0].style.visibility = 'visible';
				}
				if (dli) {
					inputs[1].style.visibility = 'hidden';
				} else {
					inputs[1].style.visibility = 'visible';
				}
				lis[i].className = "";
			}
		}
	}
	return true;
}

// page history stuff
// attach event handlers to the input elements on history page
function histrowinit() {
	var hf = document.getElementById('historytable');
	if (!hf) {
		return;
	}
	var lis = hf.getElementsByTagName('tr');
	for (var i = 0; i < lis.length; i++) {
		var inputs = historyRadios(lis[i]);
		if (inputs[0] && inputs[1]) {
			inputs[0].onclick = diffcheck;
			inputs[1].onclick = diffcheck;
		}
	}
	diffcheck();
}

function hookEvent(hookName, hookFunct) {
    if (window.addEventListener) {
        window.addEventListener(hookName, hookFunct, false);
    } else if (window.attachEvent) {
        window.attachEvent("on" + hookName, hookFunct);
    }
}

hookEvent("load", histrowinit);

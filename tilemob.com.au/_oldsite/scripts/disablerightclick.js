window.oncontextmenu = function () { return false; }
window.ondragstart = function () { return false; }
window.ondragend = function () { return false; }
window.onselectstart = function () { return false; }
var rc_alert = "Sorry, right click function is unavailable on this Website.";
bV  = parseInt(navigator.appVersion);
bNS = navigator.appName=="Netscape";
bIE = navigator.appName=="Microsoft Internet Explorer";
function disableRightClick(e) {
	if (bNS && e.which > 1){
		alert(rc_alert);
		return false;
	} else if (bIE && (event.button >1)) {
		alert(rc_alert);
		return false;
	}
}
document.onmousedown = disableRightClick;
if (document.layers) window.captureEvents(Event.MOUSEDOWN);
if (bNS && bV<5) window.onmousedown = disableRightClick;
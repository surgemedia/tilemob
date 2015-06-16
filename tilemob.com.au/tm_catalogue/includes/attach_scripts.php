<script>
function disableContextMenu() {
	window.frames["iframe_display"].document.oncontextmenu = function(){alert("Sorry, right click function is unavailable on this Website."); return false;}; 
	window.frames["iframe_display_info"].document.oncontextmenu = function(){alert("Sorry, right click function is unavailable on this Website."); return false;};
	window.frames["iframe_collection"].document.oncontextmenu = function(){alert("Sorry, right click function is unavailable on this Website."); return false;};
}
</script>
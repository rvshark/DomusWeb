function mouseMove (evt) {
	var x = 0;
	var y = 0;
	var plusX = 0;
	var plusY = 0;
	if (document.layers) {
		x = evt.x;
		y = evt.y;
		plusX = window.pageXOffset;
		plusY = window.pageYOffset;
	} else	if (document.all) {
		x = event.clientX;
		y = event.clientY;
		plusX = document.body.scrollLeft;
		plusY = document.body.scrollTop;
	} else if (document.getElementById) {
		x = evt.clientX;
		y = evt.clientY;
		plusX = window.pageXOffset;
		plusY = window.pageYOffset;
	}
    document.getElementById("popBox").style.left = (x+plusX-300)+"px";
	document.getElementById("popBox").style.top = (y+plusY-200)+"px";
    
	
} 
if (document.layers)
	document.captureEvents(Event.MOUSEMOVE); 
if (document.layers || document.all) 
	document.onmousemove = mouseMove; 
if (document.addEventListener) 
	document.addEventListener('mousemove', mouseMove, true);
</script>

<script type="text/javascript">
function montre(id) {
 var elt = document.getElementById('popBox');
 elt.style.display = "block";
 elt.innerHTML = document.getElementById(id).innerHTML;
}
function cache() {
 var elt = document.getElementById('popBox');
 elt.style.display = "none";
}

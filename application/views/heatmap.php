<?php 
/**
 * Heatmap
 * 
 * @param string $message;
 * @author christian studer <cstuder@existenz.ch>
 */
$this->load->view('_header');
?>
<script src="<?php echo site_url('js/leaflet/leaflet.js'); ?>"></script>

<script>

$(document).ready(function() {
	// create a map in the "map" div, set the view to a given place and zoom
	var map = L.map('heatmap').setView([46.801111, 8.226667], 8);

	// add an OpenStreetMap tile layer
	L.tileLayer('http://otile1.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', {
	    attribution: 'Tiles Courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>, &copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	
});

</script>

<div id="heatmap" style="width: 1024px; height: 700px;"></div>

<?php
$this->load->view('_footer');
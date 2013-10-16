<?php
	wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?sensor=false', false, '3' );
	wp_enqueue_script( 'googlemaps' );
?>
<div id="map_canvas" style="width: 95%; height: 300px;"></div>
<label for="">Address:</label>
<input name="pods_field_map_address" data-name-clean="pods-field-map-address" id="pods-form-ui-pods-field-map-address" class="pods-form-ui-field-type-map pods-form-ui-field-name-pods-field-map-test" type="text" tabindex="2">
<input type="button" name="pods_field_map_geocode" value="Lookup Location from Address" />
<label for="">Latitude:</label>
<input type="text" name="pods_field_map_lat" disabled="disabled" />
<label for="">Longitude:</label>
<input type="text" name="pods_field_map_lng" disabled="disabled" />

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var mapDiv = document.getElementById('map_canvas');
		var geocodeButton = $('input[name=pods_field_map_geocode]');
		var addressField = $('input[name=pods_field_map_address]');
		var latField = $('input[name=pods_field_map_lat]');
		var lngField = $('input[name=pods_field_map_lng]');

		var map = null;
		var geocoder = null;
		var marker = null;

		//------------------------------------------------------------------------
		// Initialze the map
		//
		(function() {
			var zoom = 10;
			var center = new google.maps.LatLng(40.026, -82.936);

			map = new google.maps.Map(mapDiv, {
				center: center,
				zoom: zoom,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			geocoder = new google.maps.Geocoder();
		})();

		//------------------------------------------------------------------------
		// Geolocate from the address
		//
		geocodeButton.click(function() {
			var address = addressField.val();

			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					location = results[0].geometry.location;

					// Center the map and set the lat/lng values
					map.setCenter(location);
					latField.val(location.lat());
					lngField.val(location.lng());

					// Set the marker options
					var markerOptions = {
						map: map,
						position: location,
						draggable: true
					};

					// Create a new marker, if needed, and set the event listeners
					if (!marker) {
						marker = new google.maps.Marker(markerOptions);
						google.maps.event.addListener(marker, 'drag', function() {
							latField.val(marker.getPosition().lat());
							lngField.val(marker.getPosition().lng());
						});
					}
					// Marker is already set, just update its options
					else {
						marker.setOptions(markerOptions);
					}
				}
				// Geocode failure
				else {
					alert("Geocode was not successful for the following reason: " + status);
				}
			}); // end geocode
		}); // end button click event

	}); // end document ready

</script>
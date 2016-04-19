<?php
/*
Plugin Name: Pods Component - Address / Maps Field
Plugin URI: http://podsframework.org/
Description: Adds a new Address / Maps field with Geocoding and Google Maps API integration
Version: 1.0 Alpha 2
Author: Pods Framework Team
Author URI: http://podsframework.org/about/

Copyright 2009-2013  Pods Foundation, Inc  (email : contact@podsfoundation.org)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'pods_components_get', 'pods_component_address_maps_init' );
add_action( 'pods_components_load', 'pods_component_address_maps_load' );

/**
 *
 */
function pods_component_address_maps_init() {

	register_activation_hook( __FILE__, 'pods_component_address_maps_reset' );
	register_deactivation_hook( __FILE__, 'pods_component_address_maps_reset' );

	pods_component_address_maps_load();

	add_filter( 'pods_components_register', array( 'Pods_Component_AddressMaps', 'component_register' ) );

}

/**
 *
 */
function pods_component_address_maps_load() {

	$component_path = plugin_dir_path( __FILE__ );
	$component_file = $component_path . '/classes/Pods/Component/AddressMaps.php';

	Pods_Component_AddressMaps::$component_path = $component_path;
	Pods_Component_AddressMaps::$component_file = $component_file;

	// Only load as needed
	pods_register_field_type( 'addressmap', $component_path . '/classes/Pods/Field/AddressMap.php' );

}

/**
 *
 */
function pods_component_address_maps_reset() {

	delete_transient( 'pods_components' );
	delete_transient( 'pods_field_types' );

}

/**
 * @param $args
 *
 * @return mixed
 */
function pods_map( $args ) {

	return PodsForm::field_method( 'address_map', 'map', $args );

}

add_shortcode( 'pods-map', 'pods_map' );
<?php

/**
 * Interface Pods_Service_AddressMap_Interface
 * @since 1.0
 */
interface Pods_Service_AddressMap_Interface {

	/**
	 * @param string      $key
	 * @param null|string $user
	 */
	public function __construct( $key, $user = null );

	/**
	 * Geocode a specific address into Latitude and Longitude values
	 *
	 * @param string|array $address Address
	 *
	 * @return array Latitude, Longitude, and Formatted Address values
	 *
	 * @public
	 * @since 1.0
	 */
	public function geocode_address( $address );

	/**
	 * Get an address from a lat / long
	 *
	 * @param string|array $lat_long Lat / long numbers
	 *
	 * @return string Address information
	 *
	 * @public
	 * @static
	 * @since 1.0
	 */
	public function geocode_lat_long( $lat_long );


	/**
	 * @param $result
	 *
	 * @return array|bool
	 * @since 1.0
	 */
	public function parse_address( $result );
}
     
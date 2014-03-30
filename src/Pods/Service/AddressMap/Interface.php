<?php

/**
 * Interface Pods_Service_AddressMap_Interface
 */
interface Pods_Service_AddressMap_Interface {

	/**
	 * @param $address
	 *
	 * @return mixed
	 */
	public function geocode_address( $address );

	/**
	 * @param $lat_long
	 *
	 * @return mixed
	 */
	public function geocode_lat_long( $lat_long );

	/**
	 * @param $result
	 *
	 * @return mixed
	 */
	public function parse_address($result);
}
     
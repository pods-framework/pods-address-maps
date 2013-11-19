<?php
class PodsField_Address_Map extends PodsField {

	/**
	 * Field Type Group
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $group = 'Text';

	/**
	 * Field Type Identifier
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $type = 'address_map';

	/**
	 * Field Type Label
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $label = 'Address / Map';

	/**
	 * Field Type Preparation
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $prepare = '%s';

	/**
	 * File path to related files of this field type
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $file_path = '';

	/**
	 * Maps Component Options
	 *
	 * @var array
	 * @since 1.0
	 */
	public static $component_options = array();

	/**
	 * Do things like register/enqueue scripts and stylesheets
	 *
	 * @since 1.0
	 */
	public function __construct () {
		if ( class_exists( 'PodsComponent_AddressMaps' ) && !empty( PodsComponent_AddressMaps::$options ) ) {
			self::$file_path = PodsComponent_AddressMaps::$component_path;

			self::$component_options = PodsComponent_AddressMaps::$options;

			wp_register_style( 'pods-component-address-maps', plugins_url( '/ui/css/pods-address-maps.css', __FILE__ ), array(), '1.0' );
			wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?sensor=false', false, '3' );
		}
	}

	/**
	 * Add options and set defaults to
	 *
	 * @return array
	 * @since 1.0
	 */
	public function options () {
		$options = array(
			self::$type . '_type' => array(
				'label' => __( 'Address Type', 'pods' ),
				'default' => 'address',
				'type' => 'pick',
				'data' => array(
					'address' => __( 'Address Field Group', 'pods' ),
					'text' => __( 'Freeform Text', 'pods' ),
					'lat-long' => __( 'Latitude / Longitude', 'pods' )
				),
				'dependency' => true
			),
			self::$type . '_address_options' => array(
				'label' => __( 'Address Options', 'pods' ),
				'depends-on' => array( self::$type . '_type' => 'address' ),
				'group' => array(
					self::$type . '_address_line_1' => array(
						'label' => __( 'Enable Address Line 1', 'pods' ),
						'default' => 1,
						'type' => 'boolean'
					),
					self::$type . '_address_line_2' => array(
						'label' => __( 'Enable Address Line 2', 'pods' ),
						'default' => 0,
						'type' => 'boolean'
					),
					self::$type . '_address_city' => array(
						'label' => __( 'Enable City', 'pods' ),
						'default' => 1,
						'type' => 'boolean'
					),
					self::$type . '_address_state' => array(
						'label' => __( 'Enable State / Province', 'pods' ),
						'default' => 1,
						'type' => 'boolean',
						'dependency' => true
					),
					self::$type . '_address_country' => array(
						'label' => __( 'Enable Country', 'pods' ),
						'default' => 0,
						'type' => 'boolean',
						'dependency' => true
					)
				)
			),
			self::$type . '_address_state_input' => array(
				'label' => __( 'State Input Type', 'pods' ),
				'depends-on' => array( self::$type . '_address_state' => true ),
				'default' => 'text',
				'type' => 'pick',
				'data' => array(
					'text' => __( 'Freeform Text', 'pods' ),
					'pick' => __( 'Drop-down Select Box', 'pods' )
				),
			),
			self::$type . '_address_country_input' => array(
				'label' => __( 'Country Input Type', 'pods' ),
				'depends-on' => array( self::$type . '_address_country' => true ),
				'default' => 'text',
				'type' => 'pick',
				'data' => array(
					'text' => __( 'Freeform Text', 'pods' ),
					'pick' => __( 'Drop-down Select Box', 'pods' )
				),
			),
			self::$type . '_autocorrect' => array(
				'label' => __( 'Autocorrect Address during save', 'pods' ),
				'depends-on' => array( self::$type . '_display_type' => array( 'single', 'multi' ) ),
				'default' => 0,
				'type' => 'boolean'
			),
			self::$type . '_show_map_input' => array(
				'label' => __( 'Show Map below Input', 'pods' ),
				'default' => 0,
				'type' => 'boolean'
			),
			self::$type . '_display_type' => array(
				'label' => __( 'Display Type', 'pods' ),
				'default' => 'address',
				'type' => 'pick',
				'data' => array(
					'map' => __( 'Map', 'pods' ),
					'address-map' => __( 'Address and Map', 'pods' ),
					'address' => __( 'Address', 'pods' ),
					'lat-long' => __( 'Latitude, Longitude', 'pods' )
				),
				'dependency' => true
			),
			self::$type . '_style' => array(
				'label' => __( 'Map Output Type', 'pods' ),
				'depends-on' => array( self::$type . '_display_type' => array( 'map', 'address-map' ) ),
				'default' => pods_v( self::$type . '_style', self::$component_options, 'static', true ),
				'type' => 'pick',
				'data' => array(
					'static' => __( 'Static (Image)', 'pods' ),
					'js' => __( 'Javascript (Interactive)', 'pods' )
				)
			),
			self::$type . '_type_of_map' => array(
				'label' => __( 'Map Type', 'pods' ),
				'depends-on' => array( self::$type . '_display_type' => array( 'map', 'address-map' ) ),
				'default' => pods_v( self::$type . '_type', self::$component_options, 'roadmap', true ),
				'type' => 'pick',
				'data' => array(
					'roadmap' => __( 'Roadmap', 'pods' ),
					'satellite' => __( 'Satellite', 'pods' ),
					'terrain' => __( 'Terrain', 'pods' ),
					'hybrid' => __( 'Hybrid', 'pods' )
				)
			),
			self::$type . '_zoom' => array(
				'label' => __( 'Map Zoom Level', 'pods' ),
				'depends-on' => array( self::$type . '_display_type' => array( 'map', 'address-map' ) ),
				'help' => array( __( 'Google Maps has documentation on the different zoom levels you can use.', 'pods' ), 'https://developers.google.com/maps/documentation/staticmaps/#Zoomlevels' ),
				'default' => pods_v( self::$type . '_zoom', self::$component_options, 12, true ),
				'type' => 'number',
				'options' => array(
					'number_decimals' => 0,
					'number_max_length' => 2
				)
			),
			self::$type . '_marker' => array(
				'label' => __( 'Map Custom Marker', 'pods' ),
				'depends-on' => array( self::$type . '_display_type' => array( 'map', 'address-map' ) ),
				'default' => pods_v( self::$type . '_marker', self::$component_options ),
				'type' => 'file',
				'options' => array(
					'file_uploader' => 'plupload',
					'file_edit_title' => 0,
					'file_restrict_filesize' => '1MB',
					'file_type' => 'images',
					'file_add_button' => 'Upload Marker Icon'
				)
			)
		);

		return $options;
	}

	/**
	 * Define the current field's schema for DB table storage
	 *
	 * @param array $options
	 *
	 * @return array
	 * @since 1.0
	 */
	public function schema ( $options = null ) {
		$schema = 'LONGTEXT';

		return $schema;
	}

	/**
	 * Change the way the value of the field is displayed with Pods::get
	 *
	 * @param mixed $value
	 * @param string $name
	 * @param array $options
	 * @param array $pod
	 * @param int $id
	 *
	 * @return mixed|null|string
	 * @since 1.0
	 */
	public function display ( $value = null, $name = null, $options = null, $pod = null, $id = null ) {
		$value = $this->strip_html( $value, $options );

		if ( 1 == pods_v( 'text_allow_shortcode', $options ) )
			$value = do_shortcode( $value );

		return $value;
	}

	/**
	 * Customize output of the form field
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param array $options
	 * @param array $pod
	 * @param int $id
	 *
	 * @since 1.0
	 */
	public function input ( $name, $value = null, $options = null, $pod = null, $id = null ) {
		$form_field_type = PodsForm::$field_type;

		if ( is_array( $value ) )
			$value = implode( ' ', $value );

		$field = PODS_DIR . 'ui/fields/text.php';
		if ( 'address' == pods_v( self::$type . '_type', $options ) ) {
			$field = self::$file_path . 'ui/fields/address.php';
		}
		elseif ( 'lat-long' == pods_v( self::$type . '_type', $options ) ) {
			$field = self::$file_path . 'ui/fields/lat-long.php';
		}

		pods_view( $field, compact( array_keys( get_defined_vars() ) ) );

		if ( 1 == pods_v( self::$type . '_show_map_input', $options ) ) {

			pods_view( self::$file_path . 'ui/fields/map.php', compact( array_keys( get_defined_vars() ) ) );
		}
	}

	/**
	 * Validate a value before it's saved
	 *
	 * @param mixed $value
	 * @param string $name
	 * @param array $options
	 * @param array $fields
	 * @param array $pod
	 * @param int $id
	 *
	 * @param null $params
	 *
	 * @return array|bool
	 * @since 1.0
	 */
	public function validate ( $value, $name = null, $options = null, $fields = null, $pod = null, $id = null, $params = null ) {
		$errors = array();

		$check = $this->pre_save( $value, $id, $name, $options, $fields, $pod, $params );

		if ( is_array( $check ) )
			$errors = $check;
		else {
			if ( 0 < strlen( $value ) && strlen( $check ) < 1 ) {
				if ( 1 == pods_v( 'required', $options ) )
					$errors[ ] = __( 'This field is required.', 'pods' );
			}
		}

		if ( !empty( $errors ) )
			return $errors;

		return true;
	}

	/**
	 * Change the value or perform actions after validation but before saving to the DB
	 *
	 * @param mixed $value
	 * @param int $id
	 * @param string $name
	 * @param array $options
	 * @param array $fields
	 * @param array $pod
	 * @param object $params
	 *
	 * @return mixed|string
	 * @since 1.0
	 */
	public function pre_save ( $value, $id = null, $name = null, $options = null, $fields = null, $pod = null, $params = null ) {
		$value = $this->strip_html( $value, $options );

		return $value;
	}

	/**
	 * Customize the Pods UI manage table column output
	 *
	 * @param int $id
	 * @param mixed $value
	 * @param string $name
	 * @param array $options
	 * @param array $fields
	 * @param array $pod
	 *
	 * @return mixed|string
	 * @since 1.0
	 */
	public function ui ( $id, $value, $name = null, $options = null, $fields = null, $pod = null ) {
		$value = $this->strip_html( $value, $options );

		if ( 0 == pods_v( 'text_allow_html', $options, 0, true ) )
			$value = wp_trim_words( $value );

		return $value;
	}

	/**
	 * Output a map
	 *
	 * @param array $args Map options
	 *
	 * @return string Map output
	 * @since 1.0
	 */
	public static function map ( $args ) {
		$defaults = array(
			'address' => '',
			'lat' => '',
			'long' => '',

			'width' => '',
			'height' => '',
			'type' => '',
			'zoom' => '',
			'style' => '',
			'marker' => '',

			'expires' => ( 60 * 60 * 24 ),
			'cache_type' => 'cache'
		);

		$args = array_merge( (array) $args, $defaults );

		$lat_long = array(
			'lat' => $args[ 'lat' ],
			'long' => $args[ 'long' ]
		);

		if ( empty( $lat_long[ 'lat' ] ) && empty( $lat_long[ 'long' ] ) ) {
			if ( !empty( $args[ 'address' ] ) ) {
				$address_data = self::geocode_address( $args[ 'address' ] );

				if ( !empty( $address_data ) ) {
					$lat_long[ 'lat' ] = $address_data[ 'lat' ];
					$lat_long[ 'long' ] = $address_data[ 'long' ];
				}
				else
					return '';
			}
			else
				return '';
		}

		return pods_view( self::$file_path . 'ui/front/map.php', compact( array_keys( get_defined_vars() ) ), $args[ 'expires' ], $args[ 'cache_type' ], true );
	}

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
	public static function geocode_address ( $address ) {
		$address_data = false;

		if ( !empty( $address ) ) {
			if ( is_array( $address ) )
				$address = implode( ', ', $address );

			$address_data = pods_cache_get( 'geocode_get_' . md5( $address ), 'pods-component-address-maps' );

			if ( !empty( $address_data ) && is_array( $address_data ) )
				return $address_data;

			$address_data = false;

			if ( 'google' == self::$component_options[ 'provider' ] ) {
				$args = array(
					'address' => $address,
					'sensor' => 'false'
				);

				if ( !empty( self::$component_options[ 'google_client_id' ] ) )
					$args[ 'client' ] = self::$component_options[ 'google_client_id' ];

				$response = wp_remote_get( 'http://maps.google.com/maps/api/geocode/json', array( 'body' => $args ) );

				if ( !is_wp_error( $response ) ) {
					$json = wp_remote_retrieve_body( $response );

					if ( !empty( $json ) ) {
						$json = @json_decode( $json );

						if ( is_object( $json ) && isset( $json->results ) && !empty( $json->results ) )
							$address_data = self::parse_google_address( $json->results[ 0 ] );
					}
				}
			}

			if ( !empty( $address_data ) ) {
				pods_cache_set( 'geocode_get_' . md5( $address ), $address_data, 'pods-component-address-maps', ( 60 * 60 * 24 ) );

				if ( !empty( $address_data[ 'formatted' ] ) && $address != $address_data[ 'formatted' ] )
					pods_cache_set( 'geocode_get_' . md5( $address_data[ 'formatted' ] ), $address_data, 'pods-component-address-maps', ( 60 * 60 * 24 ) );
			}
		}

		return $address_data;
	}

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
	public static function geocode_lat_long ( $lat_long ) {
		$address_data = false;

		if ( !empty( $lat_long ) ) {
			if ( is_array( $lat_long ) )
				$lat_long = implode( ', ', $lat_long );

			$address_data = pods_cache_get( 'geocode_address_get_' . md5( $lat_long ), 'pods-component-address-maps' );

			if ( !empty( $address_data ) && is_array( $address_data ) )
				return $address_data;

			$address_data = false;

			if ( 'google' == self::$component_options[ 'provider' ] ) {
				$args = array(
					'latlng' => $lat_long,
					'sensor' => 'false'
				);

				if ( !empty( self::$component_options[ 'google_client_id' ] ) )
					$args[ 'client' ] = self::$component_options[ 'google_client_id' ];

				$response = wp_remote_get( 'http://maps.google.com/maps/api/geocode/json', array( 'body' => $args ) );

				if ( !is_wp_error( $response ) ) {
					$json = wp_remote_retrieve_body( $response );

					if ( !empty( $json ) ) {
						$json = @json_decode( $json );

						if ( is_object( $json ) && isset( $json->results ) && !empty( $json->results ) )
							$address_data = self::parse_google_address( $json->results[ 0 ] );
					}
				}
			}

			if ( !empty( $address_data ) ) {
				pods_cache_set( 'geocode_address_get_' . $lat_long, $address_data, 'pods-component-address-maps', ( 60 * 60 * 24 ) );

				if ( !empty( $address_data[ 'lat' ] ) && !empty( $address_data[ 'long' ] ) && $lat_long != ( $address_data[ 'lat' ] . ',' . $address_data[ 'long' ] ) )
					pods_cache_set( 'geocode_address_get_' . md5( $address_data[ 'formatted' ] ), $address_data, 'pods-component-address-maps', ( 60 * 60 * 24 ) );
			}
		}

		return $address_data;
	}

	public static function parse_google_address ( $result ) {
		if ( !is_object( $result ) || !isset( $result->address_components ) )
			return false;

		$components = $result[ 'address_components' ];

		$address = array(
			'address_1' => '',
			'address_2' => '',
			'city' => '',
			'state_province' => '',
			'postal_code' => '',
			'country' => '',
			'formatted' => '',
			'lat' => '',
			'long' => ''
		);

		foreach ( $components as $component ) {
			if ( in_array( 'street_number', $component->types ) )
				$address[ 'address_1' ] = $component->long_name;
			elseif ( in_array( 'route', $component->types ) )
				$address[ 'address_1' ] = trim( $address[ 'address_1' ] . ' ' . $component->short_name );
			elseif ( in_array( 'subpremise', $component->types ) )
				$address[ 'address_2' ] = '#' . $component->long_name;
			elseif ( in_array( 'administrative_area_level_2', $component->types ) )
				$address[ 'city' ] = $component->long_name;
			elseif ( in_array( 'administrative_area_level_1', $component->types ) )
				$address[ 'state_province' ] = $component->long_name;
			elseif ( in_array( 'postal_code', $component->types ) )
				$address[ 'postal_code' ] = $component->long_name;
			elseif ( in_array( 'country', $component->types ) )
				$address[ 'country' ] = $component->long_name;
		}

		if ( isset( $result->formatted_address ) )
			$address[ 'formatted' ] = $result->formatted_address;

		if ( isset( $result->geometry ) && isset( $result->geometry->location ) ) {
			$address[ 'lat' ] = $result->geometry->location->lat;
			$address[ 'long' ] = $result->geometry->location->lng;
		}

		return $address;
	}

	/**
	 * @todo stub function, finish it up
	 *
	 * @param $value
	 * @param $options
	 *
	 * @return mixed
	 */
	public function strip_html ( $value, $options ) {
		return $value;

	}
}

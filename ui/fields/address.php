<?php
$attributes = array();
$attributes[ 'type' ] = 'text';
$attributes[ 'value' ] = $value;
$attributes[ 'tabindex' ] = 2;
$attributes = PodsForm::merge_attributes( $attributes, $name, $form_field_type, $options );
?>
<?php if ( pods_v( $form_field_type . '_address_line_1', $options ) ): ?>
	<?php echo PodsForm::label( $name . '_address_line_1', 'Address Line 1' ) ?>
	<?php echo PodsForm::field( $name . '_address_line_1', $value, 'text', $options ) ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_line_2', $options ) ): ?>
	<?php echo PodsForm::label( $name . '_address_line_2', 'Address Line 2' ) ?>
	<?php echo PodsForm::field( $name . '_address_line_2', $value, 'text', $options ) ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_city', $options ) ): ?>
	<?php echo PodsForm::label( $name . '_address_line_2', 'City' ) ?>
	<?php echo PodsForm::field( $name . '_address_city', $value, 'text', $options ) ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_state', $options ) ): ?>
	<?php echo PodsForm::label( $name . '_address_line_2', 'State / Province' ) ?>
	<?php if ( 'pick' == pods_v( $form_field_type . '_address_state_input', $options ) ): ?>
		<?php echo PodsForm::field( $name . '_address_country', $value, 'pick', [ 'pick_object' => 'us_state' ] ) ?>
	<?php else: ?>
		<?php echo PodsForm::field( $name . '_address_state', $value, 'text', $options ) ?>
	<?php endif ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_country', $options ) ): ?>
	<?php echo PodsForm::label( $name . '_address_line_2', 'Country' ) ?>

	<?php if ( 'pick' == pods_v( $form_field_type . '_address_country_input', $options ) ): ?>
		<?php echo PodsForm::field( $name . '_address_country', $value, 'pick', [ 'pick_object' => 'country' ] ) ?>
	<?php else: ?>
		<?php echo PodsForm::field( $name . '_address_country', $value, 'text', $options ) ?>
	<?php endif ?>
<?php endif; ?>

<?php
PodsForm::regex( $form_field_type, $options );
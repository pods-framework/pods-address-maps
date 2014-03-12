<?php
$attributes = array();
$attributes[ 'type' ] = 'text';
$attributes[ 'value' ] = $value;
$attributes[ 'tabindex' ] = 2;
$attributes = Pods_Form::merge_attributes( $attributes, $name, $form_field_type, $options );
?>
<?php if ( pods_v( $form_field_type . '_address_line_1', $options ) ): ?>
	<?php echo Pods_Form::label( $name . '[address][line_1]', 'Address Line 1' ) ?>
	<?php echo Pods_Form::field( $name . '[address][line_1]', pods_v( 'line_1', $value ), 'text', $options ) ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_line_2', $options ) ): ?>
	<?php echo Pods_Form::label( $name . '[address][line_2]', 'Address Line 2' ) ?>
	<?php echo Pods_Form::field( $name . '[address][line_2]', pods_v( 'line_2', $value ), 'text', $options ) ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_city', $options ) ): ?>
	<?php echo Pods_Form::label( $name . '[address][city]', 'City' ) ?>
	<?php echo Pods_Form::field( $name . '[address][city]', pods_v( 'city', $value ), 'text', $options ) ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_state', $options ) ): ?>
	<?php echo Pods_Form::label( $name . '[address][state]', 'State / Province' ) ?>
	<?php if ( 'pick' == pods_v( $form_field_type . '_address_state_input', $options ) ): ?>
		<?php echo Pods_Form::field( $name . '[address][state]', pods_v( 'state', $value ), 'pick', array( 'pick_object' => 'us_state' ) ) ?>
	<?php else: ?>
		<?php echo Pods_Form::field( $name . '[address][state]', pods_v( 'state', $value ), 'text', $options ) ?>
	<?php endif ?>
<?php endif; ?>

<?php if ( pods_v( $form_field_type . '_address_country', $options ) ): ?>
	<?php echo Pods_Form::label( $name . '[address][country]', 'Country' ) ?>

	<?php if ( 'pick' == pods_v( $form_field_type . '_address_country_input', $options ) ): ?>
		<?php echo Pods_Form::field( $name . '[address][country]', pods_v( 'country', $value ), 'pick', array( 'pick_object' => 'country' ) ) ?>
	<?php else: ?>
		<?php echo Pods_Form::field( $name . '[address][country]', pods_v( 'country', $value ), 'text', $options ) ?>
	<?php endif ?>
<?php endif; ?>

<?php
Pods_Form::regex( $form_field_type, $options );
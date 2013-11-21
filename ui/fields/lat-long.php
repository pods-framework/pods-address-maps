<?php
$attributes = array();
$attributes[ 'type' ] = 'text';
$attributes[ 'value' ] = $value;
$attributes[ 'tabindex' ] = 2;
$attributes = PodsForm::merge_attributes( $attributes, $name, PodsForm::$field_type, $options );
?>
<?php echo PodsForm::label( $name . '_lat', 'Latitude' ); ?>
<?php echo PodsForm::field( $name . '_lat', $value, 'text', $options ) ?>

<?php echo PodsForm::label( $name . '_lon', 'Longitude' ); ?>
<?php echo PodsForm::field( $name . '_lon', $value, 'text', $options ) ?>
<?php
PodsForm::regex( PodsForm::$field_type, $options );
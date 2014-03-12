<?php
$attributes = array();
$attributes[ 'type' ] = 'text';
$attributes[ 'value' ] = $value;
$attributes[ 'tabindex' ] = 2;
$attributes = Pods_Form::merge_attributes( $attributes, $name, Pods_Form::$field_type, $options );
?>
<?php echo Pods_Form::label( $name . '[lat]', 'Latitude' ); ?>
<?php echo Pods_Form::field( $name . '[lat]', pods_v( 'lat', $value ), 'number' ) ?>

<?php echo Pods_Form::label( $name . '[long]', 'Longitude' ); ?>
<?php echo Pods_Form::field( $name . '[long]', pods_v( 'long', $value ), 'number' ) ?>
<?php
Pods_Form::regex( Pods_Form::$field_type, $options );
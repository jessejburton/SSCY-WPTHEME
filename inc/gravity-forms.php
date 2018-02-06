<?php

/* GRAVITY FORMS ERROR LOGGING */

// Logging field validation errors
add_filter( 'gform_validation', 'log_validation_errors', 50 );
function log_validation_errors( $validation_result ) {
    $form = $validation_result['form'];
    foreach ( $form['fields'] as $field ) {
        if ( $field->failed_validation ) {
            GFCommon::log_error( "form #{$form['id']}: validate() - failed: {$field->label}({$field->id} - {$field->type}) - message: {$field->validation_message}" );
        }
    }
 
    return $validation_result;
}

// Logging saved values
add_filter( 'gform_save_field_value', 'log_saved_values', 50, 5 );
function log_saved_values( $value, $entry, $field, $form, $input_id ) {
 
    $input_name = 'input_' . str_replace( '.', '_', $input_id );
 
    GFCommon::log_debug( "log_save_field_value: Input ID: {$input_id}. POST value => " . print_r( rgpost( $input_name ), true ) );
    GFCommon::log_debug( 'log_save_field_value: Saved value => ' . print_r( $value, true ) );
 
    return $value;
}
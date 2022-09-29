<?php

function wrech_woocommerce_is_active(){
	return class_exists( 'woocommerce' );
}

function wrech_woocommerce_stripe_is_activate(){
	return in_array( 'woocommerce-gateway-stripe/woocommerce-gateway-stripe.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )));
}

/**
 * @param null $field
 *
 * @return array|mixed
 * All the config settings
 */
function wrech_settings($field = null){

	$default_settings = array(
		'cart_icon_url' => WRECH_PLUGIN_URL . '/assets/images/cart.png',
		'cart_icon_id' => -1,
		'excluded_pages' => ''
	);

	$wrech_settings = get_option('wrech_settings', array());

	$settings = array_replace($default_settings, $wrech_settings);

	if($field !== null){
		return $settings[$field];
	}

	return $settings;
}

/**
 * @return array
 * All the mod theme settings
 */
function wrech_mod_settings(){
	$wrech_mod_settings = array(
		//Float Btn
		'wrech_float_btn_position' => get_theme_mod('wrech_float_btn_position','bottom_left'),
		'wrech_cart_modal_position' => get_theme_mod('wrech_cart_modal_position','modal_right'),
		'wrech_float_btn_bg' => get_theme_mod('wrech_float_btn_bg','#FFFFFF'),
		'wrech_float_bubble_bg' => get_theme_mod('wrech_float_bubble_bg','#000000'),
		//Cart Header
		'wrech_header_heading' => get_theme_mod('wrech_header_heading','YOUR CART'),
		'wrech_header_bg' => get_theme_mod('wrech_header_bg','#FFFFFF'),
		'wrech_header_heading_color' => get_theme_mod('wrech_header_heading_color','#000000'),
		'wrech_coupon_input_radius' => get_theme_mod('wrech_coupon_input_radius',0),
		'wrech_coupon_button_radius' => get_theme_mod('wrech_coupon_button_radius',0),
		'wrech_cart_header_close_icon' => get_theme_mod('wrech_cart_header_close_icon','close_icon_1'),
		'wrech_header_close_icon_color' => get_theme_mod('wrech_header_close_icon_color','#000000'),
		//Cart Items
		'wrech_cart_item_close_icon_color' => get_theme_mod('wrech_cart_item_close_icon_color','#000000'),
		'wrech_cart_item_close_icon' => get_theme_mod('wrech_cart_item_close_icon','close_icon_1'),
		'wrech_cart_item_product_title_color' => get_theme_mod('wrech_cart_item_product_title_color','#000000'),
		'wrech_cart_item_product_font_size' => get_theme_mod('wrech_cart_item_product_font_size','14'),
		'wrech_cart_item_product_price_color' => get_theme_mod('wrech_cart_item_product_price_color','#000000'),

	);
	return $wrech_mod_settings;
}

function wrech_save_settings($settings){

	$wrech_settings = get_option('wrech_settings', array());

	$general_settings = array_replace($wrech_settings, $settings);

	return update_option('wrech_settings', $general_settings);
}

function wrech_save_field_settings($field,$value){

	$settings = get_option('wrech_settings', array());

	if(isset($settings[$field])){
		$settings[$field] = $value;
	}

}

function wrech_delete_field_settings($field){

	$settings = get_option('wrech_settings', array());

	if(isset($settings[$field])){
		unset($settings[$field]);
		update_option('wrech_settings', $settings);
	}

}

function wrech_upload_file( $file, $post_id = 0, $desc = null ) {
	if( empty( $file['name'] ) ) {
		return new \WP_Error( 'error', 'File is empty' );
	}

	// Get filename and store it into $file_array
	preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file['name'], $matches );

	// If error storing temporarily, return the error.
	if ( is_wp_error( $file['tmp_name'] ) ) {
		return new \WP_Error( 'error', 'Error while storing file temporarily' );
	}

	// Store and validate
	$id = media_handle_sideload( $file, $post_id, $desc );

	// Unlink if couldn't store permanently
	if ( is_wp_error( $id ) ) {
		unlink( $file['tmp_name'] );
		return new \WP_Error( 'error', "Couldn't store upload permanently" );
	}

	if ( empty( $id ) ) {
		return new \WP_Error( 'error', "Upload ID is empty" );
	}

	return $id;
}

/**
 * Return the checkout mandatory field
 */
function wrech_checkout_mandatory_fields($checkout){

    $fields = $checkout->get_checkout_fields();

    $mandatory_billing = array();
    foreach ($fields['billing'] as $key => $field){
        if(isset($field['required']) && $field['required']){
            array_push($mandatory_billing, array(
                'key' => $key,
                'type' =>  isset($field['type']) ? $field['type'] : ''
            ));
        }
    }

    $mandatory_shipping = array();
    foreach ($fields['shipping'] as $key => $field){
        if(isset($field['required']) && $field['required']){

            array_push($mandatory_shipping, array(
                'key' => $key,
                'type' =>  isset($field['type']) ? $field['type'] : ''
            ));

        }
    }

    $mandatory_order = [];
    foreach ($fields['order'] as $key => $field){
        if(isset($field['required']) && $field['required']){
            $mandatory_order[] = $key;

        }
    }

    return array(
        'billing' => $mandatory_billing,
        'shipping' => $mandatory_shipping,
        'order' => $mandatory_order
    );

}
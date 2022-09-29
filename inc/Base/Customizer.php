<?php

/*
*
* @package Yariko
*
*/

namespace Wrech\Inc\Base;

use Kirki;

class Customizer{

	public function register(){
		add_action( 'customize_register', array($this, 'kirki_sections'));

		add_filter( 'kirki/fields', array($this, 'kirki_fields'));
	}

	function kirki_sections($wp_customize ){
		/**
		 * Add panels
		 */
		$wp_customize->add_panel( 'wrech_mod_main', array(
			'priority'    => 10,
			'title'       => __( 'Easy Checkout', 'wrech_domain' ),
		) );

		/**
		 * Add sections
		 */

		$wp_customize->add_section( 'wrech_cart_modal', array(
			'title'       => __( 'Modal General', 'wrech_domain' ),
			'priority'    => 10,
			'panel'       => 'wrech_mod_main',
		) );

		$wp_customize->add_section( 'wrech_cart_modal_header', array(
			'title'       => __( 'Modal Header', 'wrech_domain' ),
			'priority'    => 10,
			'panel'       => 'wrech_mod_main',
		) );


		$wp_customize->add_section( 'wrech_cart_item_modal', array(
			'title'       => __( 'Cart Items', 'wrech_domain' ),
			'priority'    => 10,
			'panel'       => 'wrech_mod_main',
		) );

        $wp_customize->add_section( 'wrech_info_modal', array(
            'title'       => __( 'Billing/Shipping Fields', 'wrech_domain' ),
            'priority'    => 10,
            'panel'       => 'wrech_mod_main',
        ) );

		$wp_customize->add_section( 'wrech_cart_float', array(
			'title'       => __( 'Float Button', 'wrech_domain' ),
			'priority'    => 10,
			'panel'       => 'wrech_mod_main',
		) );

	}

	function kirki_fields($fields ){

		/* CART MODAL HEADER */
		$fields[] = array(
			'type' => 'text',
			'settings' => 'wrech_header_heading',
			'label'    => esc_html__( 'Text Control', 'wrech_domain' ),
			'section'  => 'wrech_cart_modal_header',
			'default'  => esc_html__( 'YOUR CART', 'wrech_domain' ),
		);

		$fields[] = array(
			'type' => 'color',
			'settings' => 'wrech_header_heading_color',
			'label'    => esc_html__( 'Cart Heading', 'wrech_domain' ),
			'description' => esc_html__( 'Set the header cart heading', 'wrech_domain' ),
			'section'  => 'wrech_cart_modal_header',
			'default'     => '#000000',
			'output'      => array(
				array(
					'element' => '.wrech-modal-cart-heading p',
					'property'=> 'color'
				)
			)
		);

		$fields[] = array(
			'type' => 'color',
			'settings'    => 'wrech_header_bg',
			'label'       => __( 'Cart Header Background', 'wrech_domain' ),
			'description' => esc_html__( 'Set the cart header background', 'wrech_domain' ),
			'section'     => 'wrech_cart_modal_header',
			'default'     => '#FFFFFF',
			'output'      => array(
				array(
					'element' => '.wrech-header-modal',
					'property'=> 'background'
				)
			)
		);

		$fields[] = array(
			'type' => 'slider',
			'settings'    => 'wrech_coupon_input_radius',
			'label'       => esc_html__( 'Coupon Text Border Radius', 'wrech_domain' ),
			'section'     => 'wrech_cart_modal_header',
			'default'     => 0,
			'choices'     => [
				'min'  => 0,
				'max'  => 20,
				'step' => 1,
			],
			'output'      => array(
				array(
					'element' => '#wrech-coupon_code',
					'property'=> 'border-radius',
					'units' => 'px'
				)
			)
		);

		$fields[] = array(
			'type' => 'slider',
			'settings'    => 'wrech_coupon_button_radius',
			'label'       => esc_html__( 'Coupon Button Border Radius', 'wrech_domain' ),
			'section'     => 'wrech_cart_modal_header',
			'default'     => 0,
			'choices'     => [
				'min'  => 0,
				'max'  => 20,
				'step' => 1,
			],
			'output'      => array(
				array(
					'element' => '#wrech-apply-coupon',
					'property'=> 'border-radius',
					'units' => 'px'
				)
			)
		);

		$fields[] = array(
			'type' => 'radio_image',
			'settings'    => 'wrech_cart_header_close_icon',
			'label'       => esc_html__( 'Cart header close icon', 'wrech_domain' ),
			'section'     => 'wrech_cart_modal_header',
			'default'     => 'close_icon_1',
			'choices'     => [
				'close_icon_1'   => WRECH_PLUGIN_URL . '/assets/images/close_icon_1.png',
				'close_icon_2' => WRECH_PLUGIN_URL . '/assets/images/close_icon_2.png',
				'close_icon_3'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_3.png',
				'close_icon_4'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_4.png',
				'close_icon_5'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_5.png',
				'close_icon_6'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_6.png',
			],
			'output'      => array(
				array(
					'element' => '.wrech-close-modal',
					'property'=> 'mask',
					'value_pattern' => 'url("'. WRECH_PLUGIN_URL . '/assets/images/$.png") no-repeat center / contain'
				),
				array(
					'element' => '.wrech-close-modal',
					'property'=> '-webkit-mask',
					'value_pattern' => 'url("'. WRECH_PLUGIN_URL . '/assets/images/$.png") no-repeat center / contain'
				)
			)
		);

		$fields[] = array(
			'type' => 'color',
			'settings'    => 'wrech_header_close_icon_color',
			'label'       => __( 'Cart Header Color Close Icon', 'wrech_domain' ),
			'description' => esc_html__( 'Set the cart header icon close color', 'wrech_domain' ),
			'section'     => 'wrech_cart_modal_header',
			'default'     => '#000000',
			'output'      => array(
				array(
					'element' => '.wrech-close-modal',
					'property'=> 'background-color'
				)
			)
		);

		/* CART FLOAT BTN  */
		$fields[] = array(
			'type' => 'color',
			'settings'    => 'wrech_float_btn_bg',
			'label'       => __( 'Cart Float Background', 'wrech_domain' ),
			'description' => esc_html__( 'Set the cart float button background.', 'wrech_domain' ),
			'section'     => 'wrech_cart_float',
			'default'     => '#FFFFFF',
			'output'      => array(
				array(
					'element' => '.wrech-float-btn',
					'property'=> 'background'
				)
			)
		);

		$fields[] = array(
			'type' => 'color',
			'settings'    => 'wrech_float_bubble_bg',
			'label'       => __( 'Cart Float Bubble Background', 'wrech_domain' ),
			'description' => esc_html__( 'Set the Cart Float Bubble Background.', 'wrech_domain' ),
			'section'     => 'wrech_cart_float',
			'default'     => '#000000',
			'output'      => array(
				array(
					'element' => '.wrech-cart-count',
					'property'=> 'background'
				)
			)
		);

		$fields[] = array(
			'type' => 'radio_image',
			'settings'    => 'wrech_float_btn_position',
			'label'       => esc_html__( 'Cart Float Button Position', 'wrech_domain' ),
			'section'     => 'wrech_cart_float',
			'default'     => 'bottom_left',
			'priority'    => 10,
			'choices'     => [
				'bottom_left'   => WRECH_PLUGIN_URL . '/assets/images/bottom_left.png',
				'bottom_right' => WRECH_PLUGIN_URL . '/assets/images/bottom_right.png',
				'up_right'  => WRECH_PLUGIN_URL . '/assets/images/up_right.png',
				'up_left'  => WRECH_PLUGIN_URL . '/assets/images/up_left.png'
			]
		);

		/* CART MODAL */
		$fields[] = array(
			'type' => 'radio_image',
			'settings'    => 'wrech_cart_modal_position',
			'label'       => esc_html__( 'Cart Modal Position', 'wrech_domain' ),
			'section'     => 'wrech_cart_modal',
				'default'     => 'modal_right',
			'priority'    => 10,
			'choices'     => [
				'modal_left' => WRECH_PLUGIN_URL . '/assets/images/modal_left.png',
				'modal_right'   => WRECH_PLUGIN_URL . '/assets/images/modal_right.png',
			]
		);

		//CART ITEMS
		$fields[] = array(
			'type' => 'radio_image',
			'settings'    => 'wrech_cart_item_close_icon',
			'label'       => esc_html__( 'Cart header close icon', 'wrech_domain' ),
			'section'     => 'wrech_cart_item_modal',
			'default'     => 'close_icon_3',
			'choices'     => [
				'close_icon_1'   => WRECH_PLUGIN_URL . '/assets/images/close_icon_1.png',
				'close_icon_2' => WRECH_PLUGIN_URL . '/assets/images/close_icon_2.png',
				'close_icon_3'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_3.png',
				'close_icon_4'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_4.png',
				'close_icon_5'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_5.png',
				'close_icon_6'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_6.png',
				'close_icon_7'  => WRECH_PLUGIN_URL . '/assets/images/close_icon_7.png',
			],
			'output'      => array(
				array(
					'element' => '.wrech_remove_item_img',
					'property'=> 'mask',
					'value_pattern' => 'url("'. WRECH_PLUGIN_URL . '/assets/images/$.png") no-repeat center / contain'
				),
				array(
					'element' => '.wrech_remove_item_img',
					'property'=> '-webkit-mask',
					'value_pattern' => 'url("'. WRECH_PLUGIN_URL . '/assets/images/$.png") no-repeat center / contain'
				)
			)
		);

		$fields[] = array(
			'type' => 'color',
			'settings'    => 'wrech_cart_item_close_icon_color',
			'label'       => __( 'Cart Header Color Close Icon', 'wrech_domain' ),
			'description' => esc_html__( 'Set the cart header icon close color', 'wrech_domain' ),
			'section'     => 'wrech_cart_item_modal',
			'default'     => '#000000',
			'output'      => array(
				array(
					'element' => '.wrech_remove_item_img',
					'property'=> 'background'
				)
			)
		);

		$fields[] = array(
			'type' => 'color',
			'settings'    => 'wrech_cart_item_product_title_color',
			'label'       => __( 'Product Title Color', 'wrech_domain' ),
			'description' => esc_html__( 'Set the product title color', 'wrech_domain' ),
			'section'     => 'wrech_cart_item_modal',
			'default'     => '#000000',
			'output'      => array(
				array(
					'element' => '.wrech-cart-item-name',
					'property'=> 'color'
				)
			)
		);

		$fields[] = array(
			'type' => 'slider',
			'settings'    => 'wrech_cart_item_product_font_size',
			'label'       => esc_html__( 'Product Title Font Size', 'wrech_domain' ),
			'section'     => 'wrech_cart_item_modal',
			'default'     => 14,
			'choices'     => [
				'min'  => 10,
				'max'  => 20,
				'step' => 1,
			],
			'output'      => array(
				array(
					'element' => '.wrech-cart-item-name',
					'property'=> 'font-size',
					'units' => 'px'
				)
			)
		);

		$fields[] = array(
			'type' => 'color',
			'settings'    => 'wrech_cart_item_product_price_color',
			'label'       => __( 'Product Price Color', 'wrech_domain' ),
			'description' => esc_html__( 'Set the product title color', 'wrech_domain' ),
			'section'     => 'wrech_cart_item_modal',
			'default'     => '#000000',
			'output'      => array(
                array(
                    'element' => '.wrech-cart-price, .wrech-cart-price .woocommerce-Price-amount.amount',
                    'property'=> 'color',
                    'value_pattern' => '$ !important'
                )
			)
		);

        $fields[] = array(
            'type' => 'slider',
            'settings'    => 'wrech_cart_item_product_price_font_size',
            'label'       => esc_html__( 'Product Price Font Size', 'wrech_domain' ),
            'section'     => 'wrech_cart_item_modal',
            'default'     => 16,
            'choices'     => [
                'min'  => 10,
                'max'  => 20,
                'step' => 1,
            ],
            'output'      => array(
                array(
                    'element' => '.wrech-cart-price .amount',
                    'property'=> 'font-size',
                    'value_pattern' => '$px !important'
                )
            )
        );

        $fields[] = array(
            'type' => 'color',
            'settings'    => 'wrech_cart_item_bg_color',
            'label'       => __( 'Cart Item Background Color', 'wrech_domain' ),
            'description' => esc_html__( 'Set the cart item background color', 'wrech_domain' ),
            'section'     => 'wrech_cart_item_modal',
            'default'     => '#F2F2F2',
            'output'      => array(
                array(
                    'element' => '.wrech_mini_cart_item',
                    'property'=> 'background'
                )
            )
        );


       //Info Section
        $fields[] = array(
			'type' => 'slider',
			'settings'    => 'wrech_info_modal_label_font',
			'label'       => __( 'Field Label Font Size', 'wrech_domain' ),
			'description' => esc_html__( 'Set field labels font size', 'wrech_domain' ),
			'section'     => 'wrech_info_modal',
            'default'     => 14,
            'choices'     => [
                'min'  => 10,
                'max'  => 20,
                'step' => 1,
            ],
			'output'      => array(
                array(
                    'element' => ".wrech-step-info label",
                    'property'=> 'font-size',
                    'value_pattern' => '$px !important',
                )
			)
		);

        $fields[] = array(
            'type' => 'color',
            'settings'    => 'wrech_info_modal_label_color',
            'label'       => __( 'Field Label Color', 'wrech_domain' ),
            'description' => esc_html__( 'Set the field labels color', 'wrech_domain' ),
            'section'     => 'wrech_info_modal',
            'default'     => '#000000',
            'output'      => array(
                array(
                    'element' => '.wrech-step-info label',
                    'property'=> 'color',
                    'value_pattern' => '$ !important'
                )
            )
        );

        $fields[] = array(
            'type' => 'slider',
            'settings'    => 'wrech_info_modal_field_font',
            'label'       => __( 'Field Font Size', 'wrech_domain' ),
            'description' => esc_html__( 'Set field font size', 'wrech_domain' ),
            'section'     => 'wrech_info_modal',
            'default'     => 14,
            'choices'     => [
                'min'  => 10,
                'max'  => 20,
                'step' => 1,
            ],
            'output'      => array(
                array(
                    'element' => ".wrech-step-info input[type='text'], .wrech-step-info input[type='phone'], .wrech-step-info input[type='number'],
                                   .wrech-step-info input[type='email'], .wrech-step-info .select2-selection--single, .wrech-step-info .select2-container,
                                   .wrech-step-info .input-text",
                    'property'=> 'font-size',
                    'value_pattern' => '$px !important',
                )
            )
        );

        /* Field color
         * $fields[] = array(
            'type' => 'color',
            'settings'    => 'wrech_info_modal_field_color',
            'label'       => __( 'Field Color', 'wrech_domain' ),
            'description' => esc_html__( 'Set the field color', 'wrech_domain' ),
            'section'     => 'wrech_info_modal',
            'default'     => '#000000',
            'output'      => array(
                array(
                    'element' => ".wrech-checkout input[type='text'], .wrech-checkout input[type='phone'], .wrech-checkout input[type='number'],
                                   .wrech-checkout input[type='email'], .wrech-checkout .select2-selection--single, .wrech-checkout .select2-container,
                                   .wrech-checkout .input-text",
                    'property'=> 'color',
                    'value_pattern' => '$ !important'
                )
            )
        );*/

        $fields[] = array(
            'type' => 'number',
            'settings'    => 'wrech_info_modal_field_height',
            'label'       => __( 'Field Height', 'wrech_domain' ),
            'description' => esc_html__( 'Set the field height', 'wrech_domain' ),
            'section'     => 'wrech_info_modal',
            'default'     => '39',
            'choices'  => [
                'min'  => 24,
                'max'  => 50,
                'step' => 1,
            ],
            'output'      => array(
                array(
                    'element' => ".wrech-step-info .select2-container--default .select2-selection--single .select2-selection__arrow, .wrech-checkout input[type='text'], .wrech-checkout input[type='phone'], .wrech-checkout input[type='number'],
                                   .wrech-checkout input[type='email'], .wrech-checkout .select2-selection--single, .wrech-checkout .select2-container,
                                   .wrech-checkout .input-text",
                    'property'=> 'height',
                    'value_pattern' => '$px !important'
                ),
               /* array(
                    'element' => ".wrech-checkout .select2-selection__arrow",
                    'property'=> 'line-height',
                    'value_pattern' => '$px !important'
                )*/
            )
        );


        /*
         * 'settings' => '',
		'label'    => esc_html__( 'Number Control', 'kirki' ),
		'section'  => 'section_id',
		'default'  => 42,
		'choices'  => [
			'min'  => -10,
			'max'  => 80,
			'step' => 1,
		],*/

		return $fields;
	}
}

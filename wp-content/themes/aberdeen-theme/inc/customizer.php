<?php
/**
 * Aberdeen Theme Customizer Settings
 * Provides full dynamic control under Appearance >> Customize
 *
 * @package Aberdeen_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aberdeen_customize_register( $wp_customize ) {

	// ==========================================
	// Panel: Aberdeen Theme Options
	// ==========================================
	$wp_customize->add_panel( 'aberdeen_options_panel', array(
		'title'       => __( 'Aberdeen Theme Options', 'aberdeen-theme' ),
		'description' => __( 'Customize Figma-designed sections: Hero, Careers, Programmes & Lead Form.', 'aberdeen-theme' ),
		'priority'    => 30,
	) );

	// ------------------------------------------
	// 1. Hero Banner Section
	// ------------------------------------------
	$wp_customize->add_section( 'aberdeen_hero_section', array(
		'title'    => __( 'Hero Banner', 'aberdeen-theme' ),
		'panel'    => 'aberdeen_options_panel',
		'priority' => 10,
	) );

	// Hero Headline
	$wp_customize->add_setting( 'aberdeen_hero_title', array(
		'default'           => 'Join the University of Aberdeen in India',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'aberdeen_hero_title', array(
		'label'    => __( 'Hero Headline', 'aberdeen-theme' ),
		'section'  => 'aberdeen_hero_section',
		'type'     => 'text',
	) );

	// Hero Subtitle
	$wp_customize->add_setting( 'aberdeen_hero_subtitle', array(
		'default'           => 'Discover world-class undergraduate and postgraduate programmes delivered with British academic excellence.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'aberdeen_hero_subtitle', array(
		'label'    => __( 'Hero Subtitle', 'aberdeen-theme' ),
		'section'  => 'aberdeen_hero_section',
		'type'     => 'textarea',
	) );

	// Hero Background Image
	$wp_customize->add_setting( 'aberdeen_hero_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'aberdeen_hero_image', array(
		'label'    => __( 'Hero Background Image', 'aberdeen-theme' ),
		'section'  => 'aberdeen_hero_section',
	) ) );

	// Hero CTA Text
	$wp_customize->add_setting( 'aberdeen_hero_cta_text', array(
		'default'           => 'Explore Programmes',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'aberdeen_hero_cta_text', array(
		'label'    => __( 'Hero CTA Button Text', 'aberdeen-theme' ),
		'section'  => 'aberdeen_hero_section',
		'type'     => 'text',
	) );

	// Hero CTA URL
	$wp_customize->add_setting( 'aberdeen_hero_cta_url', array(
		'default'           => '#our-programmes',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'aberdeen_hero_cta_url', array(
		'label'    => __( 'Hero CTA Button URL', 'aberdeen-theme' ),
		'section'  => 'aberdeen_hero_section',
		'type'     => 'url',
	) );

	// ------------------------------------------
	// 2. Careers and Employability Section
	// ------------------------------------------
	$wp_customize->add_section( 'aberdeen_careers_section', array(
		'title'    => __( 'Careers & Employability', 'aberdeen-theme' ),
		'panel'    => 'aberdeen_options_panel',
		'priority' => 20,
	) );

	// Title
	$wp_customize->add_setting( 'aberdeen_careers_title', array(
		'default'           => 'Careers and Employability',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'aberdeen_careers_title', array(
		'label'    => __( 'Section Title', 'aberdeen-theme' ),
		'section'  => 'aberdeen_careers_section',
		'type'     => 'text',
	) );

	// Description
	$wp_customize->add_setting( 'aberdeen_careers_text', array(
		'default'           => 'Our globally recognized degrees equip graduates with cutting-edge skills, professional accreditations, and strong industry linkages to thrive in international careers.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'aberdeen_careers_text', array(
		'label'    => __( 'Description Text', 'aberdeen-theme' ),
		'section'  => 'aberdeen_careers_section',
		'type'     => 'textarea',
	) );

	// Image
	$wp_customize->add_setting( 'aberdeen_careers_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'aberdeen_careers_image', array(
		'label'    => __( 'Careers Section Image', 'aberdeen-theme' ),
		'section'  => 'aberdeen_careers_section',
	) ) );

	// Button Text
	$wp_customize->add_setting( 'aberdeen_careers_btn_text', array(
		'default'           => 'Read More',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'aberdeen_careers_btn_text', array(
		'label'    => __( 'Button Text', 'aberdeen-theme' ),
		'section'  => 'aberdeen_careers_section',
		'type'     => 'text',
	) );

	// Button URL
	$wp_customize->add_setting( 'aberdeen_careers_btn_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'aberdeen_careers_btn_url', array(
		'label'    => __( 'Button URL', 'aberdeen-theme' ),
		'section'  => 'aberdeen_careers_section',
		'type'     => 'url',
	) );

	// ------------------------------------------
	// 3. Lead Form Popup & Contact
	// ------------------------------------------
	$wp_customize->add_section( 'aberdeen_lead_form_section', array(
		'title'    => __( 'Lead Form & Popup Modal', 'aberdeen-theme' ),
		'panel'    => 'aberdeen_options_panel',
		'priority' => 30,
	) );

	// Modal Title
	$wp_customize->add_setting( 'aberdeen_modal_title', array(
		'default'           => 'Register your Interest',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'aberdeen_modal_title', array(
		'label'    => __( 'Modal Title', 'aberdeen-theme' ),
		'section'  => 'aberdeen_lead_form_section',
		'type'     => 'text',
	) );

	// Header Enquire Button Label
	$wp_customize->add_setting( 'aberdeen_header_enquire_label', array(
		'default'           => 'Enquire Now',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'aberdeen_header_enquire_label', array(
		'label'    => __( 'Header Button Label', 'aberdeen-theme' ),
		'section'  => 'aberdeen_lead_form_section',
		'type'     => 'text',
	) );

	// Success Message
	$wp_customize->add_setting( 'aberdeen_thank_you_message', array(
		'default'           => 'Thank you for registering your interest! Our admissions team will review your application and contact you shortly.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'aberdeen_thank_you_message', array(
		'label'    => __( 'Thank You Alert Message', 'aberdeen-theme' ),
		'section'  => 'aberdeen_lead_form_section',
		'type'     => 'textarea',
	) );

	// ------------------------------------------
	// 4. Footer Settings
	// ------------------------------------------
	$wp_customize->add_section( 'aberdeen_footer_section', array(
		'title'    => __( 'Footer & Contact Info', 'aberdeen-theme' ),
		'panel'    => 'aberdeen_options_panel',
		'priority' => 40,
	) );

	// Address / Info
	$wp_customize->add_setting( 'aberdeen_footer_address', array(
		'default'           => 'University of Aberdeen, King\'s College, Aberdeen, AB24 3FX, Scotland',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'aberdeen_footer_address', array(
		'label'    => __( 'University Address', 'aberdeen-theme' ),
		'section'  => 'aberdeen_footer_section',
		'type'     => 'textarea',
	) );

	// Email
	$wp_customize->add_setting( 'aberdeen_footer_email', array(
		'default'           => 'admissions@abdn.ac.uk',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'aberdeen_footer_email', array(
		'label'    => __( 'Contact Email', 'aberdeen-theme' ),
		'section'  => 'aberdeen_footer_section',
		'type'     => 'email',
	) );

	// Copyright Text
	$wp_customize->add_setting( 'aberdeen_copyright_text', array(
		'default'           => '© 2026 University of Aberdeen. All Rights Reserved.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'aberdeen_copyright_text', array(
		'label'    => __( 'Copyright Text', 'aberdeen-theme' ),
		'section'  => 'aberdeen_footer_section',
		'type'     => 'text',
	) );
}
add_action( 'customize_register', 'aberdeen_customize_register' );

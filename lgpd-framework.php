<?php
/**
 * Plugin Name:       LGPD Framework
 * Plugin URI:        https://data443.com/products/lgpd-framework-wordpress-plugin/
 * Description:       Tools to help make your website LGPD-compliant. Fully documented, extendable and developer-friendly.
 * Requires at least: 4.7
 * Requires PHP:      5.6
 * Version:           2.0.2
 * Author:            Data443
 * Author URI:        https://www.data443.com/
 * Text Domain:       lgpd-framework
 * Domain Path:       /languages
 *
 * @package WordPress
 */ 

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LGPD_FRAMEWORK_VERSION', '2.0.2' );

define('LGPD_DEFAULT_UNKNOWN_USER_MESSAGE', 'Message received.');

add_shortcode( 'lgpd_privacy_safe', 'render_lgpd_privacy_safe' ); //preserve backward compatibility
add_shortcode( 'data443_privacy_safe', 'render_lgpd_privacy_safe' );

/** 
 * Render WHMCS Seal Generator Addon Javascript
 */
function render_lgpd_privacy_safe() {
	wp_register_script( 'lgpd_whmcs_seal_generator', lgpd( 'config' )->get( 'plugin.url' ) . '/assets/js/showseal.js', null, true, true );
	wp_localize_script(
		'lgpd_whmcs_seal_generator', 
		'lgpd_seal_var',
		array(
			'lgpd_imageparams'   => esc_attr( get_option( 'lgpd_privacy_safe_params' ) ),
			'lgpd_imagecode'     => esc_attr( get_option( 'lgpd_privacy_safe_imagecode' ) ),
			'lgpd_showimagefunc' => 'showimage_' . esc_attr( get_option( 'lgpd_privacy_safe_imagecode' ) ),
		)
	);
	wp_enqueue_script( 'lgpd_whmcs_seal_generator', basename( dirname( __FILE__ ) ) . '/assets/js/showseal.js', null, true, true );

	$seal_code = '<div class="data443-privacy-safe" style="font-size:12px;text-align: left;">';

	if( get_option( 'gdpr_privacy_safe_imagecode' ) !== '' && get_option( 'gdpr_privacy_safe_params' ) !== '' ){
		$seal_code .= '<a href="javascript:;" onclick="openpopup_' . esc_attr( get_option( 'gdpr_privacy_safe_imagecode' ) ) . '();">
		<img id="data443-privacy-safe-image" src="https://orders.data443.com/seal/seal.php?params=' . esc_attr( get_option( 'gdpr_privacy_safe_params' ) ) . '" alt="Data443 Privacy Safe" />
		</a>';
	}
	if( get_option( 'gdpr_privacy_safe_backlink' ) === '1' ){
		$seal_code .= '<span style="display:block;">Privacy Management Service by <a href="https://data443.com/products/global-privacy-manager/" target="_blank">Data443</a></span>';
	}
	$seal_code .= '</div>';
	// scale the size of the link text based on the loaded scaled image
	$seal_code .= "<script>jQuery('#data443-privacy-safe-image').load(function(){var px='12px';var w=jQuery(this).width();if(w>0&&w<=150){px='6px'}else if(w<300){px='10px'};jQuery('.data443-privacy-safe').css({'font-size': px});})</script>";
	return $seal_code;
}

add_action('init', 'lgpd_framework_load_textdomain');
/**
 * Render WHMCS Seal Generator Addon Javascript
 */
function lgpd_framework_load_textdomain() {
	load_plugin_textdomain( 'lgpd-framework', false, basename( dirname( __FILE__ ) ) . '/languages');
}
/**
 * Our custom post type function
 */
function create_donotsell_post_type() {
	$args = array(
		'label'               => 'Do Not Sell Info',
		'public'              => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_in_menu'        => false,
		'menu_position'       => 20,
		'show_ui'             => true,
		'hierarchical'        => false,
		'rewrite'             => array( 'slug' => 'donotsellrequests' ),
		'query_var'           => true,
		'supports'            => array( 'title', 'editor', 'excerpt', 'custom-fields', 'post-formats' ),
	);
	register_post_type( 'donotsellrequests', $args );
}

/**
 * Hooking up our function to theme setup
 */
add_action( 'init', 'create_donotsell_post_type' );

/**
 * Helper function for prettying up errors
 *
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$lgpd_error = function ( $message, $subtitle = '', $title = '' ) {
	$title   = $title ? '' : _x( 'WordPress LGPD &rsaquo; Error', '(Admin)', 'lgpd-framework' );
	$message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p>";
	wp_die( esc_attr( $message ), esc_attr( $title ) );
};

/**
 * Ensure compatible version of PHP is used
 */
if ( version_compare( phpversion(), '5.6.0', '<' ) ) {
	$lgpd_error(
		_x( 'You must be using PHP 5.6.0 or greater.', '(Admin)', 'lgpd-framework' ),
		_x( 'Invalid PHP version', '(Admin)', 'lgpd-framework' )
	);
}

include_once(dirname(__FILE__).'/autoload.php');

/**
 * Install the database table and custom role
 */
register_activation_hook(
	__FILE__,
	function () {
		$model = new \Data443\LGPD\Components\Consent\UserConsentModel();
		$model->createTable();
		$model->createUserTable();
		if ( apply_filters( 'lgpd/data-subject/anonymize/change_role', true ) && ! get_role( 'anonymous' ) ) {
			add_role(
				'anonymous',
				_x( 'Anonymous', '(Admin)', 'lgpd-framework' ),
				array()
			);
		}
		update_option( 'lgpd_enable_stylesheet', true );
		update_option( 'lgpd_enable', true );
	}
);

require_once 'lgpd-helper-functions.php';
require_once 'lgpd-init.php';

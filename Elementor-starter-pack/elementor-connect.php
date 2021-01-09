<?php
/**
 * Plugin Name: Elementor LWIH Plugin
 * Description: Custom Elementor Plugin.
 * Plugin URI:  https://imranhossain.dev/
 * Version:     1.0.0
 * Author:      Imran Hossain
 * Author URI:  https://imranhossain.dev/
 * Text Domain: elementor-LWIH-plugin
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Elementor_LWIH_Extension {
    
	const VERSION = '1.0.0';

	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;
	
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}
	
	public function __construct() {

		add_action( 'after_setup_theme', [ $this, 'init' ] );

	}

	public function i18n() {

		load_plugin_textdomain( 'elementor-LWIH-plugin' );

	}
	
	public function init() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

		add_action( 'elementor/elements/categories_registered',[$this, 'register_new_category']);

	}
	
	public function register_new_category($manager){
		$manager->add_category('testcategory',[
			'title'=>__('Elenemtor LWIH Widget','elementor-LWIH-plugin'),
			'icon'=>'fa fa-code',
		]);
	}
	
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-LWIH-plugin' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-LWIH-plugin' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-LWIH-plugin' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-plugin' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-LWIH-plugin' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-LWIH-plugin' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	
	public function init_widgets() {

		require_once( __DIR__ . '/widgets/test-widget.php' );

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \ElementorLWIHPlugin() );
			
	}

}

Elementor_LWIH_Extension::instance();

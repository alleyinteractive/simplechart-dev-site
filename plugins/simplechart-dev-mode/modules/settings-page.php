<?php
/**
 * FM submenu page with setting for overriding plugin js
 */
class Simplechart_Dev_Mode_Settings {
	private static $instance;

	private function __construct() {
		/* Don't do anything, needs to be initialized via instance() method */
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Simplechart_Dev_Mode_Settings;
			self::$instance->setup();
		}
		return self::$instance;
	}

	public function setup() {
		fm_register_submenu_page( 'simplechart_dev_mode', 'options-general.php', __( 'Simplechart Dev Mode', 'simplechart-dev-mode' ) );
		add_action( 'fm_submenu_simplechart_dev_mode', array( $this, 'options_init' ) );
		add_action( 'fm_element_markup_start', array( $this, 'prepend_static_content' ), 10, 2 );
	}

	public function options_init() {
		$fm = new Fieldmanager_Group( array(
			'name' => 'simplechart_dev_mode',
			'children' => array(
				'override_app' => new Fieldmanager_Checkbox( __( 'Apply JS overrides', 'simplechart-dev-mode' ) ),
			),
		) );
		$fm->activate_submenu_page();
	}

	public function prepend_static_content( $out, $field ) {
		if ( 'simplechart_dev_mode' === $field->name ) {
			require( SC_DEV_MODE_PATH . '/modules/settings-page-prepend.php' );
		}
		return $out;
	}
}

Simplechart_Dev_Mode_Settings::instance();

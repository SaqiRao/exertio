<?php
namespace ElementorExertioCustom;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {
	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Include Widgets files
	 *
	 */
	private function include_widgets_files() {
		if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
		{
			require_once( __DIR__ . '/widgets/hero-2-custom.php' );
			

		}
		
	}
	
	//Ad Shortcode Category
	public function add_elementor_widget_categories($category_manager)
	{
            $category_manager->add_category(
				'exertio',
				[
					'title' => __( 'Exertio Custom Widgets', 'exertio-custom-elementor' ),
					'icon' => 'fa fa-home',
				]
            );
    }
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();
		if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
		{
			// Register Widgets
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Two_Custom());
		}
	}

	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered',  [ $this, 'add_elementor_widget_categories' ]  );
	}
}
if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	Plugin::instance();
}
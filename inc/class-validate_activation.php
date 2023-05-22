<?php
/**
 * This class to check ACF PRO dependencies.
 * If ACF PRO is installed only then this plugin will be added.
 * 
 * @package book-showcase-block.
 */

namespace SS\BOOKSHOWCASE;

class Validate_Activation{
    const TARGET_PLUGIN = 'advanced-custom-fields-pro/acf.php';
    const TARGET_CLASS  = 'ACF';
    function __construct() {
        add_action( 'admin_init', array( $this, 'is_acf_pro_activated' ) );
        if ( ! self::acf_compatible_check() ) {
            return;
        }
    }

    /**
     * Function to check ACF PRO added or not if plugin installed other way.
     * 
    */
    public function is_acf_pro_activated(){
        if ( ! self::acf_compatible_check() ) {
            if ( is_plugin_active( SS_BOOK_SHOWCASE_DIR ) ) {
                deactivate_plugins( SS_BOOK_SHOWCASE_DIR );
                add_action( 'admin_notices', [ $this, 'plugin_disabled_notice' ] );
                if ( isset( $_GET['activate'] ) ) {
                    unset( $_GET['activate'] );
                }
                wp_die( __( 'This plugin needs "Advanced Custom Fields Pro" to Activate first. Please download and activate it', 'book-showcase-block' ) );
            }
        }
    }

    /**
     * Function to display admin notices.
     * 
    */
    public function plugin_disabled_notice() {
        echo '<strong>' . esc_html__( 'This plugin needs "Advanced Custom Fields Pro" to Activate first. Please download and activate it', 'book-showcase-block' ) . '</strong>';
    }

    /**
     * Function to procees for activation called with register_activation_hook.
     * 
    */
    static function activation_check() {
        if ( ! self::acf_compatible_check() ) {
            deactivate_plugins( SS_BOOK_SHOWCASE_DIR );
            wp_die( __( 'This plugin needs "Advanced Custom Fields Pro" to Activate first. Please download and activate it<br><a href='.admin_url('plugins.php').'>Go Back</a>', 'book-showcase-block' ) );
        }
    }

    /**
     * Function to check ACF compatibility.
     * 
    */
    static function acf_compatible_check() {
        $all_active_plugins = get_option('active_plugins');
        $class_exists = (class_exists(self::TARGET_CLASS));
        $class_exists = (in_array(self::TARGET_PLUGIN, $all_active_plugins, true));
        if(!($class_exists && $class_exists)){
            return false;
        }
        return true;
    }
}
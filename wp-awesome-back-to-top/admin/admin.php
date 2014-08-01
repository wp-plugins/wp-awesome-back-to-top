<?php
defined('ABSPATH') or exit;
require_once dirname( __FILE__ ) . '/class.settings-api.php';
/**
 * WordPress settings API class
 */
if ( !class_exists('AB2T_SETTINGS' ) ):
class AB2T_SETTINGS {

    private $settings_api;

    function __construct() {
        $this->settings_api = new AB2T_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        $ab2t_menu=__('AB2TOP Settings',AB2T_NAME);
        add_options_page( $ab2t_menu,$ab2t_menu, 'manage_options', 'ab2t-settings', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'ab2t_basics',
                'title' => __( 'General', AB2T_NAME )
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'ab2t_basics' => array(
                array(
                       'name' => 'disable_bootstrap',
                        'label' => __( 'Disable AB2T enqueue bootstrap? ', AB2T_NAME ),
                        'desc' => __( 'if the boostrap js library has be loaded by your current theme or other plugin,you should check this!',  AB2T_NAME),
                        'type' => 'checkbox'
                    ),
                array(
                    'name' => 'tip_text',
                    'label' => __( 'Back to top text', AB2T_NAME ),
                    'desc' => __( 'define you "Back to top" tip text', AB2T_NAME ),
                    'type' => 'text',
                    'default' => 'Top',
                    'sanitize_callback' => 'title'
                ),
                array(
                    'name' => 'height',
                    'label' => __( 'When to appear it?', AB2T_NAME ),
                    'desc' => __( 'define the distance between the position to display AB2T and the page header in px, .ex:600', AB2T_NAME ),
                    'type' => 'text',
                    'default' => '600',
                    'sanitize_callback' => 'title'
                ),
            ),

        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

$settings = new AB2T_SETTINGS();
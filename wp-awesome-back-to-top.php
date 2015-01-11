<?php
/*
Plugin Name: WP Awesome back to top
Plugin URI: http://suoling.net/wp-awesome-back-to-top
Description: An awesome back to top plugin for wordpress.
Author: suifengtec
Version: 1.1
Author URI: http://suoling.net
License: GPL V3
*/
defined('ABSPATH') or exit;

defined('AB2T_DOMAIN') or define('AB2T_DOMAIN','ab2t');
defined('AB2T_BASENAME') or define('AB2T_BASENAME',plugin_basename( __FILE__ ));
final class WP_AB2T {

    protected static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', AB2T_DOMAIN ), '1.0' );
    }

    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', AB2T_DOMAIN ), '1.0' );
    }

    public function __construct() {

        add_action('plugins_loaded', array($this,'i18n'));
        add_filter( 'plugin_action_links', array($this,'plugin_action_links' ), 10, 2);
        add_action('wp_enqueue_scripts',array($this,'enqueue'),11);
        add_action('wp_footer',array($this,'ab2t_output'));

        $this->settings();

    }

    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }

    public function settings(){
        if(is_admin()){
            $settings = $this->plugin_path().'/admin/admin.php';
            require_once($settings);
        }
    }
    public function i18n() {

         load_plugin_textdomain(AB2T_DOMAIN, false, dirname( AB2T_BASENAME ) . '/languages/');

    }


    public function plugin_action_links( $links, $file ) {

        $start_link = '<a href="' . admin_url( 'options-general.php?page=ab2t-settings' ) . '">' . __( 'Settings', AB2T_DOMAIN ) . '</a>';
        $add_on_links ='';
        if ( $file == AB2T_BASENAME )
             array_unshift( $links, $start_link ,$add_on_links);
        return $links;

    }


    public function enqueue(){

        $disable_bootstrap=$this->get( 'ab2t_basics', 'disable_bootstrap', false );

        wp_enqueue_style('coolwp-b2t-css',plugins_url('css/coolwp-b2t.css',__FILE__));
        if($disable_bootstrap=='off'){

            wp_enqueue_script('bootstrap',plugins_url('js/bootstrap',__FILE__),array('jquery'),false,true);

        }
        wp_enqueue_script('bootstrap-tooltip-js',plugins_url('js/bootstrap-tooltip.min.js',__FILE__),array('jquery'),false,true);

        wp_enqueue_script('coolwp-b2t-js',plugins_url('js/custom-b2t.js',__FILE__),array('jquery','bootstrap-tooltip-js'),false,true);

        $height=(int)$this->get( 'ab2t_basics', 'height', 800 );
        $data = array( 'height' => $height);
        wp_localize_script( 'coolwp-b2t-js', 'ab2t_str', $data );

    }

    public function ab2t_output(){

        $output=null;
        $b2t_tip_text=$this->get( 'ab2t_basics', 'tip_text', 'Top' );

        $output='<div id="back-to-top" title="" data-placement="top" data-original-title="'.$b2t_tip_text.'" style="display: block;">
                    <svg id="rocket" version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 64 64" data-original-title="" title="">
                    <path fill="#B6B6B6" d="M42.057,37.732c0,0,4.139-25.58-9.78-36.207c-0.307-0.233-0.573-0.322-0.802-0.329
                            c-0.227,0.002-0.493,0.083-0.796,0.311c-13.676,10.31-8.95,35.992-8.95,35.992c-10.18,8-7.703,9.151-1.894,23.262
                            c1.108,2.693,3.048,2.06,3.926,0.115c0.877-1.943,2.815-6.232,2.815-6.232l11.029,0.128c0,0,2.035,4.334,2.959,6.298
                            c0.922,1.965,2.877,2.644,3.924-0.024C49.974,47.064,52.423,45.969,42.057,37.732z M31.726,23.155
                            c-2.546-0.03-4.633-2.118-4.664-4.665c-0.029-2.547,2.012-4.587,4.559-4.558c2.546,0.029,4.634,2.117,4.663,4.664
                            C36.314,21.143,34.272,23.184,31.726,23.155z"></path>
                    </svg>
                </div>';
        echo $output;
    }

    public function get( $option, $section, $default = '' ) {

        $options = get_option( $option );

        if ( isset( $options[$section] ) ) {
            return $options[$section];
        }
        return $default;
    }

}/*//class*/

global $wpab2t;
$wpab2t = WP_AB2T::instance();

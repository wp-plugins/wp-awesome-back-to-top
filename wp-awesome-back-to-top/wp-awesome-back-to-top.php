<?php
/*
Plugin Name: WP Awesome back to top
Plugin URI: http://suoling.net/wp-awesome-back-to-top
Description: An awesome back to top plugin for wordpress.
Author: suifengtec
Version: 1.0
Author URI: http://suoling.net
*/
defined('ABSPATH') or exit;
defined('AB2T_NAME') or define('AB2T_NAME','ab2t');

/*
Add/Load translation
 */
add_action('plugins_loaded', 'ab2t_localization');
function ab2t_localization() {
    load_plugin_textdomain(AB2T_NAME, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/');
}

/*
Admin settings
 */
if(is_admin()){
require_once('admin/admin.php');
}
/*
 Get the value of a settings field
*/
function cwp_get_option( $option, $section, $default = '' ) {

    $options = get_option( $option );

    if ( isset( $options[$section] ) ) {
        return $options[$section];
    }
    return $default;
}

add_action('wp_enqueue_scripts','cwp_enqueue_b2t_js',999);
add_action('wp_footer','cwp_b2t');
function cwp_enqueue_b2t_js(){

$disable_bootstrap=cwp_get_option( 'ab2t_basics', 'disable_bootstrap', false );

    wp_enqueue_style('coolwp-b2t-css',plugins_url('css/coolwp-b2t.css',__FILE__));
    if($disable_bootstrap=='off'){
        wp_enqueue_script('bootstrap-tooltip-js',plugins_url('js/bootstrap-tooltip.min.js',__FILE__),array('jquery'),false,true);
    }
    wp_enqueue_script('coolwp-b2t-js',plugins_url('js/custom-b2t.js',__FILE__),array('jquery'),false,true);
    $height=(int)cwp_get_option( 'ab2t_basics', 'height', 800 );
$data = array( 'height' => $height);
        wp_localize_script( 'coolwp-b2t-js', 'ab2t_str', $data );

}

function cwp_b2t(){
    $output=null;
$b2t_tip_text=cwp_get_option( 'ab2t_basics', 'tip_text', 'Top' );
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
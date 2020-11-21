<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              keyvan.b6b.ir
 * @since             1.0.0
 * @package           Slider_widget
 *
 * @wordpress-plugin
 * Plugin Name:       Slider Widget
 * Plugin URI:        keyvan.b6b.ir
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            keyvan
 * Author URI:        keyvan.b6b.ir
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       slider_widget
 * Domain Path:       /languages
 */

require_once WP_PLUGIN_DIR . "/slider_widget/slider_widget_input.php";

class slider_widget_widget extends WP_Widget
{
    
    protected $slider_widget_is_woo;
    protected $inputs =[];


    public function __construct() 
    {
        
        $id = "slider_widget_id";
        $title = esc_html__("Slider Widget" , "slider_widget");
        $options = ["description" => esc_html__("A costumizable slider widget", "slider_widget")];
        
        parent::__construct($id, $title, $options);
        
        $this->main_scripts();
        
    }
    
    // Enqueue main scripts
    private function main_scripts() 
    {
        // Enqueue media library scripts
        wp_enqueue_media();
        // Enqueue LightSlider main script
        if(!wp_script_is("lightSlider")){
                wp_enqueue_script("lightSlider", WP_PLUGIN_URL . "/slider_widget/assets/lightslider.js", array("jquery"), "1", false);
        }
        
        // Enqueue LightSlider main sytlesheet
        if(!wp_style_is("lightSlider")){
            wp_enqueue_style("light_slider", WP_PLUGIN_URL . "/slider_widget/assets/lightslider.css", [] , 1 , "all");
        }
        
    }
    
    
    // Output main content
    public function widget($args , $instance) 
    {
        
        echo $args['before_widget'];
        
        if(isset($instance['tag_name'])){
            
            // Output content
            $this->widget_content($instance , $args);
            
            // Output footer script
            $this->add_footer_script($instance ,$args);
            
        }
        
        echo $args['after_widget'];
    }
    
    // Output main contet
    private function widget_content($instance , $args) 
    {   //todo
        if($instance["is_wooCommerce"] == "yes"){
            require_once(WP_PLUGIN_DIR . "/slider_widget/includes/the_tag_loop_woo.php");
        }elseif ($instance["is_wooCommerce"] == "no"){
            require_once(WP_PLUGIN_DIR . "/slider_widget/includes/the_tag_loop.php");
        }
        
    }
    
    
    // Add footer script
    private function add_footer_script($instance ,$args) 
    {
        add_action( 'wp_footer', function () use ($instance ,$args){
         require(WP_PLUGIN_DIR . "/slider_widget/includes/footer_script.php");
         
        }); 
        
        
        
    }
    
    // Save settings
    public function update($new_instance , $old_instance)
    {
        return slider_widget_input::save_inputs($new_instance);
    }
    
    
    // Output admin form
    public function form($instance) 
    {
        $this->inputs = slider_widget_input::get_default_inputs($this);
        echo '<p>';
        foreach ($this->inputs as $input){
            $input->display($instance);
        }
        // Script for controlling media library
        require WP_PLUGIN_DIR."/slider_widget/includes/admin_footer_script.php";
        
        echo '</p>';    
    }
    
}

function slider_widget_register () 
{
    register_widget("slider_widget_widget");
}

add_action ("widgets_init" , "slider_widget_register");




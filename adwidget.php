<?php
/*
Plugin Name: Wordpress Ad Widget
Plugin URI: https://github.com/broadstreetads/wordpress-ad-widget
Description: The easiest way to place ads in your Wordpress sidebar. Go to Settings -> Ad Widget
Version: 2.1.1
Author: Broadstreet Ads
Author URI: http://broadstreetads.com
*/

add_action('admin_init', array('AdWidget_Core', 'registerScripts'));
add_action('widgets_init', array('AdWidget_Core', 'registerWidgets'));
add_action('admin_menu', array('AdWidget_Core', 'registerAdmin'));

/**
 * This class is the core of Ad Widget
 */
class AdWidget_Core
{
    /**
     * The callback used to register the scripts
     */
    static function registerScripts()
    {
        # Include thickbox on widgets page
        if($GLOBALS['pagenow'] == 'widgets.php')
        {
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
            wp_enqueue_script('adwidget-main',  self::getBaseURL().'assets/widgets.js');
        }
    }
    
    /**
     * The callback used to register the widget
     */
    static function registerWidgets()
    {       
        register_widget('AdWidget_HTMLWidget');
        register_widget('AdWidget_ImageWidget');
    }
    
    /**
     * Get the base URL of the plugin installation
     * @return string the base URL
     */
    public static function getBaseURL()
    {   
        return (get_bloginfo('url') . '/wp-content/plugins/adwidget/');
    }
    
    /**
     * Register the admin settings page
     */
    static function registerAdmin()
    {
        add_options_page('Ad Widget', 'Ad Widget', 'edit_pages', 'adwidget.php', array(__CLASS__, 'adminMenuCallback'));
    }

    /**
     * The function used by WP to print the admin settings page
     */
    static function adminMenuCallback()
    {
        include dirname(__FILE__) . '/views/admin.php';
    }
}


/**
 * The HTML Widget
 */
class AdWidget_HTMLWidget extends WP_Widget
{
    /**
     * Set the widget options
     */
     function AdWidget_HTMLWidget()
     {
        $widget_ops = array('classname' => 'AdWidget_HTMLWidget', 'description' => 'Place an ad code like Google ads or other ad provider');
        $this->WP_Widget('AdWidget_HTMLWidget', 'Ad: HTML/Javascript Ad', $widget_ops);
     }

     /**
      * Display the widget on the sidebar
      * @param array $args
      * @param array $instance
      */
     function widget($args, $instance)
     {
         extract($args);

         echo $before_widget;
         
         $instance['w_adcode'];

         echo $after_widget;
     }

     /**
      * Update the widget info from the admin panel
      * @param array $new_instance
      * @param array $old_instance
      * @return array
      */
     function update($new_instance, $old_instance)
     {
        $instance = $old_instance;
        
        $instance['w_adcode']      = $new_instance['w_adcode'];

        return $instance;
     }

     /**
      * Display the widget update form
      * @param array $instance
      */
     function form($instance) 
     {

        $defaults = array('w_adcode' => '');
        $instance = wp_parse_args((array) $instance, $defaults);
       ?>
       <div class="widget-content">
       <p>Paste your Google ad tag, or any other ad tag in this widget below.</p>
       <p>
            <label for="<?php echo $this->get_field_id('w_adcode'); ?>">Ad Code</label>
            <textarea style="height: 100px;" class="widefat" id="<?php echo $this->get_field_id( 'w_adcode' ); ?>" name="<?php echo $this->get_field_name('w_adcode'); ?>"><?php echo $instance['w_adcode']; ?></textarea>
       </p>
        </div>
       <?php
     }
}
     
/**
 * This is an optional widget to display GitHub projects
 */
class AdWidget_ImageWidget extends WP_Widget
{
    /**
     * Set the widget options
     */
     function AdWidget_ImageWidget()
     {
        $widget_ops = array('classname' => 'AdWidget_ImageWidget', 'description' => 'Place an image ad with a link');
        $this->WP_Widget('AdWidget_ImageWidget', 'Ad: Image/Banner Ad', $widget_ops);
     }

     /**
      * Display the widget on the sidebar
      * @param array $args
      * @param array $instance
      */
     function widget($args, $instance)
     {
        extract($args);
         
        $link  = $instance['w_link'];
        $img   = $instance['w_img'];
        
        echo $before_widget;
            
        echo "<a target='_blank' href='$link' alt='Ad'><img style='width: 100%' src='$img' alt='Ad' /></a>";

        echo $after_widget;
     }

     /**
      * Update the widget info from the admin panel
      * @param array $new_instance
      * @param array $old_instance
      * @return array
      */
     function update($new_instance, $old_instance)
     {
        $instance = $old_instance;

        $instance['w_link'] = $new_instance['w_link'];
        $instance['w_img']  = $new_instance['w_img'];

        return $instance;
     }

     /**
      * Display the widget update form
      * @param array $instance
      */
     function form($instance) 
     {
        $link_id = $this->get_field_id('w_link');
        $img_id = $this->get_field_id('w_img');

        
        $defaults = array('w_link' => get_bloginfo('url'), 'w_img' => '');
        
		$instance = wp_parse_args((array) $instance, $defaults);
        
        $img = $instance['w_img'];
        $link = $instance['w_link'];
        
       ?>
        <div class="widget-content">
       <p style="text-align: center;" class="bs-proof">
           <?php if($instance['w_img']): ?>
                Your ad is ready.
                <br/><br/><strong>Scaled Visual:</strong><br/>
                <div class="bs-proof"><img style="width:100%;" src="<?php echo $instance['w_img'] ?>" alt="Ad" /></div>
           <?php else: ?>
                <a href="#" class="upload-button" rel="<?php echo $img_id ?>">Click here to upload a new image.</a> You can also paste in an image URL below.
           <?php endif; ?>
       </p>
       <input class="widefat tag" placeholder="Image URL" type="text" id="<?php echo $img_id; ?>" name="<?php echo $this->get_field_name('w_img'); ?>" value="<?php echo htmlentities($instance['w_img']); ?>" />
       <br/><br/> 
       <p>
            <label for="<?php echo $this->get_field_id('w_link'); ?>">Ad Click Destination:</label><br/>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('w_link'); ?>" name="<?php echo $this->get_field_name('w_link'); ?>" value="<?php echo $instance['w_link']; ?>" />
        </p>
        <p>
            When you're ready for a more powerful adserver, visit <a target="_blank" href="http://broadstreetads.com/ad-platform/adserving/">Broadstreet</a>.
        </p>
        </div>
       <?php
     }
}





<?php
/**
 * Disabled Direct Access
 */
defined( 'ABSPATH') or die ( 'No Permision in this Pages!');

if( !class_exists('FRP_PLugin')) {

  class FRP_PLugin {

    public function __construct() {

        $this->FRP_Initialize();
        $this->FRP_Hooks();
    }

    public function FRP_Initialize() {

        register_activation_hook(  plugin_basename( FRP_REALPATH . FRP_PLUGIN .'.php' ) , array( $this , 'FRP_Activate' ) );
        register_uninstall_hook(  plugin_basename( FRP_REALPATH . FRP_PLUGIN .'.php' ) , 'frp_uninstallation' );

        if( get_option( 'frp_images') == 1 || get_network_option(null, 'frp_images') == 1  ){
          add_filter('the_content',array($this,'Auto_Relative_Img'), 100);
          add_filter( 'content_save_pre', array($this,'Filter_Img'), 0);
        }

        if( get_option( 'frp_video') == 1 || get_network_option(null, 'frp_video') == 1 ){
          add_filter('the_content',array($this,'Auto_Relative_Video'), 100);
          add_filter( 'content_save_pre', array($this,'Filter_Video'), 0);
        }

        if( get_option( 'frp_audio') == 1  || get_network_option(null, 'frp_audio') == 1 ){
          add_filter('the_content',array($this,'Auto_Relative_Audio'), 100);
          add_filter( 'content_save_pre', array($this,'Filter_Audio'), 0);
        }

        if( get_option( 'frp_iframe') == 1 || get_network_option(null, 'frp_iframe') == 1 ){
          add_filter('the_content',array($this,'Auto_Relative_Iframe'), 100);
          add_filter( 'content_save_pre', array($this,'Filter_Iframe'), 0);
        }
    }

    public static function FRP_Activate() {

      /**
       * Initialize Generic Plugin Option
       */

       $deprecated = false;
       $autoload = null;

       if( is_multisite() ) {
         if( get_network_option(null, 'frp_images' ) == false ){ add_network_option(null, 'frp_images', 1, $deprecated, $autoload);}
         if( get_network_option(null, 'frp_video' ) == false ){ add_network_option(null, 'frp_video', 0, $deprecated, $autoload);}
         if( get_network_option(null, 'frp_audio' ) == false ){ add_network_option(null, 'frp_audio', 0, $deprecated, $autoload);}
         if( get_network_option(null, 'frp_iframe' ) == false ){ add_network_option(null, 'frp_iframe', 0, $deprecated, $autoload);}
       }

       if ( get_option( 'frp_images' ) === false ){ add_option('frp_images', 1, $deprecated, $autoload); }
       if ( get_option( 'frp_video' ) === false ){ add_option('frp_video', 0, $deprecated, $autoload); }
       if ( get_option( 'frp_iframe' ) === false ){ add_option('frp_iframe', 0, $deprecated, $autoload); }
       if ( get_option( 'frp_audio' ) === false ){ add_option('frp_audio', 0, $deprecated, $autoload); }

    }

    public function FRP_Hooks() {

        add_action('admin_menu', array($this,"FRP_Register_Menu"));
        add_action('admin_enqueue_scripts', array($this,"CSS_File"));

    }

    public static function FRP_Authorize() {

      /**
      * Check User Capability
      */
      if ( ! is_user_logged_in() ) {
          add_action( 'admin_menu', array($this,'RemoveMenu') );
          wp_die( ( 'You do not have sufficient permissions to access this page.' ) );
      }
      if ( !current_user_can( 'manage_options' ) ) {
          add_action( 'admin_menu', array($this,'RemoveMenu') );
          wp_die( ( 'You do not have sufficient permissions to access this page.' ) );
      }
      if ( ! is_admin() ) {
          add_action( 'admin_menu', array($this,'RemoveMenu') );
          wp_die( ( 'You do not have sufficient permissions to access this page. Please contact your administrator.' ) );
      }

    }

    // Register Plugin in Tools as Submenu
    public function FRP_Register_Menu() {
      self::FRP_Authorize();
      add_submenu_page(
          "tools.php",
          __("File Relative Path", FRP_PLUGIN),
          __("File Relative Path", FRP_PLUGIN),
          "manage_options",
          FRP_PLUGIN,
          array($this,"FRP_View")
      );

    }

    public function RemoveMenu() {
        /**
        * The Plugin Unregister Menu
        */
        remove_submenu_page( "tools.php", FRP_PLUGIN );
    }

    public static function FRP_View(){

          if(isset($_GET['view'])){
              switch($_GET['view']){
                  case "how-it-works":
                      require_once FRP_REALPATH . 'admin\inc\frp-how-it-works.php';
                  break;
                  case "supports":
                      require_once FRP_REALPATH . 'admin\inc\frp-support.php';
                  break;
                  default:
                      require_once FRP_REALPATH . 'admin/inc/frp-settings.php';
                  break;
              }
          }
          else{
              require_once FRP_REALPATH . 'admin/inc/frp-settings.php';
          }
    }

    public function Auto_Relative_Img($the_content) {

  		  $the_content= stripslashes($the_content);
  		  $updated_content= $the_content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<img[^>]+>/smi', $the_content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $single_image) {

  						 preg_match('%src="([^"]*)"%mi', $single_image, $output);

  						 $new_output=preg_replace(frp_server_request(),"", $output);

  						 $has_been_updated = str_replace($output, $new_output, $single_image);

  						 preg_match('%srcset="([^"]*)"%mi', $has_been_updated, $srcset_output);

  						 $new_srscet_output = preg_replace(frp_server_request(),"", $srcset_output);

  						 $last_updated = str_replace($srcset_output, $new_srscet_output, $has_been_updated);

  						 $updated_content = str_replace($single_image, $last_updated, $updated_content);
  					}
  			}
  			return $updated_content;
  	}

    public function Auto_Relative_Video($the_content) {

  		  $the_content= stripslashes($the_content);
  		  $updated_content= $the_content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<video[^>]+>/smi', $the_content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $single_image) {

  						 preg_match('%src="([^"]*)"%mi', $single_image, $output);

  						 $new_output=preg_replace(frp_server_request(),"", $output);

  						 $has_been_updated = str_replace($output, $new_output, $single_image);

  						 $updated_content = str_replace($single_image, $has_been_updated, $updated_content);
  					}
  			}
  			return $updated_content;
  	}

    public function Auto_Relative_Audio($the_content) {

  		  $the_content= stripslashes($the_content);
  		  $updated_content= $the_content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<audio[^>]+>/smi', $the_content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $single_image) {

  						 preg_match('%src="([^"]*)"%mi', $single_image, $output);

  						 $new_output=preg_replace(frp_server_request(),"", $output);

  						 $has_been_updated = str_replace($output, $new_output, $single_image);

  						 $updated_content = str_replace($single_image, $has_been_updated, $updated_content);
  					}
  			}
  			return $updated_content;
  	}

    public function Auto_Relative_Iframe($the_content) {

  		  $the_content= stripslashes($the_content);
  		  $updated_content= $the_content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<iframe[^>]+>/smi', $the_content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $single_image) {

  						 preg_match('%src="([^"]*)"%mi', $single_image, $output);

  						 $new_output=preg_replace(frp_server_request(),"", $output);

  						 $has_been_updated = str_replace($output, $new_output, $single_image);

  						 $updated_content = str_replace($single_image, $has_been_updated, $updated_content);
  					}
  			}
  			return $updated_content;
  	}

  	public function Filter_Img($content){

  		$content= stripslashes($content);
  		$updated_images = $content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<img[^>]+>/smi', $content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $images ) {

  							preg_match('%src="([^"]*)"%mi', $images, $output);

  							$new_output = preg_replace(frp_server_request(),"", $output);

  							$has_been_updated = str_replace($output, $new_output, $images);

  							$updated_images = str_replace($images, $has_been_updated, $updated_images);

  					}
  			}
  		return $updated_images;
  	}

    public function Filter_Video($content){

  		$content= stripslashes($content);
  		$updated_images = $content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<video[^>]+>/smi', $content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $images ) {

  							preg_match('%src="([^"]*)"%mi', $images, $output);

  							$new_output = preg_replace(frp_server_request(),"", $output);

  							$has_been_updated = str_replace($output, $new_output, $images);

  							$updated_images = str_replace($images, $has_been_updated, $updated_images);

  					}
  			}
  		return $updated_images;
  	}

    public function Filter_Audio($content){

  		$content= stripslashes($content);
  		$updated_images = $content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<audio[^>]+>/smi', $content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $images ) {

  							preg_match('%src="([^"]*)"%mi', $images, $output);

  							$new_output = preg_replace(frp_server_request(),"", $output);

  							$has_been_updated = str_replace($output, $new_output, $images);

  							$updated_images = str_replace($images, $has_been_updated, $updated_images);

  					}
  			}
  		return $updated_images;
  	}

    public function Filter_Iframe($content){

  		$content= stripslashes($content);
  		$updated_images = $content;

  			require_once ( FRP_REALPATH . 'function/server-host.php');

  			$count = preg_match_all('/<iframe[^>]+>/smi', $content, $all_images);

  			if($count > 0) {
  					foreach ($all_images[0] as $images ) {

  							preg_match('%src="([^"]*)"%mi', $images, $output);

  							$new_output = preg_replace(frp_server_request(),"", $output);

  							$has_been_updated = str_replace($output, $new_output, $images);

  							$updated_images = str_replace($images, $has_been_updated, $updated_images);

  					}
  			}
  		return $updated_images;
  	}

    public function CSS_File($hook_suffix) {

  		global $pagenow;
  		/**
  		 * This CSS function is loaded only in this Plugin Pages
  		 */
  		if($pagenow === 'tools.php' && ($hook_suffix === 'tools_page_'.FRP_PLUGIN)) {
  			 wp_enqueue_style('frp-style', FRP_CSS_JQUERY .'admin/css/frp-style.css');
  		}

  	}

  }

}

$FRP_PLugin = new FRP_PLugin();

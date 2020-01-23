<?php

/**
 * Disabled Direct Access
 */

defined( 'ABSPATH') or die ( 'No Permision in this Pages!');

class FRP_Settings {

  public function __construct() {

      self::FRP_Basic_Functions();

  }

  public function frp_form_handler(){

    FRP_PLugin::FRP_Authorize();

    if(! isset( $_POST['frp_plugin_action'] ) || ! wp_verify_nonce( $_POST['frp_plugin_action'], 'frp_plugin_nonce' )) {
      ?>
      <span class="error notice is-dismissible">
           <p>Sorry, your nonce was incorrect. Please try again.</p>
      </span>
      <?php
    }
    else {

      $frp_images =  (isset($_POST['frp_images']) ? intval($_POST['frp_images']) : 0);
      $frp_video =  (isset($_POST['frp_video']) ? intval($_POST['frp_video']) : 0);
      $frp_audio =  (isset($_POST['frp_audio']) ? intval($_POST['frp_audio']) : 0);
      $frp_iframe =  (isset($_POST['frp_iframe']) ? intval($_POST['frp_iframe']) : 0);

      if ( is_multisite() ) {

        update_network_option(null, 'frp_images', $frp_images );
        update_network_option(null, 'frp_video', $frp_video );
        update_network_option(null, 'frp_audio', $frp_audio );
        update_network_option(null, 'frp_iframe', $frp_iframe );

      }

      update_option('frp_images', $frp_images);
      update_option('frp_video', $frp_video);
      update_option('frp_audio', $frp_audio);
      update_option('frp_iframe', $frp_iframe);

    }

  }

  public function FRP_Basic_Functions() {

    require_once FRP_REALPATH . 'admin/inc/frp-header.php';

    $b_functions = '';

          $b_functions .= '<div class="frp-plugin-settings-title">Plugin Settings</div>';
          $b_functions .= '<nav class="frp-navigation">';
            $b_functions .= '<li><span>Settings</span></li>';
            $b_functions .= '<li><a href=" '.FRP_PLUGIN_PATH .'&view=how-it-works" >How It Works</a></li>';
          $b_functions .= '</nav>';

          $b_functions .= '<form method="POST">';
          $b_functions .=  wp_nonce_field( 'frp_plugin_nonce', 'frp_plugin_action' );

          /**
          * Check for post action
          */
          if (!empty( $_POST ) && isset( $_POST['frp_plugin_action'] ) ) {
              self::frp_form_handler();
          }

          $b_functions .= '<input type="hidden" name="frp_plugin_nonce" value=1 />';
          $b_functions .= '<div class="frp-list-functions">';
              $b_functions .= '<div class="frp-list-functions-title">Basic Functions</div>';
              $b_functions .= '<div class="frp-list-functions-content">';
                  $b_functions .= 'This plugin allow\'s to change the absolute source/path of the file into relative format. (<b>Images Example</b>)';
                  $b_functions .= '<div class="frp-function-sample-after">&lt;img src="<span style="color:rgb(0, 115, 170);text-decoration: underline;">https://www.yoursite.com/wp-content/uploads/2019/12/leandrokeenecmanalon.jpg</span>" alt="Leandro Keene C. Manalon" title="Leandro Keene C. Manalon" &gt;</div>';
                  $b_functions .= '<div class="frp-function-sample-before">&lt;img src="<span style="color:rgb(0, 115, 170);text-decoration: underline;">/wp-content/uploads/2019/12/leandrokeenecmanalon.jpg</span>" alt="Leandro Keene C. Manalon" title="Leandro Keene C. Manalon" &gt;</div>';
              $b_functions .= '</div>';
          $b_functions .= '</div>';

          $b_functions .= '<div class="frp-list-functions function-options">';
              $b_functions .= '<div class="frp-list-functions-title">Plugin Options</div>';
                $b_functions .= '<div class="function-guide">Filter By Tags: </div>';
                  $b_functions .= '<label><input type="checkbox"  name="frp_images" value=1 '.(is_multisite() ? (intval(get_network_option(null, 'frp_images')) ? 'checked' : ''): (intval(get_option('frp_images')) ? 'checked' : '')).' ><span>Image</span></label>';
                  $b_functions .= '<label><input type="checkbox"  name="frp_audio" value=1  '.(is_multisite() ? (intval(get_network_option(null, 'frp_audio')) ? 'checked' : ''): (intval(get_option('frp_audio')) ? 'checked' : '')).' ><span>Audio</span></label>';
                  $b_functions .= '<label><input type="checkbox"  name="frp_video" value=1 '.(is_multisite() ? (intval(get_network_option(null, 'frp_video')) ? 'checked' : ''): (intval(get_option('frp_video')) ? 'checked' : '')).' ><span>Video</span></label>';
                  $b_functions .= '<label><input type="checkbox"  name="frp_iframe" value=1 '.(is_multisite() ? (intval(get_network_option(null, 'frp_iframe')) ? 'checked' : ''): (intval(get_option('frp_iframe')) ? 'checked' : '')).' ><span>Iframe</span></label>';
          $b_functions .= '</div>';

          $b_functions .= '<div class="frp-submit-settings">';
              $b_functions .= '<input type="submit" value="Save Settings"/>';
          $b_functions .= '</div>';

        $b_functions .= '</form>';


    echo $b_functions;

  }

}
$FRP_Settings = new FRP_Settings();

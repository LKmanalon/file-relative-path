<?php

/**
 * Disabled Direct Access
 */

defined( 'ABSPATH') or die ( 'No Permision in this Pages!');

class FRP_Settings {

  public function __construct() {

      FRP_PLugin::FRP_Authorize();
      $this->FRP_Basic_Functions();


  }

  public function FRP_Basic_Functions() {

    require_once FRP_REALPATH . 'admin/inc/frp-header.php';

    $b_functions = '';

        $b_functions .= '<div class="frp-plugin-settings-title">Plugin Settings</div>';
        $b_functions .= '<nav class="frp-navigation">';
          $b_functions .= '<li><a href=" '.FRP_PLUGIN_PATH .'&view=settings" >Settings</a></li>';
          $b_functions .= '<li><a href=" '.FRP_PLUGIN_PATH .'&view=how-it-works" >How It Works</a></li>';
          $b_functions .= '<li><span>Support</span></li>';
        $b_functions .= '</nav>';


    echo $b_functions;


  }

}
$FRP_Settings = new FRP_Settings();

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
          $b_functions .= '<li><span>How It Works</span></li>';
        $b_functions .= '</nav>';

        $b_functions .='<div class="frp-how-works">';
          $b_functions .= '<div class="frp-list-functions-title">Plugin Functions</div>';
            $b_functions .= '<div class="frp-how-works-content">';
                $b_functions .= 'This is a simple wordpress plugin allows you to automatically update the data source of tags in the database into relative format, It supports <b>Images</b>, <b>Video</b>, <b>Audio</b> and <b>Iframe</b> tags. By using this plugin it helps you to get a better and fast rendering of data to make your site SEO Friendly. ';
                $b_functions .=  '<br>';
                $b_functions .=  '<br>';
                $b_functions .=  'The default functions of this plugin is to override all the images absolute url to relative url format, for the Audio, Video and Iframe you need to checked each tags to activate each functionalities.';
            $b_functions .='</div>';
            $b_functions .='<h3>Absolute Url Format:</h3>';
            $b_functions .= '<div class="frp-function-sample-after">&lt;img src="<span style="color:rgb(0, 115, 170);text-decoration: underline;">https://www.yoursite.com/wp-content/uploads/2019/12/leandrokeenecmanalon.jpg</span>" alt="Leandro Keene C. Manalon" title="Leandro Keene C. Manalon" &gt;</div>';
            $b_functions .='<h3>Relative Url Format:</h3>';
            $b_functions .= '<div class="frp-function-sample-before">&lt;img src="<span style="color:rgb(0, 115, 170);text-decoration: underline;">/wp-content/uploads/2019/12/leandrokeenecmanalon.jpg</span>" alt="Leandro Keene C. Manalon" title="Leandro Keene C. Manalon" &gt;</div>';

        $b_functions .='</div>';


    echo $b_functions;


  }

}
$FRP_Settings = new FRP_Settings();

<?php

/**
 * @package Images Relative Source
 * @version 1.0
 * 123
 */

/**
 * Disabled Direct Access
 */
defined( 'ABSPATH') or die ( 'No Permision in this Pages!');

function frp_server_request() {

$localhost_server = array(
  '127.0.0.1',
  '::1'
);

if(in_array($_SERVER['REMOTE_ADDR'], $localhost_server)){

  // ':'.$_SERVER['SERVER_PORT']
  $localhost_url = 'http://'.$_SERVER['SERVER_NAME'];
  $site_url = "%".$localhost_url."%";
}
else {
  $site_url = "%".site_url()."%";
}

return  $site_url;

}

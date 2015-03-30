<?php
/**
 * Class: Wordpress REST Client
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 * Version: 1.0
 * Updated: 15/03/2015
 */

namespace fizzy_pex_wp;

class wp_rest_client {

	protected $args;
	
	public function __construct($url) {
		$this->url = $url;
	}
	
    public function rest_post($content,$type) {
		$this->args = array('method' => 'POST','headers' => array('Content-Type' => 'application/json' ),'body' => $content);
		return $this->rest_exec();
	}

    private function rest_exec() {
	    $response = wp_remote_post($this->url, $this->args);
		$return['response'] = $response['body'];
		$return['status'] = $response['response']['code'];
		if($return['status'] != 200) {
			$return['error'] = 1;
		}
		return $return;
	}
	
}
?>

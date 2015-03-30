<?php
/**
 * Class: PEX API Client
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 * Version: 1.0
 * Updated: 15/03/2015
 */

namespace fizzy_pex_wp;

class pex_api {

	protected $url;
	
	public function __construct($url) {
    	$this->url = $url;
	}

	//Grabs all select options from API
	public function list_search_options($template) {
		$url = $this->url;
		$json = json_encode((object) null);
		$rest = new wp_rest_client($url);
		$response = $rest->rest_post($json,"json");
		$response = $this->rest_response($response);
		//Ok status response from API		
		if($response) {
			$tmpl = new templater(null,$template);
			$tmpl->response = $response;
			$results = json_decode($tmpl->publish(), true);
			return $results;
		}

	}
	
	//List avaliable units
	public function list_available_units($template) {
		$url = $this->url;
		$json = json_encode((object) null);
		$rest = new wp_rest_client($url);
		$response = $rest->rest_post($json,"json");
		$response = $this->rest_response($response);
		
		//Ok status response from API		
		if($response) {
			$tmpl = new templater(null,$template);
			$tmpl->response = $response;
			$results = json_decode($tmpl->publish(), true);
			return $results;
		}
		
	}	
	
	//Get unit details
	public function get_unit($template,$unit_ref) {

		$url = $this->url;
		$json = array('room' => $unit_ref);
		$json = json_encode($json, null);		
		$rest = new wp_rest_client($url);
		$response = $rest->rest_post($json,"json");
		$response = $this->rest_response($response);
		
		//Ok status response from API		
		if($response) {
			$tmpl = new templater(null,$template);
			$tmpl->response = $response;
			$results = json_decode($tmpl->publish(), true);
			return $results;
		}
		
	}

	//API specific response handler	
	private function rest_response($response) {

		if(!isset($response['error']) && $response['status'] == "200"){
			$json = json_decode($response['response']);
			if($json->status == "OK"){
				return $json;
			}
			else{
				echo "Error - API Status: ".$response['status']."<br>".$response['response'];
			}
		}
		else {
			echo "Error - Page Status: ".$response['status']."<br>".$response['response'];
		}
	}

	//strip out blank key / values from array - used for building JSON string
	private function array_tidy($a) {
		if(!empty($a)) {
			return array_filter($a);
		}
	}
	
	//To tidy up keys that are generated from PEX API e.g feature type keys.
	private function key_tidy($k) {
		return strtolower(str_replace(' ', '_', $k));
	}
	
	//Array sort by field - e.g unit_ref
	protected function array_sort($array,$params=null) {
		if(isset($params['sort'])) {
			$sort = $params['sort'];
			usort($array,function($a, $b) use ($sort) {
	
				if(is_numeric($a[$sort])){
					if ($a[$sort] == $b[$sort]) {
						return 0;
					}
					return ($a[$sort] < $b[$sort]) ? -1 : 1;
				}
				else {
					return strcmp($a[$sort],$b[$sort]);
				}
			
			});
			if(isset($params['order'])){
				$order = $params['order'];
				if($order == "desc"){
					krsort($array);
				}
			}
		}
		return $array;
	}
	
	//Filter results based on parameters
	protected function array_filtered($array,$params) {
		if(isset($params)){

			foreach($params as $p => $pp){

				if(!in_array($p,array('sort','order'))) {
								
					if(!is_array($pp)){$pp=array($pp);}	
					
					$f['field'] = $p;
					$f['values'] = $pp;

					if(!empty(array_filter($pp))){ //filter out blank values - .e.g select all
						$array = array_filter($array,function($a) use ($f)
							{
								return in_array($a[$f['field']],$f['values']);
							}
						);
					}
					
					unset($f);
				}
			
			}
		}
		return $array;
    }

		
}
?>
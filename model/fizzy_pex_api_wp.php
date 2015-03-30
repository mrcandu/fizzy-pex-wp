<?php
/**
 * Class: PEX API Client Search Form
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 * Version: 1.0
 * Updated: 15/03/2015
 */

namespace fizzy_pex_wp;

class pex_api_wp extends pex_api {
	
	public function list_search_options_wp($template,$cache) {
			
		if(get_transient('fizzy-pex-wp-list-search-options')){
			$return = get_transient('fizzy-pex-wp-list-search-options');
		}
		
		else {
			$return = $this->list_search_options($template);
			set_transient( 'fizzy-pex-wp-list-search-options', $return, $cache);
		}
		
		return $return;			
	}


	public function list_available_units_wp($template,$cache,$params=null) {
								
		if(get_transient('fizzy-pex-wp-list_available_units')){
			$return = get_transient('fizzy-pex-wp-list_available_units');
		}
		
		else {
			$return = $this->list_available_units($template);
			set_transient('fizzy-pex-wp-list_available_units', $return,$cache);
		}

		$return = $this->array_filtered($return,$params);
		$return = $this->array_sort($return,$params);
		return $return;
			
	}



	public function get_unit_wp($template,$cache,$unit_ref) {
			
		if(get_transient('fizzy-pex-wp-get-unit-'.$unit_ref)){
			$return = get_transient('fizzy-pex-wp-get-unit-'.$unit_ref);
		}
		
		else {
			$return = $this->get_unit($template,$unit_ref);
			set_transient('fizzy-pex-wp-get-unit-'.$unit_ref, $return, $cache);
		}
		
		return $return;
			
	}
			
	public function clear_cache() {
			
		delete_transient('fizzy-pex-wp-list-search-options');
			
	}
		
	
}
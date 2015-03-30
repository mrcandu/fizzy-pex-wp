<?php
/**
 * Class: Fizzy PEX WP Routing
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 * Version: 1.0
 * Updated: 15/03/2015
 */

namespace fizzy_pex_wp;

class routing {

	public function __construct() {
		add_filter('init', array($this, 'add_rewrite_variables'));
		add_filter('template_include', array($this, 'add_rewrite_template'), 1, 1);
	}
	
	//Create a rewrite rule for custom URL and variables on plugin activation
	public function add_rewrite_rules() {
		$general = get_option( 'fizzy_pex_wp_options_general' );
		add_rewrite_rule($general['slug'].'/([^/]+)/?', 'index.php?fizzy_pex_wp=1&property=$matches[1]', 'top');
		add_rewrite_rule($general['slug'].'/?', 'index.php?fizzy_pex_wp=1', 'top');
		flush_rewrite_rules();
	}

	//Remove rewrite rules on plugin deactivation
	public function remove_rewrite_rules() {
		flush_rewrite_rules();
	}
		
	public function add_rewrite_variables() {
		add_rewrite_tag('%property%', '([^&amp;]+)');
		add_rewrite_tag('%fizzy_pex_wp%', '(1)');
	}
	
	//Route to custom page template
	public function add_rewrite_template($template) {
		global $wp_query;
		$general = get_option( 'fizzy_pex_wp_options_general' );		
		$theme_dir = get_template_directory();
				
		if (isset($wp_query->query_vars['fizzy_pex_wp']) && !isset($wp_query->query_vars['property'])) {
			if(file_exists($theme_dir."/".$general['search_template'])) {
				return $theme_dir."/".$general['search_template'];
			}
			else {
				return plugin_dir_path( __FILE__ ).'../template/fizzy-pex-wp-search.php';
			}
		}
		elseif (isset($wp_query->query_vars['fizzy_pex_wp']) && isset($wp_query->query_vars['property'])) {
			if(file_exists($theme_dir."/".$general['search_template'])) {
				return $theme_dir."/".$general['property_template'];
			}
			else {
				return plugin_dir_path( __FILE__ ).'../template/fizzy-pex-wp-property.php';
			}
		}
		else {
			return $template; //else return default template
		}
	}

}

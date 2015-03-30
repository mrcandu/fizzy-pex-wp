<?php
/**
 * Plugin Name: Fizzy PEX WP
 * Plugin URI: http://mrcandu.com
 * Description: Integrate Fizzy PEX with Wordpress
 * Version:0.1
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 */

// Libraries
require( 'lib/wp_rest_client.php' );
require( 'lib/form_builder.php' );
require( 'lib/templater.php' );

// Models
require( 'model/fizzy_pex_api.php' );
require( 'model/fizzy_pex_api_wp.php' );
require( 'model/fizzy_pex_api_form.php' );
require( 'model/fizzy_pex_wp_routing.php' );
require( 'model/fizzy_pex_wp_admin.php' );
		
$fizzy_pex_wp_routing = new fizzy_pex_wp\routing();
register_activation_hook(plugin_basename(__FILE__), array($fizzy_pex_wp_routing, 'add_rewrite_rules') );
register_deactivation_hook(plugin_basename(__FILE__), array($fizzy_pex_wp_routing, 'remove_rewrite_rules') );

if( is_admin() )
new fizzy_pex_wp\admin();
	
//Public Methods

function fizzy_pex_wp_search() {
	$general = get_option( 'fizzy_pex_wp_options_general' );
	$search = get_option( 'fizzy_pex_wp_options_search' );
	$pex = new fizzy_pex_wp\pex_api_wp($search['url']);
	$search_options = $pex->list_search_options_wp($search['template'],$search['cache']);
	$form = new fizzy_pex_wp\pex_api_form($search['config']);
	return $form->form("properties",get_site_url()."/".$general['slug']."/",$search_options);
}

function fizzy_pex_wp_availability() {
	$availability = get_option( 'fizzy_pex_wp_options_availability' );
	$params = null;
	$pex = new fizzy_pex_wp\pex_api_wp($availability['url']);
	if(isset($_REQUEST['properties'])){$params = $_REQUEST['properties'];}
	else{
		$search_options = get_option( 'fizzy_pex_wp_options_search' );
		$form = new fizzy_pex_wp\pex_api_form($search_options['config']);
		$template = $form->search_template();
		$params['sort'] = $template['sort'];
		$params['order'] = $template['order'];
	}
	return $pex->list_available_units_wp($availability['template'],$availability['cache'],$params);
}

function fizzy_pex_wp_unit() {
	global $wp_query;
	$unit_ref = $wp_query->query_vars['property'];
	$properties = get_option( 'fizzy_pex_wp_options_properties' );
	$pex = new fizzy_pex_wp\pex_api_wp($properties['url']);
	return $pex->get_unit_wp($properties['template'],$properties['cache'],$unit_ref);
}
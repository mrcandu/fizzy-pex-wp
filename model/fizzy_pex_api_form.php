<?php
/**
 * Class: PEX API Client Search Form
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 * Version: 1.0
 * Updated: 15/03/2015
 */

namespace fizzy_pex_wp;

class pex_api_form {

	protected $template;
	
	public function __construct($template) {
		$this->template = $template;
	}
	
	public function form($name,$action=null,$options=null) {
		
		$this->form = new form_builder($name,$action,"post");
		
		//Get elements from search config
		$template = $this->search_template();
		
		//For each fields in config
		foreach($template['elements'] as $element => $attr){
			$this->form->form .= "<div>";
			$this->form->label($element,$attr['label']);
			$this->form->element($attr['type'],$element,$options[$attr['options']],$attr['placeholder']);
			$this->form->form .= "</div>";
		}
		
		//Add sort and order fields
		$this->form->element("hidden", "sort", $template['sort'], "Enter Sort field");
		$this->form->element("hidden", "order", $template['order'], "Enter order");
		
		$this->form->button("submit","Search");
		return $this->form->render();
	
	}
	
	//Get search config
	public function search_template() {
		$tmpl = new templater(null,$this->template);
		$template = json_decode($tmpl->publish(), true);
		return $template;
	}

}

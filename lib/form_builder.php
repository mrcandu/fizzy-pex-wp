<?php
/**
 * Class: Form Builder
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 * Version: 1.0
 * Updated: 15/03/2015
 */

namespace fizzy_pex_wp;

class form_builder {
	
	public $form; 
	private $form_open;
	private $form_close;
		
	public function __construct($name=null,$action=null,$method="post",$id=null){
		
		//If set, use the form name for REQUEST variable
		$this->name = $name;
		
		if(isset($_REQUEST[$this->name]) && isset($this->name)) {
			$this->request = $_REQUEST[$this->name];
		}
		elseif(isset($_REQUEST)){
			$this->request = $_REQUEST;
		}
		
		//Build form
    	$this->form_open = '<form'.
		$this->attr("name",$this->name).
		$this->attr("action",$action).
		$this->attr("method",$method).
		$this->attr("id",$id).
		'>';
		$this->form_close = '</form>';
		
	}

	//All Elements
	public function element($type, $name, $values=null, $placeholder=null, $id=null){
		
		if(in_array($type,array("checkbox","radio"))){
			$this->multi_input($type, $name, $values, $placeholder, $id);
		}
		elseif($type == "select"){
			$this->select($type, $name, $values, $placeholder, $id);
		}
		elseif($type == "textarea"){
			$this->textarea($type, $name, $values, $placeholder, $id);
		}
		else{
			$this->input($type, $name, $values, $placeholder, $id);
		}
		
	}

	//Button
	public function button($type, $text){
		
		$this->form .= '<input type="'.$type.'" value="'.$text.'">';
		
	}

	//label
	public function label($ele,$label){
		
		$this->form .= '<label for="'.$ele.'">'.$label.'</label>: ';
		
	}

	//Render Form
	public function render($render=false){
		$form = $this->form_open.
				$this->form.
				$this->form_close;
				
		if($render==true){
			echo $form;
		}
		else {
			return $form;
		}
	}
			
	//Checkbox && Radios
	private function multi_input($type, $name, $options, $placeholder=null, $id=null){
		$this->form .= "<ul>";
		if(!empty($options)){
			foreach($options as $k => $v) {
				$this->form .= "<li>";
				$this->label($this->element_name($type,$name,$k),$v);
				$this->input($type, $name, $k, $placeholder, $id."-".$k);
				$this->form .= "</li>";
			}
		}
		$this->form .= "</ul>";
	}
	
	//All inputs
	private function input($type, $name, $value=null, $placeholder=null, $id=null){
		
		//How to handled selected / posted values
		if(in_array($type,array("checkbox","radio"))) {
			$selected = $this->selected($type,$name,$value);
		}
		else {
			$value = $this->selected($type,$name,$value);
			$selected = "";
		}
		
		$this->form .= 
		'<input ' .
		$this->attr("type",$type) .
		$this->attr("name",$this->element_name($type,$name,$value)) .
		$this->attr("value",$value) .
		$this->attr("placeholder",$placeholder) .
		$this->attr("id",$id) .
		$selected .
		'>';
		
	}

	//Select Lists
	private function select($type,$name, $options, $placeholder=null, $id=null){
		$this->form .= '<select'.
		$this->attr("name",$this->element_name($type,$name)).
		$this->attr("id",$id) .
		'>';
		if(isset($placeholder)){
			$this->form .= '<option value="">'.$placeholder.'</option>';
		}
		if(!empty($options)){
			foreach($options as $k => $v) {
				$this->form .= '<option'.
				$this->attr("value",$k).
				$this->selected($type,$name,$k).
				'>'.
				$v.
				'</option>';
			}
		}
		$this->form .= "</select>";
	}

	//Text area
	private function textarea($type,$name, $value, $placeholder=null, $id=null){
		$this->form .= '<textarea'.
		$this->attr("name",$this->element_name($type,$name)).
		$this->attr("placeholder",$placeholder) .
		$this->attr("id",$id) .
		'>' .
		$this->selected($type,$name,$value). //value
		'</textarea>';
	}
		
	//Build element name - needed to handle form name & checkboxes / lists
	private function element_name($type,$name,$value=null){
		if(isset($this->name)) {
			$name = $this->name."[".$name."]";
		}
		if(in_array($type,array("checkbox"))) {
			$name = $name."[".$value."]";
		}
		return $name;
	}

	//Build attributes
	private function attr($a,$v){
		if(isset($v) and $v!="") {
			return ' ' . $a . '="' .$v. '"';
		}
	}
	
	// Check or selected options in Request
	private function selected($type,$name,$value){
		if(in_array($type,array("checkbox"))) {
			if(isset($this->request[$name][$value])) {
				return " checked";
			}
		}
		else if(in_array($type,array("radio","select"))) {
			if(isset($this->request[$name]) && $this->request[$name] == $value) {
				if($type=="select"){
					return " selected";
				}
				else{
					return " checked";
				}
			}
		}
		else {
			if(isset($this->request[$name])) {
				return $this->request[$name];
			}
			else{
				return $value;
			}
		}
	}
		
}

?>
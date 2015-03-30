<?php
/**
 * Class: Templater
 * Author: Matthew Cohen
 * Author URI: http://mrcandu.com
 * Version: 1.0
 * Updated: 15/03/2015
 */

namespace fizzy_pex_wp;

class templater
{
    public $template;
	
    function __construct($file = null, $var = null)
    {
        if (isset($file))
        {
            $this->load($file);
        }
		elseif (isset($var)) {
			$this->template = $var;
		}
    }
	
	public function load($template)
	{
		/*
		* This function loads the template file
		*/
		if (!is_file($template))
		{
			throw new FileNotFoundException("File not found: $template");
		} 
		elseif (!is_readable($template))
		{
			throw new IOException("Could not access file: $template");
		}
		else
		{
        	$this->template = $template;
		}
	}

	public function set($var, $content)
	{
		$this->$var = $content;
	}

	public function parse()
	{
    	/*
     	* Function that just returns the template file so it can be reused
     	*/
    	ob_start();
    	require $this->template;
    	$content = ob_get_clean();
    	return $content;
	}
	
	public function publish()
	{
		ob_start();
		eval('?>'.$this->template);
    	$content = ob_get_clean();
    	return $content;
	}

}
?>

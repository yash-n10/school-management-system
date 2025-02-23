<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DynamicLoad
 *
 * Enables the user to load only the needed Javascript and CSS files
 *
 * Usage:
 *
 * Load it within your Controllers:
 * $this->load->library("DynamicLoad");
 *
 * Configure CodeIgniter to Auto-Load it:
 *
 * Edit application/config/autoload.php
 * $autoload['libraries'] = array('DynamicLoad');
 *
 *
 * Use it in your view files
 * echo $this->dynamicload->loadFiles("header");
 * echo $this->dynamicload->loadFiles("footer");
 * echo $this->dynamicload->loadFiles("custom_tag");
 *
 */
class Dynamic_load {

	// Holds the formatted strings to output, grouped by section
	private $files = array();

	function __construct(){}

	/**
	 * addJS()
	 *
	 * Adds a Javascript file in the specified section
	 *
	 * @access public
	 * @param string       $section - The section where this file should be loaded. Default are "header" and "footer" but you can use any tag you want.
	 * @param string/array $params  - If a string is given then that string MUST be the link to the JS file. If an array is passed it will parse it's
	 *                                attributes key : value.
	 *
	 * @return void
	 */
	public function add_js($section = 'footer', $params)
	{
		if (!is_array($params))
		{
			$this->files[$section][] = $this->build_js(true, $params);
		}
		else
		{
			$this->files[$section][] = $this->build_jS(false, $params);
		}
	}

	/**
	 * addCSS()
	 *
	 * Adds a CSS file in the "header" section only
	 *
	 * @access public
	 * @param string/array $params - If a string is given then that string MUST be the link to the JS file. If an array is passed it will parse it's
	 *                                attributes key : value.
	 *
	 * @return void
	 */
    public function add_css($params)
    {
		if (!is_array($params))
		{
			$this->files['header'][] = $this->build_css(true, $params);
		}
		else
		{
			$this->files['header'][] = $this->build_css(false, $params);
		}
    }

	/**
	 * loadFiles()
	 *
	 * Returns a generated string from the files added in the specified section.
	 *
	 * @access public
	 * @param string $section - Either "header", "footer" or your custom tag
	 * @return string - The generated string
	 */
	public function load_files($section)
	{
		$output = "";
		for ($i = 0; $i<count($this->files[$section]); $i++)
		{
			$output .= $this->files[$section][$i] . "\n    ";
		}

		return $output;
	}

	/**
	 * clear()
	 *
	 * Clears the array :)
	 *
	 * @access public
	 */
	public function clear()
	{
		$this->files = array();
	}

	/**
	 *
	 * _buildJS()
	 *
	 * @access private
	 * @param bool $default         - Mode: true - outputs the simplest form, false - parses the params and outputs
	 * @param string/array $params  - If $default is true this should be a string, if $default is false this should be an associative array
	 * @return string
	 * @throws Exception
	 */
	private function build_js($default = true, $params)
	{
		if ($default)
		{
			if (is_array($params))
			{
				throw new Exception("Expected String, Array given.");
			}
			
			return '<script src="' . $params . '"></script>';
		}
		else
		{
			if (!is_array($params))
			{
				throw new Exception("Expected Array, String given.");
			}

			$str = "";

			foreach ($params as $key => $value)
			{
				$str .= $key . '="' . $value . '" ';
			}

			$str = trim($str);

			return '<script ' . $str . '></script>';
		}
    }

	/**
	 *
	 * _buildCSS()
	 *
	 * @access private
	 * @param bool $default         - Mode: true - outputs the simplest form, false - parses the params and outputs
	 * @param string/array $params  - If $default is true this should be a string, if $default is false this should be an associative array
	 * @return string
	 * @throws Exception
	 */
	private function build_css($default = true, $params)
	{
		if($default)
		{
			if(is_array($params))
			{
				throw new Exception('Expected String, Array given.');
			}

			return '<link rel="stylesheet" href="' . $params . '">';
		}
		else
		{
			if(!is_array($params))
			{
				throw new Exception('Expected Array, String given.');
            }

			$str = "";
			foreach($params as $key => $value)
			{
				$str .= $key . '="' . $value. '" ';
			}

			$str = trim($str);

			return '<link ' . $str . '>';
		}
	}

}

?>
<?php
/**
 * Object to Array
 *
 * Takes an object as input and converts the class variables to array key/vals
 * Uses the magic __FUNCTION__ callback method for multi arrays.
 *
 * $array = object_to_array($object);
 * print_r($array);
 * 
 * @param object - The $object to convert to an array
 * @return array
 */
if(!function_exists('object_to_array'))
{
	function object_to_array($object)
	{
		if (is_object($object))
		{
			// Gets the properties of the given object with get_object_vars function
			$object = get_object_vars($object);
		}

		return (is_array($object)) ? array_map(__FUNCTION__, $object) : $object;
	}
}

// --------------------------------------------------------------------

/**
 * Array to Object
 *
 * Takes an array as input and converts the class variables to an object
 * Uses the magic __FUNCTION__ callback method for multi objects.
 *
 * $object = array_to_object($array);
 * print_r($object);
 * 
 * @param array - The $array to convert to an object
 * @return object
 */
if(!function_exists('array_to_object'))
{
	function array_to_object($array)
	{
		$object = new stdClass;
		foreach($array as $key => $value)
		{
			if(is_array($value))
				$object->{$key} = array_to_object($value);
			else
				$object->{$key} = $value;
		}

		return $object;
	}
}

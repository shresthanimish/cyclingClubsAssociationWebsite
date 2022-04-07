<?php

namespace App\Helpers;

use DateTime;

/**
 * This class contains common utility functions used
 */
class Utilities
{

	/**
	 * Processes the specified data array, parsing the fields matching the specified array of date field(s) formatting as defined in the array
	 * @param array $dateFields
	 * @param array $data. Passed by reference
	 */
	public static function parseDateFields( $dateFields, &$data )
	{
		foreach ( $dateFields as $dateField => $format )
		{
			if ( isset($data[$dateField]) && !empty($data[$dateField]) )
			{
				$date = DateTime::createFromFormat(config('app.date_format'), $data[$dateField]);
				if ( $date !== false )
				{
					$value = $date->format($format);
					$data[$dateField] = $value;
				}
			}
		}
	}

	/**
	 * Fills a model with the specified data, first filtering the data
	 * @param $model object The Model to be filled
	 * @param $data array The data array to filter and use to fill
	 */
	public static function fillFromFilteredData(&$model, $data)
	{
		$parameterNames = array_keys($data);
		$attributeNames = $model->getFillable();
		if ( is_array($parameterNames) )
		{
			$attributeNames = array_flip(array_intersect($attributeNames, $parameterNames));
		}
		$input = array_intersect_key($data, $attributeNames);

		// If date fields have been defined, parse the date field set and format the data from request (likely in a JS format)
		if ( method_exists($model, 'getDateFields') )
		{
			// Get the date fields and parse the date fields in the input data
			$dateFields = $model->getDateFields();
			self::parseDateFields($dateFields, $input);
		}

		$model->fill($input);
	}

}


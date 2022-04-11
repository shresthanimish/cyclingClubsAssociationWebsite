<?php

namespace App\Models\Traits;

/**
 * This trait manages a Status attribute of a model which can be 'active' or 'not active'.
 *
 * The trait provides the public properties:
 * @var string $STATUS_ACTIVE
 * @var string $STATUS_INACTIVE
 *
 * The trait provides the public methods:
 *    getStatusOptions()
 *    getStatusText()
 */

trait StatusTrait
{
	/**
	 * Define the set of values for each status available to a status model
	 */
	public static $STATUS_ACTIVE = 'active';
	public static $STATUS_INACTIVE = 'inactive';

	/**
	 * Gets the names for the available status field enum options
	 * @return array Gets the names for the available status field enum options
	 */
	public static function getStatusOptions()
	{
		return array(
			self::$STATUS_ACTIVE => 'Active',
			self::$STATUS_INACTIVE => 'Not Active'
		);
	}

	/**
	 * Gets the name for the specified status enum value
	 * @param string $status The name for the status
	 * @return string
	 */
	public static function getStatusText( $status )
	{
		$statusOptions = self::getStatusOptions();
		return ( isset($statusOptions[$status]) ? $statusOptions[$status] : '' );
	}

	/**
	 * Gets the literal name for the status attribute value stored for a model using this trait
	 * @return string
	 */
	public function getStatus()
	{
		return self::getStatusText($this->status);
	}

}


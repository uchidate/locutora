<?php
class DBFunctions
{
	/**
	 * The left db wrapper
	 * @type String
	 */
	protected $strLeftWrapper;
	
	/**
	 * The right db wrapper	
	 * @type String
	 */	
	protected $strRightWrapper;

	
	function DBFunctions( $leftWrapper, $rightWrapper, $extraParams )
	{
		$this->strLeftWrapper = $leftWrapper;
		$this->strRightWrapper = $rightWrapper;
	}
}
?>
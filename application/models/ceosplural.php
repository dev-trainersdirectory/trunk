<?php
class CEosPlural extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public static function fetchObjects( $strClassName, $strSQL, $objDatabase ) {
		$arrobjResults = array();
		$arrmixResults = (array) $objDatabase->query($strSQL)->result_array();

		foreach( $arrmixResults as $key => $arrmixResult) {
			$objResult = new $strClassName();
			$objResult->assignData( $arrmixResult );
			$arrobjResults[] = $objResult;
		}

		return $arrobjResults;
	}

	public function fetchObject( $strClassName, $strSQL, $objDatabase ) {

		$arrobjResults = array();
		$arrmixResults = ( array ) $objDatabase->query($strSQL)->result_array();

		if( 0 == count( $arrmixResults ) ) return NULL;

		//if( 1 < count( $arrmixResults ) ) trigger_error( 'Expected single record, received multiple.' );

		$arrmixResult = reset( $arrmixResults );

		$objResult = new $strClassName();
		$objResult->assignData( $arrmixResult );

		return $objResult;
	}
}
?>
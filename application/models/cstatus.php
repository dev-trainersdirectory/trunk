<?php

class CStatus extends CEosSingular {
	
	public $intId;
	public $strName;
	
	function __construct() {
		parent::__construct();
	}

	public function assignData( $arrstrRequestData ) {

		if( false == is_array( $arrstrRequestData ) ) return false;

		if( true == array_key_exists( 'id', $arrstrRequestData ) )
			$this->setId( $arrstrRequestData['id'] );

		if( true == array_key_exists( 'name', $arrstrRequestData ) )
			$this->setName( $arrstrRequestData['name'] );
	}

	public function setId( $intId ) {
		$this->intId = $intId;
	}

	public function setName( $strName ) {
		$this->strName = $strName;
	}

	public function getId() {
		return $this->intId;
	}

	public function getName() {
		return $this->strName;
	}

	public function validate( $strAction ) {

		$boolResult = true;

		switch ( $strAction ) {
			
			default:
				return true;
				break;
		}

		return $boolResult;
	}

	public function insert() {

		if( true == is_null( $this->intId ) ) {
			$this->intId = $this->getNextId( 'sq_statuses', $this->db );
		}
		$arrStrInsertData = array(
								'id'	=> $this->intId,
								'name' 	=> $this->strName,
							);

		if( false == $this->db->insert( 'statuses', $arrStrInsertData ) ) return false;

		return true;
	}

	public function update() {

		$arrStrUpdateData = array();

		if( false == is_null( $this->strName ) ) $arrStrUpdateData['name'] = $this->strName;
		
		$this->db->where( 'id =', $this->intId );

		if( false == $this->db->update( 'statuses', $arrStrUpdateData ) ) return false;

		return true;
	}

	public function delete() {

		$this->db->where( 'id =', $this->intId );
 	
 		if( false == $this->db->delete( 'statuses' ) ) return false;

		return true;
	}
	
}

?>
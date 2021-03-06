<?php

class CEmailType extends CEosSingular {

	public $intId;
	public $strSubject;
	public $boolIsActive;
	
	function __construct() {
		parent::__construct();
	}

	public function assignData( $arrstrRequestData ) {

		if( false == is_array( $arrstrRequestData ) ) return false;

		if( true == array_key_exists( 'id', $arrstrRequestData ) )
			$this->setId( $arrstrRequestData['id'] );

		if( true == array_key_exists( 'subject', $arrstrRequestData ) )
			$this->setSubject( $arrstrRequestData['subject'] );
		
		if( true == array_key_exists( 'is_active', $arrstrRequestData ) )
			$this->setIsActive( $arrstrRequestData['is_active'] );

	}

	public function setId( $intId ) {
		$this->intId = $intId;
	}

	public function setSubject( $strSubject ) {
		$this->strSubject = $strSubject;
	}

	public function setIsActive( $boolIsActive ) {
		$this->boolIsActive = $boolIsActive;
	}

	public function getId() {
		return $this->intId;;
	}

	public function getSubject() {
		return $this->strSubject;
	}

	public function getIsActive() {
		return $this->boolIsActive;
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
			$this->intId = $this->getNextId( 'sq_email_types', $this->db );
		}
		
		$arrStrInsertData = array(
								'id'			=> $this->intId,
								'subject' 		=> $this->strName,
								'is_active' 	=> $this->boolIsActive,
							);

		if( false == $this->db->insert( 'email_types', $arrStrInsertData ) ) return false;

		return true;
	}

	public function update() {

		$arrStrUpdateData = array();

		if( false == is_null( $this->strSubject ) ) $arrStrUpdateData['subject'] 		= $this->strSubject;
		if( false == is_null( $this->boolIsActive ) ) $arrStrUpdateData['is_active'] = $this->boolIsActive;

		$this->db->where( 'id =', $this->intId );

		if( false == $this->db->update( 'email_types', $arrStrUpdateData ) ) return false;

		return true;
	}

	public function delete() {

		$this->db->where( 'id =', $this->intId );
 	
 		if( false == $this->db->delete( 'email_types' ) ) return false;

		return true;
	}
	
}

?>
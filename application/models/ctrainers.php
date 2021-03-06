<?php

/**
* 
*/
class CTrainers extends CEosPlural {
	
	function __construct() {
		parent::__construct();
	}

	public function fetchTrainers( $strSQL, $objDatabase ) {
		return self::fetchObjects( 'CTrainer', $strSQL, $objDatabase );
	}

	public function fetchTrainer( $strSQL, $objDatabase ) {
		return self::fetchObject( 'CTrainer', $strSQL, $objDatabase );
	}

	public static function fetchAllPublishedTrainers( $objDatabase ) {
		$strSQL = 'SELECT * FROM trainers';

		return self::fetchTrainers( $strSQL, $objDatabase );
	}

	public static function fetchTrainerById( $intTrainerId, $objDatabase ) {
		
		$strSQL = 'SELECT * FROM trainers WHERE id = ' . $intTrainerId;

		return self::fetchTrainer( $strSQL, $objDatabase );
	}

	public static function fetchAllActiveTrainersBySubjectIdByCityId( $intSubjectId, $intCityId, $objDatabase, $intUserId = 0 ) {
		
		$strSelect = ',FALSE AS show_details';
		$strJoin = '';
		if( 0 != (int) $intUserId  ) {
			$strSelect = ',CASE IF pl.id THEN true
								ELSE FALSE 
							END as show_details';
			$strJoin = 'LEFT JOIN purchased_leads pl ON ( pl.bought_user_id = t.user_id AND pl.user_id = ' . $intUserId . ' )';
		}
		$strSQL = ' SELECT
						t.*,
						l.first_name,
						l.last_name,
						l.profile_pic,
						GROUP_CONCAT(DISTINCT s.name) as skills ' . $strSelect . '
					FROM
						trainers t
						JOIN leads l ON ( t.lead_id = l.id )
						JOIN cities c ON ( l.city_id = c.id )
						JOIN trainer_skills ts ON ( ts.trainer_id = t.id )
						JOIN trainer_skills ts1 ON ( ts.trainer_id = t.id )
						JOIN tr_subjects s ON (ts1.tr_subject_id = s.id) ' . $strJoin . '
					WHERE
						ts.tr_subject_id = ' . $intSubjectId . '
						AND c.id = ' . $intCityId . '
					GROUP BY t.id';

		return self::fetchTrainers( $strSQL, $objDatabase );
	}

	public static function fetchAllTrainersDetails( $objDatabase ) {

		$strSQL = ' SELECT
						u.*,
						l.first_name,
						l.last_name
					FROM
						users u
						JOIN leads l ON ( l.user_id = u.id )';

		return self::fetchTrainers( $strSQL, $objDatabase );
	}

	public static function fetchTrainersByUserIds( $arrintUserIds, $objDatabase ) {
		if( false == valArr( $arrintUserIds ) ) return NULL;

		$strSQL = ' SELECT
						*
					FROM
						trainers
					WHERE
						user_id IN ( ' . implode( $arrintUserIds, ',' ) . ' )';
		
		return self::fetchTrainers( $strSQL, $objDatabase );
	}

	public static function fetchTrainerByUserId( $intUserId, $objDatabase ) {
		if( false == isset( $intUserId ) ) return NULL;

		$strSQL = ' SELECT
						*
					FROM
						trainers
					WHERE
						user_id = ' . ( int ) $intUserId;
		
		return self::fetchTrainer( $strSQL, $objDatabase );
	}

	public static function fetchTrainerDetailsByIds( $arrintIds, $objDatabase ) {
		
		$strSQL = ' SELECT
						t.id,
						l.first_name,
						l.last_name
					FROM
						trainers t
						JOIN leads l ON ( l.id = t.lead_id )
					WHERE
						t.id IN ( ' . implode( ',', $arrintIds ) .' )';
		
		return self::fetchTrainers( $strSQL, $objDatabase );
	}

	public static function fetchTrainerDetailById( $intId, $objDatabase ) {
		
		$strSQL = ' SELECT
						t.*,
						l.first_name,
						l.last_name,
						u.contact_number,
						u.email_id
					FROM
						trainers t
						JOIN leads l ON ( l.id = t.lead_id )
						JOIN users u ON ( u.id = t.user_id )
					WHERE
						t.id = '. (int) $intId;
		
		return self::fetchTrainer( $strSQL, $objDatabase );
	}

	public static function fetchAllActiveTrainersBySubjectIdByCityIdByLocationByTimeByPreference( $intSubjectId, $intCityId, $arrintLocationsIds, $arrintTimesIds, $arrintPreferencesIds, $objDatabase ) {

		$strJOIN = '';
		$strWhere = '';

		if( true == valArr( $arrintLocationsIds ) )
			$strJOIN .= 'JOIN trainer_locations tl ON ( t.id = tl.trainer_id AND tl.location_id IN ( '.implode( $arrintLocationsIds, ',' ).' ) ) ';

		if( true == valArr( $arrintPreferencesIds ) )
			$strJOIN .= 'JOIN trainer_prefereces tp ON ( t.id = tp.trainer_id AND tp.preference_id IN ( '.implode( $arrintPreferencesIds, ',' ).' ) ) ';

		if( true == valArr( $arrintTimesIds ) )
			$strJOIN .= 'JOIN trainer_timings tt ON ( t.id = tt.trainer_id AND tt.time_id IN ( '.implode( $arrintTimesIds, ',' ).' ) ) ';

		$strSQL = ' SELECT
						t.*,
						l.first_name,
						l.last_name
					FROM
						trainers t
						JOIN leads l ON ( t.lead_id = l.id )
						JOIN cities c ON ( l.city_id = c.id )
						JOIN trainer_skills ts ON ( ts.trainer_id = t.id )
						'. $strJOIN .'
					WHERE
						ts.tr_subject_id = ' . $intSubjectId . '
						AND c.id = ' . $intCityId;

		return self::fetchTrainers( $strSQL, $objDatabase );

	}
}

?>
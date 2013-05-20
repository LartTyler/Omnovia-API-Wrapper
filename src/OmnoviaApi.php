<?php
	interface OmnoviaApi {
		public function getCompanyId();
		public function getHashPassword();
		public function getBaseUrl();
		public function prepare($method);
		public function addParameter(/* Varargs */);
		public function execute();
	}

	/*

	$api->addParameter('eventInfo', array(
		'events' => array(
			'node' => 'registrant',
			'values' => array(
				array(
					'eventID' => $eventId,
					'registeredEventDate' => $eventDate . $eventTime
				),
				array(
					'eventId' => $otherId,
					'registeredEventDate' => $otherDate . $otherTime
				)
			)
		)
	));
	*/
?>


<?php
	interface OmnoviaApi {
		public function getCompanyId();
		public function getPassword();
		public function getBaseUrl();
		public function prepare($method);
		public function addParameter(/* Varargs */);
		public function execute();
	}

	/*
		Sample query code... delete on completion

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


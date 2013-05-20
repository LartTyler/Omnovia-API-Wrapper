<?php
	require_once('OmnoviaApi.php');

	abstract class OmnoviaApiImpl implements OmnoviaApi {
		private $companyId = '<COMPANY ID HERE>';
		private $password  = '<API PASSWORD HERE>';
		private $baseUrl   = 'http://www.omnovia.com/api/event/';

		public function getCompanyId() {
			return $this->companyId;
		}

		public function getHashPassword() {
			return md5($this->password);
		}

		public function getBaseUrl() {
			return $this->baseUrl;
		}
	}
?>
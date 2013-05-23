<?php
	require_once('OmnoviaApiImpl.php');

	class SimpleOmnoviaApi extends OmnoviaApiImpl {
		private $query = array();
		private $method = null;

		public function prepare($method) {
			$this->query = array(
				'companyID' => parent::getCompanyId(),
				'md5pass' => parent::getPassword()
			);
			$this->method = $method;

			return $this;
		}

		public function addParameter(/* Varargs */) {
			$args = func_get_args();

			switch (sizeof($args)) {
				case 1:
					if (is_array($args[0]))
						foreach ($args[0] as $k => $v)
							$this->query[$k] = $v;

				case 2:
					if (!is_string($args[0]) && !is_integer($args[0]))
						throw new Exception('Parameter 1 of addParameter must be a string or integer for this argument set');

					$this->query[$args[0]] = $args[1];

					break;

				default:
					if (!is_string($args[0]) || !is_integer($args[0]))
						throw new Exception('Parameter 1 of addParameter must be a string or an integer for this argument set');

					$key = array_shift($args);
					$this->query[$key] = $args;
			}

			return $this;
		}

		public function execute($dryRun = false) {
			if ($dryRun) {
				$queryTmp = $this->query;

				foreach ($queryTmp as $k => $v)
					if (is_array($v))
						$queryTmp[$k] = $this->generateXml($k, $v);

				return $queryTmp;
			}

			foreach ($this->query as $k => $v)
				if (is_array($v))
					$this->query[$k] = $this->generateXml($k, $v);

			$ch = curl_init(parent::getBaseUrl() . $this->method);

			curl_setopt_array($ch, array(
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => http_build_query($this->query),
				CURLOPT_HEADER => false,
				CURLOPT_RETURNTRANSFER => true
			));

			$res = curl_exec($ch);

			curl_close($ch);

			return json_decode(json_encode((array)simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA)), 1);
		}

		private function generateXml($node, $array) {
			$xml = "<$node>";

			if (isset($array['node'], $array['values'])) {
				$innerNode = $array['node'];

				foreach ($array['values'] as $value) {
					$xml .= "<$innerNode>";

					foreach ($value as $k => $v)
						if (is_array($v))
							$xml .= $this->generateXml($k, $v);
						else
							$xml .= "<$k>$v</$k>";

					$xml .= "</$innerNode>";
				}
			} else {
				foreach ($array as $k => $v)
					if (is_array($v))
						$xml .= $this->generateXml($k, $v);
					else
						$xml .= "<$k>$v</$k>";
			}

			$xml .= "</$node>";

			return $xml;
		}
	}
?>
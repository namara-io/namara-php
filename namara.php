<?php
	class Namara {
		public function __construct($api_key, $debug=false, $host='api.namara.io', $api_version='v0') {
			$this->api_key = $api_key;
			$this->debug = $debug;
			$this->host = $host;
			$this->api_version = $api_version;

			$this->headers = (Object) array('Content-Type' => 'application/json', 'X-API-Key' => $api_key);
		}

		public function get($dataset, $version, $options=null) {
			if ($this->debug) printf("REQUEST: %s", $this->get_path($dataset, $version, $options));

			$ch = curl_init($this->get_path($dataset, $version, $options));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = json_decode(trim(curl_exec($ch)));
			curl_close($ch);

			return $response;
		}


		public function get_path($dataset, $version, $options) {
			$encoded_options = $options != null ? http_build_query($options) : '';
			if (!$this->is_aggregation($options)) {
				return sprintf("%s?api_key=%s&%s", $this->get_base_path($dataset, $version), $this->api_key, $encoded_options);
			} else {
				return sprintf("%s/aggregation?api_key=%s&%s", $this->get_base_path($dataset, $version), $this->api_key, $encoded_options);
			}
		}

		public function get_base_path($dataset, $version) {
			return sprintf("http://%s/%s/data_sets/%s/data/%s", $this->host, $this->api_version, $dataset, $version);
		}

		private function is_aggregation($options) {
			return ($options != null && property_exists($this, 'operation'));
		}
	}
<?php
	require_once('namara.php');

	class NamaraTest extends PHPUnit_Framework_TestCase {

		public function setUp() {
			$this->subject = new Namara('myapikey');
			$this->dataset = '18b854e3-66bd-4a00-afba-8eabfc54f524';
			$this->version = 'en-2';
		}

		public function test_get_base_path() {
			$base_path = $this->subject->get_base_path($this->dataset, $this->version);
			$this->assertEquals($base_path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2');
		}

		public function test_get_path() {
			$path = $this->subject->get_path($this->dataset, $this->version, null);
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&');
		}

		public function test_get_path_limit() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('limit' => 1));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&limit=1');
		}

		public function test_get_path_offset() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('offset' => 1));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&offset=1');
		}

		public function test_get_path_select() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('select' => 'facility_code'));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&select=facility_code');
		}

		public function test_get_path_sum() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('sum' => 'facility_code'));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&sum=facility_code');
		}

		public function test_get_path_avg() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('avg' => 'facility_code'));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&avg=facility_code');
		}

		public function test_get_path_min() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('min' => 'facility_code'));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&min=facility_code');
		}

		public function test_get_path_max() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('max' => 'facility_code'));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&max=facility_code');
		}

		public function test_get_path_where() {
			$path = $this->subject->get_path($this->dataset, $this->version, (Object)array('where' => 'facility_code>1000'));
			$this->assertEquals($path, 'http://api.namara.io/v0/data_sets/18b854e3-66bd-4a00-afba-8eabfc54f524/data/en-2?api_key=myapikey&where=facility_code%3E1000');
		}

		public function test_get_count() {
	        $stub = $this->getMockBuilder('Namara')
				         ->disableOriginalConstructor()
	        			 ->getMock();

	        $stub->method('get')
	             ->willReturn((Object)array('result' => 129));

			$response = $stub->get($this->dataset, $this->version, (Object)array('operation' => 'count(*)'));
			$this->assertEquals($response->result, 129);
		}

		public function test_get_select() {
			$stub = $this->getMockBuilder('Namara')
						 ->disableOriginalConstructor()
						 ->getMock();

			$stub->method('get')
				 ->willReturn(array((Object)array('facility_code' => 1000)));

			$response = $stub->get($this->dataset, $this->version, (Object)array('select' => 'facility_code'));
			$this->assertEquals($response[0]->facility_code, 1000);
		}
	}
<?php
namespace App\Models;

class ResponseData {
	public $result = null;
	public $response = null;
	public function __construct($result, $response = array('code' => 0, 'message' => '')) {
		$this->result = $result;
		$this->response = $response;
	}
	
}
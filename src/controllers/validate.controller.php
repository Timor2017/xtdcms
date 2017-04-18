<?php
namespace App\Controllers;

class ValidateController extends BaseController {
	public function __invoke() {
	}

	public function definition()  {
		$this->app->post('/exists', 'App\Controllers\ValidateController:exists');
	}

	public function exists($request, $response, $args)  {
		$parsedBody=$request->getParsedBody();
		$folder= new \App\Models\Folders();
		$form_id = $this->retrieveArray($parsedBody, 'fid', '-1');
		$form_item_id = $this->retrieveArray($parsedBody, 'cid', '-1');

		
		$value = $this->retrieveArray($parsedBody, 'value', '');
		$search_keys = array();
		$search_keys[] = $value;
		$db_query = \App\Models\FormDataValues::where('status','=',STATUS_ACTIVE)->where('form_id','=',$form_id)->where('form_item_id','=',$form_item_id)->where(function ($query) use ($search_keys) {
			foreach ($search_keys as $key) {
				$query->orWhere('text_value','=',$key);	
			}
		});
		$values = $db_query->get();
		$total = $db_query->distinct()->count('form_data_id');
		$code = null;
		$message = null;
		if ($total == 0) {
			$code = '';
			$message = '';
		} else {
			$value = $values[0];
			$data_id = $value->form_data_id;
			$data_values = \App\Models\FormDataValues::where('status','=',STATUS_ACTIVE)->where('form_id','=',$form_id)->where('form_item_id','=',$form_item_id)->where('form_data_id','=',$data_id)->get();
			
		}
		return $this->toJSON($total > 0, $code, $message);
	}
	
}

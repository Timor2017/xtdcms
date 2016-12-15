<?php
namespace App\Controllers;

class SearchController extends BaseController {
	public function __invoke() {
	}

	public function search()  {
		//$this->app->get('[/k/{key:.*}][/p/{page}][/]', 'App\Controllers\SearchController:loadForm')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('[/]', 'App\Controllers\SearchController:searchData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function searchData($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		$search_key = $parsedBody['key'];
		//$search_key = $_GET['key'];
		$search_keys = explode(' ', $search_key);
		
		$forms = \App\Models\Forms::get();
		$allowed_form_list = [];
		foreach ($forms as $form) {
			if (has_form_permission($form->id, PERMISSION_READ)){
				$allowed_form_list[] = $form->id;
			}
		}
		
		$db_query = \App\Models\FormDataValues::whereIn('form_id',$allowed_form_list)->where(function ($query) use ($search_keys) {
			foreach ($search_keys as $key) {
				$query->orWhere('text_value','like','%'.$key.'%');	
			}
		});

		$values = $db_query->get();
		$r = [];
		foreach ($values as $value) {
			if (!isset($r[$value->data->id])) {
				$r[$value->data->id] = [];
				$form = $value->form;
				unset($form->created_date);
				unset($form->created_by);
				unset($form->last_modified_date);
				unset($form->last_modified_by);
				unset($form->concurrent_id);
				$r[$value->data->id]['form'] = $form;
			}
			
			$r[$value->data->id]['fields'][$value->item->display] = $value->text_value;
		}

		$result = null;
		$result = $r;
		
		//if (!empty($result)) {
			return $this->toJSON($result);
		//} else {
		//	return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		//}
	}
	
}

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
		$search_key = isset($parsedBody['key']) ? $parsedBody['key'] : '';
		if (!empty($search_key)) {
			$page = isset($parsedBody['page']) ? $parsedBody['page'] : 2;
			if (--$page < 0) $page = 0;
			$size = isset($parsedBody['size']) ? $parsedBody['size'] : 24;
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
			//full text
			//$db_query = \App\Models\FormDataValues::whereIn('form_id',$allowed_form_list)->whereRaw('match (text_value) against (? in boolean mode)', $search_keys);

			$values = $db_query->get();
			$total = $db_query->distinct()->count('form_data_id');
			$r = [];
			$rc = [];
			$count = 0;
			$offset = $page * $size;
			$search_range = $offset + $size;
			$columns = [];
			$forms = [];
			foreach ($values as $value) {
			//for ($count = $offset; $count < $search_range; $count++) {
			//	$value = $values[$count];
				if (!in_array($value->form_data_id, $rc)) {
					$rc[] = $value->form_data_id;
					$count++;
				}
				if ($count <= $offset) continue;
				if ($count > $search_range) break;
				
				if (!isset($r[$value->form_data_id])) {
					$r[$value->form_data_id] = [];
					if (!isset($forms[$value->form_id])) {
						$forms[$value->form_id]['id'] = $value->form->id;
						$forms[$value->form_id]['name'] = $value->form->name;
					}
					//$form = $value->form;
					unset($form->created_date);
					unset($form->created_by);
					unset($form->last_modified_date);
					unset($form->last_modified_by);
					unset($form->concurrent_id);
					$r[$value->form_data_id]['form'] = $forms[$value->form_id]; //$form;
				}
				if (!isset($columns[$value->form_item_id])) {
					$columns[$value->form_item_id] = $value->item->display;
				}
				$r[$value->form_data_id]['fields'][$columns[$value->form_item_id]] = $value->text_value;
			}

			$result = null;
			$result['data'] = $r;
			$result['total'] = $total; //count($rc);
			$result['current_page'] = $page + 1;
			$result['page_size'] = $size;
			
			//if (!empty($result)) {
				return $this->toJSON($result);
			//} else {
			//	return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
			//}
		}
		return $this->toJSON(false);
	}
	
}

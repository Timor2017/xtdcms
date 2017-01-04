<?php
namespace App\Controllers;

class SearchController extends BaseController {
	public function __invoke() {
	}

	public function search()  {
		$this->app->post('[/]', 'App\Controllers\SearchController:searchData')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function searchData($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		$search_key = isset($parsedBody['key']) ? $parsedBody['key'] : '';
		if (!empty($search_key)) {
			$page = isset($parsedBody['page']) ? $parsedBody['page'] : 1;
			if (--$page < 0) $page = 0;
			$size = isset($parsedBody['size']) ? $parsedBody['size'] : 24;
			$search_keys = explode(' ', $search_key);
			
			$forms = \App\Models\Forms::get();
			$allowed_form_list = [];
			foreach ($forms as $form) {
				if (has_form_permission($form->id, PERMISSION_READ)){
					$allowed_form_list[] = $form->id;
				}
			}
			
			$db_query = \App\Models\FormDataValues::where('status','=',STATUS_ACTIVE)->whereIn('form_id',$allowed_form_list)->where(function ($query) use ($search_keys) {
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
			$items = [];
			$forms = [];
			foreach ($values as $value) {
				if (!in_array($value->form_data_id, $rc)) {
					$rc[] = $value->form_data_id;
					$count++;
				}
				if ($count <= $offset) continue;
				if ($count > $search_range) break;
				$form_data_id = $value->form_data_id;
				$form_item_id = $value->form_item_id;
				if (!isset($r[$form_data_id])) {
					$r[$form_data_id] = [];
					if (!isset($forms[$value->form_id])) {
						$forms[$value->form_id]['id'] = $value->form_id;
						$forms[$value->form_id]['name'] = $value->form['name'];
					}
					unset($form->created_date);
					unset($form->created_by);
					unset($form->last_modified_date);
					unset($form->last_modified_by);
					unset($form->concurrent_id);
					$r[$form_data_id]['form'] = $forms[$value->form_id]; 
				}
				if (!isset($columns[$form_item_id])) {
					$columns[$form_item_id] = $value->item->display;
					$items[$form_item_id] = $value->item->is_show_in_list;
				}
				if (!isset($r[$form_data_id]['fields'][$columns[$form_item_id]])) {
					$r[$form_data_id]['fields'][$columns[$form_item_id]] = $value->text_value;
				}
				if (!empty($value->data)) {
					foreach ($value->data->values as $val) {
						$form_item_id = $val->form_item_id;	
						$form_data_id = $val->form_data_id;
						if (!isset($items[$form_item_id])) {
							$columns[$form_item_id] = $val->item->display;
							$items[$form_item_id] = $val->item->is_show_in_list;
						}
						if ($items[$form_item_id] > 0) {
							if (!isset($r[$form_data_id]['fields'][$columns[$form_item_id]])) {
								$r[$form_data_id]['fields'][$columns[$form_item_id]] = $val->text_value;
							}
						}
					}
				}
			}

			$result = null;
			$result['data'] = $r;
			$result['total'] = $total; 
			$result['current_page'] = $page + 1;
			$result['page_size'] = $size;
			$result['total_page'] = ceil($result['total'] / $result['page_size']);
			
			//if (!empty($result)) {
				return $this->toJSON($result);
			//} else {
			//	return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
			//}
		}
		return $this->toJSON(false);
	}
	
}

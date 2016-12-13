<?php
namespace App\Controllers;
class TranslateController extends BaseController{
	
	public function __invoke(){
		
	}
	public function definition(){

		$this->app->post('/manage[/]','App\Controllers\TranslateController:createStaticWords')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/manage/{id}','App\Controllers\TranslateController:updateWords')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->delete('/manage/{id}', 'App\Controllers\TranslateController:deleteGroup')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/manage/{id}', 'App\Controllers\TranslateController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('[/]', 'App\Controllers\TranslateController:getStaticWords')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function member() {
	}
	
	
	
	public function getStaticWords($request, $response, $args)  {
		$words = \App\Models\StaticContents::orderby('content')->get();
		if (!empty($words)) {
			return $this->toJSON($words);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	
	public function getGroups($id)  {
		$groups = \App\Models\Groups::where('parent_id','=',$id)->orderby('name')->get();
		
		foreach ($groups as $key => $group) {
			if (!has_group_permission($group->id, PERMISSION_READ)){
					unset($groups[$key]);
			} else {
				unset($group->created_date);
				unset($group->created_by);
				unset($group->last_modified_date);
				unset($group->last_modified_by);
				unset($group->concurrent_id);
				$group->children = $this->getGroups($group->id);
			}
		}
		return $groups;
	}	

	
	public function getProfile($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '';
		
		if (empty($id)) {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		} else {
			$group = \App\Models\Groups::find($id);
			foreach ($group->members as $member) {
				unset($member->password);
				unset($member->status);
				unset($member->login_ip);
				unset($member->login_time);
				unset($member->token);
				unset($member->created_date);
				unset($member->created_by);
				unset($member->last_modified_date);
				unset($member->last_modified_by);
				unset($member->concurrent_id);
			}
			foreach ($group->permissions as $permission) {
				unset($permission->created_date);
				unset($permission->created_by);
				unset($permission->last_modified_date);
				unset($permission->last_modified_by);
				unset($permission->concurrent_id);
			}
		}
		
		if (!empty($group)) {
			unset($group->created_date);
			unset($group->created_by);
			unset($group->last_modified_date);
			unset($group->last_modified_by);
			unset($group->concurrent_id);
			return $this->toJSON($group);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	public function createStaticWords($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		$static_wordings = isset($parsedBody['static_wordings']) ? $parsedBody['static_wordings'] : '';
		$static_wording_list = explode("\n", $static_wordings);
		
		if (count($static_wording_list) > 0) {
			$bulk_list = [];
			foreach ($static_wording_list as $static_word) {
				$model = \App\Models\StaticContents::where('content','=',$static_word)->get();
				if ($model->isEmpty()) {
					$model = new \App\Models\StaticContents();
					$model->content=$static_word;
					$model->save();
				}
			}
			//\App\Models\StaticContents::insert($bulk_list);
			return $this->toJSON(true);
		} else {
			return $this->toJSON(false, ERR_GROUP_NAME_EMPTY, ERR_GROUP_NAME_EMPTY);
		}
	}
	
	public function updateWords($request, $response, $args)  {
		$id = $args['id'];
		
		if (!empty($id)) {
			$parsedBody = $request->getParsedBody();
			$language = isset($parsedBody['language']) ? $parsedBody['language'] : '';
			$content = isset($parsedBody['content']) ? $parsedBody['content'] : '';
			
			if (!empty($content)) {
				$model = \App\Models\StaticContents::find($id);
				if (!empty($model)) {
					$glossary = $model->glossaries()->where('language',$language)->first();
					if (empty($glossary)) {
						$glossary = new \App\Models\Glossaries();
					}
					$glossary->language = $language;
					$glossary->content = $content;
					$glossary->status = STATUS_ACTIVE;
					
					$model->glossaries()->save($glossary);
					
					return $this->toJSON(true);
				} else {
					return $this->toJSON(false, ERR_GROUP_NOT_FOUND, ERR_GROUP_NOT_FOUND);
				}
			} else {
				return $this->toJSON(false, ERR_GROUP_NAME_EMPTY, ERR_GROUP_NAME_EMPTY);
			}
		} else {
			return $this->toJSON(false, ERR_GROUP_ID_EMPTY, ERR_GROUP_ID_EMPTY);
		}
	}
	
	public function deleteGroup($request, $response, $args)  {
		$id = $args['id'];
		
		if (!empty($id)) {
			$model = \App\Models\Groups::find($id);
			if (!empty($model)) {
				$model->status=STATUS_DELETED;
				$model->save();

				//删除子文件夹
				$this->delSubGroups($group->id);
				//同时也删除和文件夹相关联的
				$groupPermissions = \App\Models\GroupPermissions::where('group_id','=',$id)->get();
				if (!empty($groupPermissions)){
					foreach ($groupPermissions as $groupPermission) {
						$groupPermission->status=STATUS_DELETED;
						$groupPermission->save();
					}
				}

				$forms = \App\Models\Forms::where('group_id','=',$id)->get();
				$formC = new \App\Controllers\FormController();
				if ($forms->count()>=1){
					foreach ($forms as $form) {
						
						$formC->deleteForm($request, $response,['id'=>$form->id]);
					}
				}
					
				
				return $this->toJSON(true);
			} else {
				return $this->toJSON(false, ERR_GROUP_NOT_FOUND, ERR_GROUP_NOT_FOUND);
			}
		} else {
			return $this->toJSON(false, ERR_GROUP_ID_EMPTY, ERR_GROUP_ID_EMPTY);
		}
	}

	public function deleteSubGroups($parent_id){
		$groups = \App\Models\Groups::where('parent_id','=',$parent_id)->get();
		if ($groups->count()>=1){
			foreach ($groups as $group) {
				$group->status=STATUS_DELETED;
				$group->save();

				//$groupPermissions = \App\Models\GroupPermissions::where('group_id','=',$group->id)->get();
				//if (!empty($groupPermissions)){
				//	foreach ($groupPermissions as $groupPermission) {
				//		$groupPermission->status=STATUS_DELETED;
				//		$groupPermission->save();
				//	}
				//}
				
				$forms = \App\Models\Forms::where('group_id','=',$group->id)->get();
				$formC = new \App\Controllers\FormController();
				if ($forms->count()>=1){
					foreach ($forms as $form) {
						$formC->deleteForm($request, $response,['id'=>$form->id]);
					}
				}
					
				deleteSubGroups($group->id);
			}	
		}		
	}
	
	public function updatePermission($request, $response, $args) {
		$parsedBody = $request->getParsedBody();
		$id = isset($parsedBody['id']) ? $parsedBody['id'] : '';
		$member_id = isset($parsedBody['member_id']) ? $parsedBody['member_id'] : '';
		$permission = isset($parsedBody['permission']) ? $parsedBody['permission'] : '';
		
		if (!empty($id)) {
			$group = \App\Models\Groups::find($id);
			
			$groupPermission = $group->permissions()->where('owner_id','=',$member_id)->first();
			if (empty($groupPermission)) {
				$groupPermission = new \App\Models\Permissions();
				$groupPermission->owner_id = $member_id;
				$groupPermission->group_id = $id;
				$groupPermission->status = STATUS_ACTIVE;
			}
			
			$groupPermission->permission = $permission;
			
			$group->permissions()->save($groupPermission);
		}
		return true;
	}
}

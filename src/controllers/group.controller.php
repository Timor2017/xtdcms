<?php
namespace App\Controllers;
class GroupController extends BaseController{
	
	public function __invoke(){
		
	}
	public function definition(){
		$this->app->post('/permission/manage/users[/]', 'App\Controllers\GroupController:addMembers')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/permission/manage[/]', 'App\Controllers\GroupController:updatePermission')->add('\App\Middlewares\AuthenticateMiddleware::authUser');

		$this->app->post('/check[/]','App\Controllers\GroupController:checkGroup')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('/manage[/]','App\Controllers\GroupController:createGroup')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/manage/{id}','App\Controllers\GroupController:updateGroup')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->delete('/manage/{id}', 'App\Controllers\GroupController:deleteGroup')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/manage/{id}', 'App\Controllers\GroupController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/[{id}]', 'App\Controllers\GroupController:getAllGroups')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	public function member() {
	}
	
	
	
	public function getAllGroups($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '0';
		$groups = $this->getGroups($id);
		if (!empty($groups)) {
			return $this->toJSON($groups);
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
		return $groups->toArray();
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
	public function createGroup($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		$parent_id = isset($parsedBody['parent_id']) ? $parsedBody['parent_id'] : '0';
		$name = isset($parsedBody['name']) ? $parsedBody['name'] : '';
		
		if (!empty($name)) {
			$model = new \App\Models\Groups();
			$model->parent_id=$parent_id;
			$model->name=$name;
			$model->status=STATUS_ACTIVE;
			$model->save();
			
			
			unset($model->created_date);
			unset($model->created_by);
			unset($model->last_modified_date);
			unset($model->last_modified_by);
			unset($model->concurrent_id);
			return $this->toJSON($model);
		} else {
			return $this->toJSON(false, ERR_GROUP_NAME_EMPTY, ERR_GROUP_NAME_EMPTY);
		}
	}
	public function checkGroup($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		$parent_id = isset($parsedBody['parent_id']) ? $parsedBody['parent_id'] : '0';
		$name = isset($parsedBody['name']) ? $parsedBody['name'] : '';
		
		if (!empty($name)) {
			$model = \App\Models\Groups::where([['name','=',$name],['parent_id','=',$parent_id]])->get();
			
			return $this->toJSON($model->count() == 0);
		} else {
			return $this->toJSON(true);
		}
	}
	
	public function updateGroup($request, $response, $args)  {
		$id = $args['id'];
		
		if (!empty($id)) {
			$parsedBody = $request->getParsedBody();
			$parent_id = isset($parsedBody['parent_id']) ? $parsedBody['parent_id'] : '0';
			$name = isset($parsedBody['name']) ? $parsedBody['name'] : '';
			
			if (!empty($name)) {
				$model = \App\Models\Groups::find($id);
				if (!empty($model)) {
				
					$model->parent_id=$parent_id;
					$model->name=$name;
					$model->status=STATUS_ACTIVE;
					$model->save();
					
					
					unset($model->created_date);
					unset($model->created_by);
					unset($model->last_modified_date);
					unset($model->last_modified_by);
					unset($model->concurrent_id);
					return $this->toJSON($model);
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
	
	public function addMembers($request, $response, $args) {
		$parsedBody = $request->getParsedBody();
		$id = isset($parsedBody['id']) ? $parsedBody['id'] : '';
		$member_ids = isset($parsedBody['member_id']) ? $parsedBody['member_id'] : '';
		if (!empty($id)) {
			foreach ($member_ids as $member_id) {
				$groupMembers = \App\Models\GroupMembers::where([['group_id','=',$id],['member_id','=',$member_id]])->get();
				if ($groupMembers->count() == 0) {
					$groupMember = new \App\Models\GroupMembers();
					$groupMember->status = STATUS_ACTIVE;
					$groupMember->group_id = $id;
					$groupMember->member_id = $member_id;
					$groupMember->save();
				}
			}
			return $this->toJSON(true);
		} else {
			return $this->toJSON(false, ERR_GROUP_NOT_FOUND, ERR_GROUP_NOT_FOUND);
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
		return $this->toJSON(true);
	}
}

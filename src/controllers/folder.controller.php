<?php
namespace App\Controllers;
class FolderController extends BaseController{
	
	public function __invoke(){
		
	}
	public function definition(){
		$this->app->post('/manage[/]','App\Controllers\FolderController:createFolder')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/manage/{id}','App\Controllers\FolderController:updateFolder')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->delete('/manage/{id}', 'App\Controllers\FolderController:deleteFolder')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/manage/{id}', 'App\Controllers\FolderController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/[{id}]', 'App\Controllers\FolderController:getAllFolders')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/{id}/forms', 'App\Controllers\FolderController:getAllForms')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	//2147483649
	
	public function getAllFolders($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '0';
		$folders = $this->getFolders($id);
		if (!empty($folders)) {
			return $this->toJSON($folders);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	
	public function getAllForms($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '0';
		$result = $this->getForms($id);
		//if (!empty($result)) {
			return $this->toJSON($result);
		//} else {
		//	return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		//}
	}	
	
	public function getForms($id) {
		$forms = \App\Models\Forms::where([['folder_id','=',$id],['status','=',STATUS_ACTIVE]])->get();
		$result = [];
		if (!empty($forms)) {
			foreach ($forms as $key => $form) {
				$can_read = has_form_permission($form->id, PERMISSION_READ);
				$can_create = has_form_permission($form->id, PERMISSION_CREATE);
				if ($can_read || $can_create) {
				//if ($can_create) {
					$form->data_count = \App\Models\FormDatas::where('form_id','=',$form->id)->count();
					$form->can_read = $can_read;
					$form->can_create = $can_create;
					unset($form->created_date);
					unset($form->created_by);
					unset($form->last_modified_date);
					unset($form->last_modified_by);
					unset($form->concurrent_id);
					
					$result[] = $form;
				}
			}
		}
		
		return $result;
	}
	
	public function getFolders($id)  {
		$folders = \App\Models\Folders::where([['parent_id','=',$id],['status','=',STATUS_ACTIVE]])->orderby('is_featured', 'desc')->orderby('sequence')->get();
		$result = [];
		foreach ($folders as $key => $folder) {
			//echo $folder->name.':'.has_folder_permission($folder->id, PERMISSION_READ);
			if (!has_folder_permission($folder->id, PERMISSION_READ)){
					$child = $this->getFolders($folder->id);
					if (count($child) > 0) {
						$result = array_merge($result, $child);
					}
					unset($folders[$key]);
			} else {
				unset($folder->created_date);
				unset($folder->created_by);
				unset($folder->last_modified_date);
				unset($folder->last_modified_by);
				unset($folder->concurrent_id);
				$children = [];
				$children['folders'] = $this->getFolders($folder->id);
				$children['forms'] = $this->getForms($folder->id);
				
				$folder->children = $children;
				$result[] = $folder;
			}
		}
		return $result;
	}	

	
	public function getProfile($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '';
		
		if (empty($id)) {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		} else {
			$folder = \App\Models\Folders::find($id);
		}
		
		if (!empty($folder)) {
			unset($folder->created_date);
			unset($folder->created_by);
			unset($folder->last_modified_date);
			unset($folder->last_modified_by);
			unset($folder->concurrent_id);
			return $this->toJSON($folder);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	public function createFolder($request,$response,$args){
		$parsedBody=$request->getParsedBody();
		$folder= new \App\Models\Folders();
		$parent_id = $this->retrieveArray($parsedBody, 'parent_id', '0');
			
		$name = $this->retrieveArray($parsedBody, 'name'); 
		
		if (!empty($name)) {
			$folder->name =$name; 
			$folder->parent_id = $parent_id;
			$folder->color =$this->retrieveArray($parsedBody, 'color'); 
			$folder->icon =$this->retrieveArray($parsedBody, 'icon', 'folder'); 
			$folder->is_featured =$this->retrieveArray($parsedBody, 'is_featured', '0'); 
			$folder->sequence =$this->retrieveArray($parsedBody, 'sequence', '0');
			$folder->tags =$this->retrieveArray($parsedBody, 'tags'); 
			$folder->status = STATUS_ACTIVE;
			//$folder->CreateDate=now();
			
			$folder->save();
			
			unset($folder->created_date);
			unset($folder->created_by);
			unset($folder->last_modified_date);
			unset($folder->last_modified_by);
			unset($folder->concurrent_id);
			return $this->toJSON($folder);
		}
		else{
			return $this->toJSON(false, ERR_GROUP_NAME_EMPTY, ERR_GROUP_NAME_EMPTY);
		}
	}
	
	public function updateFolder($request, $response, $args)  {
		$id = $args['id'];
		
		if (!empty($id)) {
			$parsedBody = $request->getParsedBody();
			$parent_id = $this->retrieveArray($parsedBody, 'parent_id', '0');
			$name = $this->retrieveArray($parsedBody, 'name');
			
			if (!empty($name)) {
				$folder = \App\Models\Folders::find($id);
				if (!empty($folder)) {
				
					
					$folder->name =$this->retrieveArray($parsedBody, 'name'); 
					$folder->color =$this->retrieveArray($parsedBody, 'color'); 
					$folder->icon =$this->retrieveArray($parsedBody, 'icon'); 
					$folder->is_featured =$this->retrieveArray($parsedBody, 'is_featured'. '0'); 
					$folder->sequence =$this->retrieveArray($parsedBody, 'sequence', '0');
					$folder->tags =$this->retrieveArray($parsedBody, 'tags'); 
					$folder->status = STATUS_ACTIVE;
					$folder->save();
					
					
					unset($folder->created_date);
					unset($folder->created_by);
					unset($folder->last_modified_date);
					unset($folder->last_modified_by);
					unset($folder->concurrent_id);
					return $this->toJSON($folder);
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

	public function delSubFolders($parent_id){
		$folders = \App\Models\Folders::where('parent_id','=',$parent_id)->get();
		if ($folders->count()>=1){
			foreach ($folders as $folder) {
				$folder->status=STATUS_DELETED;
				$folder->save();
				delSubFolders($folder->id);
			}	
		}		
	}
	public function deleteFolder($request, $response, $args)  {
		$id = $args['id'];
		
		if (!empty($id)) {
			$folder = \App\Models\Folders::find($id);
			if (!empty($folder)) {
				$folder->status=STATUS_DELETED;
				$folder->save();
				
				//删除子文件夹
				$this->delSubFolders($folder->id);
				
				//同时也删除和文件夹相关联的
				$folderPermissions = \App\Models\FolderPermissions::where('folder_id','=',$id)->get();
				if (!empty($folderPermissions)){
					foreach ($folderPermissions as $folderPermission) {
						$folderPermission->status=STATUS_DELETED;
						$folderPermission->save();
					}
				}
						
				$forms = \App\Models\Forms::where('folder_id','=',$id)->get();
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
}

<?php
namespace App\Controllers;
class FolderController extends BaseController{
	
	public function __invoke(){
		
	}
	public function definition(){
		$this->app->post('/manage','App\Controllers\FolderController:createFolder')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->put('/manage/{id}','App\Controllers\FolderController:updateFolder')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->delete('/manage/{id}', 'App\Controllers\FolderController:deleteFolder')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/manage/{id}', 'App\Controllers\FolderController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->get('/[{id}]', 'App\Controllers\FolderController:getAllFolders')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
	}
	
	
	
	public function getAllFolders($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '0';
		$folders = $this->getFolders($id);
		if (!empty($folders)) {
			return $this->toJSON($folders);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	
	public function getFolders($id)  {
		$folders = \App\Models\Folders::where('parent_id','=',$id)->orderby('sequence')->get();
		
		foreach ($folders as $key => $folder) {
			if (!has_folder_permission($folder->id, PERMISSION_READ)){
					unset($folders[$key]);
			} else {
				unset($folder->created_date);
				unset($folder->created_by);
				unset($folder->last_modified_date);
				unset($folder->last_modified_by);
				unset($folder->concurrent_id);
				$folder->children = $this->getFolders($folder->id);
			}
		}
		return $folders;
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
		$parseBody=$request->getParsedBody();
		$folder=\App\Models\Folders();
		$parent_id = isset($parsedBody['parent_id']) ? $parsedBody['parent_id'] : '0';
			
		$name = isset($parsedBody['name']) ? $parsedBody['name'] : '';
		
		if (!empty($name)) {
			$folder->name =$this->retrieveValue($parsedBody['name']); 
			$folder->color =$this->retrieveValue($parsedBody['color']); 
			$folder->icon =$this->retrieveValue($parsedBody['icon']); 
			$folder->is_featured =$this->retrieveValue($parsedBody['is_featured']); 
			$folder->sequence =isset($parsedBody['sequence']) ? $parsedBody['sequence'] : '0';
			$folder->tags =$this->retrieveValue($parsedBody['tags']); 
			$folder->status = STATUS_ACTIVE;
			//$folder->CreateDate=now();
			
			$this->save();
			
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
			$parent_id = isset($parsedBody['parent_id']) ? $parsedBody['parent_id'] : '0';
			$name = isset($parsedBody['name']) ? $parsedBody['name'] : '';
			
			if (!empty($name)) {
				$folder = \App\Models\Folders::find($id);
				if (!empty($folder)) {
				
					
					$folder->name =$this->retrieveValue($parsedBody['name']); 
					$folder->color =$this->retrieveValue($parsedBody['color']); 
					$folder->icon =$this->retrieveValue($parsedBody['icon']); 
					$folder->is_featured =$this->retrieveValue($parsedBody['is_featured']); 
					$folder->sequence =isset($parsedBody['sequence']) ? $parsedBody['sequence'] : '0';
					$folder->tags =$this->retrieveValue($parsedBody['tags']); 
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

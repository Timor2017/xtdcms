<?php
namespace App\Controllers;

class MemberController extends BaseController {
	public function __invoke() {
	}

	public function me()  {
		$this->app->post('/login', 'App\Controllers\MemberController:login');
		$this->app->post('/logout', 'App\Controllers\MemberController:logout')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('/getLoginStatus', 'App\Controllers\MemberController:getLoginStatus');
		$this->app->get('/profile', 'App\Controllers\MemberController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('/profile', 'App\Controllers\MemberController:updateProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');

	}

	public function user()  {
		$this->app->get('/profile/{id}', 'App\Controllers\MemberController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
		$this->app->post('/profile/{id}', 'App\Controllers\MemberController:updateProfile')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
	}

	public function group()  {
		$this->app->post('[/]', 'App\Controllers\MemberController:createGroup')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
		$this->app->put('/{id}', 'App\Controllers\MemberController:updateGroup')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
		$this->app->delete('/{id}', 'App\Controllers\MemberController:deleteGroup')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
	}

	public function login($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		
		$username = isset($parsedBody['username']) ? $parsedBody['username'] : '';
		$password = isset($parsedBody['password']) ? md5($parsedBody['password']) : '';
		
		$members = \App\Models\Members::where([['username','=',$username],['password','=',$password]])->get();
		if ($members->count() == 1) {
			$member = $members[0];
			$member->token = $token = $this->container['auth.manager']->getCurrentToken($username);
			$member->login_ip = $_SERVER['REMOTE_ADDR'];
			$member->login_time = date('Y-m-d H:i:s');
			$member->save();
			return $this->toJSON($token);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}
	
	public function logout($request, $response, $args) {
		$token = $this->container['auth.manager']->getToken();
		$members = \App\Models\Members::where('token','=',$token)->get();
		if ($members->count() == 1) {
			$member = $members[0];
			$member->token = '';
			$member->save();
			return $this->toJSON(true);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}

	public function getLoginStatus($request, $response, $args)  {
		$token = $this->container['auth.manager']->getToken();
		
		$members = \App\Models\Members::where('token','=',$token)->get();
		if ($members->count() == 1) {
			return $this->toJSON(true);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	
	public function getProfile($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '';
		$token = $this->container['auth.manager']->getToken();
		
		if (empty($id)) {
			$member = \App\Models\Members::where('token','=',$token)->first();
		} else {
			$member = \App\Models\Members::find($id);
		}
		
		if (!empty($member)) {
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
			return $this->toJSON($member);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	
	public function updateProfile($request, $response, $args)  {
		$id = isset($args['id']) ? $args['id'] : '';
		$token = $this->container['auth.manager']->getToken();
		
		if (empty($id)) {
			$member = \App\Models\Members::where('token','=',$token)->first();
		} else {
			$member = \App\Models\Members::find($id);
		}
		
		if (!empty($member)) {
			$parsedBody = $request->getParsedBody();
			if (!empty($parsedBody['password'])) {
				$member->password = $parseBody['password'];
			}
			$member->email = $parseBody['email'];
			$member->phone = $parseBody['phone'];
			$member->status = $parseBody['status'];
			$member->save();
			
			return $this->toJSON(true);
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
				return $this->toJSON(true);
			} else {
				return $this->toJSON(false, ERR_GROUP_NOT_FOUND, ERR_GROUP_NOT_FOUND);
			}
		} else {
			return $this->toJSON(false, ERR_GROUP_ID_EMPTY, ERR_GROUP_ID_EMPTY);
		}
	}
	
}

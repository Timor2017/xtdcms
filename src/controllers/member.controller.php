<?php
namespace App\Controllers;

class MemberController extends BaseController {
	public function __invoke() {
	}

	public function me()  {
		$this->app->post('/login', 'App\Controllers\MemberController:login');
		$this->app->post('/logout', 'App\Controllers\MemberController:logout');
		$this->app->post('/getLoginStatus', 'App\Controllers\MemberController:getLoginStatus');
		$this->app->get('/profile', 'App\Controllers\MemberController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');
		$this->app->post('/profile', 'App\Controllers\MemberController:updateProfile')->add('\App\Middlewares\AuthenticateMiddleware::authUser');

	}

	public function user()  {
		$this->app->get('/', 'App\Controllers\MemberController:getProfileList')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
		$this->app->get('/profile/{id}', 'App\Controllers\MemberController:getProfile')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
		$this->app->post('/profile/manage[/]', 'App\Controllers\MemberController:createProfile')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
		$this->app->put('/profile/manage/{id}', 'App\Controllers\MemberController:updateProfile')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
		$this->app->put('/permission/manage/{id}', 'App\Controllers\MemberController:updatePermission')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');
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
			//setcookie('token', $token);
			
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
		//$token = $this->container['auth.manager']->getToken();
		
		//$members = \App\Models\Members::where('token','=',$token)->get();
		$result = $this->container['auth.manager']->isAuthenticatedUser();
		if ($result) {
			return $this->toJSON(true);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}	
	
	public function getProfileList($request, $response, $args)  {
		$members = \App\Models\Members::where('status','=',STATUS_ACTIVE)->get();
		
		if (!empty($members)) {
			
			foreach ($members as $member) {
				if (!empty($member)) {
					unset($member->password);
					unset($member->status);
					unset($member->login_ip);
					unset($member->token);
					unset($member->created_date);
					unset($member->created_by);
					unset($member->last_modified_date);
					unset($member->last_modified_by);
					unset($member->concurrent_id);
				}
			}
			return $this->toJSON($members);
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
			$member->is_admin = is_admin($member->groups);
			unset($member->groups);
			
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
				$member->password = md5($parsedBody['password']);
			}
			$member->display_name = $parsedBody['display_name'];
			$member->email = $parsedBody['email'];
			$member->phone = $parsedBody['phone'];
			$member->status = $parsedBody['status'];
			$member->save();
			
			return $this->toJSON(true);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
		}
	}
	
	
	public function createProfile($request, $response, $args)  {
		$parsedBody = $request->getParsedBody();
		if (true) {
			$member = new \App\Models\Members();
			
			$member->username = $parsedBody['username'];
			$member->status = $parsedBody['status'];
			$member->password = md5($parsedBody['password']);
			$member->display_name = $parsedBody['display_name'];
			$member->email = $parsedBody['email'];
			$member->phone = $parsedBody['phone'];
			$member->status = $parsedBody['status'];
			$member->save();
				
			return $this->toJSON(true);
		} else {
			return $this->toJSON(false, ERR_INVALID_USER, ERR_INVALID_USER);
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

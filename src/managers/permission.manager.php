<?php

function has_group_permission($id, $access = PERMISSION_READ) {
	$item = \App\Models\Groups::find($id);
	$permissions = $item->permissions;
	$result = has_permission($permissions, $item->created_by, $access = 'READ');

	return $result;
}

function has_folder_permission($id, $access = PERMISSION_READ) {
	$item = \App\Models\Folders::find($id);
	$permissions = $item->permissions;
	$result = has_permission($permissions, $item->created_by, $access = 'READ');

	return $result;
}

function has_form_permission($id, $access = 'READ') {
	$item = \App\Models\Forms::find($id);
	$permissions = $item->permissions;
	$result = has_permission($permissions, $item->created_by, $access = 'READ');
	
	return $result;
}

function has_form_item_permission($id, $access = 'READ') {
	$item = \App\Models\FormItems::find($id);
	$permissions = $item->permissions;
	$result = has_permission($permissions, $item->created_by, $access = 'READ');
	
	return $result;
}

function has_permission($permissions, $created_by, $access = 'READ') {
	global $app;
	$container = $app->getContainer();
	$result = false;
	
	if (($access != PERMISSION_CREATE) && ($access != PERMISSION_UPDATE) && ($access != PERMISSION_READ) && ($access != PERMISSION_DELETE) && ($access != PERMISSION_ADD) && ($access != PERMISSION_REMOVE) && ($access != PERMISSION_EXECUTE)) {
		throw new Exception ('variable access only allowed: CREATE, UPDATE, READ, DELETE, ADD, REMOVE');
	}
	$user = (object)[ 'id' => '' ];
	$groups = [(object)[ 'id' => '' ]];
	if (isset($container->user)) {
		$user = $container->user;
		if (isset($container->user->groups)) {
			$groups = $container->user->groups;
		}
	}
	
	$position = 0;
	switch ($access) {
		case PERMISSION_DELETE:
			$position = ACCESS_RIGHT_DELETE;
		break;
		case PERMISSION_READ:
			$position = ACCESS_RIGHT_READ;
		break;
		case PERMISSION_UPDATE:
			$position = ACCESS_RIGHT_UPDATE;
		break;
		case PERMISSION_CREATE:
			$position = ACCESS_RIGHT_CREATE;
		break;
		case PERMISSION_ADD:
			$position = ACCESS_RIGHT_ADD;
		break;
		case PERMISSION_REMOVE:
			$position = ACCESS_RIGHT_REMOVE;
		break;			
	}
			
	foreach ($permissions as $permission) {
		$access_right = $permission['permission'];

		if ((($access_right & ACCESS_MEMBER_PUBLIC) == ACCESS_MEMBER_PUBLIC) && ($access_right & $position == $position)) {
			$result = true;
			break;
		}
		else if ((($access_right & ACCESS_MEMBER_GROUP) == ACCESS_MEMBER_GROUP) && ($access_right & $position == $position) && (in_same_group($permission['group_id'], $groups))) {
			$result = true;
			break;
		}
		else if ((($access_right & ACCESS_MEMBER_SELF) == ACCESS_MEMBER_SELF) && ($access_right & $position == $position) && ($permission['owner_id'] == $user->id)) {
			$result = true;
			break;
		}
	}
	$result |= ($created_by == $user->id && $created_by !== 0);
	$result |= is_admin($groups);
	
	return $result;
}


function is_admin($groups) {
	$result = false;
	foreach ($groups as $group) {
		if ($group->name == '__admin') {
			
			$result = true;
			break;
		}
	}
	
	return $result;
}

function in_same_group($group_id, $groups) {
	$result = false;
	foreach ($groups as $group) {
		if ($group->group_id == $group_id) {
			
			$result = true;
			break;
		}
	}
	
	return $result;
}

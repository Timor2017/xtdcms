<?php

function has_folder_permission($folder_id, $access = 'READ') use ($app) {
	$result = false;
	
	if (($access != 'CREATE') || ($access != 'UPDATE') || ($access != 'READ') || ($access != 'DELETE') || ($access != 'ADD') || ($access != 'REMOVE')) {
		throw new Exception ('variable access only allowed: CREATE, UPDATE, READ, DELETE, ADD, REMOVE');
	}
	
	if (isset($app['user'])) {
		if (isset($app['user']['group'])) {
			$permissions = $app->db->select()
									->from('folder_permissions')
									->where('folder_id', '=', $folder_id)
									->where('status', '=', STATUS_ACTIVE)
									->execute()
									->fetchAll();
			$position = 0;
			switch ($access) {
				case 'DELETE':
					$position = ACCESS_RIGHT_DELETE;
				break;
				case 'READ':
					$position = ACCESS_RIGHT_READ;
				break;
				case 'UPDATE':
					$position = ACCESS_RIGHT_UPDATE;
				break;
				case 'CREATE':
					$position = ACCESS_RIGHT_CREATE;
				break;
			}
			
			foreach ($permissions as $permission) {
				$access_right = $permission['permission'];
				$check_access_right = $access_right >> $position;
				
				if ($check_access_right & ACCESS_MEMBER_PUBLIC == ACCESS_MEMBER_PUBLIC) {
					$result = true;
					break;
				}
				else if ($check_access_right & ACCESS_MEMBER_GROUP == ACCESS_MEMBER_GROUP && $permission['group_id'] == app['user']['group']['id']) {
					$result = true;
					break;
				}
				else if ($check_access_right & ACCESS_MEMBER_SELF == ACCESS_MEMBER_SELF && $permission['owner_id'] == app['user']['id']) {
					$result = true;
					break;
				}
				
			}
		}
	}
	
	return $result;
}


function has_form_permission($form_id, $access = 'READ') use ($app) {
	$result = false;
	
	if (($access != 'CREATE') || ($access != 'UPDATE') || ($access != 'READ') || ($access != 'DELETE')) {
		throw new Exception ('variable access only allowed: CREATE, UPDATE, READ, DELETE');
	}
	
	if (isset($app['user'])) {
		if (isset($app['user']['group'])) {
			$permissions = $app->db->select()
									->from('form_permissions')
									->where('form_id', '=', $form_id)
									->where('status', '=', STATUS_ACTIVE)
									->execute()
									->fetchAll();
			$position = 0;
			switch ($access) {
				case 'DELETE':
					$position = ACCESS_RIGHT_DELETE;
				break;
				case 'READ':
					$position = ACCESS_RIGHT_READ;
				break;
				case 'UPDATE':
					$position = ACCESS_RIGHT_UPDATE;
				break;
				case 'CREATE':
					$position = ACCESS_RIGHT_CREATE;
				break;
			}
			
			foreach ($permissions as $permission) {
				$access_right = $permission['permission'];
				$check_access_right = $access_right >> $position;
				
				if ($check_access_right & ACCESS_MEMBER_PUBLIC == ACCESS_MEMBER_PUBLIC) {
					$result = true;
					break;
				}
				else if ($check_access_right & ACCESS_MEMBER_GROUP == ACCESS_MEMBER_GROUP && $permission['group_id'] == app['user']['group']['id']) {
					$result = true;
					break;
				}
				else if ($check_access_right & ACCESS_MEMBER_SELF == ACCESS_MEMBER_SELF && $permission['owner_id'] == app['user']['id']) {
					$result = true;
					break;
				}
				
			}
		}
	}
	
	return $result;
}
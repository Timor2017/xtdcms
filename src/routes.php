<?php
// Routes

// API will all redirect to api controller
$app->group('/api', 'App\Controllers\ApiController')->add('\App\Middlewares\AuthenticateMiddleware::authHeader');

// minify the static file (css, js) and add cache header
$app->get('/min/{f:.*}', function ($request, $response, $args) use ($app, $container) {
	$_GET['f'] = $args['f'];
	$_GET['b'] = substr(dirname($_SERVER['SCRIPT_NAME']), 1);

	require __DIR__ .'/../vendor/mrclay/minify/min/index.php';
});

$app->get('/cmlist', function ($request, $response, $args) use ($app, $container) {
	$modules = array(
										'singleline' => 'modules/singeline',
									);
	$response->withJson($modules);
})->add('\App\Middlewares\AuthenticateMiddleware::authHeader')->add('\App\Middlewares\AuthenticateMiddleware::authUser');

$app->get('/modules/{file}', function ($request, $response, $args) use ($app, $container) {
	echo 'a';
});


$app->get('/forms/[{folder_id}]', function ($request, $response, $args) use ($app, $container) {

	$ids = $this->db->select(['max(id) as id'])
					->from('swdata')
					->groupBy('parent_id')
					//->max('version')
					->execute()
					->fetchAll();
	$show_ids = array();
	foreach ($ids as $i) {
		$show_ids[] = $i['id'];
	}
	
	$values = $this->db->select()
					->from('swdata')
					->whereIn('id', $show_ids)
					->orderBy('fruit_name')
					//->groupBy('parent_id')
					//->max('id')
					->execute()
					->fetchAll();
					
	$args['values'] = $values;

	return $this->view->render($response, 'form.list.html', $args);
})->setName("form.list");

$app->post('/folder', function ($request, $response, $args) use ($app, $container) {
	$stmt = $this->db->insert(array('name', 'sequence', 'status', 'created_date', 'created_by', 'last_modified_date', 'last_modified_by'))
                       ->into('folders')
                       ->values(array($_POST['name'], 1, STATUS_ACTIVE, 'NOW()', 'sys', 'NOW()', 'sys'));
	
	$insertId = $stmt->execute(false);

	$url = $container->router->pathFor('form.list');
	return $response->withRedirect($url);
	
})->setName("folder.create.submit");

$app->put('/folder/{id}', function ($request, $response, $args) use ($app, $container) {
	$stmt = $this->db->update(array('name' => $_POST['name'], 'last_modified_date' => 'NOW()', 'last_modified_by' => 'sys'))
                       ->table('folders')
                       ->where('id', '=', $args['id']);
	
	$affectedRows = $stmt->execute();

	$url = $container->router->pathFor('form.list');
	return $response->withRedirect($url);

	})->setName("folder.update.submit");

$app->delete('/folder/{id}', function ($request, $response, $args) use ($app, $container) {
	$stmt = $this->db->update(array('status' => STATUS_DELETED, 'last_modified_date' => 'NOW()', 'last_modified_by' => 'sys'))
                       ->table('folders')
                       ->where('id', '=', $args['id']);
	
	$affectedRows = $stmt->execute();

	$url = $container->router->pathFor('form.list');
	return $response->withRedirect($url);

})->setName("folder.delete.submit");


$app->get('/form/create', function ($request, $response, $args) use ($app, $container) {
	$args['route'] = 'form';
	return $this->view->render($response, 'form.form.html', $args);
})->setName("form.create");

$app->get('/form/success', function ($request, $response, $args) use ($app, $container) {
	$args['route'] = 'form';
	return $this->view->render($response, 'form.success.html', $args);
})->setName("form.submit.success");

$app->get('/form/{id}', function ($request, $response, $args) use ($app, $container) {
	$values = $this->db->select()
					->from('swdata')
					->where('id','=',$args['id'])
					->orWhere('parent_id','=',$args['id'])
					->orderBy('version', 'DESC')
					->execute()
					->fetch();
	foreach ($values as $key => $value){
		$values[$key] = str_replace(' 00:00:00', '', $value);
	}
	$args['data'] = $values;

	return $this->view->render($response, 'form.details.html', $args);
})->setName("form.details");

$app->get('/form/{id}/edit', function ($request, $response, $args) use ($app, $container) {
	$values = $this->db->select()
					->from('swdata')
					->where('id','=',$args['id'])
					->orWhere('parent_id','=',$args['id'])
					->orderBy('version', 'DESC')
					->execute()
					->fetch();
	foreach ($values as $key => $value){
		$values[$key] = str_replace(' 00:00:00', '', $value);
	}
	$args['data'] = $values;

	return $this->view->render($response, 'form.edit.html', $args);
})->setName("form.edit");

$app->post('/form', function ($request, $response, $args) use ($app, $container) {
	$values = array('sw_time'=>''
								,'sw_time_has_changed'=>'0'
								,'sw_type'=>''
								,'sw_type_has_changed'=>'0'
								,'sw_place'=>''
								,'sw_place_has_changed'=>'0'
								,'guider_qy'=>''
								,'guider_qy_has_changed'=>'0'
								,'guider_name'=>''
								,'guider_name_has_changed'=>'0'
								,'guider_phone'=>''
								,'guider_phone_has_changed'=>'0'
								,'manager_name'=>''
								,'manager_name_has_changed'=>'0'
								,'manager_phone'=>''
								,'manager_phone_has_changed'=>'0'
								,'fruit_name'=>''
								,'fruit_name_has_changed'=>'0'
								,'fruit_status'=>''
								,'fruit_status_has_changed'=>'0'
								,'fruit_phone'=>''
								,'fruit_phone_has_changed'=>'0'
								,'fruit_wechat'=>''
								,'fruit_wechat_has_changed'=>'0'
								,'fruit_qq'=>''
								,'fruit_qq_has_changed'=>'0'
								,'fruit_dept'=>''
								,'fruit_dept_has_changed'=>'0'
								,'fruit_gender'=>''
								,'fruit_gender_has_changed'=>'0'
								,'fruit_birthday'=>''
								,'fruit_birthday_has_changed'=>'0'
								,'tl_level'=>''
								,'tl_level_has_changed'=>'0'
								,'tl_reason'=>''
								,'tl_reason_has_changed'=>'0'
								,'tl_withstand'=>''
								,'tl_withstand_has_changed'=>'0'
								,'tl_withstand_method'=>''
								,'tl_withstand_method_has_changed'=>'0'
								,'remark'=>''
								,'remark_has_changed'=>'0'
								,'submitter'=>''
								,'submitter_has_changed'=>'0'
								,'version'=>'1'
								,'parent_id'=>'0'
								,'upper_id'=>'0'
								,'status'=>STATUS_ACTIVE
								,'createddate'=>'NOW()'
								,'createdby'=>'sys'
								,'lastmodifieddate'=>'NOW()'
								,'lastmodifiedby'=>'sys'
							);
	foreach ($_POST as $key => $value) {
		if (isset($values[$key])) {
			$values[$key] = $value;
		}
	}
	$stmt = $this->db->insert(array_keys($values))
	//array('sw_time','sw_time_has_changed','sw_type','sw_type_has_changed','sw_place','sw_place_has_changed','guider_qy','guider_qy_has_changed','guider_name','guider_name_has_changed','guider_phone','guider_phone_has_changed','manager_name','manager_name_has_changed','manager_phone','manager_phone_has_changed','fruit_name','fruit_name_has_changed','fruit_status','fruit_status_has_changed','fruit_phone','fruit_phone_has_changed','fruit_wechat','fruit_wechat_has_changed','fruit_qq','fruit_qq_has_changed','fruit_dept','fruit_dept_has_changed','fruit_gender','fruit_gender_has_changed','fruit_birthday','fruit_birthday_has_changed','tl_level','tl_level_has_changed','tl_reason','tl_reason_has_changed','tl_withstand','tl_withstand_has_changed','tl_withstand_method','tl_withstand_method_has_changed','remark','remark_has_changed','submitter','submitter_has_changed','version','parent_id','upper_id','status','createddate','createdby','lastmodifieddate','lastmodifiedby'))
                       ->into('swdata')
                       ->values($values);
	
	$insertId = $stmt->execute(true);
	
	$stmt = $this->db->update(array('parent_id'=>$insertId))
                       ->table('swdata')
                       ->where('id', '=', $insertId);
	$affectedRows = $stmt->execute();

	$url = $container->router->pathFor('form.submit.success');
	return $response->withRedirect($url);


	//$app->redirect($app->urlFor('form.submit.success'));
})->setName("form.create.submit");

$app->post('/form/{id}/edit', function ($request, $response, $args) use ($app, $container) {
	$values = $this->db->select()
					->from('swdata')
					->where('id','=',$args['id'])
					->orWhere('parent_id','=',$args['id'])
					->orderBy('version', 'DESC')
					->execute()
					->fetch();
	if ($values['parent_id'] == '0') {
			$values['parent_id'] = $values['id'];
	}
	$values['upper_id'] = $values['id'];
	$values['version'] = $values['version'] + 1;
	$values['lastmodifieddate'] = 'NOW()';
	$values['lastmodifiedby'] = 'sys';
	unset($values['id']);

	foreach ($_POST as $key => $value) {
		if (isset($values[$key])) {
			if ($values[$key] != $value) {
				$values[$key] = $value;
				$values[$key.'_has_changed'] = '1';
			} else {
				$values[$key.'_has_changed'] = '0';
			}
		}
	}
	
	$stmt = $this->db->insert(array_keys($values))
	//array('sw_time','sw_time_has_changed','sw_type','sw_type_has_changed','sw_place','sw_place_has_changed','guider_qy','guider_qy_has_changed','guider_name','guider_name_has_changed','guider_phone','guider_phone_has_changed','manager_name','manager_name_has_changed','manager_phone','manager_phone_has_changed','fruit_name','fruit_name_has_changed','fruit_status','fruit_status_has_changed','fruit_phone','fruit_phone_has_changed','fruit_wechat','fruit_wechat_has_changed','fruit_qq','fruit_qq_has_changed','fruit_dept','fruit_dept_has_changed','fruit_gender','fruit_gender_has_changed','fruit_birthday','fruit_birthday_has_changed','tl_level','tl_level_has_changed','tl_reason','tl_reason_has_changed','tl_withstand','tl_withstand_has_changed','tl_withstand_method','tl_withstand_method_has_changed','remark','remark_has_changed','submitter','submitter_has_changed','version','parent_id','upper_id','status','createddate','createdby','lastmodifieddate','lastmodifiedby'))
                       ->into('swdata')
                       ->values($values);
	//print_r($values);exit;
	
	//echo $stmt->__toString();exit;

	$insertId = $stmt->execute(false);

	$url = $container->router->pathFor('form.submit.success');
	return $response->withRedirect($url);
	//$app->redirect($app->urlFor('form.list'));
})->setName("form.update.submit");

$app->delete('/form/{id}', function ($request, $response, $args) use ($app, $container) {
	$app->redirect($app->urlFor('form.list'));
})->setName("form.delete.submit");

$app->get('/members', function ($request, $response, $args) use ($app, $container) {
	$args['route'] = 'member';
	return $this->view->render($response, 'member.list.html', $args);
})->setName("member.list");

$app->get('/member/create', function ($request, $response, $args) use ($app, $container) {
	$args['route'] = 'member';
	return $this->view->render($response, 'member.form.html', $args);
})->setName("member.create");

$app->get('/member/{id}', function ($request, $response, $args) use ($app, $container) {
	$args['route'] = 'member';
	return $this->view->render($response, 'member.list.html', $args);
})->setName("member.details");

$app->get('/member/{id}/edit', function ($request, $response, $args) use ($app, $container) {
	$args['route'] = 'member';
	return $this->view->render($response, 'member.form.html', $args);
})->setName("member.edit");

$app->post('/member', function ($request, $response, $args) use ($app, $container) {
	$app->redirect($app->urlFor('member.list'));
})->setName("member.create.submit");

$app->put('/member/{id}', function ($request, $response, $args) use ($app, $container) {
	$app->redirect($app->urlFor('member.list'));
})->setName("member.update.submit");

$app->delete('/member/{id}', function ($request, $response, $args) use ($app, $container) {
	$app->redirect($app->urlFor('member.list'));
})->setName("member.delete.submit");




$app->get('/', function ($request, $response, $args) {
	$args['route'] = 'dashboard';
	return $this->view->render($response, 'index.html', $args);
})->setName("dashboard");


$app->get('/test/[{name}]', function ($request, $response, $args) {

	$members = $this->db->select()
			 ->from('members')
			 ->execute()
			 ->fetchAll();
	 $args['data'] = $members;
	 return $this->view->render($response, 'index.html', $args);
	//return $this->view->render($response, 'index.html', [
    //    'name' => $args['name']
    //]);
	
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");
    //
	// // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);
})->setName("test");


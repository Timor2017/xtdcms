<?php
namespace App\Controllers;

class ApiController extends BaseController {
	protected $appID;
	protected $secret;
    protected $version;
    protected $token;

	public function __invoke() {
		$this->app->group('/me', '\App\Controllers\MemberController:me');
		$this->app->group('/user', '\App\Controllers\MemberController:user');
		//$this->app->group('/group', '\App\Controllers\MemberController:group');
		$this->app->group('/group', '\App\Controllers\GroupController:definition');
		$this->app->group('/form/def', '\App\Controllers\FormController:definition');
		$this->app->group('/form/data', '\App\Controllers\FormController:data');
		$this->app->group('/folder', '\App\Controllers\FolderController:definition');
		$this->app->group('/translate', '\App\Controllers\TranslateController:definition');
		$this->app->group('/search', '\App\Controllers\SearchController:search');
		$this->app->group('/validate', '\App\Controllers\ValidateController:definition');
		$this->app->group('/rule', '\App\Controllers\RuleController:definition');
		$this->app->post('/test[/]','App\Controllers\ApiController:testFunction');
	}
	
	public function testFunction($request,$response,$args){
	//	$parsedBody=$request->getParsedBody();
	//	$folder= new \App\Models\Folders();
	//	$form_id = $this->retrieveArray($parsedBody, 'fid', '-1');
	//	$form_item_id = $this->retrieveArray($parsedBody, 'cid', '-1');
    //
	//	
	//	$value = $this->retrieveArray($parsedBody, 'value', '');
	//	$search_keys = array();
	//	$search_keys[] = $value;
	//	$db_query = \App\Models\FormDataValues::where('status','=',STATUS_ACTIVE)->where('form_id','=',$form_id)->where('form_item_id','=',$form_item_id)->where(function ($query) use ($search_keys) {
	//		foreach ($search_keys as $key) {
	//			$query->orWhere('text_value','=',$key);	
	//		}
	//	});
	//	$values = $db_query->get();
	//	$total = $db_query->distinct()->count('form_data_id');
	//	$code = null;
	//	$message = null;
	//	if ($total == 0) {
	//		$code = '';
	//		$message = '';
	//	}
	//	return $this->toJSON($total > 0, '', '');
	}
}

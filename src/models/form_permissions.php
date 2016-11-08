<?php
namespace App\Models;

class FormPermissions extends BaseModel {
	protected $connection = 'form_definition';
	protected $table = 'form_permissions';
}
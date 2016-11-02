<?php
namespace App\Models;

class FormItemElements extends BaseModel {
	protected $connection = 'form_definition';
	protected $table = 'form_item_elements';
}
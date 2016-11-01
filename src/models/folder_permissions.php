<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderPermissions extends Model {
	protected $connection = 'form_definition';
	protected $table = 'folder_permissions';
}
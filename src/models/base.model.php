<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
	const CREATED_AT = 'created_date';
	const UPDATED_AT = 'last_modified_date';

	protected static function boot()
	{
		global $container;
		parent::boot();
		
		static::creating(function ($model) use ($container) {
			if ($container->user->isLoggedIn) {
				$model->created_by = $container->user->id;
				$model->last_modified_by = $container->user->id;
			}
		});
		static::updating(function ($model) use ($container) {
			if ($container->user->isLoggedIn) {
				$model->last_modified_by = $container->user->id;
			}
		});
		static::saving(function ($model) use ($container) {
			if ($model instanceof FormDataValues){
				$model->text_value = encrypt($container->user->info->code, $model->text_value);
			}
		});
	}
}
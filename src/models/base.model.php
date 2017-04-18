<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
	const CREATED_AT = 'created_date';
	const UPDATED_AT = 'last_modified_date';
	
	protected $available_properties = [''];

	protected static function boot()
	{
		global $container;
		parent::boot();
		
		static::creating(function ($model) use ($container) {
			$model->created_by = '0';
			$model->last_modified_by = '0';
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
				//$model->text_value = encrypt($container->user->info->code, $model->text_value);
			}
		});
	}
	
	public function __get($name) {
		if (isset($this->available_properties[$name])) {
			if (isset($this->items)) {
				foreach ($this->items as $item) {
					if ($item->name == $name) {
						return $item->value;
					}
				}
			}
		} else {
			return parent::__get($name);
		}
	}
	
	public function __set($name, $value) {
		if (isset($this->available_properties[$name])) {
			if (isset($this->items)) {
				foreach ($this->items as $item) {
					if ($item->name == $name) {
						$item->value = $value;
					}
				}
			}
		} else {
			parent::__set($name, $value);
		}
	}
}
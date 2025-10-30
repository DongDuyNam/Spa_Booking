<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $role_id
 * @property string|null $name
 * @property string|null $description
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';
	protected $primaryKey = 'role_id';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'description'
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}
}

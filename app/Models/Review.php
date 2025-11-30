<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $primaryKey = 'review_id';

	public $timestamps = false;

	protected $fillable = [
		'user_id',
		'rating',
		'comment',
		'reply_content',
		'is_replied',
		'replied_at',
		'replied_by',
		'created_at'
	];


	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function repliedBy()
	{
		return $this->belongsTo(User::class, 'replied_by');
	}
}

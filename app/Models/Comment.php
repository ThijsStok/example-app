<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use HasFactory;

	protected $fillable = [
		'product_id',
		'borrower_id',
		'owner_id',
		'comment',
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function borrower()
	{
		return $this->belongsTo(User::class, 'borrower_id');
	}

	public function owner()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}
}
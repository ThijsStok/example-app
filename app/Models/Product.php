<?php

namespace App\Models; // Add this line to declare the namespace

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Specify the table associated with the Product model, if different from 'products'
    protected $table = 'products';

    // Primary key of the table
    protected $primaryKey = 'id';

    // Attributes that are mass assignable
    protected $fillable = [
        'name',
        'description',
        'category',
        'image',
        'owner_id',
        'borrower_id', // Indicates who is borrowing the product. Null if available.
        'lend_date', // The date when the product was lent. Null if available.
        'return_date', // The expected return date. Null if available or not applicable.
        'state,'
    ];

    protected $hidden = [
    ];

    // Attributes that should be cast to native types
    protected $casts = [
        'id' => 'integer',
        'owner_id' => 'integer',
        'borrower_id' => 'integer',
        'lend_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function transitionToWaitingForAcceptance()
    {
        $this->update(['state' => 'waiting_for_acceptance']);
    }

    public function acceptReturn()
    {
        $this->update([
            'state' => 'available',
            'borrower_id' => null,
            'lend_date' => null,
            'return_date' => null,
        ]);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lend extends Model
{
    // Specify the table associated with the Lend model, if different from 'lends'
    public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}
    protected $table = 'lends';

    // Primary key of the table
    protected $primaryKey = 'id';

    // Attributes that are mass assignable
    protected $fillable = [
        'product_id',
        'borrower_id',
        'owner_id', // Add this if you're using owner_id directly in Lend
        'lend_date',
        'return_date',
        // Add other attributes here
    ];

    // Attributes that should be hidden for arrays
    protected $hidden = [
        // Example: 'sensitive_attribute',
    ];

    // Attributes that should be cast to native types
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'borrower_id' => 'integer',
        'lend_date' => 'datetime',
        'return_date' => 'datetime',
        // Add other casts here
    ];

    // Relationship: Lend belongs to a Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relationship: Lend belongs to a Borrower (assuming Borrower is a User)
    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    // Add other relationships and model methods here
}
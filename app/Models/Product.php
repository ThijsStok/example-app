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
    ];

    // Attributes that should be hidden for arrays
    protected $hidden = [
        // Example: 'secret_attribute',
    ];

    // Attributes that should be cast to native types
    protected $casts = [
        'id' => 'integer',
        'owner_id' => 'integer',
        'borrower_id' => 'integer',
        'lend_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    // Example relationship: Product belongs to an owner
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function borrower()
    {
        // This relationship is optional and only relevant if the product is currently lent out.
        return $this->belongsTo(User::class, 'borrower_id');
    }

    // Add other methods and relationships here as needed
}
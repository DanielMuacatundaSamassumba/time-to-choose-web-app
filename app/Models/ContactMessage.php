<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'message', 'property_id', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

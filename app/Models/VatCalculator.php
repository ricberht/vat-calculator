<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatCalculator extends Model
{
    use HasFactory;
    //allow-lists column names which can be updated
    protected $fillable = ['value', 'percentage', 'included'];
}

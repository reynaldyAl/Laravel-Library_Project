<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanStatus extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}

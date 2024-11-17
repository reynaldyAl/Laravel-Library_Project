<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'return_date',
        'due_date',
        'loan_status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function loanStatus()
    {
        return $this->belongsTo(LoanStatus::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    
}

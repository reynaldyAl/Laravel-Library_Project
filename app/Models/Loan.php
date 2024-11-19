<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'return_date',
        'due_date',
        'loan_status_id',
        'is_approved',
        'is_returned',
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

    public function getOverdueDaysAttribute()
    {
        if ($this->return_date > $this->due_date) {
            return Carbon::parse($this->return_date)->diffInDays(Carbon::parse($this->due_date));
        }
        return 0;
    }
}
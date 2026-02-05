<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'email',
        'phone',
        'dob',
        'country_of_interest',
        'current_stage',
        'current_status',
        'assigned_marketing_id',
        'assigned_consultant_id',
        'assigned_application_id',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function marketingAssignee()
    {
        return $this->belongsTo(User::class, 'assigned_marketing_id');
    }

    public function consultantAssignee()
    {
        return $this->belongsTo(User::class, 'assigned_consultant_id');
    }

    public function applicationAssignee()
    {
        return $this->belongsTo(User::class, 'assigned_application_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

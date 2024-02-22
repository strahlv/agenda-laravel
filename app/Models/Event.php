<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'start_date',
        'end_date',
        'user_id'
    ];

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d'
    ];

    protected $appends = [
        'start_time',
        'end_time',
        'is_all_day'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStartTimeAttribute()
    {
        return $this->start_date->format('H:i');
    }

    public function getEndTimeAttribute()
    {
        return $this->end_date->format('H:i');
    }

    public function getIsAllDayAttribute()
    {
        $startDateEnd = $this->start_date->copy();
        $startDateEnd->hour = 23;
        $startDateEnd->minute = 59;
        $startDateEnd->second = 59;
        return $this->end_date->greaterThanOrEqualTo($startDateEnd);
    }

    public function getIsHolidayAttribute()
    {
        return $this->id == -1;
    }

    public function getCanUpdateOrDestroyAttribute()
    {
        return !$this->is_holiday;
    }
}

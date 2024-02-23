<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

    public function getFormattedStartTimeAttribute()
    {
        return $this->start_date->format('G:i');
    }

    public function getEndTimeAttribute()
    {
        return $this->end_date->format('H:i');
    }

    public function getFormattedEndTimeAttribute()
    {
        return $this->end_date->format('G:i');
    }

    public function getIsAllDayAttribute()
    {
        $startDateEnd = $this->start_date->copy();
        $startDateEnd->hour = 23;
        $startDateEnd->minute = 59;
        $startDateEnd->second = 59;
        return $this->end_date->greaterThanOrEqualTo($startDateEnd);
    }

    public function getDurationInDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function getDurationInHoursAttribute()
    {
        return $this->start_date->diffInHours($this->end_date);
    }

    public function getIsHolidayAttribute()
    {
        return $this->id == -1;
    }

    public function getCanUpdateOrDestroyAttribute()
    {
        return !$this->is_holiday;
    }

    public function getPeriodAttribute()
    {
        return CarbonPeriod::create($this->start_date, $this->end_date);
    }

    public function startsAt(Carbon $date)
    {
        return $this->start_date->isSameDay($date);
    }

    public function startsAtHour(int $hour)
    {
        return $this->start_date->hour == $hour;
    }

    public function startsBefore(Carbon $date)
    {
        return $this->start_date->isBefore($date);
    }

    public function endsAfter(Carbon $date)
    {
        return $this->end_date->isAfter($date);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventsCalendar extends Model
{
    protected $table = 'events_calendar';
    protected $fillable = ['event_description', 'event_date', 'event_day'];
}

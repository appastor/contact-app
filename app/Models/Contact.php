<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Contact extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'address',
        'avatar',
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected static $logName = 'contact';

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'contact_number', 'address', 'avatar'])
            ->logOnlyDirty()
            ->useLogName(self::$logName)
            ->setDescriptionForEvent(fn(string $eventName) => "Contact has been {$eventName}");
    }
}

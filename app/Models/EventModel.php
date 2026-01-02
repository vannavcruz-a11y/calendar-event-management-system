<?php namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';

    // Fields that can be inserted/updated
    protected $allowedFields = [
        'campus_id',
        'org_name',
        'title',
        'description',
        'date',
        'time_in',
        'time_out',
        'location',
        'poster',
        'created_by'
    ];

    // Disable automatic timestamps to avoid 'updated_at' errors
    protected $useTimestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'about',
        'company',
        'job',
        'country',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'twitter',
        'facebook',
        'instagram',
        'linkedin',
        'website',
        'birthday',
        'notes'
    ];

    protected function setWebAttribute($value)
    {
        if ($value && !preg_match("~^(?:f|ht)tps?://~i", $value)) {
            $this->attributes['web'] = 'https://' . $value;
        } else {
            $this->attributes['web'] = $value;
        }
    }
}

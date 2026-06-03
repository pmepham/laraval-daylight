<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{

    protected $appends = ['encrypted_id'];
    protected $hidden = ['id'];

    protected $fillable = [
        'name',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'address_line_4',
        'post_code', // postcode
        'company_id'
    ];

    public function getEncryptedIdAttribute(){
        return _encrypt($this->id);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function rooms(){
        return $this->hasMany(Room::class)->orderBy('id', 'asc');;
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $appends = ['encrypted_id'];
    protected $hidden = ['id'];
    protected $fillable = [
        'id',
        'name',
        'site_id',
        'company_id'
    ];

    public function getEncryptedIdAttribute(){
        return _encrypt($this->id);
    }

    public function site(){
        return $this->belongsTo(Site::class);
    }

    
}

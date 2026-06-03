<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentFramework extends Model
{
    //
    protected $appends = ['encrypted_id'];
    protected $hidden = ['id'];
    protected $fillable = ['company_id', 'user_id', 'name', 'is_public'];

    public function getEncryptedIdAttribute(){
        return _encrypt($this->id);
    }

}

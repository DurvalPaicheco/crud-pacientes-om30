<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'id',
        'name',
        'mother_name',
        'birthdate',
        'cpf',
        'cns',
        'path_picture',
        'deleted',
        'deleted_at',
        'updated_at',
    ];

    protected $appends = [
        'url_picture'
    ];

    public function getUrlPictureAttribute(){
        return url('storage/'.$this->path_picture);
    }

    public function address(){
        return $this->hasOne(PatientAddress::class);
    }
}

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
        'cep',
        'street',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city', 
        'state',
        'path_picture',
        'deleted',
        'deleted_at',
        'path_picutre'
    ];
}

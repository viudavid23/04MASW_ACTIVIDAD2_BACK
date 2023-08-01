<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * La tabla asociada al modelo
     * 
     * @var string
     */
    protected $table = "persons";
    /**
     * Llave primaria asociada con la tabla
     * 
     * @var string
     */
    protected $primaryKey = "persons_document";

    protected $fillable = [
        'persons_document',
        'persons_first_name',
        'persons_middle_name',
        'persons_last_name',
        'persons_second_surname',
        'persons_direction',
        'persons_phone',
        'persons_mobile',
        'persons_state',
        'persons_notes',
    ];

    public $timestamps = true;

    protected $dates = ['deleted_at'];

     /**
     * Función encargada de definir la relación de llave foránea con la tabla persons
     * Argumentos: Modelo relacionado, columna que actua como llave foránea y columna de clave primaria
     */
    public function resident(){

        return $this->hasOne(Resident::class, 'persons_document', 'persons_document');
    }

}

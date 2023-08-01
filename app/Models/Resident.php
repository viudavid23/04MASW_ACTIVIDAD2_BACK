<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "residents";

    protected $primaryKey = "id";

    protected $fillable = [
        'persons_document',
        'residents_date_of_birth',
        'residents_registration_date',
        'residents_sons_number',
        'residents_clothing_size',
    ];

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    /**
     * Función encargada de definir la relación de llave foránea con la tabla persons
     * Argumentos: Modelo relacionado, columna que actua como llave foránea y columna de referencia en el modelo
     */
   public function person(){

        return $this->belongsTo(Person::class, 'persons_document', 'persons_document');
    }
}

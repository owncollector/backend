<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objeto extends Model
{
    use HasFactory;

    // Especificar la tabla si el nombre no sigue la convención de Laravel
    protected $table = 'objetos';

    // Especificar los campos que se pueden llenar masivamente
    protected $fillable = [
        'user_id', // Asegúrate de que este campo coincida con el nombre del campo en la base de datos
        'nombre',
        'valor',
    ];

    // Definir la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

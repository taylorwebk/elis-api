<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class Estudiante extends Model
{
    protected $guarded = [];
    protected $table = 'estudiante';
    public $timestamps = false;

    public function persona() {
      return $this->belongsTo('\Models\Persona');
    }
    public function modulos() {
      return $this->belongsToMany('\Models\Modulo')->withPivot('qrurl');
    }
}
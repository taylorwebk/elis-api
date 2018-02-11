<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class Persona extends Model
{
    protected $guarded = [];
    protected $table = 'persona';
    public $timestamps = false;
    public function instructor() {
      return $this->hasOne('\Models\Instructor');
    }
    public function estudiante() {
      return $this->hasOne('\Models\Estudiante');
    }
}

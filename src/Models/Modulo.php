<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class Modulo extends Model
{
    protected $guarded = [];
    protected $table = 'modulo';
    public $timestamps = false;
    public function instructores() {
      return $this->belongsToMany('\Models\Instructor');
    }
    public function estudiantes() {
      return $this->belongsToMany('\Models\Estudiante')->withPivot('qrurl');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Categories extends Model
{
    use HasFactory;

    protected $fillable = ['category_name','active'];

    static function todas_las_categorias(){
        return Categories::where('active',true)->get();
    }

    static function notas_por_categoria($id){
        return Categories::leftJoin('notes','categories.id','=','notes.category_id')
        ->select('category_name','notes.id','title','content','categories.created_at','categories.updated_at')
        ->where('categories.id',$id)
        ->where('notes.active',true)
        ->get();
    }
 
    static function categoria_por_id($id){
        return Categories::where('id',$id)->where('active',true)->firstOrFail();
    }
}

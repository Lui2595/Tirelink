<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;

class productosController extends Controller
{
    public function get()
    {
        return response(Productos::all(),200);
    }
    public function getSlug($slug)
    {
       return response(Productos::Where("slug",$slug)->get(),200);
    }
    public function create(Request $r)
    {
        $v = $r->validate([
            'nombre' => 'required|unique:productos|max:255',
            'descripcion' => 'required',
            'slug' => 'required',
            'precio' => 'required|numeric',
            'stock'  => 'required|numeric',
        ]);

        $p=new Productos();
        $p->nombre=$r->nombre;
        $p->descripcion=$r->descripcion;
        $p->slug=$r->slug;
        $p->precio=$r->precio;
        $p->stock=$r->stock;
        $p->save();

        return response($p,200);

    }
    public function update(Request $r, $id)
    {
        $v = $r->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
            'slug' => 'required',
            'precio' => 'required|numeric',
            'stock'  => 'required|numeric',
        ]);
        $p= Productos::find($id);
        $p->nombre=$r->nombre;
        $p->descripcion=$r->descripcion;
        $p->slug=$r->slug;
        $p->precio=$r->precio;
        $p->stock=$r->stock;
        $p->save();
        return response($p,200);
    }
    public function delete($id)
    {
        $p= Productos::find($id);
        $p->delete();
        return response("Producto Eliminado con exito ",200);
    }
}

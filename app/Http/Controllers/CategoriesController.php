<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\notes; 

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::todas_las_categorias();
        #dd($notes);
        return view ('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         #dd($request);
         Categories::create([
            
            'category_name' => $request->category_name,
        
        ]);

        return redirect()->route('categories.index')
        ->with('success','Categoria creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('categories.show')
        ->with('category',Categories::categoria_por_id($id))
        ->with('notes',Categories::notas_por_categoria($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('categories.edit')
        ->with('category',Categories::categoria_por_id($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category= Categories::categoria_por_id($id);

        $category->update([
            'category_name' => $request->category_name,
        ]);

        
        return redirect()->route('categories.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::categoria_por_id($id);

        $category->update([
            'active'     =>  false,
        ]);

        $notes = notes::notas_por_category_id($id);

        foreach ($notes as $note) {
            
            $currentnote = notes::nota_por_id($note -> id);

            $currentnote->update([
                'category_id' =>  NULL
            ]);
        }

        return redirect()->route('categories.index');
    }
}

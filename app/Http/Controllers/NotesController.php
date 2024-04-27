<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\notes;
use App\Models\Categories; 

class NotesController extends Controller
{

    public function index()
    {
        $notes =notes::todas_las_notas();
        //dd($notes);
        return view('notes.index',compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::todas_las_categorias();
        return view ('notes.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        notes::create([
         'title'=> $request->title,
         'content'=> $request->content,
         'category_id' => $request->category_id
        ]);

        //return to_route('notes.index');
        return redirect()->route('notes.index')
            ->with('success','Nota creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view ('notes.show')
        ->with('note', notes::nota_por_id($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view ('notes.edit')
        ->with('note', notes::nota_por_id($id))
        ->with('categories',Categories::todas_las_categorias());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note= notes::nota_por_id($id);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id'   =>  $request->category
        ]);

        //return to_route('notes.index');
        return redirect()->route('notes.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = notes::nota_por_id($id);

        //$note->delete();
        $note->update([
            'active'     =>  false,
        ]);

        return redirect()->route('notes.index');
    }
}

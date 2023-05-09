<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;
use App\Models\Evento;
use App\Models\Album;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;  ///paquete que sirve para reducir el tamaño de la foto
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image'
        ]);
        $foto  = new Foto();

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '-' . $file->getClientOriginalName();
            $destinationPath = storage_path() . '\app\public\imagenes/' . $filename;
           
            Image::make($request->file('imagen'))
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    //$constraint->upsize();
                }) 
            ->save($destinationPath);
            $foto->imagen = 'storage/imagenes/' . $filename;
        };
        $foto->estado = $request->estado;
        $foto->fotografo_id = Auth::user()->id;
        $foto->evento_id = $request->evento_id;
        $foto->save();

        return redirect()->route('albums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}

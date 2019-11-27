<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class AlbumsController extends Controller
{
    public function index(){
        return view('albums.index');
    }

    public function create(){
        return view('albums.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'cover-image' => 'required|image'
        ]);

        $filenameWithExtension = $request->file('cover-image')->getClientOriginalName(); //File Name with Extention ex 123.jpg
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME); //File Name Only ex 123
        $extension = $request->file('cover-image')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . $extension;

        $path = $request->file('cover-image')->storeAs('public/album_covers', $filenameToStore); //storing actual image file
      
        $album = new Album();
        $album->name = $request->input('name');
        $album->description = $request->input('description');
        $album->cover_image = $filenameToStore;
        $album->save();

        return redirect('/albums')->with('success', 'Album created successfully.');
    }
}

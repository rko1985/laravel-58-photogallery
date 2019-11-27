<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Storage;

class PhotosController extends Controller
{
    public function create(int $albumId){
        return view('photos.create')->with('albumId', $albumId);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required|image'
        ]);

        $filenameWithExtension = $request->file('photo')->getClientOriginalName(); //File Name with Extention ex 123.jpg
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME); //File Name Only ex 123
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . $extension;

        $request->file('photo')->storeAs('public/albums/' . $request->input('album-id'), $filenameToStore); //storing actual image file
      
        $photo = new Photo();
        $photo->title = $request->input('title');
        $photo->description = $request->input('description');
        $photo->photo = $filenameToStore;
        $photo->size = $request->file('photo')->getSize();
        $photo->album_id = $request->input('album-id');
        $photo->save();

        return redirect('/albums/'. $request->input('album-id'))->with('success', 'Photo uploaded successfully.');
    }

    public function show($id){
        $photo = Photo::find($id);
        return view('photos.show')->with('photo', $photo);
    }

    public function destroy($id){
        $photo = Photo::find($id);

        if(Storage::delete('public/albums/' . $photo->album->id .'/' . $photo->photo)){
            $photo->delete();
            return redirect('/')->with('success', 'Photo deleted successfully.');
        }

    }
}

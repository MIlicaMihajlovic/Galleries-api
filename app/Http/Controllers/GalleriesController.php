<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Requests\GalleryRequest;

class GalleriesController extends Controller
{
    public function __construct(){

        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {           
        $userId = $request->input('id');

        if($userId) {
            return Gallery::where('user_id', $userId)->with(['user', 'images'])->latest()->paginate(10);
        }

        return Gallery::with(['user', 'images'])->latest()->paginate(10);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->user_id = auth()->user()->id;
        $gallery->save();
  
        $images = $request->input('images');
        $images_array= [];
        
            foreach($images as $key => $image) {
                
                $images_array [] = new Image ($image);
            }
        
        $gallery->images()->saveMany($images_array);
        
        return response()->json([
            'gallery' => $gallery,
            'user' => auth()->user()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return $gallery->load(['user', 'images', 'comments', 'comments.user']);  //da nam za jednu galeriju dovuce usera i slike
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Image;
use App\User;

class AuthorsController extends Controller
{
    
    public function show($id)
    { 
        return User::with(['galleries', 'galleries.images'])->find($id);
      
    }

    
}

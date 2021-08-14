<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index(){
        echo 'you getting this?';
    }

    public function store(){

        $image = auth()->user()->addMediaFromRequest('file')->toMediaCollection('images');

        return response()->json([
            'id'  => $image->id,
            'url' => $image->getUrl()
        ]);
    }
}

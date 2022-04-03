<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Jobs\ProcessImage;

use Inertia\Inertia;

class NewImageController extends Controller
{
    public function show(){
        $route = 'APP/' . (new \ReflectionClass($this))->getShortName() . '/' . __FUNCTION__;

        return Inertia::render($route);
    }

    public function store(Request $request){
        $user = Auth::user();
        
        $request->validate([
            'image_uri' => 'required|string',
        ]);

        $url = $request->image_uri;

        ProcessImage::dispatch($user, $url);

        $route = 'APP/' . (new \ReflectionClass($this))->getShortName() . '/' . __FUNCTION__;

        return redirect()->route('APP.newimage.show');
    }
}

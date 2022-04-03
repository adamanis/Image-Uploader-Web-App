<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\UploadedImage;

class DashboardController extends Controller
{
    public function show(){
        $user = \Auth::user();
        // $images = $user->uploadedImages;
        $images = UploadedImage::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->paginate(3);

        $data = [
            'images' => $images,
        ];

        $route = 'APP/' . (new \ReflectionClass($this))->getShortName() . '/' . __FUNCTION__;

        return Inertia::render($route, $data);
    }
}

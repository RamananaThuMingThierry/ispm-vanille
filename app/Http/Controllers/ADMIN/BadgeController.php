<?php

namespace App\Http\Controllers\ADMIN;

use App\Models\Tour;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Reservation;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Support\Facades\Cache;

class BadgeController extends Controller
{
    public function getAll(){
        $cacheKey = 'all_data'; // Clé de cache
        $cacheTime = 60; // Temps en minutes

        $data = Cache::remember($cacheKey, $cacheTime, function () {
            return [
                'galleries' => Gallery::count(),
                'reservations' => Reservation::count(),
                'tours' => Tour::count(),
                'testimonials' => Testimonial::count(),
                'users' => User::count(),
                'slides' => Slide::count(),
            ];
        });

        return response()->json($data);
    }
}

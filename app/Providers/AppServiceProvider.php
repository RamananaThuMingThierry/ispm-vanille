<?php

namespace App\Providers;

use App\Interfaces\GalleryInterface;
use App\Interfaces\TourInterface;
use App\Interfaces\SlideInterface;
use App\Repositories\TourRepository;
use Illuminate\Pagination\Paginator;
use App\Repositories\SlideRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ReservationInterface;
use App\Interfaces\TestimonialInterface;
use App\Interfaces\TourImagesInterface;
use App\Interfaces\UserInterface;
use App\Repositories\GalleryRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\TestimonialRepository;
use App\Repositories\TourImagesRepository;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
/**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TestimonialInterface::class, TestimonialRepository::class);
        $this->app->bind(SlideInterface::class, SlideRepository::class);
        $this->app->bind(ReservationInterface::class, ReservationRepository::class);
        $this->app->bind(TourInterface::class, TourRepository::class);
        $this->app->bind(GalleryInterface::class, GalleryRepository::class);
        $this->app->bind(TourImagesInterface::class, TourImagesRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}

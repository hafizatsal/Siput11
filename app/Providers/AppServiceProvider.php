<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('user.home', function ($view) {
            try {
                $pengumuman = DB::table('pengumuman')->get();
            } catch (\Throwable $e) {
                $pengumuman = collect();
            }
            $view->with('pengumuman', $pengumuman);
        });

        View::composer('layouts.adminlayout', function ($view) {
            $defaultUrl = asset('Admin/dist/img/default-user.png');
            try {
                if (!auth()->check()) {
                    $view->with('fotoUrl', $defaultUrl);
                    return;
                }
                $foto = DB::table('foto_user')->where('id_user', auth()->id())->first();
                $fotoUrl = $foto ? asset('upload/profile/' . $foto->filename) : $defaultUrl;
            } catch (\Throwable $e) {
                $fotoUrl = $defaultUrl;
            }
            $view->with('fotoUrl', $fotoUrl);
        });
    }
}

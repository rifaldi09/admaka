<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\HakAkses;

class AdminLTEServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Tidak ada yang perlu didaftarkan di sini
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Pakai event BuildingMenu untuk menambah menu
        \Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Ambil data hak akses dari model HakAkses
            // mmasih mengambil seluruh data
            $menus = HakAkses::orderBy('id_akses')->get();

            // penampungan menu berdasarkan header
            $menuGroups = [];

            // Kelompokkan menu berdasarkan header
            foreach ($menus as $menu) {
                $menuGroups[$menu->header]['header'] = $menu->header;  // Set header
                $menuGroups[$menu->header]['menus'][] = [               // Set menu-item di bawah header
                    'text' => $menu->menu,
                    'url'  => $menu->url,
                    'icon' => $menu->icon,
                ];
            }

            // Tambahkan menu ke dalam sidebar berdasarkan grup menu
            foreach ($menuGroups as $group) {

                // Tambahkan header
                $event->menu->add([
                    'header' => $group['header'],
                ]);

                // Tambahkan menu-item
                foreach ($group['menus'] as $menuItem) {
                    $event->menu->add([
                        'text' => $menuItem['text'],
                        'url'  => $menuItem['url'],
                        'icon' => $menuItem['icon'],
                    ]);
                }
            }
        });
    }
}

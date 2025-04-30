<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\HakAkses;
use App\Models\RoleAkses;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            // Ambil data hak akses dari model HakAkses sesuai dengan role user yang sedang login
            $nim = Auth::user()->id_user;
            // $menus = RoleAkses::with('hakAkses')->orderBy('id_akses')->where('id_user', $nim)->get();
            $menus = User::with('roleAkses.hakAkses')->where('id_user', $nim)->first();

            // penampungan menu berdasarkan header
            $menuGroups = [];

            // Kelompokkan menu berdasarkan header
            foreach ($menus->roleAkses as $menu) {
                $menuGroups[$menu->hakAkses->header]['header'] = $menu->hakAkses->header;  // set header berdasarkan relasi hakAkses
                $menuGroups[$menu->hakAkses->header]['menus'][] = [               // Set menu-item berdasarkan relasi hakAkses
                    'text' => $menu->hakAkses->menu,
                    'url'  => $menu->hakAkses->url,
                    'icon' => $menu->hakAkses->icon,
                ];
            }

            // Tambahkan menu ke dalam sidebar berdasarkan grup menu
            foreach ($menuGroups as $group) {

                // Tambahkan header ke admin LTE
                $event->menu->add([
                    'header' => $group['header'],
                ]);

                // Tambahkan menu-item ke admin LTE
                foreach ($group['menus'] as $menuItem) {
                    $event->menu->add([
                        'text' => $menuItem['text'],
                        'url'  => $menuItem['url'],
                        'icon' => $menuItem['icon'],
                    ]);
                }
            }

            //  // menu untuk logout
            // $event->menu->add([
            //     'text' => 'Logout',
            //     'url' => 'logout',
            //     'icon' => 'fas fa-sign-out-alt'
            // ]);
        });
    }
}

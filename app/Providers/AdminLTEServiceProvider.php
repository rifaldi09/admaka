<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\RoleAkses;
use App\Models\User;
use App\Models\ViewMenusByRole;
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
           
            $role = Auth::user()->id_role;
           
            // $menus = RoleAkses::with('hakAkses')->orderBy('id_menu')->where('id_role', $role)->get();
            // $menus = User::with('roleAkses.hakAkses')->where('id_role',$role)->first();
            $menus = ViewMenusByRole::where('id_role',$role)->get();
            // dd( $menus);
            // penampungan menu berdasarkan header
            $menuGroups = [];

            // Kelompokkan menu berdasarkan header
            foreach ($menus as $menu) {
                $menuGroups[$menu->header]['header'] = $menu->header;  // set header berdasarkan relasi hakAkses
                $menuGroups[$menu->header]['menus'][] = [               // Set menu-item berdasarkan relasi hakAkses
                    'text' => $menu->menu,
                    'url'  => $menu->url,
                    'icon' => $menu->icon,
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

                    // Tambahkan menu-item ke admin LTE
                    $event->menu->add([
                        'text' => $menuItem['text'] ,
                        'url'  => $menuItem['url'],
                        'icon' => $menuItem['icon'],
                        // notofikasi menu sementara
                        'label' => '3'
                    ]);
                }
            }
        });
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\RoleAkses;
use App\Models\User;
use App\Models\Role;
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


    //! 100% chatGPT,  
    public function boot()
    {
        \Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $role = Auth::user()->id_role;
            $roleUser = \App\Models\Role::find($role);
        
            $menus = ViewMenusByRole::where('id_role', $role)->get();
        
            // Kelompokkan berdasarkan kelompok_menu (header AdminLTE)
            $groupedByKelompok = $menus->groupBy('kelompok_menu');
        
            foreach ($groupedByKelompok as $kelompok => $menusInKelompok) {
                // Tambahkan sebagai header AdminLTE
                $event->menu->add(['header' => $kelompok]);
        
                // Di dalam kelompok, kelompokkan berdasarkan header
                $groupedByHeader = $menusInKelompok->groupBy('header');
        
                // Inisialisasi single item holder
                $singleItems = [];
        
                foreach ($groupedByHeader as $header => $menuItems) {
                    if ($menuItems->count() > 1) {
                        // Jika lebih dari 1 menu → buat submenu
                        $submenu = [];
        
                        foreach ($menuItems as $menu) {
                            $submenu[] = [
                                'text' => $menu->menu,
                                'url'  => url(str_replace('{role}', $roleUser->name_role, $menu->url)),
                                'icon' => $menu->icon,
                            ];
                        }
        
                        $event->menu->add([
                            'text'    => $header,
                            'icon'    => 'fas fa-folder',
                            'submenu' => $submenu,
                        ]);
                    } else {
                        // Jika hanya satu menu → simpan dulu untuk ditambahkan nanti
                        $singleItems[] = $menuItems->first();
                    }
                }
       
                // Tambahkan semua menu tunggal setelah submenu
                foreach ($singleItems as $menu) {
                    $event->menu->add([
                        'text' => $menu->menu,
                        'url'  => url(str_replace('{role}', $roleUser->name_role, $menu->url)),
                        'icon' => $menu->icon,
                    ]);
                }
            }
        });
    }
}
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
            $roleUser = Role::where('id', $role)->first();
            $menus = ViewMenusByRole::where('id_role', $role)->get();


            $dashboardMenus = [];
            $groupedMenus = [];

            foreach ($menus as $menu) {
                if (strtolower($menu->header) === 'dashboard') {
                    // Masukkan ke menu Dashboard
                    $dashboardMenus[] = [
                        'text' => $menu->menu,
                        'url'  => $menu->url,
                        'icon' => $menu->icon,
                    ];
                } else {
                    // Kelompokkan berdasarkan header selain Dashboard
                    $groupedMenus[$menu->header][] = [
                        'text' => $menu->menu,
                        'url'  => url(str_replace('{role}', $roleUser->name_role, $menu->url)),
                        'icon' => $menu->icon,
                    ];
                }
            }

            // === 1. Tambahkan Header: Dashboard ===
            if (count($dashboardMenus) > 0) {
                $event->menu->add(['header' => 'Dashboard']);
                foreach ($dashboardMenus as $item) {
                    $event->menu->add($item);
                }
            }

            // === 2. Tambahkan Header Role ===
            if (count($groupedMenus) > 0) {
                $event->menu->add(['header' => $roleUser->name_role]);

                foreach ($groupedMenus as $group => $items) {
                    if (count($items) > 1) {
                        // Jika lebih dari satu item → submenu
                        $event->menu->add([
                            'text'    => $group,
                            'icon'    => 'fas fa-folder',
                            'submenu' => $items,
                        ]);
                    } else {
                        // Jika hanya satu item → simpan dulu untuk ditaruh di bawah
                        $singleItems[] = $items[0]; // simpan di array sementara
                    }
                }

                // Setelah semua submenu ditambahkan, baru tambahkan single item-nya
                if (!empty($singleItems)) {
                    foreach ($singleItems as $item) {
                        $event->menu->add($item); // ditaruh setelah semua submenu
                    }
                }
            }
        });
    }
}
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
            $user = Auth::user()->load('roles');

            if (!$user) {
                return;
            }

            $roles = $user->roles;
            $roleIds = $roles->pluck('id')->toArray();
            $roleMapping = $roles->pluck('name_role', 'id')->toArray();

            $menus = ViewMenusByRole::whereIn('id_role', $roleIds)->get();

            $groupedByKelompok = $menus->groupBy('kelompok_menu');

            foreach ($groupedByKelompok as $kelompok => $menusInKelompok) {
                // Tambahkan header utama AdminLTE
                $event->menu->add(['header' => $kelompok]);

                $groupedByHeader = $menusInKelompok->groupBy('header');

                $singleItems = [];

                foreach ($groupedByHeader as $header => $menuItems) {
                    if ($menuItems->count() > 1) {
                        // Jika ada lebih dari 1 menu, buat submenu dan subheader role
                        $submenu = [];

                        $menusByRole = $menuItems->groupBy('id_role');

                        foreach ($menusByRole as $roleId => $menusByThisRole) {
                            $roleName = $roleMapping[$roleId] ?? 'Role Tidak Dikenal';

                            $submenu[] = [
                                'text' => strtoupper($roleName),
                                'url' => '#',
                                'icon' => '',
                                'classes' => 'text-muted text-xs font-weight-bold px-3',
                                'escape' => false,
                            ];

                            foreach ($menusByThisRole as $menu) {
                                $submenu[] = [
                                    'text' => $menu->menu,
                                    'url'  => url(str_replace('{role}', $roleName, $menu->url)),
                                    'icon' => $menu->icon,
                                ];
                            }
                        }

                        $event->menu->add([
                            'text'    => $header,
                            'icon'    => 'fas fa-folder',
                            'submenu' => $submenu,
                        ]);
                    } else {
                        $singleItems[] = $menuItems->first();
                    }
                }

                foreach ($singleItems as $menu) {
                    $roleName = $roleMapping[$menu->id_role] ?? $roles->first()->name_role ?? '';

                    $event->menu->add([
                        'text' => $menu->menu,
                        'url'  => url(str_replace('{role}', $roleName, $menu->url)),
                        'icon' => $menu->icon,
                    ]);
                }
            }
        });
    }

}
<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\ViewRoleUserDetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataUser extends Controller
{
    public function index()
    {
        $dataUser = ViewRoleUserDetail::all();
        $user = auth()->user();
        $allRoles = Role::all();
        if (empty($dataUser)) {
            $dataUserFormatted = [];
        } else {
//             // Buat array dengan format yang diinginkan
//             $dataUserFormatted = $dataUser->map(function ($user) {

//                 // $btnEdit = '<button data-key="' . encrypt($user->id) . '" class="btn btn-sm btn-default text-primary update-user" id="updateUser" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                $token = csrf_token();
//                 $deleteUrl = route('destroy-user', encrypt($user->user_id));
//                 $btnDelete = '
//                     <form class="m-0 p-0" action="' . $deleteUrl . '" method="POST" enctype="multipart/form-data">
//                         <input type="hidden" name="_token" value="' . $token . '">
//                         <input type="hidden" name="_method" value="DELETE">
//                         <button class="btn btn-sm btn-default text-danger delete-user" title="Delete">
//                             <i class="fa fa-lg fa-fw fa-trash"></i>
//                         </button>
//                     </form>
//                 ';
// // dd($user->roles);
//                 // Mengembalikan data dalam bentuk array yang diinginkan
//                 return [
//                     'id_user' => $user->id_user,
//                     'nama_user' => $user->nama_user,
//                     'roles' => $user->roles->pluck('name_role')->implode(', '),
//                     // '<div class="d-flex gap-1">' . $btnDelete . '</div>', // gabungkan tombol
//                     // '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
//                 ];
//             })->toArray();
//         }
     // Gabungkan berdasarkan id_user
                $dataUserFormatted = $dataUser->groupBy('id_user')->map(function ($items, $id_user) use ($token) {
                $first = $items->first();
                $user = auth()->user();
                //  $btnEdit = '<button data-key="' . encrypt($first->role_user_id) . '" class="btn btn-sm btn-default text-primary update-role-user" id="updateRoleUser" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                //$btnEdit = '<button data-key="' . encrypt($first->role_user_id) . '" class="btn btn-sm btn-default text-primary update-role-user" id="updateRoleUser" data-id="' . $first->user_id . '" title="Edit" data-bs-toggle="modal" data-bs-target="#editRoleModal"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                $btnEdit ='<x-adminlte-button data-key="' . encrypt($first->role_user_id) . '" label="Open Modal" data-toggle="modal" data-target="#modalUpdateRoleUser" class="btn btn-sm btn-default text-primary update-role-user" data-id="' . $first->user_id . '" title="Edit"/> <i class="fa fa-lg fa-fw fa-pen"></i></x-adminlte-button>';
                // Tombol hapus
                $deleteUrl = route('destroy-user', encrypt($first->user_id));
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-default text-danger delete-user" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </form>
                ';
                if ($user->roles->contains('name_role', 'Super-Administrator')){
                    return [
                            'id_user'    => $id_user,
                            'nama_user'  => $first->nama_user,
                            'roles'      => $items->pluck('name_role')->unique()->implode(', '),
                            'aksi'       => '<div class="d-flex gap-1">' .$btnEdit . $btnDelete . '</div>',
                    ];    
                }else if ($user->roles->contains('name_role', 'Administrator')){
                    return [
                            'id_user'    => $id_user,
                            'nama_user'  => $first->nama_user,
                            'roles'      => $items->pluck('name_role')->unique()->implode(', '),
                            // 'aksi'       => '<div class="d-flex gap-1">' . $btnDelete . '</div>',
                    ];
                }
               
            })->values()->toArray();
        }
        return view('admin.data-master.data-user', compact('dataUser', 'dataUserFormatted','allRoles'));
    }

    // public function storeProdi(Request $request)
    // {
    //     // validasi input
    //     $validasi = $request->validate([
    //         'nama' => 'required|string|min:3|max:255',
    //     ]);

    //     try {
    //         // Simpan ke database
    //         Prodi::create($validasi);

    //         // Jika berhasil
    //         return redirect()->route('data-prodi')->with('success', 'Data Prodi berhasil ditambahkan');
    //     } catch (QueryException $e) {
    //         // Log error untuk debugging
    //         Log::error('Gagal menambahkan data prodi: ' . $e->getMessage());

    //         // Redirect balik dengan error message
    //         return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Prodi. Silakan coba lagi.');
    //     }
    // }

    public function updateUser($id)
    {
        $user = User::where('id', decrypt($id))->first();

        if (!$user) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $user->key = $id;
        return response()->json($user);
    }

    public function updatedataUser(Request $request, $id)
    {
        try {
            $user = User::where('id', decrypt($id))->firstOrFail();
            // Validasi input
            $validasi = $request->validate([
                'id_user' => 'required',
            ]);

            // Lakukan update
            $updated = $user->update($validasi);

            if (!$updated) {
                return redirect()->back()->with('error', 'Gagal memperbarui data user.');
            }
            return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Gagal update prodi: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        } catch (\Exception $e) {
            Log::error('Kesalahan umum saat update user: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Data user tidak ditemukan atau terjadi error.');
        }
    }

    public function destroyUser($id)
    {
        // ambil id prodi dari request
        $user_id = decrypt($id);

        try {
            // hapus user
            User::where('id', $user_id)->delete();

            // Jika berhasil
            return redirect()->route('data-user')->with('success', 'Data User berhasil dihapus');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menghapus data user: ' . $e->getMessage());

            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data user. Silakan coba lagi.');
        }
    }

    public function getRoles($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json([
            'roles' => $user->roles->pluck('id')->toArray()
        ]);
    }

    public function updateRoles(Request $request, $id)
    {
        $request->validate([
            'roles' => 'array|exists:role,id'
        ]);

        $user = User::findOrFail($id);
        $user->roles()->sync($request->roles);

        return redirect()->back()->with('success', 'Roles diperbarui.');
    }
}
<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class DataDosen extends Controller
{
    public function index()
    {
        $dataDosen = Dosen::all();

        // Cek data dosen
        if (empty($dataDosen)) {
            $dataDosenFormatted = [];
        } else {
            // Buat array dengan format yang diinginkan
            $dataDosenFormatted = $dataDosen->map(function ($dosen) {

                // Button edit, delete, dan details bisa kamu sesuaikan dengan route atau URL yang sesuai
                $btnEdit = '<button data-key="' . encrypt($dosen->nidn) . '" class="btn btn-sm btn-default text-primary update-mhs" id="updateMhs" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                // $btnDelete = '<button class="btn btn-sm btn-default text-danger  " title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>';
                $token = csrf_token();
                $deleteUrl = route('destroy-dosen', encrypt($dosen->nidn));
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-default text-danger delet-dosen" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </form>
                ';
                // $btnDetails = '<button class="btn btn-sm btn-default text-teal  " title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></button>';

                // Mengembalikan data dalam bentuk array yang diinginkan
                return [
                    $dosen->nidn,
                    $dosen->nip,
                    $dosen->nama,
                    $dosen->email,
                    $dosen->no_hp,
                    '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
                ];
            })->toArray();
        }
        return view('admin.data-master.data-dosen', compact('dataDosen', 'dataDosenFormatted'), ['titleHeader' => 'Data Dosen']);
    }
}

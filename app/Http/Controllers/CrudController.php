<?php

namespace App\Http\Controllers;

use App\Anggota;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CrudController extends Controller
{
    // Menampilkan halaman form
    public function create()
    {
      // Mengambil parameter "name" dari url
      $id = Input::get('name');
      // Mengecek apakah alamat url ada parameter, jika "Y" tampikan form dengan isi dari file txt
      if ($id){
        // Mengambil isi data dengan file name yang sama dengan parameter
        $isi = Storage::get($id);
        // Data yang sudah diambil masih dalam bentuk single string, maka harus diubah menjadi beberpa string dan disimpan dalam array
        $data = explode(", ", $isi);
        // Data tanggal masih dalam format "DD-MM-YYY" harus dirubah format agar sesuai dengan format default text type=date "YYYY-MM-DD"
        $datatgl = explode("-", $data[2]);
        $count = count($datatgl);
        $tgl = "";
        for($i = $count - 1; $i >= 0; $i--)
        {
          if($i>0)
          {
            $tgl = $tgl.$datatgl[$i]."-";
          } else
          {
            $tgl = $tgl.$datatgl[$i];
          }
        }
        // Merubah isi $data index 2 dengan tanggal yang sudah dirubah format
        $data[2] = $tgl;
        // Menampilkan halaman dengan $data yang telah siap ditampilkan di view
        return view('form.unggah')->with('data', $data);
      } else {
        // Jika alamat url tidak terdapat paramaeter "name" maka form akan kosong
        $data = ["", "", "", ""];
        return view('form.unggah')->with('data', $data);
      }
    }

    public function submit(Request $request)
    {
      // Validasi isi form, jika tidak lengkap maka error dan ditampilkan di halaman
      $anggota = $this->validate(request(), [
        'nama' => 'required',
        'email' => 'required',
        'tgl_lahir' => 'required|date',
        'alamat' => 'required'
      ]);

      // Insert data dari form ke database
      //Anggota::create($anggota);

      // Mengambil data dari form
      $nama = $request->nama;
      $email = $request->email;
      $tanggal = $request->tgl_lahir;
      $alamat = $request->alamat;

      // Merubah format tanggal dari y-m-d ke d-m-y
      $tgl = strtotime($tanggal);
      $tgl_lahir = date("d-m-Y", $tgl);

      // Membuat template isi file yang akan diciptakan
      $isifile = $nama.', '.$email.', '.$tgl_lahir.', '.$alamat;

      // Membuat template nama file nama-tanggaljamcreate.txt
      $namafile1 = $nama.'-'.date('dmYhis').'.txt';
      $namafile2 = strtolower($namafile1);
      $namafile = str_replace(" ", "", $namafile2);

      // Isi pesan sukses upload
      $isipesan = 'Data telah tersimpan. Terimakasih telah mengisi form. Data anda disimpan di "crud\storage\app\ '.$namafile.'"';

      /* mengambil data  dari database yang paling terakhir diinputkan
      $anggota = Anggota::orderBy('created_at', 'desc')->take(1)->get();

      // Data dari database dipindah ke variable $item untuk dapat diolah
      foreach ($anggota as $item)
      {
        // Merubah format tanggal dari y-m-d ke d-m-y
        $tgl = strtotime($item['tgl_lahir']);
        $tgl_lahir = date("m-d-Y", $tgl);

        // Membuat template isi file yang akan diciptakan
        $isifile = $item['nama'].', '.$item['email'].
                   ', '.$tgl_lahir.', '.$item['alamat'];

        // Membuat template nama file nama-tanggaljamcreate.txt
        $namafile = $item['nama'].'-'.date('dmYhis').'.txt';
      } */

      // Create file txt sesuai format dan disimpan di crud\storage\app
      Storage::put($namafile, $isifile);

      // Setelah berhasil insert data dan create file, halaman kembali ke halaman awal dan menampilkan pesan sukses
      return back()->with('berhasil', $isipesan);
    }

    // fungsi reset
    public function reset()
    {
      return back();
    }
}

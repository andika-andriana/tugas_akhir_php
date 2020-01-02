<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\tbl_biodata;
use Illuminate\Support\Facades\DB;

class Biodata extends Controller
{
  public function baca(){
    $data = DB::table('tbl_biodata')->get();
    if(count($data) > 0){
      $res['status'] = "Sukses";
      $res['message'] = "Data Berhasil Dibaca";
      $res['value'] = $data;
      return response($res);
    }else{
      $res['status'] = "Sukses";
      $res['message'] = "Data Kosong";
      return response($res);
    }
  }

  public function simpan(Request $request){
    $this->validate($request, [
      'file' => 'required|max:2048'
    ]);
    // menyimpan data file yang diupload ke variable $file
    $file = $request->file('file');
    $nama_file = time()."_".$file->getClientOriginalName();
    // isi dengan nama folder tempat kemana file diupload
    $tujuan_upload = 'data_file';
    if($file->move($tujuan_upload,$nama_file)){
      $data = tbl_biodata::create([
        'nama' => $request->nama,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'hobi' => $request->hobi,
        'foto' => $nama_file
      ]);
      $res['status'] = "Sukses";
      $res['message'] = "Data Berhasil Disimpan";
      $res['values'] = $data;
      return response($res);
    }
  }

  public function ubah(Request $request){
    if(!empty($request->file)){
    $this->validate($request, [
      'file' => 'required|max:2048'
    ]);
      // menyimpan data file yang diupload ke variable $file
      $file = $request->file('file');
      $nama_file = time()."_".$file->getClientOriginalName();
      // isi dengan nama folder tempat kemana file diupload
      $tujuan_upload = 'data_file';
      $file->move($tujuan_upload,$nama_file);
      // mengambil data spesifik by id
      $data = DB::table('tbl_biodata')->where('id',$request->id)->get();
      foreach($data as $biodata){
        @unlink(public_path('data_file/'.$biodata->foto));
        $ket = DB::table('tbl_biodata')->where('id',$request->id)->update([
          'nama' => $request->nama,
          'no_hp' => $request->no_hp,
          'alamat' => $request->alamat,
          'hobi' => $request->hobi,
          'foto' => $nama_file
        ]);
        $res['status'] = "Sukses";
        $res['message'] = "Data Berhasil Diperbaharui";
        $res['values'] = $ket;
        return response($res);
      }
    }else{
      $data = DB::table('tbl_biodata')->where('id',$request->id)->get();
      foreach($data as $biodata){
        $ket = DB::table('tbl_biodata')->where('id',$request->id)->update([
          'nama' => $request->nama,
          'no_hp' => $request->no_hp,
          'alamat' => $request->alamat,
          'hobi' => $request->hobi
        ]);
        $res['status'] = "Sukses";
        $res['message'] = "Data Berhasil Diperbaharui (Data Saja)";
        $res['values'] = $ket;
        return response($res);
      }
    }
  }
  public function hapus($id){
    $data = DB::table('tbl_biodata')->where('id',$id)->get();
    foreach($data as $biodata){
      $image_path = 'http://localhost/APIREST/public' .$biodata->foto;
      if(file_exists(public_path('data_file/'.$biodata->foto))){
        @unlink(public_path('data_file/'.$biodata->foto));
        DB::table('tbl_biodata')->where('id',$id)->delete();
        $res['status'] = "Sukses";
        $res['message'] = "Data Berhasil Dihapus";
        return response($res);
      }else{
        $res['status'] = "Gagal";
        $res['message'] = "Data Tidak Ditemukan";
        return response($res);
      }
    }
  }

  public function bacaDetail($id){
    $data = DB::table('tbl_biodata')->where('id',$id)->get();
    if(count($data) > 0){
      $res['status'] = "Sukses";
      $res['message'] = "Detail Berhasil Ditampilkan";
      $res['value'] = $data;
      return response($res);
    }else{
      $res['status'] = "Gagal";
      $res['message'] = "Data Tidak Ditemukan";
      return response($res);
    }
  }
}

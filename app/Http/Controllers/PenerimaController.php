<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penerima;
use App\ProfilIkm;
use App\User;
use App\DataEvaluasi;
use App\DataKriteria;
use App\Kriteria;
use Auth;
use Yajra\Datatables\Datatables;

class PenerimaController extends Controller
{
  public function show()
  {


    // dd($penerima);

    return view('admin.penerima.penerima');
  }

  public function lihatEvaluasi($id, $tahun)
  {
    //join dengan data_kriterias dan data_evaluasis

    $dataKriteria = DataKriteria::join('kriterias', 'kriterias.id', '=', 'data_kriterias.id_kriteria')
                  ->where('id_user', '=', $id)
                  -> where('tahun', '=', $tahun)
                  -> get();

    $dataEvaluasi = DataEvaluasi::join('kriterias', 'kriterias.id', '=', 'data_evaluasis.id_kriteria')
                  -> where('id_user', '=', $id)
                  -> where('tahun', '=', $tahun)
                  -> get();

    $user = User::findOrFail($id);


    //Data2 dalam chart
    $category = [];

  	$series0[0]['name'] = 'Sebelum';
  	$series0[1]['name'] = 'Sesudah';

    $series1[0]['name'] = 'Sebelum';
  	$series1[1]['name'] = 'Sesudah';

    $series2[0]['name'] = 'Sebelum';
  	$series2[1]['name'] = 'Sesudah';

    $series3[0]['name'] = 'Sebelum';
  	$series3[1]['name'] = 'Sesudah';

    $series4[0]['name'] = 'Sebelum';
  	$series4[1]['name'] = 'Sesudah';

    $series5[0]['name'] = 'Sebelum';
  	$series5[1]['name'] = 'Sesudah';

    // $i = 0;
    // for ($i=0; $i < $dataKriteria->count(); $i++) {
    //   $category[] = $dataKriteria[$i]->nama;
    //   // $series0[0]['data'][] = $dataKriteria[$i]->nilai;
    //   $series0[0]['data'][] = (float)$dataKriteria[$i]->nilai;
    // }
    //
    // for ($i=0; $i < $dataEvaluasi->count(); $i++) {
    //   $series0[1]['data'][] = (float)$dataEvaluasi[$i]->nilai;
    // }

    $series0[0]['data'][] = (float)$dataKriteria[0]->nilai;
    $series0[1]['data'][] = (float)$dataEvaluasi[0]->nilai;

    $series1[0]['data'][] = (float)$dataKriteria[1]->nilai;
    $series1[1]['data'][] = (float)$dataEvaluasi[1]->nilai;

    $series2[0]['data'][] = (float)$dataKriteria[2]->nilai;
    $series2[1]['data'][] = (float)$dataEvaluasi[2]->nilai;

    $series3[0]['data'][] = (float)$dataKriteria[3]->nilai;
    $series3[1]['data'][] = (float)$dataEvaluasi[3]->nilai;

    $series4[0]['data'][] = (float)$dataKriteria[5]->nilai;
    $series4[1]['data'][] = (float)$dataEvaluasi[5]->nilai;

    $series5[0]['data'][] = (float)$dataKriteria[6]->nilai;
    $series5[1]['data'][] = (float)$dataEvaluasi[6]->nilai;

    // dd( $dataKriteria->count());

    return view('admin.evaluasi.evaluasi', ['dataKriteria' => $dataKriteria], ['dataEvaluasi' => $dataEvaluasi])->with('user', $user)->with('category', $category)->with('series0', $series0)
    ->with('series1', $series1)
    ->with('series2', $series2)
    ->with('series3', $series3)
    ->with('series4', $series4)
    ->with('series5', $series5);
  }

  public function createPerangkingan(Request $request)
  {
    // $dataEval = DataEvaluasi::all();
    // dd($dataEval);

    //membuat data evaluasi kosong yang natinya bisa diedit oleh pelaku IKM
    $kriteria = Kriteria::all();
    $jumlahKriteria = $kriteria -> count();
    $idIkm = $request->user_id;
    // dd($idIkm);
    foreach ($kriteria as $key => $krit) {
      $name = $krit -> id;
      // dd($request -> $name);
      $dataEvaluasi = DataEvaluasi::create([
          'id_user' =>  $idIkm,
          'id_kriteria' => $krit->id,
          'nilai' => 0,
          'tahun' => $request->tahun,
        ]);
    }

    // dd('masuk data');

    $user_tahun = $request->user_id.$request->tahun;

    $user = User::findOrFail($request->user_id);

    $profilIkm = User::join('profilikm', 'profilikm.user_id', '=', 'users.id')
                ->select('profilikm.id AS idIkm')
                ->findOrFail($request->user_id);

    $profilId = $profilIkm -> idIkm;
    // dd($profilId);
    $profil = ProfilIkm::findOrFail($profilId);

    $profil -> update([
      'status' => 1,
    ]);

    // dd($user_tahun);
    $data = Penerima::create([
      'user_id' => $request->user_id,
      'user_tahun' => $user_tahun,
      'komoditi_id' => $request -> komoditi_id,
      'tahun' => $request -> tahun,
    ]);

    // dd('BERHASIL');

    return $data;
  }



  //-> API untuk menampilkan data peralatan IKM
  public function apiPenerima()
  {

    $penerima = Penerima::
                   join('users', 'penerimas.user_id', '=', 'users.id')
                // -> join('komoditis', 'penerimas.user_id', '=', 'komoditis.id')
                -> select('penerimas.*', 'users.name')
                -> get();

    // dd($penerima);


    return Datatables::of($penerima)
      -> addColumn('action', function($penerima){
        return '
          <a onclick="deleteData(' . $penerima-> id . ', ' . $penerima-> user_id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</a>
          <a href="/penerima/' . $penerima-> user_id . '/' . $penerima-> tahun . '" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i>Evaluasi</a>
          <a href="/ikm/show/' . $penerima-> user_id . '" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i>Show</a>
        ';
      })
      ->make(true);
  }




  public function destroy($id, $idUser)
  {
    // dd($profilId);
    $user = User::findOrFail($idUser);


    $profilIkm = User::join('profilikm', 'profilikm.user_id', '=', 'users.id')
                ->select('profilikm.id AS idIkm')
                ->findOrFail($idUser);

    $profilId = $profilIkm -> idIkm;


    $profil = ProfilIkm::findOrFail($profilId);

    //hapus juga data evaluasinya
    $dataEvaluasi = DataEvaluasi::
                    where('id_user', '=', $idUser)
                  ->get();

    foreach ($dataEvaluasi as $key => $krit) {
      // dd($request -> idData);
      $name = $krit -> nama;
      $dataKrito = DataEvaluasi::destroy($krit -> id);
    }

    $profil -> update([
      'status' => 0,
    ]);

    Penerima::destroy($id);
  }
}

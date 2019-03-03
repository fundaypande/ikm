<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NilaiProduksi;
use App\ProfilIkm;
use App\User;
use Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Token;

class ProduksiController extends Controller
{
    public function welcome()
    {
      $produksis = NilaiProduksi::paginate(10);

      return view('welcome', ['produksis' => $produksis]);
    }


    public function showProduksi($id)
    {
      $idUser = null;
      $idUser = User::findOrFail($id);

      return view('ikm.produksi.produksi', ['idUser' => $idUser]);
    }



// *** For HALAMAN DEPAN
    public function showRandom()
    {
      $produksis = NilaiProduksi::inRandomOrder()->paginate(10);

      return view('public.showProduksi', ['produksis' => $produksis], ['cari' => null]);
    }

    public function search(Request $request)
    {
      $search = $request -> cari;
      $produksis = NilaiProduksi::inRandomOrder()
                  ->Where('jenis_produksi', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->paginate(10);
      return view('public.showProduksi', ['produksis' => $produksis], ['cari' => $search])->with('notif', 'Hasil Pencarian "'. $search . '"');;
    }

    public function showOne($id)
    {
      // $produksi = NilaiProduksi::findOrFail($id);

      $produksi = NilaiProduksi::join('users', 'users.id', '=', 'nilai_produksis.user_id')
                  -> join('profilikm', 'profilikm.user_id', '=', 'users.id')
                  -> select('nilai_produksis.*', 'users.photo AS user_photo', 'profilikm.*', 'profilikm.id AS id_profilikm')
                  -> findOrFail($id);
      // dd($produksi);

      return view('public.showOne', ['produksi' => $produksi]);
    }

    public function showProdusen($id)
    {
      $datas = ProfilIkm::findOrFail($id);

      $userId = $datas -> user_id;

      $produksi = NilaiProduksi::Where('user_id', '=', $userId)
                  -> paginate(10);

      $totalProduksi = NilaiProduksi::Where('user_id', '=', $userId)
                  ->count();


      return view('public.showProdusen', ['data' => $datas], ['produksis' => $produksi], ['totalProduksi' => $totalProduksi]);
    }

// *** END For HALAMAN DEPAN








    //-> API untuk menampilkan data produksi IKM
    public function apiProduksi($id)
    {
      $idUser = $id;
      $staf = NilaiProduksi::where('user_id', '=', $idUser)->get();


      return Datatables::of($staf)
        -> addColumn('action', function($staf){
          return '
            <a onclick="showData(' . $staf-> id . ')" class="btn btn-info btn-xs"><i class="fa fa-eye"></i>Show</a>
            <a href="/produksi/' . $staf-> id . '/edit" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
            <a onclick="deleteData(' . $staf-> id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</a>
          ';
        })
        -> addColumn('photos', function($staf){
          if(!$staf->photo) $photo = '/images/user.png'; else $photo = '/images/produksi/'.$staf->photo;
          return '
            '.$photo.'
          ';
        })
        -> addColumn('ket', function($staf){
          $deskripsi = $staf-> deskripsi;
          $deskripsi = substr($deskripsi, 0, 40);
          if (strlen($deskripsi) > 39) {
            $deskripsi = $deskripsi . "[...]";
          }

          return $deskripsi;
        })
        ->make(true);
    }

    public function edit($id)
    {
      $produksi = NilaiProduksi::findOrFail($id);

      return view('ikm.produksi.updateProduksi', compact('produksi'));
    }

    public function update(Request $request, $id)
    {
      $produksi = NilaiProduksi::findOrFail($id);

      $this -> validate($request, [
              'jenis_produksi' => 'required|min:1',
              'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              'jumlah' => 'required|min:1|numeric',
              'harga' => 'required|min:1|numeric',
              'nilai_penjualan' => 'required|min:1|numeric',
            ]);

      $input = $request->gambar;
      if($input){
        $input = time().'.'.$request->gambar->getClientOriginalExtension();
        $request->gambar->move('images/produksi/', $input);
        $oldPic = $produksi -> photo;
        if($oldPic != null){
          $image_path = 'images/produksi/'.$oldPic;
          if(file_exists($image_path)){
              unlink($image_path); //unlink untuk menghapus foto lama pada saat proses create and store
          }
        }
        $produksi->update([
          'photo' => $input,
        ]);
      }



      $hasil = $produksi->update([
        'jenis_produksi' => $request -> jenis_produksi,
        'jumlah' => $request -> jumlah,
        'merk_produk' => $request -> merk_produk,
        'harga' => $request -> harga,
        'nilai_penjualan' => $request -> nilai_penjualan,
        'tujuan' => $request -> tujuan,
        'deskripsi' => $request -> deskripsi,
        'tahun' => $request -> get('tahun'),
      ]);

      return back()->with('status', 'Berhasil mengedit data produksi');
    }

    //--> mengambil data untuk kita edit
    public function formEdit($id)
    {
      return $peralatan = NilaiProduksi::find($id);
    }



    public function store2(Request $request, $id)
    {
      $idUser = User::findOrFail($id);
      $this -> validate($request, [
              'jenis_produksi' => 'required|min:1',
              'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              'jumlah' => 'required|min:1|numeric',
              'harga' => 'required|min:1|numeric',
              'nilai_penjualan' => 'required|min:1|numeric',
            ]);


      $input = $request->photo;
      if($input){
        $input = time().'.'.$request->photo->getClientOriginalExtension();
        $request->photo->move('images/produksi/', $input);
      }
      else {
        $input = null;
      }

      $hasil = NilaiProduksi::create([
        'user_id' => $idUser->id,
        'jenis_produksi' => $request -> jenis_produksi,
        'jumlah' => $request -> jumlah,
        'merk_produk' => $request -> merk_produk,
        'harga' => $request -> harga,
        'nilai_penjualan' => $request -> nilai_penjualan,
        'tujuan' => $request -> tujuan,
        'deskripsi' => $request -> deskripsi,
        'photo' => $input,
        'tahun' => $request -> get('tahun'),
      ]);

      return redirect('/produksi/'.$idUser->id)->with('status', 'Berhasil menambahkan produksi baru');
    }

    public function showCreate($id)
    {
      $idUser = User::findOrFail($id);

      return view('ikm.produksi.createProduksi', ['idUser' => $idUser]);
    }

    public function destroy($id)
    {
        NilaiProduksi::destroy($id);
    }


}

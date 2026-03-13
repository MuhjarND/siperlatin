<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TransaksiPerawatanController extends Controller
{
    public function index()
    {
        $detailBarang = DB::table("tb_detail_barang")
        ->select(
            "tb_detail_barang.id AS id_detail_barang",
            "tb_detail_barang.tgl_perolehan",
            "tb_detail_barang.harga_perolehan",
            "tb_detail_barang.id_barang",
            "tb_detail_barang.foto",
            "tb_detail_barang.kode AS kode_detail_barang",
            "tb_detail_barang.nama AS nama_detail_barang",
            "tb_barang.kode AS kode_barang",
            "tb_barang.nama AS nama_barang"
        )
        ->join("tb_barang", "tb_detail_barang.id_barang", "=", "tb_barang.id")
        ->orderBy("tb_barang.nama")
        ->orderBy("tb_detail_barang.kode")
        ->get();

        $totalPerBarang = DB::table("tb_transaksi")
        ->select("id_barang", DB::raw("SUM(nominal) AS total"))
        ->groupBy("id_barang")
        ->pluck("total", "id_barang");

        $totalPerSubBarang = DB::table("tb_transaksi")
        ->select("id_sub_barang", DB::raw("SUM(nominal) AS total"))
        ->groupBy("id_sub_barang")
        ->pluck("total", "id_sub_barang");

        $barangGroups = $detailBarang
        ->groupBy("id_barang")
        ->map(function ($items, $idBarang) use ($totalPerBarang, $totalPerSubBarang) {
            $first = $items->first();

            return (object) [
                "id_barang" => $idBarang,
                "kode" => $first->kode_barang,
                "nama" => $first->nama_barang,
                "grand_total" => (float) ($totalPerBarang[$idBarang] ?? 0),
                "detail_count" => $items->count(),
                "details" => $items->map(function ($item) use ($totalPerSubBarang) {
                    return (object) [
                        "id_detail_barang" => $item->id_detail_barang,
                        "kode_detail_barang" => $item->kode_detail_barang,
                        "nama_detail_barang" => $item->nama_detail_barang,
                        "subtotal" => (float) ($totalPerSubBarang[$item->id_detail_barang] ?? 0),
                        "is_orphan" => false,
                    ];
                })->values(),
            ];
        });

        $orphanTransactions = DB::table("tb_transaksi")
        ->leftJoin("tb_detail_barang", "tb_detail_barang.id", "=", "tb_transaksi.id_sub_barang")
        ->join("tb_barang", "tb_barang.id", "=", "tb_transaksi.id_barang")
        ->whereNull("tb_detail_barang.id")
        ->select(
            "tb_transaksi.id_barang",
            "tb_barang.kode AS kode_barang",
            "tb_barang.nama AS nama_barang",
            "tb_transaksi.id_sub_barang",
            DB::raw("SUM(tb_transaksi.nominal) AS subtotal"),
            DB::raw("COUNT(tb_transaksi.id) AS transaksi_count")
        )
        ->groupBy(
            "tb_transaksi.id_barang",
            "tb_barang.kode",
            "tb_barang.nama",
            "tb_transaksi.id_sub_barang"
        )
        ->orderBy("tb_barang.nama")
        ->get();

        foreach ($orphanTransactions as $orphan) {
            if (!$barangGroups->has($orphan->id_barang)) {
                $barangGroups->put($orphan->id_barang, (object) [
                    "id_barang" => $orphan->id_barang,
                    "kode" => $orphan->kode_barang,
                    "nama" => $orphan->nama_barang,
                    "grand_total" => (float) ($totalPerBarang[$orphan->id_barang] ?? 0),
                    "detail_count" => 0,
                    "details" => collect(),
                ]);
            }

            $group = $barangGroups->get($orphan->id_barang);
            $group->details = $group->details->push((object) [
                "id_detail_barang" => null,
                "kode_detail_barang" => "ID hilang #" . $orphan->id_sub_barang,
                "nama_detail_barang" => "Sub barang tidak ditemukan",
                "subtotal" => (float) $orphan->subtotal,
                "is_orphan" => true,
            ])->values();
            $group->detail_count = $group->details->count();
            $barangGroups->put($orphan->id_barang, $group);
        }

        $barangGroups = $barangGroups
        ->sortBy("nama", SORT_NATURAL | SORT_FLAG_CASE)
        ->values();

        $baris = $barangGroups->count();

        return view("transaksi_perawatan/index", compact("barangGroups", "baris"));
    }

    public function detail($id_detail_barang){
        $table=DB::table("tb_detail_barang")
        ->where("tb_detail_barang.id",$id_detail_barang)
        ->select(
            "tb_detail_barang.nama AS nama_detail_barang", 
            "tb_barang.nama AS nama_barang", 
            "tb_detail_barang.kode AS kode_detail_barang", 
            "tb_detail_barang.keterangan",
            "tb_detail_barang.foto", 
            "tb_detail_barang.harga_perolehan",
            "tb_detail_barang.tgl_perolehan",
            "tb_detail_barang.id_kondisi_barang",
            "tb_kondisi_barang.nama AS kondisi_barang",
            "tb_brand.nama_brand AS brand",
            "tb_satuan_barang.nama_satuan",
            "tb_ruang.nama_ruang")
        ->join("tb_barang", "tb_detail_barang.id_barang","=","tb_barang.id")
        ->leftJoin('tb_ruang', 'tb_detail_barang.ruang', '=','tb_ruang.id')
        ->leftJoin('tb_kondisi_barang', 'tb_detail_barang.id_kondisi_barang', '=','tb_kondisi_barang.id')
        ->leftJoin('tb_satuan_barang', 'tb_detail_barang.satuan', '=','tb_satuan_barang.id')
        ->leftJoin('tb_brand', 'tb_detail_barang.brand', '=','tb_brand.id')
        ->first();

        $transaksi = DB::table("tb_transaksi")
        ->select("tb_transaksi.id as kode_transaksi","tb_transaksi.tanggal","tb_transaksi.file_name","tb_transaksi.nominal","tb_transaksi.nominal","tb_transaksi.keterangan")
        ->where("id_sub_barang",$id_detail_barang)
        ->get();

        $total = $transaksi->sum("nominal");

        $count = $transaksi->count();

        return view("transaksi_perawatan/detail", compact("table","transaksi","count","id_detail_barang","total"));
    }

    public function tambah_transaksi($id_detail_barang){
        $tb = DB::table("tb_detail_barang")
        ->select("id_barang")
        ->where("id",$id_detail_barang)
        ->first();

        $tb_barang = DB::table("tb_barang")
        ->where("tb_barang.id","=",$tb->id_barang)
        ->select("tb_barang.id","tb_barang.nama as nama_barang")
        ->first();

        $tb_detail_barang=DB::table("tb_detail_barang")
        ->select("id","kode","nama")
        ->where("id",$id_detail_barang)
        ->first();

        return view("transaksi_perawatan/new_transaksi", compact("id_detail_barang","tb_barang","tb_detail_barang"));
    }

    public function simpan_transaksi(Request $request, $id_detail_barang){
        $fileName = time().'.'.$request->lampiran->extension();
        
        $tujuan_upload = storage_path('files');
        $request->lampiran->move($tujuan_upload, $fileName);

        DB::table("tb_transaksi")
        ->insert([
            "id_barang"=>$request->barang,
            "id_sub_barang"=>$request->sub_barang,
            "tanggal"=>$request->tanggal,
            "keterangan"=>$request->keterangan,
            "nominal"=>$request->nominal,
            "file_name"=>$fileName
        ]);
        return redirect()->route("transaksi_perawatan.detail",["id_detail_barang"=>$id_detail_barang])->with('success','Data successfuly saved');;
    }

    public function edit($id_transaksi, $id_detail_barang){

        $tb_transaksi = DB::table("tb_transaksi")
        ->where("tb_transaksi.id",$id_transaksi)
        ->select("tb_transaksi.id as kode_transaksi","tb_transaksi.tanggal","tb_transaksi.nominal","tb_transaksi.nominal","tb_transaksi.keterangan","tb_barang.nama as nama_barang", "tb_detail_barang.nama as nama_sub_barang", "tb_detail_barang.id_barang", "tb_detail_barang.id AS id_sub_barang")
        ->join("tb_barang","tb_transaksi.id_barang","=","tb_barang.id")
        ->join("tb_detail_barang","tb_transaksi.id_sub_barang","=","tb_detail_barang.id")
        ->first();

        $tb_barang = DB::table("tb_barang")
        ->where("tb_detail_barang.id", $id_detail_barang)
        ->select("tb_barang.id AS id_barang","tb_barang.nama as nama_barang")
        ->join("tb_detail_barang","tb_barang.id","=","tb_detail_barang.id_barang")
        ->first();

        $tb_detail_barang = DB::table("tb_detail_barang")
        ->select("nama","id","kode")
        ->where("id_barang", $tb_transaksi->id_barang)
        ->first();

        return view("transaksi_perawatan/edit", compact("tb_barang", "tb_transaksi", "tb_detail_barang","id_transaksi","id_detail_barang"));
    }

    public function update(Request $request, $id_transaksi, $id_detail_barang){
        if($request->hasFile("lampiran")){
            $exist = DB::table("tb_transaksi")
            ->where("id",$id_transaksi)
            ->select("file_name")
            ->first();

            if(file_exists(storage_path().'/files/'.$exist->file_name)){
                $previous_file = DB::table("tb_transaksi")
                ->where("id",$id_transaksi)
                ->select("file_name")
                ->first();
                //delete previous file
                unlink(storage_path('files/'.$previous_file->file_name));
            }

            $fileName = time().'.'.$request->lampiran->extension();
        
            $tujuan_upload = storage_path('files');
            $request->lampiran->move($tujuan_upload, $fileName);

            DB::table("tb_transaksi")
            ->where("id",$id_transaksi)
            ->update([
                "tanggal"=>$request->tanggal,
                "keterangan"=>$request->keterangan,
                "nominal"=>$request->nominal,
                "file_name"=>$fileName
            ]);
        }else{
            DB::table("tb_transaksi")
            ->where("id",$id_transaksi)
            ->update([
                "tanggal"=>$request->tanggal,
                "keterangan"=>$request->keterangan,
                "nominal"=>$request->nominal
            ]);
        }

        return redirect()->route("transaksi_perawatan.detail",["id_detail_barang"=>$id_detail_barang])->with('success','Data successfuly updated');;
    }

    public function delete($id_transaksi, $id_detail_barang){
        $exist = DB::table("tb_transaksi")
        ->where("id",$id_transaksi)
        ->select("file_name")
        ->first();

        if(file_exists(storage_path().'/files/'.$exist->file_name)){
            $previous_file = DB::table("tb_transaksi")
            ->where("id",$id_transaksi)
            ->select("file_name")
            ->first();
            //delete related file
            unlink(storage_path('files/'.$previous_file->file_name));
        }

        DB::table("tb_transaksi")
        ->where("id",$id_transaksi)
        ->delete();

        return redirect()->route("transaksi_perawatan.detail", ["id_detail_barang"=>$id_detail_barang])->with('success','Data successfuly deleted');
    }

    public function get_sub_barang(Request $request){
        $table=DB::table("tb_detail_barang")
        ->select("id","kode","nama")
        ->where("id_barang",$request->id_barang)
        ->get();

        return response()->json($table);
    }
}

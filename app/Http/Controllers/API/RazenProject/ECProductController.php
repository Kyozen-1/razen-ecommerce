<?php

namespace App\Http\Controllers\API\RazenProject;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\EcProductCategories;
use App\Models\EcProduct;
use App\Models\EcProductFile;
use App\Models\EcProductCategoryProduct;
use Validator;

class ECProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = EcProduct::where('store_id', 12)->whereNotNull('approved_by')->get();
            foreach ($products as $product) {
                $get_categories = EcProductCategoryProduct::where('product_id', $product->id)->whereHas('ec_product_categories', function($q){
                    $q->where('parent_id', 84);
                })->get();
                $kategori_produk = [];
                foreach ($get_categories as $item) {
                    $kategori_produk[] = $item->ec_product_categories->name;
                }
                $data[] = [
                    'id' => $product->id,
                    'nama' => $product->name,
                    'deskripsi' => $product->description,
                    'konten' => $product->content,
                    'status' => $product->status,
                    'gambar' => $product->images,
                    'product_file' => EcProductFile::where('product_id', $product->id)->get(),
                    'sku' => $product->sku,
                    'order' => $product->order,
                    'quantity' => $product->quantity,
                    'sku' => $product->sku,
                    'brand' => $product->brand ? $product->brand->name : '',
                    'harga' => $product->price,
                    'pajak' => $product->taxes ? $product->taxes->title: '',
                    'panjang' => $product->length,
                    'lebar' => $product->wide,
                    'tinggi' => $product->height,
                    'berat' => $product->weight,
                    'tipe_produk' => $product->product_type,
                    'kategori_produk' => $kategori_produk,
                ];
            }
            return $this->sendResponse($data, 'Produk Razen Project berhasil dikirim');
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

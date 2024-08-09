<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use League\Csv\Reader;

class ProductController extends Controller
{
    use FileUploader;


    /*
    |-----------------------------------------------------------------------------
    |PRODUCT INDEX (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function index()
    {
        $data['products'] = Product::with('images')->latest()->get();
        return view('pages.products.index', $data);
    }



    /*
    |-----------------------------------------------------------------------------
    |PRODUCT CREATE (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function create()
    {
        return view('pages.products.create');
    }



    /*
    |-----------------------------------------------------------------------------
    |PRODUCT STORE (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'name'                  => 'required',
            'description'           => 'required',
            'price'                 => 'required',
            'images'                => 'required|array',
            'images.*'              => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = Product::create([
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'price'                 => $request->input('price')
        ]);
        if ($request->images) {
            foreach ($request->images ?? [] as $key => $image) {
                $productImage       = $product->images()->create([
                    'product_id'    => $product->id
                ]);
                $this->uploadImage($image, $productImage, 'image', 'product', 450, 400);
            }
        }
        return redirect()->route('product.index')->with('status', 'Product added successfully!');
    }



    /*
    |-----------------------------------------------------------------------------
    |PRODUCT SHOW (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function show($id)
    {
        $product = Product::find($id);
        return view('pages.products.view', ['product' => $product]);
    }



    /*
    |-----------------------------------------------------------------------------
    |PRODUCT EDIT (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('pages.products.edit', ['product' => $product]);
    }



    /*
    |-----------------------------------------------------------------------------
    |PRODUCT UPDATE (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $productImage = $product->images;
    }



    /*
    |-----------------------------------------------------------------------------
    |PRODUCT DELETE (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function delete($id)
    {
        $product = Product::find($id);
        $productImage = $product->images;
        foreach($productImage ?? [] as $key=>$image){
            if($image->image){
                if(File::exists($image->image)) {
                    File::delete($image->image);
                }
            }
        }

        $product->images()->delete();
        $product->delete();
        return Redirect()->back()->with('status','Product Delete Successfully!');
    }



    /*
    |-----------------------------------------------------------------------------
    |IMPORT CSV (FUNCTION)
    |-----------------------------------------------------------------------------
    */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        DB::beginTransaction();
        try {
            foreach ($records as $record) {
                Product::create([
                    'name' => $record['name'],
                    'description' => $record['description'],
                    'price' => $record['price'],
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error importing the CSV file.');
        }

        return back()->with('success', 'CSV file imported successfully.');
    }


}

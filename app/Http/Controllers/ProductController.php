<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateProduct;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /*=============================================
     VISTA DE TIENDA DE PRODUCTOS
   =============================================*/
    public function index()
    {
        return view('product');
    }

    /*=============================================
     OBTENER TODOS LOS PRODUCTOS
   =============================================*/
    public function getProducts()
    {
        $products = Product::with('category')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Get Products',
            'response' => 'get_products',
            'data' => $products
        ], 200);
    }

    /*=============================================
     REALIZAR LA VENTA DEL PRODUCTO
   =============================================*/
    public function saleProduct(Product $product, $quantity)
    {
        DB::beginTransaction(); // Inicializamos la transacción
        try {
            /* Descontamos el stock*/
            $product->decrement('stock', $quantity);
            /* Guardamos la venta*/
            Order::create([
                'product_id' => $product->id_product,
                'quantity' => $quantity,
                'total' => ($product->price * $quantity),
            ]);

            DB::commit(); //Realizamos commit para almecenar los datos en la DB
            return response()->json([
                'success' => true,
                'message' => 'The product was successfully sold, the product stock has been updated.',
                'response' => 'sale_product',
                'data' => $product
            ], 200);

        } catch (\Throwable $th) {
            /* Si tenemos un error, no permitimos la transacción*/
            $response = [
                'success' => false,
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR SALE PRODUCT.', $response); // Guardamos el error en el archivo de logs
            DB::rollBack(); // Hacemos un rollback para eliminar cualquier registro almacenado en la BD
            return response()->json($response, 500);
        }
    }

    /*=============================================
         CREAR PRODUCTO
       =============================================*/
    public function createProduct(CreateProduct $request)
    {

        DB::beginTransaction();
        try {
            $product = Product::create([
                'product_name' => $request['name'],
                'product_description' => $request['description'],
                'reference' => $request['reference'],
                'price' => $request['price'],
                'stock' => $request['stock'],
                'product_slug' => Str::slug($request['name'] . '-' . Str::random(5), '-'),
                'weight' => $request['weight'],
                'product_category_id' => $request['category']['id_category'],
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Create product',
                'response' => 'create_product',
                'data' => $product,

            ], 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR CREATE PRODUCT.', $response); // Guardamos el error en el archivo de logs
            DB::rollBack();
            return response()->json($response, 500);
        }
    }

    /*=============================================
    EDITAR PRODUCTO
   =============================================*/
    public function editProduct(CreateProduct $request, $productId)
    {
        DB::beginTransaction();

        try {
            $product = Product::where('id_product', $productId)->update([
                'product_name' => $request['name'],
                'product_description' => $request['description'],
                'reference' => $request['reference'],
                'price' => $request['price'],
                'stock' => $request['stock'],
                'product_slug' => Str::slug($request['name'] . '-' . Str::random(5), '-'),
                'weight' => $request['weight'],
                'product_category_id' => $request['category']['id_category'],
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Create product',
                'response' => 'create_product',
                'data' => $product,

            ], 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR EDITAR PRODUCT.', $response); // Guardamos el error en el archivo de logs
            DB::rollBack();
            return response()->json($response, 500);
        }
    }

    /*=============================================
     CARGAR IMAGEN PRODUCTO
   =============================================*/
    public function uploadPicture(Request $request)
    {
        $product = Product::latest()->first(); //Obtenemos el último producto creado
        $fileName = Str::random(10) . '-' . $product->product_name; //Creamos un nombre para el archivo
        $file = $request->file('file'); //La imagen recibida
        Storage::disk('public')->put('/products/' . str_replace(' ', '-', $fileName . '.' . $file->getClientOriginalExtension()), file_get_contents($file)); //Guardamos la imagen en el storage
        $urlFinal = '/storage/products/' . $fileName . '.' . $file->getClientOriginalExtension(); //Obtenemos la url final, y es la que guardaremos en la base de datos
        DB::beginTransaction();
        try {
            $product->update([
                'picture' => $urlFinal
            ]); //Guardamos la imagen al producto correspondiente
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Upload Picture',
                'response' => 'upload_picture',
                'path_file' => $urlFinal,

            ], 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR UPLOAD PICTURE.', $response); // Guardamos el error en el archivo de logs
            DB::rollBack();
            return response()->json($response, 500);
        }
    }

    /*=============================================
         ELIMINAR PRODUCTOS
       =============================================*/
    public function deleteProduct($productId)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($productId);
            foreach ($product->orders as $order) {
                $order->delete();
            }
            $product->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Delete Product',
                'response' => 'delete_product',

            ], 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => 'Transaction Error',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('LOG ERROR DELETE PRODUCT.', $response); // Guardamos el error en el archivo de logs
            DB::rollBack();
            return response()->json($response, 500);
        }
    }
}

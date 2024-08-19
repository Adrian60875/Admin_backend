<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Sale\Cart;
use Illuminate\Http\Request;
use App\Models\Cupone\Cupone;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductVariation;
use App\Http\Resources\Ecommerce\Cart\CartEcommerceResource;
use App\Http\Resources\Ecommerce\Cart\CartEcommerceCollection;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('api')->user();

        $carts = Cart::where("user_id",$user->id)->get();

        return response()->json([
            "carts" => CartEcommerceCollection::make($carts),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        if($request->product_variation_id){

            $is_exists_cart_variations = Cart::where("product_variation_id",$request->product_variation_id)
                                                ->where("product_id",$request->product_id)
                                                ->where("user_id",$user->id)->first();
            if($is_exists_cart_variations){
                return response()->json([
                    "message" => 403,
                    "message_text" => "EL PRODUCTO JUNTO CON LA VARIACIÓN YA HA SIDO AGREGADO, SIRVASE AUMENTAR LA CANTIDAD, EN EL CARRITO DIRECTAMENTE",
                ]);
            }else{
                $variation = ProductVariation::find($request->product_variation_id);
                if($variation && $variation->stock < $request->quantity){
                    return response()->json([
                        "message" => 403,
                        "message_text" => "NO SE PUEDE AGREGAR ESA CANTIDAD DEL PRODUCTO VARIACION POR FALTA DE STOCK",
                    ]);
                }
            }
                        
        }else{
            $is_exists_cart_simple = Cart::where("product_variation_id",NULL)
                                        ->where("product_id",$request->product_id)
                                        ->where("user_id",$user->id)->first();
            if($is_exists_cart_simple){
                return response()->json([
                "message" => 403,
                "message_text" => "EL PRODUCTO YA HA SIDO AGREGADO, SIRVASE AUMENTAR LA CANTIDAD, EN EL CARRITO DIRECTAMENTE",
                ]);
            }else{
                $product = Product::find($request->product_id);
                if($product->stock < $request->quantity){
                    return response()->json([
                        "message" => 403,
                        "message_text" => "NO SE PUEDE AGREGAR ESA CANTIDAD DEL PRODUCTO POR FALTA DE STOCK",
                    ]);
                }
            }
        }
        error_log(json_encode($user));
        $request->request->add(["user_id" => $user->id]);
        $cart = Cart::create($request->all());

        return response()->json(["cart" => CartEcommerceResource::make($cart)]);
    }

    public function apply_cupon(Request $request)
    {
       //
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth('api')->user();

        if($request->product_variation_id){
            $is_exists_cart_variations = Cart::where("product_variation_id",$request->product_variation_id)
                                                ->where("product_id",$request->product_id)
                                                ->where("id",'<>',$id)
                                                ->where("user_id",$user->id)->first();
            if($is_exists_cart_variations){
                return response()->json([
                    "message" => 403,
                    "message_text" => "EL PRODUCTO JUNTO CON LA VARIACIÓN YA HA SIDO AGREGADO, SIRVASE AUMENTAR LA CANTIDAD, EN EL CARRITO DIRECTAMENTE",
                ]);
            }else{
                $variation = ProductVariation::find($request->product_variation_id);
                if($variation && $variation->stock < $request->quantity){
                    return response()->json([
                        "message" => 403,
                        "message_text" => "NO SE PUEDE AGREGAR ESA CANTIDAD DEL PRODUCTO VARIACION POR FALTA DE STOCK",
                    ]);
                }
            }
                        
        }else{
            $is_exists_cart_simple = Cart::where("product_variation_id",NULL)
                                        ->where("product_id",$request->product_id)
                                        ->where("id",'<>',$id)
                                        ->where("user_id",$user->id)->first();
            if($is_exists_cart_simple){
                return response()->json([
                "message" => 403,
                "message_text" => "EL PRODUCTO YA HA SIDO AGREGADO, SIRVASE AUMENTAR LA CANTIDAD, EN EL CARRITO DIRECTAMENTE",
                ]);
            }/* else{
                $product = Product::find($request->product_id);
                if($product->stock < $request->quantity){
                    return response()->json([
                        "message" => 403,
                        "message_text" => "NO SE PUEDE AGREGAR ESA CANTIDAD DEL PRODUCTO POR FALTA DE STOCK",
                    ]);
                }
            } */
        }

        $cart = Cart::findOrFail($id);
        $cart->update($request->all());

        return response()->json(["cart" => CartEcommerceResource::make($cart)]);
    }

   /*  public function delete_all() {
        $user = auth("api")->user();
        $carts = Cart::where("user_id",$user->id)->get();
        foreach ($carts as $key => $cart) {
            $cart->delete();
        }
        return response()->json([
            "message" => 200,
        ]);
    } */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json([
            "message" => 200,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Session;
class PageController extends Controller
{
    //
    public function getIndex(){
        $slide = Slide::all();
        $new_product =  Product::where('new',1)->paginate(4);
        $sanpham_khuyenmai = Product::where('promotion_price','<>',0)->paginate(4);
        //dd($new_product);
        return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
        //return view('page.trangchu')->with($sanpham_khuyenmai);
    }
    public function getLoaiSp($type){
        $loai = ProductType::all();
       $sp_theoloai = Product::where('id_type',$type) ->get();
       $sp_khac = Product::where('id_type','<>',$type)->paginate(4);
       $loai_sp = ProductType::where('id',$type)->first();
        return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }
    public function getChitiet(Request $req){
        $sanpham = Product::where('id',$req->id)->first();
        $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(6);
        return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }
    public function getLienHe(){
        return view('page.lienhe');
    }
    public function getGioiThieu(){
        return view('page.gioithieu');
    }
    public function getAddtoCart(Request $req,$id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart -> add($product,$id);
        $req ->session() -> put('cart',$cart);
        return redirect() ->back();

    }
  
}

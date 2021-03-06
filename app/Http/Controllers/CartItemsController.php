<?php

namespace App\Http\Controllers;

use App\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* 検索結果に含めるカラムを指定　*は全ての
           joinでテープルを結合　第２引数以降はカラムの制約条件
           （ items.id = cart_items.item_idになるように結合 ）*/
        $cartItems = CartItem::select('cart_items.*', 'items.name', 'items.amount')
            ->where('user_id', Auth::id())
            ->join('items', 'items.id', '=', 'cart_items.item_id')
            ->get();
        // 合計額を計算
        $subtotal = 0;
        foreach($cartItems as $cartitem){
            $subtotal += $cartitem->amount * $cartitem->quantity;
        }
        return view('cartitems.index', ['cartitems' => $cartItems, 'subtotal' => $subtotal]);
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
        /* id取得はAuth::id()で
           DB::rawで生のSQL文を生成できる */
        CartItem::updateOrCreate(
           [
               'user_id' => Auth::id(),
               'item_id' => $request->post('item_id'),
           ],
           [
               'quantity' => \DB::raw('quantity + ' . $request->post('quantity') ),
           ]
        );
        // with('flash.message')でメッセージを表示　セッションの値になる
        return redirect('/')->with('flash_message', 'カートに追加しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    // resourceでルーティングした場合後ろのCartitemは使えない
    public function update(Request $request, CartItem $cartItem)
    {
        $cartItem->quantity = $request->post('quantity');
        $cartItem->save();
        return redirect('cartitems')->with('flash_message', 'カートを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect('cartitems')->with('flash_message', 'カートから削除しました');
    }
}

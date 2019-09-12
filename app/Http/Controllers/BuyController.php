<?php

namespace App\Http\Controllers;

use App\Mail\Buy;
use App\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BuyController extends Controller
{
    public function index()
    {
        $cartitems = CartItem::select('cart_items.*', 'Items.name', 'Items.amount')
            ->where('user_id', Auth::id())
            ->join('items', 'items.id', '=', 'cart_items.item_id')
            ->get();
        $subtotal = 0;
        foreach($cartitems as $cartitem){
            $subtotal += $cartitem->amount * $cartitem->quantity;
        }
        return view('buy.index', ['cartitems' => $cartitems, '$subtotal' => $subtotal]);
    }

    public function store(Request $request)
    {
        // ユーザーが持っているカート情報を削除し、購入完了画面に進む
        if( $request->has('post') ){
            // MailクラスとBuyクラスを使ってメールを送信する
            Mail::to(Auth::user()->email)->send(new Buy());
            CartItem::where('user_id', Auth::id()->delete());
            return view('buy.complete');
        }
        // リクエスト情報をセッションに保存
        $request->flash();
        //　購入画面のビューを再度表示
        return $this->index();
    }
}

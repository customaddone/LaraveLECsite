<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /* Create等のレコードを編集可能なメソッドを利用する場合には、
      編集可能なカラムをあらかじめ指定する */
    protected $fillable = ['user_id', 'item_id', 'quantity'];
}

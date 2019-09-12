@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-left">
            @foreach ($items as $item)
            <div class="col-md-4 mb-2">
                <div class="card">
                    <!-- 商品の名前を表示 -->
                    <div class="card-header">{{ $item->name }}</div>
                    <!-- 商品の価格を表示 -->
                    <div class="card-body">
                        {{ $item->amount }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- 以下の部分を追加 -->
        <div class="row justify-content-center">
            <!-- appendsでURLにパラメータを付与 Request::getでkeywordの値をビューから
        　　　　　参照できる -->
            {{ $items->appends(['keyword' => Request::get('keyword')])->links() }}
        </div>
    </div>
@endsection

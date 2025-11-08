@extends('layouts.default')
@section('title', 'お問い合わせ完了')

@section('content')
<section class="max-w-xl mx-auto mt-16 px-6 py-12 bg-white rounded-xl shadow-md text-center space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">お問い合わせありがとうございました！</h1>
    <p class="text-gray-700">送信が完了しました。内容を確認の上、担当者よりご連絡いたします。</p>

    <a href="{{ url('/') }}" class="inline-block mt-6 px-6 py-2 bg-gray-100 text-gray-900 font-semibold rounded-md hover:bg-gray-200 transition">
        トップページへ戻る
    </a>
</section>
@endsection
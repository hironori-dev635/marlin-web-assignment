@extends('layouts.default')
@section('title', 'お問い合わせ')

@section('content')
<section class="py-10 px-4">
    <form action="{{ route('contact.send') }}" method="POST" class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-6">
        @csrf
        <h1 class="max-w-xl mx-auto mt-16 px-6 py-12 text-center space-y-6">確認画面</h1>
        <table class="w-full text-left border-collapse">
            <tbody>
                <tr class="border-b">
                    <th class="py-3 px-4 w-40 bg-gray-50">会社名：</th>
                    <td class="py-3 px-4">{{ $input['company'] }}</td>
                    <input type="hidden" name="company" value="{{ $input['company'] }}">
                </tr>
                <tr class="border-b">
                    <th class="py-3 px-4 bg-gray-50">お名前：</th>
                    <td class="py-3 px-4">{{ $input['name'] }}</td>
                    <input type="hidden" name="name" value="{{ $input['name'] }}">
                </tr>
                <tr class="border-b">
                    <th class="py-3 px-4 bg-gray-50">性別：</th>
                    <td class="py-3 px-4">{{ $input['gender'] }}</td>
                    <input type="hidden" name="gender" value="{{ $input['gender'] }}">
                </tr>
                <tr class="border-b">
                    <th class="py-3 px-4 bg-gray-50">メールアドレス：</th>
                    <td class="py-3 px-4">{{ $input['email'] }}</td>
                    <input type="hidden" name="email" value="{{ $input['email'] }}">
                </tr>
                <tr class="border-b">
                    <th class="py-3 px-4 bg-gray-50">電話番号：</th>
                    <td class="py-3 px-4">{{ $input['phone'] }}</td>
                    <input type="hidden" name="phone" value="{{ $input['phone'] }}">
                </tr>
                <tr class="border-b">
                    <th class="py-3 px-4 bg-gray-50">郵便番号：</th>
                    <td class="py-3 px-4">{{ $input['zip'] }}</td>
                    <input type="hidden" name="zip" value="{{ $input['zip'] }}">
                </tr>
                <tr class="border-b">
                    <th class="py-3 px-4 bg-gray-50">住所：</th>
                    <td class="py-3 px-4">{{ $input['address'] }}</td>
                    <input type="hidden" name="address" value="{{ $input['address'] }}">
                </tr>
                <tr class="border-b">
                    <th class="py-3 px-4 bg-gray-50 w-1/4 whitespace-nowrap">当社を知ったきっかけ：</th>
                    <td class="py-3 px-4">
                        {{ !empty($input['how_found']) ? implode('、', $input['how_found']) : '（未選択）' }}
                        @if (!empty($input['how_found']))
                            @foreach ($input['how_found'] as $how)
                                <input type="hidden" name="how_found[]" value="{{ $how }}">
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr class="border-b align-top">
                    <th class="py-3 px-4 bg-gray-50 w-1/4 whitespace-nowrap">お問い合わせ内容：</th>
                    <td class="py-3 px-4">{!! nl2br(e($input['message'])) !!}
                        <input type="hidden" name="message" value="{{ $input['message'] }}">
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="text-center space-x-4">
            <button type="button" onclick="history.back()" class="px-6 py-2 text-gray-900 font-semibold rounded-md ring-1 ring-gray-300 hover:bg-gray-100 transition" >
                戻る
            </button>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition"
             onclick="this.disabled=true; this.innerText='送信中...'; this.form.submit();"
            >
                送信する
            </button>
        </div>
    </form>
</section>
@endsection

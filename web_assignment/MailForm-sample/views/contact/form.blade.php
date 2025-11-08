@extends('layouts.default')
@section('title', 'お問い合わせ')

@section('content')
<section>

<form action="{{ route('contact.confirm') }}" method="POST" class="h-adr   max-w-xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-6">
    @csrf
    <h1 class="max-w-xl mx-auto mt-16 px-6 py-12 text-center space-y-6">お問い合わせフォーム</h1>
     {{-- 会社名 --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">会社名：</label>
        <input type="text" name="company" value="{{ old('company') }}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring-0 focus:border-blue-500" autocomplete="on">
        @error('company') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    {{-- お名前 --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">お名前：</label>
        <input type="text" name="name" value="{{ old('name') }}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring-0 focus:border-blue-500" autocomplete="on">
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    {{-- 性別 --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">性別：</label>
        <div class="flex space-x-4">
            <label class="inline-flex items-center">
                <input type="radio" name="gender" value="男性" class="form-radio text-blue-600" {{ old('gender') == '男性' ? 'checked' : '' }}>
                <span class="ml-2">男</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="gender" value="女性" class="form-radio text-blue-600" {{ old('gender') == '女性' ? 'checked' : '' }}>
                <span class="ml-2">女</span>
            </label>
        </div>
        @error('gender') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    {{-- メールアドレス --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">メールアドレス：</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div> 
     {{-- 電話番号 --}}
     <div>
        <label class="block text-sm font-medium text-gray-700">電話番号：</label>
        <input  type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-32 border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
   {{-- 郵便番号 --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">郵便番号：</label>
        <span class="p-country-name" style="display:none;">Japan</span>
        <input type="text" name="zip" value="{{ old('zip') }}" class="p-postal-code      mt-1 block w-32 border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" size="8" maxlength="8">
        @error('zip') <div>{{ $message }}</div> @enderror
    </div>

    {{-- 住所 --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">住所：</label>
        <input type="text" name="address" value="{{ old('address') }}" class="p-region p-locality p-street-address p-extended-address      mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"">
        @error('address') <div>{{ $message }}</div> @enderror
    </div>



    {{-- きっかけ --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">当社を知ったきっかけ：</label>
        <div class="space-y-1">
            @foreach (['検索エンジン', '広告', 'その他'] as $option)
                <label class="inline-flex items-center mr-4">
                    <input type="checkbox" name="how_found[]" value="{{ $option }}" class="form-checkbox text-blue-600"
                        {{ is_array(old('how_found')) && in_array($option, old('how_found')) ? 'checked' : '' }}>
                    <span class="ml-2">{{ $option }}</span>
                </label>
            @endforeach
        </div>
        @error('how_found') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    {{-- お問い合わせ内容 --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">お問い合わせ内容：</label>
        <textarea name="message"
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                  rows="8">{{ old('message') }}</textarea>
        @error('message') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

        {{-- 確認ボタン --}}
    <div class="text-center">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
            確認する
        </button>
    </div>
</form>

</section>

{{-- ここにCDN追加推奨 --}}
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js"></script>
@endsection
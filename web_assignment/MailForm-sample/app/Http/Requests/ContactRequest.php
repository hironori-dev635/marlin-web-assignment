<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認証なしの場合はtrue
    }

    public function rules(): array
    {
        return [
            'company' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:男性,女性'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['required', 'regex:/^0(\\d-?\\d{4}|\\d{2}-?\\d{3}|\\d{3}-?\\d{2}|\\d{4}-?\\d|\\d0-?\\d{4})-?\\d{4}$/'],
            'zip' => ['required', 'regex:/^\d{3}-?\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'how_found' => ['nullable', 'array'],
            'how_found.*' => ['in:検索エンジン,広告,その他'],
            'message' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'company.required' => 'お名前は必須です。',
            'name.required' => 'お名前は必須です。',
            'gender.required' => '性別を選択してください。',
            'gender.in' => '性別の値が不正です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'phone.regex' => '電話番号が正しくありません。',
            'how_found.*.in' => '選択されたきっかけに不正な値があります。',
            'message.required' => 'お問い合わせ内容は必須です。',
        ];
    }
}

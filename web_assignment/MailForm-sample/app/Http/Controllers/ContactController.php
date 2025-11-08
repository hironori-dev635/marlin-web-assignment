<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactSendMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function form()
    {
        return view('contact.form');
    }

    public function confirm(ContactRequest $request)
    {
        $input = $request->validated();

        // dd($input);
        return view('contact.confirm', compact('input'));
    }

    public function send(ContactRequest $request)
    {

        $input = $request->validated();
        // dd($input);
        // 開発用アドレスに送信（Mailpit で見る）
        Mail::to('test@example.com')->send(new ContactSendMail($input));

        // 処理後、完了画面へリダイレクト
        // リダイレクト（POST → GET に切り替え）
        return redirect()->route('contact.thanks');
    }
}

<p>以下の内容でお問い合わせがありました：</p>

<p><strong>会社名：</strong> {{ $input['company'] }}</p>
<p><strong>お名前：</strong> {{ $input['name'] }}</p>
<p><strong>性別　：</strong> {{ $input['gender'] }}</p>
<p><strong>メール：</strong> {{ $input['email'] }}</p>
<p><strong>電話番号：</strong> {{ $input['phone'] }}</p>
<p><strong>郵便番号：</strong> {{ $input['zip'] }}</p>
<p><strong>住所　　：</strong> {{ $input['address'] }}</p>
<p><strong>当社を知ったきっかけ：</strong> {{ !empty($input['how_found']) ? implode('、', $input['how_found']) : '（未選択）' }}</p>

<p><strong>お問い合わせ内容：</strong><br>
{!! nl2br(e($input['message'])) !!}</p>


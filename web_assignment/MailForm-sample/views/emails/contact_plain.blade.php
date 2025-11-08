お問い合わせ内容：

会社名：{{ $input['company'] }}
名前  ：{{ $input['name'] }}
性別  ：{{ $input['gender'] }}
メール：{{ $input['email'] }}
電話番号：{{ $input['phone'] }}
郵便番号：{{ $input['zip'] }}
住所　：{{ $input['address'] }}
当社を知ったきっかけ：{{ !empty($input['how_found']) ? implode('、', $input['how_found']) : '（未選択）' }}
---
メッセージ：
{{ $input['message'] }}
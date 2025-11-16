<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class UserController extends Controller
{
 public function index(Request $request)
    {   // ソート対象カラムと順序を取得（デフォルトは id 昇順）
       
        $sortBy = $request->input('sortBy', 'id');
         //ブラウザから送られてきたリクエスト（?sortBy=nameなど）に sortBy というパラメータがあるかを確認。
        //あればその値を使い、なければ 'id' を使う（つまりデフォルトはID順で並べ替える）。
       
        
        $sortOrder = $request->input('sortOrder', 'asc');
        //並び順（昇順・降順）を指定するためのパラメータを受け取る。
        //asc（昇順）または desc（降順）。
        //パラメータがなければ 'asc'（昇順）をデフォルトにする。
        
        //dd('here is');
        // 表示件数を受け取る（デフォルト10件）
        $perPage = $request->input('perPage', 10);

        $search = $request->get('search');


        // ソート・ページネーション・検索
        $users = User::select('id', 'name', 'email')
         ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
           ->orderBy($sortBy, $sortOrder)//第一引数：カラム名、第二引数：昇順降順
           ->paginate($perPage)
            ->appends(['perPage' => $perPage]); // ページ移動時に保持

        return Inertia::render('Users/Index', [
            'users' => $users,
            'perPage' => (int)$perPage,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'filters' => ['search' => $search,],
        ]);
    }




    public function index1(Request $request)
    {
        // ソート対象カラムと順序を取得（デフォルトは id 昇順）
       
        $sortBy = $request->input('sortBy', 'id');
         //ブラウザから送られてきたリクエスト（?sortBy=nameなど）に sortBy というパラメータがあるかを確認。
        //あればその値を使い、なければ 'id' を使う（つまりデフォルトはID順で並べ替える）。
       
        
        $sortOrder = $request->input('sortOrder', 'asc');
        //並び順（昇順・降順）を指定するためのパラメータを受け取る。
        //asc（昇順）または desc（降順）。
        //パラメータがなければ 'asc'（昇順）をデフォルトにする。
        
        
        
        // クエリ実行
        $users = User::select('id', 'name', 'email')
            ->orderBy($sortBy, $sortOrder)//第一引数：カラム名、第二引数：昇順降順
            ->get();

        return Inertia::render('Users/UserSort1', [
            'users' => $users,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
        ]);
    }


     public function index2(Request $request)
    {//dd('here is');
        // 表示件数を受け取る（デフォルト10件）
        $perPage = $request->input('perPage', 10);

        // ソート・ページネーション
        $users = User::select('id', 'name', 'email')
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends(['perPage' => $perPage]); // ページ移動時に保持

        return Inertia::render('Users/Paginate2', [
            'users' => $users,
            'perPage' => (int)$perPage,
        ]);
    }
    public function search1(Request $request)
{
    $search = $request->get('search');

    $users = User::select('id', 'name', 'email')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->get();

    return Inertia::render('Users/UserSearch1', [
        'users' => $users,
        'filters' => [
            'search' => $search,
        ],
    ]);
}



public function search2(Request $request)
{
    $search = $request->get('search');

    $users = User::select('id', 'name', 'email')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->get();

    return Inertia::render('Users/UserSearch2', [
        'users' => $users,
        'filters' => [
            'search' => $search,
        ],
    ]);
}
public function search3(Request $request)
{
    $search = $request->get('search');

 
$users = User::select('id', 'name', 'email')
    ->when($search, function ($query, $search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }, function ($query) {
        // searchが空なら結果ゼロ
        $query->whereRaw('0=1');
    })
    ->get();
    return Inertia::render('Users/UserSearch3', [
        'users' => $users,
        'filters' => [
            'search' => $search,
        ],
    ]);
}


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxonomyController extends Controller
{
    /**
     * カテゴリー・タグ一覧画面
     * 
     * @param 
     * @return view
     */
    public function index(Request $request, Category $category, Tag $tag)
    {
        $taxonomy = $request->is('admin/categories') ? 'カテゴリー' : 'タグ';
        $params = [
            'taxonomy' => $taxonomy,
            'items' => null,
        ];

        if ($taxonomy == 'カテゴリー')
        {
            $items = $category->orderBy('path', 'asc')->get();
            $params['items'] = $items;
        }
        else
        {
            $items = $tag->orderBy('name', 'asc')->get();
            $params['items'] = $items;
        }

        return view('admin.taxonomy.index', $params);
    }

    /**
     * カテゴリー・タグ登録
     * 
     * @param 
     * @return 
     */
    public function register(Request $request, Category $category, Tag $tag)
    {
        // バリデーション
        $request->validate([
            'name' => 'required',
        ]);

        // カテゴリーの場合
        if ( $request->is('admin/categories/register') )
        {
            // カラムIDの設定
            $id = $category->max('id') + 1;

            // パスの生成
            if ( $request->path == '' )
            {
                $path = '/' . $id . '/';
            }
            else 
            {
                $path = $request->path . $id . '/';
            }

            // スラッグ名を自動生成
            if ( $request->slug == '' )
            {
                do
                {
                    $slug = Str::random(10);
                }
                while ( $category::where('slug', $slug)->exists() );
            }
            else
            {
                $slug = $request->slug;
            }

            // DBに格納する値
            $params = [
                'id' => $id,
                'slug' => $slug,
                'name' => $request->name,
                'path' => $path,
            ];
            // DBに格納
            $category->fill($params)->save();

            return redirect()->route('admin.categories');
        }
        // タグの場合
        else
        {
            // スラッグ名を自動生成
            if ( $request->slug == '' )
            {
                do
                {
                    $slug = Str::random(10);
                }
                while ( $tag::where('slug', $slug)->exists() );
            }
            else
            {
                $slug = $request->slug;
            }

            // DBに格納する値
            $params = [
                'name' => $request->name,
                'slug' => $slug,
            ];
            // DBに格納
            $tag->fill($params)->save();

            return redirect()->route('admin.tags');
        }
    }

    /**
     * カテゴリー・タグの削除
     * 
     * @param Illuminate\Http\Request
     * @return redirect
     */
    public function delete(Request $request, Category $category, Tag $tag)
    {
        // パラメータを取得
        $id = $request->id;

        // カテゴリーの場合
        if ( $request->is('admin/categories/delete') )
        {
            // DBのカテゴリーの削除
            $category::destroy($id);

            // 子カテゴリーの階層構造を変更
            $items = $category->where('path', 'like', '%/' . $id . '/%')->get();
            foreach ( $items as $item )
            {
                $path = $item->path;
                $target = $category->where('path', $path)->get()->first();
                $path = str_replace('/' . $id . '/', '/', $path);
                $target->path = $path;
                $target->save();
            }

            return redirect()->route('admin.categories');
        }
        // タグの場合
        else 
        {
            // DBのタグ削除
            $tag::destroy($id);

            return redirect()->route('admin.tags');
        }
    }

    /**
     * 更新
     * 
     * @param
     * @return
     */
    public function update(Request $request, Category $category, Tag $tag)
    {
        // バリデーション
        $request->validate([
            'new_name' => 'required',
            'new_slug' => 'required'
        ]);
        // 入力情報を取得
        $items = $request->all();

        // カテゴリーの場合
        if ( $request->is('admin/categories/update') )
        {
            // 更新するテーブルカラムを取得
            $target = $category->find($request->new_id);
            // 名前を更新
            $target->name = $items['new_name'];
            // スラッグ名を更新
            $target->slug = $items['new_slug'];
            // パスを更新
            if ( $request->new_path == $category->find($request->new_id)->path )
            {
                $new_path = $request->new_path;
            }
            else
            {
                $new_path = $request->new_path . $request->new_id . '/';
            }
            $target->path = $new_path;
            // 更新内容を保存
            $target->save();

            return redirect()->route('admin.categories');
        }
        // タグの場合
        else
        {
            // 更新するテーブルカラムを取得
            $target = $tag->find($request->new_id);
            // 名前を更新
            $target->name = $items['new_name'];
            // スラッグ名を更新
            $target->slug = $items['new_slug'];
            // 更新内容を保存
            $target->save();

            return redirect()->route('admin.tags');
        }
    }
}

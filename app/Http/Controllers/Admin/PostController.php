<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Category;
use App\Models\RelationCategory;
use App\Models\RelationTag;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct(
        Entry $entry,
        Category $category,
        Tag $tag,
        RelationCategory $relationCategory,
        RelationTag $relationTag
    )
    {
        $this->entry = $entry;
        $this->category = $category;
        $this->tag = $tag;
        $this->relationCategory = $relationCategory;
        $this->relationTag = $relationTag;
    }

    /**
     * 記事の一覧取得
     * 
     * @return view
     */
    public function index(Request $request)
    {
        // 記事の表示数
        $show_num = config( 'myconfig.admin_post_num' );

        // 記事の取得
        $entries = $this->entry->orderBy('created_at', 'desc')->paginate($show_num);

        // 記事数の取得
        $count = DB::table('entries')->count();

        // 記事数をリクエストに追加
        $request->merge(['allCount' => $count, 'showNum' => $show_num]);

        // viewに渡す値
        $params = [
            "entries" => $entries,
            'request' => $request,
        ];

        return view('admin.post.index', $params);
    }

    /**
     * 記事の新規画面
     * 
     * @return view
     */
    public function add()
    {
        $categories = $this->category->orderBy('path', 'asc')->get();
        $tags = $this->tag->orderBy('name', 'asc')->get();
        $params = [
            'categories' => $categories,
            'tags' => $tags,
            'selected_category' => null,
            'selected_tags' => null,
        ];

        return view('admin.post.input', $params);
    }

    /**
     * 記事の投稿（POST）
     *
     * @param Illuminate\Http\Request $request
     * @return redirect
     */
    public function addPost(Request $request)
    {
        // バリデーション
        $rules = ['title' => 'required'];
        $this->validate($request, $rules);

        // フォームの入力内容を全て取得
        $entries = $request->all();

        // DBに格納する値（記事）
        $entry = [
            'title' => $entries['title'],
            'content' => $entries['content'],
        ];

        // 記事をDBに格納（記事）
        $this->entry->fill($entry)->save();

        // 記事IDを取得
        $post_id = $this->entry->id;

        // 記事とカテゴリーの紐付け
        if ( isset ( $entries['category'] ) )
        {
            // DBに格納する値（カテゴリー）
            $relation_category = [
                'post_id' => $post_id,
                'category_id' => $entries['category'],
            ];
            // DBへ格納
            $this->relationCategory->fill($relation_category)->save();
        }


        // 記事とタグの紐付け
        if ( isset ( $entries['tag'] ) )
        {
            foreach ( $entries['tag'] as $tag )
            {
                $relation_tag = [
                    'post_id' => $post_id,
                    'tag_id' => $tag,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                // DBへ格納（記事とタグの紐付け）
                $relationTag = new $this->relationTag;
                $relationTag->fill($relation_tag)->save();
            }
        }

        return redirect( route('admin.post.index') );
    }

    /**
     * 記事の編集画面
     * 
     * @param Illuminate\Http\Request $request
     * @return view
     */
    public function edit(Request $request)
    {
        // 記事IDを取得
        $post_id = $request->post_id;
        $request->merge( ['id' => $post_id] );

        // 記事を取得
        $entry = $this->entry->find($post_id);

        // カテゴリーを取得（昇順）
        $categories = $this->category->orderBy('path', 'asc')->get();


        $tags = $this->tag->orderBy('name', 'asc')->get();
        $selected_category = $this->relationCategory->where('post_id', $post_id)->get()->first();
        $selected_tags_before = $this->relationTag->where('post_id', $post_id)->get();

        // タグIDを配列に格納（in_array()で探索可能にするため）
        $selected_tags = [];
        foreach ( $selected_tags_before as $value )
        {
            array_push( $selected_tags, $value['tag_id'] );
        }

        $params = [
            'entry' => $entry,
            'categories' => $categories,
            'tags' => $tags,
            'selected_category' => $selected_category,
            'selected_tags' => $selected_tags,
            'request' => $request,
        ];
        return view('admin.post.input', $params);
    }

    /**
     * 記事の更新（POST）
     * 
     * @param Illuminate\Http\Request $request
     * @return redirect
     */
    public function editPost(Request $request)
    {
        // 記事IDを取得
        $post_id = $request->post_id;

        // バリデーション
        $rules = ['title' => 'required'];
        $this->validate($request, $rules);

        // フォームの入力内容を全て取得
        $entries = $request->all();

        // DBを更新（記事）
        $entry = $this->entry->find( $entries['post_id'] );
        $entry->title = $request->title;
        $entry->content = $request->content;
        $entry->save();

        // 記事とカテゴリーの関係を一旦リセット
        $this->relationCategory->where('post_id', $entries['post_id'])->delete();
        // 記事とカテゴリーの紐付け
        if ( $entries['category'] != 0 )
        {
            // DBに格納する値
            $relation_category = [
                'post_id' => $entries['post_id'],
                'category_id' => $entries['category'], 
            ];
            // DBに格納（記事をカテゴリーの関係）
            $this->relationCategory->fill( $relation_category )->save();
        }

        // 記事とタグの関係を一旦リセット
        $this->relationTag->where( 'post_id', $entries['post_id'] )->delete();
        // 記事とタグの紐付け
        if ( isset( $entries['tag'] ) )
        {
            foreach ( $entries['tag'] as $value )
            {
                $relationTag = new $this->relationTag;
                $relation_tag = [
                    'post_id' => $entries['post_id'],
                    'tag_id' => $value,
                ];
                $relationTag->fill( $relation_tag )->save();
            }
        }

        // メッセージ
        $message = '投稿が更新されました。';

        return redirect()->route('admin.post.edit', ['post_id' => $post_id])->with('update_message', $message);
    }

    /**
     * 記事の削除
     * 
     * @param
     * @return
     */
    public function deleteOne(Request $request)
    {
        if ( empty($request->post_id) ) {
            return redirect()->route('admin.post.index');
        }
        $this->entry->deleteOne($request->post_id);
        return redirect()->route('admin.post.index')->with('delete_message', '記事を１件削除しました。');
    }

    /**
     * 記事の複製
     * 
     * @param
     * @return
     */
    public function replicateOne(Request $request)
    {
        if ( empty($request->post_id) ) {
            return redirect()->route('admin.post.index');
        }
        $this->entry->replicateOne($request->post_id);
        return redirect()->route('admin.post.index')->with('replicate_message', '記事を１件複製しました。');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Category;
use App\Models\Tag;
use App\Models\RelationCategory;
use App\Models\RelationTag;

class EntriesController extends Controller
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

    public function index()
    {
        $num = config( 'myconfig.post_num' );
        $items = $this->entry->orderby( 'created_at', 'DESC' )->paginate($num);
        $categories = $this->category->orderby( 'path', 'ASC' )->get();
        $tags = $this->tag->all();

        $params = [
            'items'      => $items,
            'categories' => $categories,
            'tags'       => $tags,
        ];

        return view('index', $params);
    }

    public function detail($id)
    {
        $item = $this->entry->findOrFail( $id );
        $category_slug = $item->entry['relation_category']['category']['slug'];
        $categories = $this->category->orderby( 'path', 'ASC' )->get();
        $tags = $this->tag->all();

        $params = [
            'item'          => $item,
            'category_slug' => $category_slug,
            'id'            => $id,
            'categories'    => $categories,
            'tags'          => $tags,
        ];

        return view('detail', $params);
    }

    /**
     * カテゴリー別記事一覧
     * 
     * @param $category (URL Param)
     * @return view
     */
    public function category($category)
    {
        $num = config( 'myconfig.post_num' );
        // URLに指定されたスラッグ名からカテゴリ名を取得
        $term_name = $this->category->where( 'slug', $category )->get()->first();
        // URLに指定されたスラッグ名からカテゴリIDを取得
        $category_id = $this->category->where( 'slug', $category )->get()->first()['id'];
        // 記事を取得
        $items = $this->entry->whereHas('relation_category', function ( $q ) use ( $category_id ) {
            $q->where( 'category_id', $category_id );
        })->paginate( $num );
        $categories = $this->category->orderby( 'path', 'ASC' )->get();
        $tags = $this->tag->all();

        $params = [
            'items'         => $items,
            'term_name'     => $term_name['name'],
            'categories'    => $categories,
            'tags'          => $tags,
        ];

        return view( 'archive', $params );
    }

    /**
     * タグ別記事一覧ページ
     */
    public function tag($tag)
    {
        $num = config( 'myconfig.post_num' );
        // URLに指定されたスラッグ名からタグ名を取得
        $term_name = $this->tag->where( 'slug', $tag )->get()->first();
        // URLに指定されたスラッグ名からタグIDを取得
        $tag_id = $this->tag->where( 'slug', $tag )->get()->first()['id'];
        // 記事を取得
        $items = $this->entry->whereHas('relation_tags', function ( $q ) use ( $tag_id ) {
            $q->where( 'tag_id', $tag_id );
        })->paginate( $num );
        $categories = $this->category->orderby( 'path', 'ASC' )->get();
        $tags = $this->tag->all();

        $params = [
            'items'         => $items,
            'term_name'     => $term_name['name'],
            'categories'    => $categories,
            'tags'          => $tags,
        ];

        return view( 'archive', $params );
    }
}

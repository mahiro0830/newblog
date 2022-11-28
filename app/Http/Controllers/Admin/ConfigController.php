<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * 設定画面の表示
     * 
     * @param void
     * @return view
     */
    public function index()
    {
        // 設定ファイルから値を取得
        $config_params = config('myconfig');

        return view( 'admin.config.index', $config_params );
    }

    /**
     * 設定の保存
     * 
     * @param Request $request
     * @return redirect
     */
    public function save(Request $request)
    {
        // フラッシュメッセージ
        $message = 'Configファイルを書き換えました。';

        // フォームの入力内容を取得
        $params = $request->all();

        // 設定ファイルの値を取得
        $config_params = config( 'myconfig' );

        // 設定ファイルの書き換え
        $path = base_path('config/myconfig.php');
        if (file_exists($path))
        {
            foreach ( $config_params as $key => $value )
            {
                file_put_contents($path, str_replace(
                    "'" . $key . "'" . ' => ' . $value,
                    "'" . $key . "'" . ' => ' . $params[$key],
                    file_get_contents($path)
                ));
            }
        }

        return redirect()->route( 'admin.config' )->with( 'update_message', $message );
    }
}

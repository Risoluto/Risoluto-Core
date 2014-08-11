<?php
/**
 * Url
 *
 * Url操作のためのファンクション群
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

class Url
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * __construct()
     *
     * コンストラクタ
     */
    private function __construct()
    {
    }

    /**
     * GetBaseUrlGetBaseUrl(array $target = array('HTTP_HOST' => 'localhost', 'SERVER_PORT' => '80', 'PHP_SELF' => '/'))
     *
     * ベースURLを取得する
     *
     * @access    public
     *
     * @param array $target
     *
     * @internal  param array $_SERVER 相当の情報が格納された配列
     *
     * @return    string    自身のベースURL
     */
    public static function GetBaseUrl(array $target = array('HTTP_HOST' => 'localhost', 'SERVER_PORT' => '80', 'PHP_SELF' => '/'))
    {
        //---スキーマ（ポートの値でHTTP/HTTPSのどちらかを判定）
        switch ($target['SERVER_PORT']) {
            // スタンダードなHTTPS
            case '443': // FALL THRU
            case '8443': // FALL THRU
                $schema = 'https://';
                break;

            // デフォルト
            default:
                $schema = 'http://';
                break;
        }

        //---ポート（80と443以外なら「〜:PORTNUMBER」とする）
        $port = '';
        if ($target['SERVER_PORT'] != '80' and $target['SERVER_PORT'] != '443') {
            $port = ':' . $target['SERVER_PORT'];
        }

        //---ホスト名
        $host = $target['HTTP_HOST'];

        //---実行ファイル名（デフォルトの「index.php」が付いている場合は消す）
        $self = str_replace('index.php', '', $target['PHP_SELF']);

        return $schema . $host . $port . $self;
    }

    /**
     * RedirectTo($target = null,array $getKey = null,array $getVal = null)
     *
     * 指定された画面へリダイレクトする
     *
     * @access    public
     *
     * @param     string $target リダイレクト先の画面識別子
     * @param     array  $getKey リダイレクト時に付与するGETパラメタのキー部（配列指定）
     * @param     array  $getVal リダイレクト時に付与するGETパラメタのバリュー部（配列指定）
     *
     * @return    void      なし
     */
    public static function RedirectTo($target = null,array $getKey = null,array $getVal = null)
    {
        // ベースURLを取得する
        $baseUrl    = self::GetBaseUrl() . '?seq=' . $target;
        $otherParam = null;

        // 他のパラメタが指定されていたら、それをGETパラメタの形に生成
        if (!empty($getKey) and !empty($getVal)) {
            $tmp_keys = explode(',', $getKey);
            $tmp_vals = explode(',', $getVal);

            // 両方の要素数が合致する場合のみGETパラメタの形式に編集する
            if (count($tmp_keys) == count($tmp_vals)) {
                for ($i = 0; $i < count($tmp_keys); $i++) {
                    $otherParam .= '&' . $tmp_keys[$i] . '=' . $tmp_vals[$i];
                }
            }
        }

        // ヘッダを出力する
        header("Location: $baseUrl$otherParam");
    }
}
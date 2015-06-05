<?php
/**
 * Url
 *
 * Url操作のためのファンクション群
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
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
     * getBaseUrl(array $target = array('HTTP_HOST' => 'localhost', 'SERVER_PORT' => '80', 'PHP_SELF' => '/'))
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
    public static function getBaseUrl(
        array $target = [ 'HTTP_HOST' => 'localhost', 'SERVER_PORT' => '80', 'PHP_SELF' => '/' ]
    ) {
        //---スキーマ（ポートの値でHTTP/HTTPSのどちらかを判定）
        switch ($target[ 'SERVER_PORT' ]) {
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
        if ($target[ 'SERVER_PORT' ] != '80' and $target[ 'SERVER_PORT' ] != '443') {
            $port = ':' . $target[ 'SERVER_PORT' ];
        }

        //---ホスト名
        $host = $target[ 'HTTP_HOST' ];

        //---実行ファイル名（デフォルトの「index.php」が付いている場合は消す）
        $self = str_replace( 'index.php', '', $target[ 'PHP_SELF' ] );

        return $schema . $host . $port . $self;
    }

    /**
     * redirectTo($target = '', array $param = [], $status = '302', array $servinfo = [])
     *
     * 指定された画面へリダイレクトする
     *
     * @access    public
     *
     * @param     string $target リダイレクト先の画面識別子
     * @param     array  $param リダイレクト時に付与するパラメタ（連想配列指定）
     * @param     string $status リダイレクト時に付与するHTTPステータスコード
     * @param     array  $servinfo GetBaseUrlに引き渡すサーバ情報が格納された配列（$_SERVER相当）
     *
     * @return    void      なし
     */
    public static function redirectTo( $target = '', array $param = [ ], $status = '302', array $servinfo = [ ] )
    {
        // ベースURLを取得する
        $baseUrl = self::getBaseUrl( ( !empty( $servinfo ) and is_array( $servinfo ) ) ? $servinfo : $_SERVER ) . ( !empty( $target ) ? '?seq=' . $target : '' );

        // 他のパラメタが指定されていたら、それをGETパラメタの形に生成
        $otherParam = '';
        if (!empty( $param )) {
            ksort( $param );
            foreach ($param as $key => $val) {
                $otherParam .= '.' . $key . ( !empty( $val ) ? '=' . $val : '' );
            }
        }

        // ヘッダを出力する
        header( "Location: $baseUrl$otherParam", true, $status );
    }
}
<?php
/**
 * View
 *
 * 静的ページ表示機能を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Pages;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class View extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
{
    // View関連の処理を使用する
    use \Risoluto\RisolutoViewTrait;

    /**
     * play()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function play()
    {
        // パラメタを取得し、空だった時はデフォルトの画面を取得する
        $params = $this->getParam();
        if (empty( $params ) or !preg_match( '/^[[:alnum:]_-].*$/', $params[ 0 ] )) {
            $tmpl = 'Top';
        } else {
            // パラメタ中のディレクトリセパレタを編集してセット
            $tmpl = str_replace( '_', DS, $params[ 0 ] );
        }

        // デフォルトヘッダ情報の取得
        $header = $this->getDefaultHeader();

        // ファイルの実在を確認し、優先順に沿って処理を実施
        $basepath = RISOLUTO_APPS . 'RisolutoApps/Pages/shelf/' . str_replace( '../', '', $tmpl );
        clearstatcache( true );
        if (file_exists( $basepath . '.tpl' )) {
            //--- .tplファイルが存在するときはテンプレートエンジンで処理した結果を出力する
            $tmpl .= '.tpl';

            // テンプレートエンジン関連の処理
            $assign_value = [ 'header' => $header, 'pagename' => $params[ 0 ], 'options' => $params ];
            echo trim( $this->risolutoView( $assign_value, 'fetch', 'Pages/shelf/', $tmpl ) );
        } elseif (file_exists( $basepath . '.md' )) {
            //--- .mdファイルが存在するときはパースしてから処理する
            // タイトルだけ置き換えてヘッダとフッタを取得
            $header[ 'title' ] = ( isset( $params[ 0 ] ) and !empty( $params[ 0 ] ) ) ? $params[ 0 ] : 'Top';
            $assign_value = [ 'header' => $header, 'pagename' => $params[ 0 ], 'options' => $params ];
            $parts_header = $this->risolutoView( $assign_value, 'fetch', 'Pages/', 'dummy_header.tpl' );
            $parts_footer = $this->risolutoView( $assign_value, 'fetch', 'Pages/', 'dummy_footer.tpl' );

            // 本体をパースして取得
            /** @noinspection PhpUndefinedNamespaceInspection */
            $parts_body = \Michelf\MarkdownExtra::defaultTransform( file_get_contents( $basepath . '.md' ) );

            // 画面に出力
            echo trim( $parts_header . $parts_body . $parts_footer );
        } elseif (file_exists( $basepath . '.raw' )) {
            //--- .rawファイルが存在するときは取得した内容をそのまま出力
            echo trim( file_get_contents( $basepath . '.raw' ) );
        } else {
            //--- いずれも存在しないときはエラー
            $conf = new \Risoluto\Conf;
            $conf->parse( RISOLUTO_CONF . 'risoluto.ini' );

            $error = $conf->getIni( 'SEQ', 'error' );
            \Risoluto\Url::redirectTo( $error );
        }
    }
}
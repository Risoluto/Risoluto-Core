<?php
/**
 * RisolutoViewTrait
 *
 * View関連用メソッドTrait
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

trait RisolutoViewTrait
{
    /**
     * risolutoView(array $assign_values, $mode = 'view', $path = '', $name = '', array $options = [ ], array $extres = [ ])
     *
     * Viewに関する処理を実行する（ヘルパーメソッド）
     *
     * @access    private
     *
     * @param     array  $assign_values テンプレートへのアサイン内容
     * @param     string $mode モード（view:そのまま表示/fetch:表示内容を取得）
     * @param     string $path テンプレートのパス
     * @param     string $name テンプレートファイル名
     * @param     array  $options initTemplateに引き渡すオプション
     * @param     array  $extres initTemplateに引き渡す外部リソース情報
     *
     * @return    mixed     $mode=view:常にtrue / $mode=fetch:表示内容/想定外の場合：false
     */
    private function risolutoView(
        array $assign_values = [ ],
        $mode = 'view',
        $path = '',
        $name = '',
        array $options = [ ],
        array $extres = [ ]
    ) {
        // 呼び出し元クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        if ($path) {
            $tmpl_path = str_replace( DS . DS, DS, DS . str_replace( '../', '', $path ) . DS );
        } else {
            $tmpl_path = str_replace( 'RisolutoApps', '', str_replace( '\\', DS, $called->getNamespaceName() ) . DS );
        }
        if ($name) {
            $tmpl_name = $name;
        } else {
            $tmpl_name = $called->getShortName() . '.tpl';
        }

        // テンプレートエンジンを初期設定してインスタンスを取得
        $tmpl_instance = $this->initTemplate( $tmpl_path, $options, $extres );

        // テンプレートに値をアサイン
        $this->assignTemplate( $tmpl_instance, $assign_values );

        // テンプレート処理を実行して結果を返す
        return $this->dispTemplate( $tmpl_instance, $tmpl_name, $mode );
    }

    /**
     * initTemplate($tmpl_path = '', array $options = [ ], array $extres = [ ])
     *
     * テンプレートエンジンのインスタンスを生成する
     *
     * @access    private
     *
     * @param     string $tmpl_path テンプレートファイルが格納されているディレクトリのパス
     * @param     array  $options Smartyに引き渡すオプション
     * @param     array  $extres 外部リソースの定義
     *
     * @return    object    テンプレートエンジンのインスタンス
     */
    private function initTemplate(
        $tmpl_path = '',
        array $options = [
            'cache' => [
                'mode' => \Smarty::CACHING_LIFETIME_SAVED,
                'lifetime' => 3600,
                'modified_check' => true,
            ],
            'compile' => [
                'check' => true,
                'force' => false,
            ],
            'debug' => [
                'enable' => false,
                'ctrl' => 'NONE',
            ],
        ],
        array $extres = [ ]
    ) {
        // テンプレートパスをアプリケーション格納フォルダ配下に限定
        $tmpl_path = str_replace( DS . DS, DS, RISOLUTO_APPS . 'RisolutoApps/' . str_replace( '../', '', $tmpl_path ));

        // テンプレートエンジン関連定義（Smartyを使用）
        $tmpl = new \Smarty;

        //--- テンプレートキャッシュの設定
        $tmpl->setCacheDir( RISOLUTO_CACHE );
        $tmpl->caching = ( isset( $options[ 'cache' ][ 'mode' ] ) ? $options[ 'cache' ][ 'mode' ] : \Smarty::CACHING_LIFETIME_SAVED );
        $tmpl->cache_lifetime = ( isset( $options[ 'cache' ][ 'lifetime' ] ) ? $options[ 'cache' ][ 'lifetime' ] : 3600 );
        $tmpl->cache_modified_check = ( isset( $options[ 'cache' ][ 'modified_check' ] ) ? $options[ 'cache' ][ 'modified_check' ] : true );

        //--- コンパイル済みテンプレートの設定
        $tmpl->setCompileDir( RISOLUTO_CACHE );
        $tmpl->compile_check = ( isset( $options[ 'compile' ][ 'check' ] ) ? $options[ 'compile' ][ 'check' ] : true );
        $tmpl->force_compile = ( isset( $options[ 'compile' ][ 'force' ] ) ? $options[ 'compile' ][ 'force' ] : false );

        //--- テンプレート用コンフィグファイルの設定
        $tmpl->setConfigDir( $tmpl_path );

        //--- テンプレートのデバッグ設定
        $tmpl->debugging = ( isset( $options[ 'debug' ][ 'enable' ] ) ? $options[ 'debug' ][ 'enable' ] : false );
        $tmpl->debugging_ctrl = ( isset( $options[ 'debug' ][ 'ctrl' ] ) ? $options[ 'debug' ][ 'ctrl' ] : 'NONE' );

        //--- テンプレートファイルのパス
        $tmpl->setTemplateDir( $tmpl_path );

        // 外部リソースの登録
        if (isset( $extres )) {
            foreach ($extres as $dat) {
                if (isset( $dat[ 'name' ] ) and isset( $dat[ 'class' ] )) {
                    $tmpl->register_resource(
                        $dat[ 'name' ],
                        [ $dat[ 'class' ], 'getTemplate', 'getTimeStamp', 'getSecure', 'getTrusted' ]
                    );
                }
            }

        }

        return $tmpl;
    }

    /**
     * assignTemplate(\Smarty $tmpl_instance,array $values)
     *
     * テンプレートに表示内容をアサインする
     *
     * @access    private
     *
     * @param     \Smarty $tmpl_instance テンプレートエンジンのインスタンス
     * @param     array   $values アサイン内容
     *
     * @return    boolean   常にtrue
     */
    private function assignTemplate( \Smarty $tmpl_instance, array $values )
    {
        // デフォルトでテンプレートに引き渡す情報
        $tmpl_instance->assign( '__RISOLUTO_APPS', RISOLUTO_APPS );

        // 与えられた引数の内容をテンプレートにアサインする
        foreach ($values as $key => $val) {
            $tmpl_instance->assign( $key, $val );
        }

        // 戻り値を返却
        return true;
    }

    /**
     * dispTemplate(\Smarty $tmpl_instance, $tmpl_name, $mode = 'view')
     *
     * テンプレートを表示または表示内容を取得する
     *
     * @access    private
     *
     * @param     \Smarty $tmpl_instance テンプレートエンジンのインスタンス
     * @param     string  $tmpl_name テンプレート名
     * @param     string  $mode モード（view:そのまま表示/fetch:表示内容を取得）
     *
     * @return    mixed     $mode=view:常にtrue / $mode=fetch:表示内容/想定外の場合：false
     */
    private function dispTemplate(
        \Smarty $tmpl_instance,
        $tmpl_name,
        $mode = 'view'
    ) {
        // $modeに応じて呼び出すメソッドを変更する
        switch ($mode) {
            // 変数格納時の時
            case 'fetch':
                $retval = $tmpl_instance->fetch( $tmpl_name );
                break;

            // 画面表示の時（デフォルト）
            case 'view': // FALL THRU
            default:
                $tmpl_instance->display( $tmpl_name );
                $retval = true;
                break;
        }

        // 戻り値を返却
        return $retval;
    }

    /**
     * getDefaultHeader()
     *
     * デフォルトのヘッダ情報が格納された配列を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    array   デフォルトのヘッダ
     */
    private function getDefaultHeader()
    {
        // Risolutoのコンフィグからテーマの情報を取得する
        $conf = new Conf();
        $conf->parse( RISOLUTO_CONF . 'risoluto.ini' );
        $outboards = $conf->getIni( 'THEME', 'outboards' );

        return [
            'robots' => $this->getDefaultHeaderRobots(), // robots
            'description' => $this->getDefaultHeaderDescription(), // Description
            'keywords' => $this->getDefaultHeaderKeywords(), // Keywords
            'author' => $this->getDefaultHeaderAuthor(), // Author
            'css' => $this->getDefaultHeaderCss( $outboards ), // CSS
            'js' => $this->getDefaultHeaderJavaScript( $outboards ), // JavaScript
            'favicon' => $this->getDefaultHeaderFavicon( $outboards ), // Favicon
            'title' => $this->getDefaultHeaderTitle(), // Title
            'outboards' => $outboards, // テーマ格納ディレクトリ名
        ];
    }


    /**
     * replaceHeader()
     *
     * ヘッダ情報を置き換える
     *
     * @access    private
     *
     * @param     array  $target ヘッダ情報がセットされた配列(GetDefaultHeader()の戻り値など)
     * @param     string $key 置き換えるヘッダのキー
     * @param     string $val 置き換える値
     *
     * @return    array   変更後のヘッダ情報がセットされた配列 / false: 変更失敗
     */
    private function replaceHeader( array $target, $key, $val )
    {
        // ヘッダ情報の格納された配列が存在しなければ即時戻る
        if (empty( $target )) {
            return false;
        }

        // 既存の項目が存在していたら置き換え、存在していなければ失敗とみなす
        if (array_key_exists( $key, $target )) {
            $target[ $key ] = $val;
        } else {
            return false;
        }

        return $target;
    }

    /**
     * getDefaultHeaderRobots()
     *
     * デフォルトのヘッダ情報（robots）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(robots)
     */
    private function getDefaultHeaderRobots()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderRobots' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderRobots();
        } else {
            return 'INDEX,FOLLOW';
        }
    }

    /**
     * getDefaultHeaderDescription()
     *
     * デフォルトのヘッダ情報（description）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(description)
     */
    private function getDefaultHeaderDescription()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderDescription' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderDescription();
        } else {
            return 'Risoluto';
        }
    }

    /**
     * getDefaultHeaderKeywords()
     *
     * デフォルトのヘッダ情報（keywords）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(keywords)
     */
    private function getDefaultHeaderKeywords()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderKeywords' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderKeywords();
        } else {
            return 'Risoluto';
        }
    }

    /**
     * getDefaultHeaderAuthor()
     *
     * デフォルトのヘッダ情報（author）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(author)
     */
    private function getDefaultHeaderAuthor()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderAuthor' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderAuthor();
        } else {
            return 'Risoluto';
        }
    }

    /**
     * getDefaultHeaderCss()
     *
     * デフォルトのヘッダ情報（CSS）を返却する
     *
     * @access    private
     *
     * @param     string $outboards テーマ格納ディレクトリ名
     *
     * @return    string   デフォルトのヘッダ(CSS)
     */
    private function getDefaultHeaderCss( $outboards )
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderCss' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderCss();
        } else {
            return [
                '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css',
                '/outboards/' . $outboards . '/css/common.css'
            ];
        }
    }

    /**
     * getDefaultHeaderJavaScript()
     *
     * デフォルトのヘッダ情報（JavaScript）を返却する
     *
     * @access    private
     *
     * @param     string $outboards テーマ格納ディレクトリ名
     *
     * @return    string   デフォルトのヘッダ(JavaScript)
     */
    private function getDefaultHeaderJavaScript( $outboards )
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderJs' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderJs();
        } else {
            return [
                '//code.jquery.com/jquery-2.1.1.min.js',
                '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js',
                '/outboards/' . $outboards . '/js/common.js',
            ];
        }
    }

    /**
     * getDefaultHeaderFavicon()
     *
     * デフォルトのヘッダ情報（favicon）を返却する
     *
     * @access    private
     *
     * @param     string $outboards テーマ格納ディレクトリ名
     *
     * @return    string   デフォルトのヘッダ(favicon)
     */
    private function getDefaultHeaderFavicon( $outboards )
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderFavicon' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderFavicon();
        } else {
            return '/outboards/' . $outboards . '/img/favicon.ico';
        }
    }

    /**
     * getDefaultHeaderTitle()
     *
     * デフォルトのヘッダ情報（title）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(title)
     */
    private function getDefaultHeaderTitle()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass( get_called_class() );
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists( $parent->getName(), 'getUserHeaderTitle' )) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderTitle();
        } else {
            return 'ようこそ！Risolutoの世界へ！';
        }
    }
}
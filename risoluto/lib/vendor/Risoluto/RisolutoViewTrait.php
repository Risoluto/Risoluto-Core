<?php
/**
 * RisolutoViewTrait
 *
 * View関連用メソッドTrait
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

trait RisolutoViewTrait
{
    /**
     * risolutoView($tmpl_path = '', array $assign_values, $tmpl_name = '', $mode = 'view')
     *
     * Viewに関する処理を実行する（ヘルパーメソッド）
     *
     * @access    private
     *
     * @param     array  $assign_values テンプレートへのアサイン内容
     * @param     string $mode          モード（view:そのまま表示/fetch:表示内容を取得）
     *
     * @return    mixed     $mode=view:常にtrue / $mode=fetch:表示内容/想定外の場合：false
     */
    private function risolutoView(array $assign_values = array(), $mode = 'view')
    {
        // 呼び出し元クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());

        // テンプレートエンジンを初期設定してインスタンスを取得
        $tmpl_instance = $this->initTemplate(str_replace('RisolutoApps', '', str_replace('\\', DIRECTORY_SEPARATOR, $called->getNamespaceName()) . DIRECTORY_SEPARATOR));

        // テンプレートに値をアサイン
        $this->assignTemplate($tmpl_instance, $assign_values);

        // テンプレート処理を実行して結果を返す
        return $this->dispTemplate($tmpl_instance, $called->getShortName() . '.tpl', $mode);
    }

    /**
     * initTemplate($tmpl_path = '')
     *
     * テンプレートエンジンのインスタンスを生成する
     *
     * @access    private
     *
     * @param     string $tmpl_path テンプレートファイルが格納されているディレクトリのパス
     *
     * @return    object    テンプレートエンジンのインスタンス
     */
    private function initTemplate($tmpl_path = '')
    {
        // テンプレートパスをアプリケーション格納フォルダ配下に限定
        $tmpl_path = RISOLUTO_APPS . 'RisolutoApps/' . str_replace('../', '', $tmpl_path);

        // テンプレートエンジン関連定義（Smartyを使用）
        $tmpl = new \Smarty;

        //--- テンプレートキャッシュの設定
        $tmpl->caching = \Smarty::CACHING_OFF;
        $tmpl->setCacheDir(RISOLUTO_CACHE);
        $tmpl->cache_modified_check = true;
        $tmpl->cache_lifetime       = 0;

        //--- コンパイル済みテンプレートの設定
        $tmpl->compile_check = true;
        $tmpl->setCompileDir(RISOLUTO_CACHE);
        $tmpl->force_compile = true;

        //--- テンプレート用コンフィグファイルの設定
        $tmpl->setConfigDir($tmpl_path);

        //--- テンプレートのデバッグ設定
        $tmpl->debugging      = false;
        $tmpl->debugging_ctrl = 'NONE';

        //--- テンプレートファイルのパス
        $tmpl->setTemplateDir($tmpl_path);

        return $tmpl;
    }

    /**
     * assignTemplate(\Smarty $tmpl_instance,array $values)
     *
     * テンプレートに表示内容をアサインする
     *
     * @access    private
     *
     * @param     object $tmpl_instance テンプレートエンジンのインスタンス
     * @param     array  $values        アサイン内容
     *
     * @return    boolean   常にtrue
     */
    private function assignTemplate(\Smarty $tmpl_instance, array $values)
    {
        // デフォルトでテンプレートに引き渡す情報
        $tmpl_instance->assign('__RISOLUTO_APPS', RISOLUTO_APPS);

        // 与えられた引数の内容をテンプレートにアサインする
        foreach ($values as $key => $val) {
            $tmpl_instance->assign($key, $val);
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
     * @param     object $tmpl_instance テンプレートエンジンのインスタンス
     * @param     string $tmpl_name     テンプレート名
     * @param     string $mode          モード（view:そのまま表示/fetch:表示内容を取得）
     *
     * @return    mixed     $mode=view:常にtrue / $mode=fetch:表示内容/想定外の場合：false
     */
    private function dispTemplate(\Smarty $tmpl_instance, $tmpl_name, $mode = 'view')
    {
        // $modeに応じて呼び出すメソッドを変更する
        switch ($mode) {
            // 変数格納時の時
            case 'fetch':
                $retval = $tmpl_instance->fetch($tmpl_name);
                break;

            // 画面表示の時（デフォルト）
            case 'view': // FALL THRU
            default:
                $tmpl_instance->display($tmpl_name);
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
        $conf->parse(RISOLUTO_CONF . 'risoluto.ini');
        $outboards = $conf->getIni('THEME', 'outboards');

        return array(
            'robots'      => $this->getDefaultHeaderRobots(), // robots
            'description' => $this->getDefaultHeaderDescription(), // Description
            'keywords'    => $this->getDefaultHeaderKeywords(), // Keywords
            'author'      => $this->getDefaultHeaderAuthor(), // Author
            'css'         => $this->getDefaultHeaderCss($outboards), // CSS
            'js'          => $this->getDefaultHeaderJavaScript($outboards), // JavaScript
            'favicon'     => $this->getDefaultHeaderFavicon($outboards), // Favicon
            'title'       => $this->getDefaultHeaderTitle(), // Title
            'outboards'   => $outboards, // テーマ格納ディレクトリ名
            'mobile'      => $this->getDefaultHeaderMobile() // モバイル判定情報
        );
    }


    /**
     * replaceHeader()
     *
     * ヘッダ情報を置き換える
     *
     * @access    private
     *
     * @param     array  $target ヘッダ情報がセットされた配列(GetDefaultHeader()の戻り値など)
     * @param     string $key    置き換えるヘッダのキー
     * @param     string $val    置き換える値
     *
     * @return    array   変更後のヘッダ情報がセットされた配列 / false: 変更失敗
     */
    private function replaceHeader(array $target, $key, $val)
    {
        // ヘッダ情報の格納された配列が存在しなければ即時戻る
        if (empty($target)) {
            return false;
        }

        // 既存の項目が存在していたら置き換え、存在していなければ失敗とみなす
        if (array_key_exists($key, $target)) {
            $target[$key] = $val;
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
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderRobots')) {
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
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderDescription')) {
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
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderKeywords')) {
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
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderAuthor')) {
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
    private function getDefaultHeaderCss($outboards)
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderCss')) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderCss();
        } else {
            return array(
                '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css',
//                'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css',
                '/outboards/' . $outboards . '/css/common.css'
            );
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
    private function getDefaultHeaderJavaScript($outboards)
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderJs')) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderJs();
        } else {
            return array(
                '//code.jquery.com/jquery-2.1.1.min.js',
                '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js',
                '/outboards/' . $outboards . '/js/common.js'
            );
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
    private function getDefaultHeaderFavicon($outboards)
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderFavicon')) {
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
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'getUserHeaderTitle')) {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::getUserHeaderTitle();
        } else {
            return 'ようこそ！Risolutoの世界へ！';
        }
    }

    /**
     * getDefaultHeaderMobile()
     *
     * デフォルトのヘッダ情報（mobile）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    array   デフォルトのヘッダ(mobile)
     */
    private function getDefaultHeaderMobile()
    {
        // Mobile Detectのインスタンスを作成
        $mb = new \Mobile_Detect;

        return array(
            'isMobile' => $mb->isMobile(),
            'isTablet' => $mb->isTablet()
        );
    }
}
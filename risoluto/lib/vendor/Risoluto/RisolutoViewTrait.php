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
     * RisolutoView($tmpl_path = '', array $assign_values, $tmpl_name = '', $mode = 'view')
     *
     * Viewに関する処理を実行する（ヘルパークラス）
     *
     * @access    private
     *
     * @param     array  $values テンプレートへのアサイン内容
     * @param     string $mode   モード（view:そのまま表示/fetch:表示内容を取得）
     *
     * @return    mixed     $mode=view:常にtrue / $mode=fetch:表示内容/想定外の場合：false
     */
    private function RisolutoView(array $assign_values = array(), $mode = 'view')
    {
        // 呼び出し元クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());

        // テンプレートエンジンを初期設定してインスタンスを取得
        $tmpl_instance = $this->InitTemplate(str_replace(array('RisolutoApps', '\\'), '', $called->getNamespaceName()) . DIRECTORY_SEPARATOR);

        // テンプレートに値をアサイン
        $this->AssignTemplate($tmpl_instance, $assign_values);

        // テンプレート処理を実行して結果を返す
        return $this->DispTemplate($tmpl_instance, $called->getShortName() . '.tpl', $mode);
    }

    /**
     * InitTemplate($tmpl_path = '')
     *
     * テンプレートエンジンのインスタンスを生成する
     *
     * @access    private
     *
     * @param     string $tmpl_path テンプレートファイルが格納されているディレクトリのパス
     *
     * @return    object    テンプレートエンジンのインスタンス
     */
    private function InitTemplate($tmpl_path = '')
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
     * AssignTemplate(\Smarty $tmpl_instance,array $values)
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
    private function AssignTemplate(\Smarty $tmpl_instance, array $values)
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
     * DispTemplate(\Smarty $tmpl_instance, $tmpl_name, $mode = 'view')
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
    private function DispTemplate(\Smarty $tmpl_instance, $tmpl_name, $mode = 'view')
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
     * GetDefaultHeader()
     *
     * デフォルトのヘッダ情報が格納された配列を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    array   デフォルトのヘッダ
     */
    private function GetDefaultHeader()
    {
        // Risolutoのコンフィグからテーマの情報を取得する
        $conf = new Conf();
        $conf->parse(RISOLUTO_CONF . 'risoluto.ini');
        $outboards = $conf->GetIni('THEME', 'outboards');

        return array(
            'robots'      => $this->GetDefaultHeaderRobots(), // robots
            'description' => $this->GetDefaultHeaderDescription(), // Description
            'keywords'    => $this->GetDefaultHeaderKeywords(), // Keywords
            'author'      => $this->GetDefaultHeaderAuthor(), // Author
            'css'         => $this->GetDefaultHeaderCss($outboards), // CSS
            'js'          => $this->GetDefaultHeaderJavaScript($outboards), // JavaScript
            'favicon'     => $this->GetDefaultHeaderFavicon($outboards), // Favicon
            'title'       => $this->GetDefaultHeaderTitle(), // Title
            'outboards'   => $outboards, // テーマ格納ディレクトリ名
            'mobile'      => $this->GetDefaultHeaderMobile() // モバイル判定情報
        );
    }


    /**
     * ReplaceHeader()
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
    private function ReplaceHeader(array $target, $key, $val)
    {
        // ヘッダ情報の格納された配列が存在しなければ即時戻る
        if (empty($target)){
            return false;
        }

        // 既存の項目が存在していたら置き換え、存在していなければ失敗とみなす
        if (array_key_exists($key, $target)) {
            $target[$key] = $val;
        }else{
            return false;
        }

        return $target;
    }

    /**
     * GetDefaultHeaderRobots()
     *
     * デフォルトのヘッダ情報（robots）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(robots)
     */
    private function GetDefaultHeaderRobots()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderRobots')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderRobots();
        } else {
            return 'INDEX,FOLLOW';
        }
    }

    /**
     * GetDefaultHeaderDescription()
     *
     * デフォルトのヘッダ情報（description）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(description)
     */
    private function GetDefaultHeaderDescription()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderDescription')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderDescription();
        } else {
            return 'Risoluto';
        }
    }

    /**
     * GetDefaultHeaderKeywords()
     *
     * デフォルトのヘッダ情報（keywords）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(keywords)
     */
    private function GetDefaultHeaderKeywords()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderKeywords')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderKeywords();
        } else {
            return 'Risoluto';
        }
    }

    /**
     * GetDefaultHeaderAuthor()
     *
     * デフォルトのヘッダ情報（author）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(author)
     */
    private function GetDefaultHeaderAuthor()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderAuthor')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderAuthor();
        } else {
            return 'Risoluto';
        }
    }

    /**
     * GetDefaultHeaderCss()
     *
     * デフォルトのヘッダ情報（CSS）を返却する
     *
     * @access    private
     *
     * @param     string $outboards テーマ格納ディレクトリ名
     *
     * @return    string   デフォルトのヘッダ(CSS)
     */
    private function GetDefaultHeaderCss($outboards)
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderCss')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderCss();
        } else {
            return array(
                '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
                '/outboards/' . $outboards . '/css/common.css'
            );
        }
    }

    /**
     * GetDefaultHeaderJavaScript()
     *
     * デフォルトのヘッダ情報（JavaScript）を返却する
     *
     * @access    private
     *
     * @param     string $outboards テーマ格納ディレクトリ名
     *
     * @return    string   デフォルトのヘッダ(JavaScript)
     */
    private function GetDefaultHeaderJavaScript($outboards)
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderJs')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderJs();
        } else {
            return array(
                '//code.jquery.com/jquery-2.1.1.min.js',
                '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',
                '/outboards/' . $outboards . '/js/common.js'
            );
        }
    }

    /**
     * GetDefaultHeaderFavicon()
     *
     * デフォルトのヘッダ情報（favicon）を返却する
     *
     * @access    private
     *
     * @param     string $outboards テーマ格納ディレクトリ名
     *
     * @return    string   デフォルトのヘッダ(favicon)
     */
    private function GetDefaultHeaderFavicon($outboards)
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderFavicon')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderFavicon();
        } else {
            return '/outboards/' . $outboards . '/img/favicon.ico';
        }
    }

    /**
     * GetDefaultHeaderTitle()
     *
     * デフォルトのヘッダ情報（title）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string   デフォルトのヘッダ(title)
     */
    private function GetDefaultHeaderTitle()
    {
        // 親クラスの情報を取得
        $called = new \ReflectionClass(get_called_class());
        $parent = $called->getParentClass();

        // 基底クラスでオーバーライド用メソッドが定義されていたらそちらを優先する
        if (method_exists($parent->getName(), 'GetUserHeaderTitle')){
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::GetUserHeaderTitle();
        } else {
            return 'ようこそ！Risolutoの世界へ！';
        }
    }

    /**
     * GetDefaultHeaderMobile()
     *
     * デフォルトのヘッダ情報（mobile）を返却する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    array   デフォルトのヘッダ(mobile)
     */
    private function GetDefaultHeaderMobile()
    {
        // Mobile Detectのインスタンスを作成
        $mb = new \Mobile_Detect;

        return array(
            'isMobile' => $mb->isMobile(),
            'isTablet' => $mb->isTablet()
        );
    }
}
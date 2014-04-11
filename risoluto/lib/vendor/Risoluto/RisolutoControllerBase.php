<?php
/**
 * RisolutoControllerBase
 *
 * ユーザアプリ向けコントローラ用基底クラス
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

use \Smarty;
use \Risoluto\Conf;

abstract class RisolutoControllerBase
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $param
     * @access private
     * @var    array    コール時に取得されたデータを格納する配列
     */
    private $__param;

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * __construct()
     *
     * コンストラクタ
     */
    public function __construct()
    {
    }

    /**
     * GetParam()
     *
     * コール時に渡されたパラメタ情報を取得する
     *
     * @access    protected
     *
     * @param     void なし
     *
     * @return    array    パラメタ情報
     */
    protected function GetParam()
    {
        return $this->__param;
    }

    /**
     * InitTemplate()
     *
     * テンプレートエンジンのインスタンスを生成する
     *
     * @access    protected
     *
     * @param     string $tmpl_path テンプレートファイルが格納されているディレクトリのパス
     *
     * @return    object    テンプレートエンジンのインスタンス
     */
    protected function InitTemplate($tmpl_path = '')
    {
        // テンプレートパスをアプリケーション格納フォルダ配下に限定
        $tmpl_path = RISOLUTO_APPS . 'RisolutoApps/' . str_replace('../', '', $tmpl_path);

        // テンプレートエンジン関連定義（Smartyを使用）
        $tmpl = new Smarty;

        //--- テンプレートキャッシュの設定
        $tmpl->caching              = Smarty::CACHING_OFF;
        $tmpl->cache_dir            = RISOLUTO_CACHE;
        $tmpl->cache_modified_check = true;
        $tmpl->cache_lifetime       = 0;

        //--- コンパイル済みテンプレートの設定
        $tmpl->compile_check = true;
        $tmpl->compile_dir   = RISOLUTO_CACHE;
        $tmpl->force_compile = true;

        //--- テンプレート用コンフィグファイルの設定
        $tmpl->config_dir = $tmpl_path;

        //--- テンプレートのデバッグ設定
        $tmpl->debugging      = false;
        $tmpl->debugging_ctrl = 'NONE';

        //--- テンプレートファイルのパス
        $tmpl->template_dir = $tmpl_path;

        return $tmpl;
    }

    /**
     * AssignTemplate()
     *
     * テンプレートに表示内容をアサインする
     *
     * @access    protected
     *
     * @param     object $tmpl_instance テンプレートエンジンのインスタンス
     * @param     array  $values        アサイン内容
     *
     * @return    boolean   常にtrue
     */
    protected function AssignTemplate($tmpl_instance, $values)
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
     * DispTemplate()
     *
     * テンプレートを表示または表示内容を取得する
     *
     * @access    protected
     *
     * @param     object $tmpl_instance テンプレートエンジンのインスタンス
     * @param     string $tmpl_name     テンプレート名
     * @param     string $mode          モード（view:そのまま表示/fetch:表示内容を取得）
     *
     * @return    mixed     $mode=view:常にtrue / $mode=fetch:表示内容/想定外の場合：false
     */
    protected function DispTemplate($tmpl_instance, $tmpl_name, $mode = 'view')
    {
        // 戻り値を保持する変数
        $retval = false;

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
     * @access    protected
     *
     * @param     void    なし
     *
     * @return    array   デフォルトのヘッダ
     */
    public function GetDefaultHeader()
    {
        // Risolutoのコンフィグからテーマの情報を取得する
        $conf = new Conf();
        $conf->parse(RISOLUTO_CONF . 'risoluto.ini');
        $outboards = $conf->GetIni('THEME', 'outboards');

        return array(
            // ROBOTS
            'robots'      => 'index,follow',

            // Description
            'Description' => 'Risoluto',

            // Keywords
            'keywords'    => 'Risoluto',

            // Author
            'author'      => 'Risoluto',

            // CSS
            'css'         => array(
                'outboards/' . $outboards . '/css/common.css'
            ),

            // JavaScript
            'js'          => array(
                '//code.jquery.com/jquery-2.1.0.min.js',
                '//code.jquery.com/ui/1.10.4/jquery-ui.min.js',
                'outboards/' . $outboards . '/js/common.js'
            ),

            // テーマが格納されたディレクトリ名
            'favicon'     => 'outboards/' . $outboards . '/img/favicon.ico',

            // タイトル
            'title'       => 'ようこそ！Risolutoの世界へ！',

            // テーマが格納されたディレクトリ名
            'outboards'   => $outboards
        );
    }

    /**
     * Init($param = array())
     *
     * 初期化処理を行う
     *
     * @access    public
     *
     * @param     array 当該クラスに関するパラメタ情報
     *
     * @return    void     なし
     */
    public function Init($param = array())
    {
        // 取得したパラメタをクラス変数にセットする
        $this->__param = $param;

        return true;
    }

    /**
     * Play()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function Play()
    {
        return true;
    }

    /**
     * PlayGet()
     *
     * GETメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayGet()
    {
        $this->Play();

        return true;
    }

    /**
     * PlayPost()
     *
     * POSTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayPost()
    {
        $this->Play();

        return true;
    }

    /**
     * PlayPut()
     *
     * PUTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayPut()
    {
        $this->Play();

        return true;
    }

    /**
     * PlayDelete()
     *
     * DELETEメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayDelete()
    {
        $this->Play();

        return true;
    }

    /**
     * PlayOption()
     *
     * OPTIONメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayOption()
    {
        $this->Play();

        return true;
    }

    /**
     * PlayHead()
     *
     * HEADメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayHead()
    {
        $this->Play();

        return true;
    }

    /**
     * PlayTrace()
     *
     * TRACEメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayTrace()
    {
        $this->Play();

        return true;
    }

    /**
     * PlayConnect()
     *
     * CONNECTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function PlayConnect()
    {
        $this->Play();

        return true;
    }

    /**
     * Error()
     *
     * エラー処理を行う
     *
     * @access    public
     *
     * @param     object エラーオブジェクト
     *
     * @return    void      なし
     */
    public function Error($errobj = null)
    {
        return true;
    }

    /**
     * Clean()
     *
     * 後処理を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    void    なし
     */
    public function Clean()
    {
        return true;
    }
}

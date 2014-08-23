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
     * @param     void
     *
     * @return    array    パラメタ情報
     */
    protected function GetParam()
    {
        return $this->__param;
    }

    /**
     * InitTemplate($tmpl_path = '')
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
     * @access    protected
     *
     * @param     object $tmpl_instance テンプレートエンジンのインスタンス
     * @param     array  $values        アサイン内容
     *
     * @return    boolean   常にtrue
     */
    protected function AssignTemplate(\Smarty $tmpl_instance, array $values)
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
     * @access    protected
     *
     * @param     object $tmpl_instance テンプレートエンジンのインスタンス
     * @param     string $tmpl_name     テンプレート名
     * @param     string $mode          モード（view:そのまま表示/fetch:表示内容を取得）
     *
     * @return    mixed     $mode=view:常にtrue / $mode=fetch:表示内容/想定外の場合：false
     */
    protected function DispTemplate(\Smarty $tmpl_instance, $tmpl_name, $mode = 'view')
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
     * @access    protected
     *
     * @param     void
     *
     * @return    array   デフォルトのヘッダ
     */
    protected function GetDefaultHeader()
    {
        // Risolutoのコンフィグからテーマの情報を取得する
        $conf = new Conf();
        $conf->parse(RISOLUTO_CONF . 'risoluto.ini');
        $outboards = $conf->GetIni('THEME', 'outboards');

        // Mobile Detectのインスタンスを作成
        $mb = new \Mobile_Detect;

        return array(
            // ROBOTS
            'robots'      => 'INDEX,FOLLOW',

            // Description
            'Description' => 'Risoluto',

            // Keywords
            'keywords'    => 'Risoluto',

            // Author
            'author'      => 'Risoluto',

            // CSS
            'css'         => array(
                '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
                '/outboards/' . $outboards . '/css/common.css'
            ),

            // JavaScript
            'js'          => array(
                '//code.jquery.com/jquery-2.1.1.min.js',
                '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',
                '/outboards/' . $outboards . '/js/common.js'
            ),

            // テーマが格納されたディレクトリ名
            'favicon'     => '/outboards/' . $outboards . '/img/favicon.ico',

            // タイトル
            'title'       => 'ようこそ！Risolutoの世界へ！',

            // テーマが格納されたディレクトリ名
            'outboards'   => $outboards,

            // アクセス元のデバイス
            'mobile'      => array(
                'isMobile' => $mb->isMobile(),
                'isTablet' => $mb->isTablet()
            )
        );
    }

    /**
     * Init($param = array())
     *
     * 初期化処理を行う
     *
     * @access    public
     *
     * @param     array $param 当該クラスに関するパラメタ情報
     *
     * @return    void     なし
     */
    public function Init(array $param = array())
    {
        // 取得したパラメタをクラス変数にセットする
        $this->__param = $param;
    }

    /**
     * Play()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function Play()
    {
    }

    /**
     * PlayGet()
     *
     * GETメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayGet()
    {
        $this->Play();
    }

    /**
     * PlayPost()
     *
     * POSTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayPost()
    {
        $this->Play();
    }

    /**
     * PlayPut()
     *
     * PUTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayPut()
    {
        $this->Play();
    }

    /**
     * PlayDelete()
     *
     * DELETEメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayDelete()
    {
        $this->Play();
    }

    /**
     * PlayOption()
     *
     * OPTIONメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayOption()
    {
        $this->Play();
    }

    /**
     * PlayHead()
     *
     * HEADメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayHead()
    {
        $this->Play();
    }

    /**
     * PlayTrace()
     *
     * TRACEメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayTrace()
    {
        $this->Play();
    }

    /**
     * PlayConnect()
     *
     * CONNECTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function PlayConnect()
    {
        $this->Play();
    }

    /**
     * Error(\Exception $errobj = null)
     *
     * エラー処理を行う
     *
     * @access    public
     *
     * @param     object $errobj 例外オブジェクト
     *
     * @return    void      なし
     */
    public function Error(\Exception $errobj = null)
    {
        if ($errobj) {
            trigger_error($errobj->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * Clean()
     *
     * 後処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function Clean()
    {
    }
}

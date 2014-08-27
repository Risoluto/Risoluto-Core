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
    use RisolutoErrorLogTrait;

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
        // エラー情報をログに出力
        if ($errobj) {
            $msg = $errobj->getMessage();
        } else {
            $msg = 'Unknown error occurred.';
        }
        $this->RisolutoErrorLog('error', 'Class => ' . get_class($this) . ' / Error Message => ' . $msg);

        // エラー画面に遷移する
        Url::RedirectTo('Error');
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

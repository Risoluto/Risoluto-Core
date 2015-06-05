<?php
/**
 * RisolutoControllerBase
 *
 * ユーザアプリ向けコントローラ用基底クラス
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
     * getParam()
     *
     * コール時に渡されたパラメタ情報を取得する
     *
     * @access    protected
     *
     * @param     void
     *
     * @return    array    パラメタ情報
     */
    protected function getParam()
    {
        return $this->__param;
    }

    /**
     * init($param = [])
     *
     * 初期化処理を行う
     *
     * @access    public
     *
     * @param     array $param 当該クラスに関するパラメタ情報
     *
     * @return    void     なし
     */
    public function init( array $param = [ ] )
    {
        // 取得したパラメタをクラス変数にセットする
        $this->__param = $param;
    }

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
    }

    /**
     * playGet()
     *
     * GETメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playGet()
    {
        $this->play();
    }

    /**
     * playPost()
     *
     * POSTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playPost()
    {
        $this->play();
    }

    /**
     * playPut()
     *
     * PUTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playPut()
    {
        $this->play();
    }

    /**
     * playDelete()
     *
     * DELETEメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playDelete()
    {
        $this->play();
    }

    /**
     * playOption()
     *
     * OPTIONメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playOption()
    {
        $this->play();
    }

    /**
     * playHead()
     *
     * HEADメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playHead()
    {
        $this->play();
    }

    /**
     * playTrace()
     *
     * TRACEメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playTrace()
    {
        $this->play();
    }

    /**
     * playConnect()
     *
     * CONNECTメソッドでアクセスされた際の主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function playConnect()
    {
        $this->play();
    }

    /**
     * error(\Exception $errobj = null)
     *
     * エラー処理を行う
     *
     * @access    public
     *
     * @param     object $errobj 例外オブジェクト
     *
     * @return    void      なし
     */
    public function error( \Exception $errobj = null )
    {
        // エラー情報をログに出力
        if ($errobj) {
            $msg = $errobj->getMessage();
        } else {
            $msg = 'Unknown error occurred.';
        }
        $this->risolutoErrorLog( 'error', 'Class => ' . get_class( $this ) . ' / Error Message => ' . $msg );

        // エラー画面に遷移する
        Url::redirectTo( 'Error' );
    }

    /**
     * clean()
     *
     * 後処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function clean()
    {
        // Nothing to do...
    }
}

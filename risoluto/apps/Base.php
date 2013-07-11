<?php
/**
 * Base
 *
 * 基底クラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
abstract class Base
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * Init($param = array())
     *
     * 初期化処理を行う
     *
     * @access    public
     * @param     array    当該クラスに関するパラメタ情報
     * @return    void     なし
     */
    public function Init($param = array())
    {
        return true;
    }

    /**
     * Play()
     *
     * 主処理を行う
     *
     * @access    public
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     void    なし
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
     * @param     object    エラーオブジェクト
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
     * @param     void    なし
     * @return    void    なし
     */
    public function Clean()
    {
        return true;
    }
}

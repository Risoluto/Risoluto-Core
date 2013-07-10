<?php
/**
 * RisolutoApps\Base
 *
 * 基底クラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Base;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Base
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
    abstract function Pray();

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

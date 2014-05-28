<?php
/**
 * RisolutoModelBase
 *
 * ユーザアプリ向けモデル用基底クラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

// ToDo: \Risoluto\Dbクラス作成後にいい感じにする

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

abstract class RisolutoModelBase
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $obj_db
     * @access private
     * @var    object    Dbクラスのオブジェクト
     */
    private $__obj_db;

    /**
     * __construct()
     *
     * コンストラクタ
     */
    public function __construct()
    {
        $this->__obj_db = new Db();
    }

    /**
     * __destruct()
     *
     * デストラクタ
     */
    public function __destruct()
    {
        unset($this->__obj_db);
    }
}

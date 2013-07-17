<?php
/**
 * CoreTest
 *
 * Core()用テストケース
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
use Risoluto\Core;

//------------------------------------------------------//
// テストクラス定義
//------------------------------------------------------//
class CoreTest extends PHPUnit_Framework_TestCase
{
    //------------------------------------------------------//
    // テストクラス変数定義
    //------------------------------------------------------//
    /**
     * $instance
     * @access protected
     * @var    object    テスト対象インスタンスを保持
     */
    protected $instance;

    //------------------------------------------------------//
    // テストメソッド定義
    //------------------------------------------------------//
    /**
     * setUp()
     *
     * テストに必要な準備を実施
     */
    protected function setUp()
    {
        $this->instance = new Risoluto\Core;
    }

    /**
     * testDummy()
     *
     * ダミー
     */
    public function testDummy()
    {
        $this->markTestIncomplete('We have no idea for this test... I need your help...');
    }
}

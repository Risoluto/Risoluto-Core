<?php
/**
 * ConfTest4Parse
 *
 * Conf::Parse用テストケース
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

//------------------------------------------------------//
// テストクラス定義
//------------------------------------------------------//
class ConfTest4Parse extends \PHPUnit_Framework_TestCase
{
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
    }

    /**
     * test_ParseSet_InvalidFile()
     *
     * Iniファイル形式ではないファイルが指定された場合のParse()の挙動をテストする
     */
    public function test_ParseSet_InvalidFile()
    {
        $instance = new Conf;
        $this->assertFalse($instance->Parse('/dev/null'));
        unset($instance);
    }

    /**
     * test_ParseSet_ValidFile()
     *
     * Iniファイル形式のファイルが指定された場合のParse()の挙動をテストする
     */
    public function test_ParseSet_ValidFile()
    {
        $instance = new Conf;
        $this->assertTrue($instance->Parse(RISOLUTO_CONF . 'risoluto.ini'));
        unset($instance);
    }
}

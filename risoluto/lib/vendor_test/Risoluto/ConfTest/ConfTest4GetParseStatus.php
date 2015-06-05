<?php
/**
 * ConfTest4GetParseStatus
 *
 * Conf::GetParseStatus用テストケース
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

//------------------------------------------------------//
// テストクラス定義
//------------------------------------------------------//
class ConfTest4GetParseStatus extends \PHPUnit_Framework_TestCase
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
     * test_GetParseStatus_BeforeParsed()
     *
     * 未パース時のGetParseStatus()の挙動をテストする
     */
    public function test_GetParseStatus_BeforeParsed()
    {
        $instance = new Conf;
        $this->assertFalse( $instance->getParseStatus() );
        unset( $instance );
    }

    /**
     * test_GetParseStatus_AfterParsed()
     *
     * パース後のGetParseStatus()の挙動をテストする
     */
    public function test_GetParseStatus_AfterParsed()
    {
        $instance = new Conf;
        $instance->parse( RISOLUTO_CONF . 'risoluto.ini' );
        $this->assertTrue( $instance->getParseStatus() );
        unset( $instance );
    }
}

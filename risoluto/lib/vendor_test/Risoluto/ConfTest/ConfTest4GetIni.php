<?php
/**
 * ConfTest4getIni
 *
 * Conf::getIni用テストケース
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
class ConfTest4getIni extends \PHPUnit_Framework_TestCase
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
     * test_getIni_Beforeparsed()
     *
     * 未パース時のgetIni()の挙動をテストする
     */
    public function test_getIni_Beforeparsed()
    {
        $instance = new Conf;
        $this->assertNull( $instance->getIni() );
        unset( $instance );
    }

    /**
     * test_getIni_NoArgs()
     *
     * パース後のgetIni()の挙動をテストする（引数なし）
     */
    public function test_getIni_NoArgs()
    {
        $want = [
            "SEQ" => [
                "default" => "RisolutoApps\\Pages\\View",
                "error" => "RisolutoApps\\Error",
                "servicestop" => "RisolutoApps\\ServiceStop"
            ],
            "LOGGING" => [
                "loglevel" => "warn"
            ],
            "SESSION" => [
                "timeout" => 3600
            ],
            "LIMITS" => [
                "max_loadavg" => 3
            ],
            "THEME" => [
                "outboards" => "vendor"
            ],
            "AUTH" => [
                "provider" => "Risoluto\\AuthDb",
                "users" => "risoluto_users",
                "groups" => "risoluto_groups"
            ],
        ];

        $instance = new Conf;
        $instance->parse( RISOLUTO_CONF . 'risoluto.ini' );
        $this->assertEquals( $instance->getIni(), $want );
        unset( $instance );
    }

    /**
     * test_getIni_WithOneArgs()
     *
     * パース後のgetIni()の挙動をテストする（セクションのみ指定）
     */
    public function test_getIni_WithOneArgs()
    {
        $want = [
            "default" => "RisolutoApps\\Pages\\View",
            "error" => "RisolutoApps\\Error",
            "servicestop" => "RisolutoApps\\ServiceStop"
        ];

        $instance = new Conf;
        $instance->parse( RISOLUTO_CONF . 'risoluto.ini' );
        $this->assertEquals( $instance->getIni( 'SEQ' ), $want );
        unset( $instance );
    }

    /**
     * test_getIni_WithTwoArgs()
     *
     * パース後のgetIni()の挙動をテストする（セクションのみ指定）
     */
    public function test_getIni_WithTwoArgs()
    {
        $want = "RisolutoApps\\Pages\\View";

        $instance = new Conf;
        $instance->parse( RISOLUTO_CONF . 'risoluto.ini' );
        $this->assertEquals( $instance->getIni( 'SEQ', 'default' ), $want );
        unset( $instance );
    }
}

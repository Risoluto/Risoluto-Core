<?php
/**
 * ConfTest4GetIni
 *
 * Conf::GetIni用テストケース
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
class ConfTest4GetIni extends \PHPUnit_Framework_TestCase
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
     * test_GetIni_BeforeParsed()
     *
     * 未パース時のGetIni()の挙動をテストする
     */
    public function test_GetIni_BeforeParsed()
    {
        $instance = new Conf;
        $this->assertNull($instance->GetIni());
        unset($instance);
    }

    /**
     * test_GetIni_NoArgs()
     *
     * パース後のGetIni()の挙動をテストする（引数なし）
     */
    public function test_GetIni_NoArgs()
    {
        $want = array(
            "SEQ"     => array(
                "default"     => "RisolutoApps\\Top",
                "error"       => "RisolutoApps\\Error",
                "servicestop" => "RisolutoApps\\ServiceStop"
            ),

            "LOGGING" => array(
                "loglevel" => "warn"
            ),

            "SESSION" => array(
                "timeout" => 3600
            ),

            "LIMITS"  => array(
                "max_loadavg" => 3
            ),


            "THEME"   => array(
                "outboards" => "vendor"
            )
        );

        $instance = new Conf;
        $instance->Parse(RISOLUTO_CONF . 'risoluto.ini');
        $this->assertEquals($instance->GetIni(), $want);
        unset($instance);
    }

    /**
     * test_GetIni_WithOneArgs()
     *
     * パース後のGetIni()の挙動をテストする（セクションのみ指定）
     */
    public function test_GetIni_WithOneArgs()
    {
        $want = array(
            "default"     => "RisolutoApps\\Top",
            "error"       => "RisolutoApps\\Error",
            "servicestop" => "RisolutoApps\\ServiceStop"
        );

        $instance = new Conf;
        $instance->Parse(RISOLUTO_CONF . 'risoluto.ini');
        $this->assertEquals($instance->GetIni('SEQ'), $want);
        unset($instance);
    }

    /**
     * test_GetIni_WithTwoArgs()
     *
     * パース後のGetIni()の挙動をテストする（セクションのみ指定）
     */
    public function test_GetIni_WithTwoArgs()
    {
        $want = "RisolutoApps\\Top";

        $instance = new Conf;
        $instance->Parse(RISOLUTO_CONF . 'risoluto.ini');
        $this->assertEquals($instance->GetIni('SEQ', 'default'), $want);
        unset($instance);
    }
}

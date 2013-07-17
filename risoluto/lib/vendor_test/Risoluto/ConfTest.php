<?php
/**
 * ConfTest
 *
 * Conf()用テストケース
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */
//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
use Risoluto\Conf;

//------------------------------------------------------//
// テストクラス定義
//------------------------------------------------------//
class ConfTest extends PHPUnit_Framework_TestCase
{
    //------------------------------------------------------//
    // テストクラス変数定義
    //------------------------------------------------------//
    /**
     * $instance
     * @access protected
     * @var    object    テスト対象インスタンスを保持
     */
    protected static $instance;

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
        $this->instance = new Risoluto\Conf;
    }

    /**
     * test_GetParseStatus_BeforeParsed()
     *
     * 未パース時のGetParseStatus()の挙動をテストする
     */
    public function test_GetParseStatus_BeforeParsed()
    {
        $this->assertFalse($this->instance->GetParseStatus());
    }

    /**
     * test_GetIni_BeforeParsed()
     *
     * 未パース時のGetIni()の挙動をテストする
     */
    public function test_GetIni_BeforeParsed()
    {
        $this->assertNull($this->instance->GetIni());
    }

    /**
     * test_ParseSet_InvalidFile()
     *
     * Iniファイル形式ではないファイルが指定された場合のParse()の挙動をテストする
     */
    public function test_ParseSet_InvalidFile()
    {
        $this->assertFalse($this->instance->Parse('/dev/null'));
    }

    /**
     * test_ParseSet_ValidFile()
     *
     * Iniファイル形式のファイルが指定された場合のParse()の挙動をテストする
     */
    public function test_ParseSet_ValidFile()
    {
        $this->assertTrue($this->instance->Parse(RISOLUTO_CONF . 'risoluto.ini'));
    }

    /**
     * test_GetParseStatus_AfterParsed()
     *
     * パース後のGetParseStatus()の挙動をテストする
     * @depends test_ParseSet_ValidFile
     */
    public function test_GetParseStatus_AfterParsed()
    {
        $this->instance->Parse(RISOLUTO_CONF . 'risoluto.ini');

        $this->assertTrue($this->instance->GetParseStatus());
    }

    /**
     * test_GetIni_NoArgs()
     *
     * パース後のGetIni()の挙動をテストする（引数なし）
     * @depends test_ParseSet_ValidFile
     */
    public function test_GetIni_NoArgs()
    {
        $want = array(
                         "SEQ" => array(
                                           "default" => "\\Top",
                                           "error"   => "\\Error",
                                           "servicestop" => "\\ServiceStop"
                                       ),

                         "LOGGING" => array(
                                               "loglevel" => "warn"
                                           ),

                         "SESSION" => array(
                                               "timeout" => 3600
                                           ),

                         "LIMITS" => array(
                                              "max_loadavg" => 3
                                          ),


                         "DB" => array(
                                          "default" => "{DBTYPE}://{USER}:{PASSWORD}@{HOST}/{DBNAME}"
                                      )
                     );
        $this->instance->Parse(RISOLUTO_CONF . 'risoluto.ini');

        $this->assertEquals($this->instance->GetIni(), $want);
    }

    /**
     * test_GetIni_WithOneArgs()
     *
     * パース後のGetIni()の挙動をテストする（セクションのみ指定）
     * @depends test_GetIni_NoArgs
     */
    public function test_GetIni_WithOneArgs()
    {
        $want = array(
                         "default" => "\\Top",
                         "error"   => "\\Error",
                         "servicestop" => "\\ServiceStop"
                     );
        $this->instance->Parse(RISOLUTO_CONF . 'risoluto.ini');

        $this->assertEquals($this->instance->GetIni('SEQ'), $want);
    }

    /**
     * test_GetIni_WithTwoArgs()
     *
     * パース後のGetIni()の挙動をテストする（セクションのみ指定）
     * @depends test_GetIni_WithOneArgs
     */
    public function test_GetIni_WithTwoArgs()
    {
        $want = "\\Top";
        $this->instance->Parse(RISOLUTO_CONF . 'risoluto.ini');

        $this->assertEquals($this->instance->GetIni('SEQ', 'default'), $want);
    }
}

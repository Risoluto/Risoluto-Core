<?php
/**
 * ValidateTest4IsEmailAddr
 *
 * Validate4IsEmailAddr用テストケース
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
class ValidateTest4IsEmailAddr extends \PHPUnit_Framework_TestCase
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
     * test_IsEmailAddr_InvalidTextPart1()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスじゃない文字列その1）
     */
    public function test_IsEmailAddr_InvalidTextPart1()
    {
        $test = '@risoluto This is test!';

        $this->assertFalse(Validate::IsEmailAddr($test));
    }

    /**
     * test_IsEmailAddr_InvalidText()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスじゃない文字列その2）
     */
    public function test_IsEmailAddr_InvalidTextPart2()
    {
        $test = 'test+test-test.test@risoluto_test-test+test.jp';

        $this->assertFalse(Validate::IsEmailAddr($test));
    }

    /**
     * test_IsEmailAddr_ValidTextPart1()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスな文字列その1）
     */
    public function test_IsEmailAddr_ValidTextPart1()
    {
        $test = 'webmaster@example.net';

        $this->assertTrue(Validate::IsEmailAddr($test));
    }

    /**
     * test_IsEmailAddr_ValidTextPart2()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスな文字列その2）
     */
    public function test_IsEmailAddr_ValidTextPart2()
    {
        $test = 'web_master+test-test.test@example.gr.jp';

        $this->assertTrue(Validate::IsEmailAddr($test));
    }
}
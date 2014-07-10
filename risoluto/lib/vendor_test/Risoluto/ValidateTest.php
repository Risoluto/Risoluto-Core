<?php
/**
 * ValidateTest
 *
 * Validate()用テストケース
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
class ValidateTest extends \PHPUnit_Framework_TestCase
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

    /**
     * test_IsHalfWidth_HalfNumeric()
     *
     * IsHalfWidth()の挙動をテストする（半角数字）
     */
    public function test_IsHalfWidth_HalfNumeric()
    {
        $test = '0';

        $this->assertTrue(Validate::IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_HalfAlphabet()
     *
     * IsHalfWidth()の挙動をテストする（半角英字）
     */
    public function test_IsHalfWidth_HalfAlphabet()
    {
        $test = 'A';

        $this->assertTrue(Validate::IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_HalfSymbol()
     *
     * IsHalfWidth()の挙動をテストする（半角記号）
     */
    public function test_IsHalfWidth_HalfSymbol()
    {
        $test = '+';

        $this->assertTrue(Validate::IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_FullNumeric()
     *
     * IsHalfWidth()の挙動をテストする（全角数字）
     */
    public function test_IsHalfWidth_FullNumeric()
    {
        $test = '０';

        $this->assertFalse(Validate::IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_FullAlphabet()
     *
     * IsHalfWidth()の挙動をテストする（全角英字）
     */
    public function test_IsHalfWidth_FullAlphabet()
    {
        $test = 'Ａ';

        $this->assertFalse(Validate::IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_FullSymbol()
     *
     * IsHalfWidth()の挙動をテストする（全角記号）
     */
    public function test_IsHalfWidth_FullSymbol()
    {
        $test = '＋';

        $this->assertFalse(Validate::IsHalfWidth($test));
    }

    /**
     * test_IsLeapYear_InvalidArgPart1()
     *
     * IsLeapYear()の挙動をテストする（数字2桁）
     */
    public function test_IsLeapYear_InvalidArgPart1()
    {
        $test = '13';

        $this->assertFalse(Validate::IsLeapYear($test));
    }

    /**
     * test_IsLeapYear_InvalidArgPart2()
     *
     * IsLeapYear()の挙動をテストする（英字4桁）
     */
    public function test_IsLeapYear_InvalidArgPart2()
    {
        $test = 'AAAA';

        $this->assertFalse(Validate::IsLeapYear($test));
    }

    /**
     * test_IsLeapYear_ValidArgPart1()
     *
     * IsLeapYear()の挙動をテストする（閏年である）
     */
    public function test_IsLeapYear_ValidArgPart1()
    {
        $test = '2000';

        $this->assertTrue(Validate::IsLeapYear($test));
    }

    /**
     * test_IsLeapYear_ValidArgPart2()
     *
     * IsLeapYear()の挙動をテストする（閏年でない）
     */
    public function test_IsLeapYear_ValidArgPart2()
    {
        $test = '2013';

        $this->assertFalse(Validate::IsLeapYear($test));
    }

    /**
     * test_IsBetween_InRangePart1()
     *
     * IsLeapYear()の挙動をテストする（範囲内：全て同値）
     */
    public function test_IsBetween_InRangePart1()
    {
        $test = '0';
        $low  = '0';
        $high = '0';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart2()
     *
     * IsLeapYear()の挙動をテストする（範囲内：下限値と同値）
     */
    public function test_IsBetween_InRangePart2()
    {
        $test = '1';
        $low  = '1';
        $high = '9';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart3()
     *
     * IsLeapYear()の挙動をテストする（範囲内：上限値と同値）
     */
    public function test_IsBetween_InRangePart3()
    {
        $test = '9';
        $low  = '1';
        $high = '9';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart4()
     *
     * IsLeapYear()の挙動をテストする（範囲内：下限値と同値、負数）
     */
    public function test_IsBetween_InRangePart4()
    {
        $test = '-9';
        $low  = '-9';
        $high = '-2';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart5()
     *
     * IsLeapYear()の挙動をテストする（範囲内：上限値と同値、負数）
     */
    public function test_IsBetween_InRangePart5()
    {
        $test = '-2';
        $low  = '-9';
        $high = '-2';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart6()
     *
     * IsLeapYear()の挙動をテストする（範囲内：下限値と同値、小数）
     */
    public function test_IsBetween_InRangePart6()
    {
        $test = '1.0';
        $low  = '1.0';
        $high = '9.0';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart7()
     *
     * IsLeapYear()の挙動をテストする（範囲内：上限値と同値、小数）
     */
    public function test_IsBetween_InRangePart7()
    {
        $test = '9.0';
        $low  = '1.0';
        $high = '9.0';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart8()
     *
     * IsLeapYear()の挙動をテストする（範囲内：下限値と同値、小数）
     */
    public function test_IsBetween_InRangePart8()
    {
        $test = '-9.0';
        $low  = '-9.0';
        $high = '-2.0';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_InRangePart9()
     *
     * IsLeapYear()の挙動をテストする（範囲内：上限値と同値、小数）
     */
    public function test_IsBetween_InRangePart9()
    {
        $test = '-2.0';
        $low  = '-9.0';
        $high = '-2.0';

        $this->assertTrue(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart1()
     *
     * IsLeapYear()の挙動をテストする（範囲外：下限値より下）
     */
    public function test_IsBetween_OutRangePart1()
    {
        $test = '0';
        $low  = '1';
        $high = '9';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart2()
     *
     * IsLeapYear()の挙動をテストする（範囲外：上限値より上）
     */
    public function test_IsBetween_OutRangePart2()
    {
        $test = '10';
        $low  = '1';
        $high = '9';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart3()
     *
     * IsLeapYear()の挙動をテストする（範囲外：下限値より下、負数）
     */
    public function test_IsBetween_OutRangePart3()
    {
        $test = '-10';
        $low  = '-9';
        $high = '-2';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart4()
     *
     * IsLeapYear()の挙動をテストする（範囲外：上限値より上、負数）
     */
    public function test_IsBetween_OutRangePart4()
    {
        $test = '-1';
        $low  = '-9';
        $high = '-2';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart5()
     *
     * IsLeapYear()の挙動をテストする（範囲外：下限値より下、小数）
     */
    public function test_IsBetween_OutRangePart5()
    {
        $test = '0.9';
        $low  = '1.0';
        $high = '9.0';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart6()
     *
     * IsLeapYear()の挙動をテストする（範囲外：上限値より上、小数）
     */
    public function test_IsBetween_OutRangePart6()
    {
        $test = '9.1';
        $low  = '1.0';
        $high = '9.0';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart7()
     *
     * IsLeapYear()の挙動をテストする（範囲外：下限値より下、負数、小数）
     */
    public function test_IsBetween_OutRangePart7()
    {
        $test = '-9.1';
        $low  = '-9.0';
        $high = '-2.0';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }

    /**
     * test_IsBetween_OutRangePart8()
     *
     * IsLeapYear()の挙動をテストする（範囲外：上限値より上、負数、小数）
     */
    public function test_IsBetween_OutRangePart8()
    {
        $test = '-1.9';
        $low  = '-9.0';
        $high = '-2.0';

        $this->assertFalse(Validate::IsBetween($test, $low, $high));
    }
}
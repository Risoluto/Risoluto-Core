<?php
/**
 * ValidateTest4IsLeapYear
 *
 * Validate::IsLeapYear用テストケース
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
class ValidateTest4IsLeapYear extends \PHPUnit_Framework_TestCase
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
     * test_IsLeapYear_InvalidArgPart1()
     *
     * isLeapYear()の挙動をテストする（数字2桁）
     */
    public function test_IsLeapYear_InvalidArgPart1()
    {
        $test = '13';

        $this->assertFalse(Validate::isLeapYear($test));
    }

    /**
     * test_IsLeapYear_InvalidArgPart2()
     *
     * isLeapYear()の挙動をテストする（英字4桁）
     */
    public function test_IsLeapYear_InvalidArgPart2()
    {
        $test = 'AAAA';

        $this->assertFalse(Validate::isLeapYear($test));
    }

    /**
     * test_IsLeapYear_ValidArgPart1()
     *
     * isLeapYear()の挙動をテストする（閏年である）
     */
    public function test_IsLeapYear_ValidArgPart1()
    {
        $test = '2000';

        $this->assertTrue(Validate::isLeapYear($test));
    }

    /**
     * test_IsLeapYear_ValidArgPart2()
     *
     * isLeapYear()の挙動をテストする（閏年でない）
     */
    public function test_IsLeapYear_ValidArgPart2()
    {
        $test = '2013';

        $this->assertFalse(Validate::isLeapYear($test));
    }
}
<?php
/**
 * ValidateTest4IsHalfWidth
 *
 * Validate::IsHalfWidth用テストケース
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
class ValidateTest4IsHalfWidth extends \PHPUnit_Framework_TestCase
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
}
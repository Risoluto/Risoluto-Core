<?php
/**
 * DateTest4CnvYear
 *
 * Date::CnvYear用テストケース
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
class DateTest4CnvYear extends \PHPUnit_Framework_TestCase
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
     * test_CnvYear_InvalidArgPart1()
     *
     * CnvYear()の挙動をテストする（引数が数値じゃない）
     */
    public function test_CnvYear_InvalidArgPart1()
    {
        $test = 'AAAA';
        $want = '';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_InvalidArgPart2()
     *
     * CnvYear()の挙動をテストする（引数が数値4桁じゃない）
     */
    public function test_CnvYear_InvalidArgPart2()
    {
        $test = '13';
        $want = '';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_InvalidArgPart3()
     *
     * CnvYear()の挙動をテストする（引数が1868より小さい数値）
     */
    public function test_CnvYear_InvalidArgPart3()
    {
        $test = '1867';
        $want = '';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_MeijiPart1()
     *
     * CnvYear()の挙動をテストする（明治元年）
     */
    public function test_CnvYear_MeijiPart1()
    {
        $test = '1868';
        $want = '明治元年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_MeijiPart2()
     *
     * CnvYear()の挙動をテストする（明治1年）
     */
    public function test_CnvYear_MeijiPart2()
    {
        $test = '1869';
        $want = '明治2年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_MeijiPart3()
     *
     * CnvYear()の挙動をテストする（明治45年、大正元年）
     */
    public function test_CnvYear_MeijiPart3()
    {
        $test = '1912';
        $want = '明治45年 / 大正元年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_TaishoPart1()
     *
     * CnvYear()の挙動をテストする（大正2年）
     */
    public function test_CnvYear_TaishoPart1()
    {
        $test = '1913';
        $want = '大正2年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_TaishoPart2()
     *
     * CnvYear()の挙動をテストする（大正15年、昭和元年）
     */
    public function test_CnvYear_TaishoPart2()
    {
        $test = '1926';
        $want = '大正15年 / 昭和元年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_ShowaPart1()
     *
     * CnvYear()の挙動をテストする（昭和2年）
     */
    public function test_CnvYear_ShowaPart1()
    {
        $test = '1927';
        $want = '昭和2年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_ShowaPart2()
     *
     * CnvYear()の挙動をテストする（昭和64年、平成元年）
     */
    public function test_CnvYear_ShowaPart2()
    {
        $test = '1989';
        $want = '昭和64年 / 平成元年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_HeiseiPart1()
     *
     * CnvYear()の挙動をテストする（平成2年）
     */
    public function test_CnvYear_HeiseiPart1()
    {
        $test = '1990';
        $want = '平成2年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }

    /**
     * test_CnvYear_HeiseiPart2()
     *
     * CnvYear()の挙動をテストする（平成25年）
     */
    public function test_CnvYear_HeiseiPart2()
    {
        $test = '2013';
        $want = '平成25年';

        $this->assertEquals(Date::CnvYear($test), $want);
    }
}
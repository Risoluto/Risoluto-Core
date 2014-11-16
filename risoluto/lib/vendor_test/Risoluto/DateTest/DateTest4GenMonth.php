<?php
/**
 * DateTest4GenMonth
 *
 * Date::GenMonth用テストケース
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
class DateTest4GenMonth extends \PHPUnit_Framework_TestCase
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
     * test_GenMonth_NoArgs()
     *
     * GenMonth()の挙動をテストする（引数なし）
     */
    public function test_GenMonth_NoArgs()
    {
        $want = array(
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12'
        );

        $this->assertEquals(Date::genMonth(), $want);
    }

    /**
     * test_GenMonth_Args1()
     *
     * GenMonth()の挙動をテストする（引数1つ）
     */
    public function test_GenMonth_Args1()
    {
        $want = array(
            ''   => '',
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12'
        );

        $this->assertEquals(Date::genMonth(true), $want);
    }

    /**
     * test_GenMonth_Args2()
     *
     * GenMonth()の挙動をテストする（引数2つ）
     */
    public function test_GenMonth_Args2()
    {
        $want = array(
            '--' => '',
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12'
        );

        $this->assertEquals(Date::genMonth(true, '--'), $want);
    }

    /**
     * test_GenMonth_Args3()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenMonth_Args3()
    {
        $want = array(
            '--' => '--',
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12'
        );

        $this->assertEquals(Date::genMonth(true, '--', '--'), $want);
    }
}
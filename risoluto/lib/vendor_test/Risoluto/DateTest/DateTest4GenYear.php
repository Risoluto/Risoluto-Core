<?php
/**
 * DateTest4GenYear
 *
 * Date::GenYear用テストケース
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
class DateTest4GenYear extends \PHPUnit_Framework_TestCase
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
     * test_GenYear_NoArgs()
     *
     * GenYear()の挙動をテストする（引数なし）
     */
    public function test_GenYear_NoArgs()
    {
        $tmpYear = date('Y') - 5;
        $want    = array(
            $tmpYear + 0 => $tmpYear + 0
        , $tmpYear + 1   => $tmpYear + 1
        , $tmpYear + 2   => $tmpYear + 2
        , $tmpYear + 3   => $tmpYear + 3
        , $tmpYear + 4   => $tmpYear + 4
        , $tmpYear + 5   => $tmpYear + 5
        , $tmpYear + 6   => $tmpYear + 6
        , $tmpYear + 7   => $tmpYear + 7
        , $tmpYear + 8   => $tmpYear + 8
        , $tmpYear + 9   => $tmpYear + 9
        );

        $this->assertEquals(Date::GenYear(), $want);
    }

    /**
     * test_GenYear_Args1()
     *
     * GenYear()の挙動をテストする（引数1つ）
     */
    public function test_GenYear_Args1()
    {
        $tmpYear = date('Y') - 5;
        $want    = array(
            ''         => ''
        , $tmpYear + 0 => $tmpYear + 0
        , $tmpYear + 1 => $tmpYear + 1
        , $tmpYear + 2 => $tmpYear + 2
        , $tmpYear + 3 => $tmpYear + 3
        , $tmpYear + 4 => $tmpYear + 4
        , $tmpYear + 5 => $tmpYear + 5
        , $tmpYear + 6 => $tmpYear + 6
        , $tmpYear + 7 => $tmpYear + 7
        , $tmpYear + 8 => $tmpYear + 8
        , $tmpYear + 9 => $tmpYear + 9
        );

        $this->assertEquals(Date::GenYear(true), $want);
    }

    /**
     * test_GenYear_Args2()
     *
     * GenYear()の挙動をテストする（引数2つ）
     */
    public function test_GenYear_Args2()
    {
        $tmpYear = date('Y') - 5;
        $want    = array(
            '----'     => ''
        , $tmpYear + 0 => $tmpYear + 0
        , $tmpYear + 1 => $tmpYear + 1
        , $tmpYear + 2 => $tmpYear + 2
        , $tmpYear + 3 => $tmpYear + 3
        , $tmpYear + 4 => $tmpYear + 4
        , $tmpYear + 5 => $tmpYear + 5
        , $tmpYear + 6 => $tmpYear + 6
        , $tmpYear + 7 => $tmpYear + 7
        , $tmpYear + 8 => $tmpYear + 8
        , $tmpYear + 9 => $tmpYear + 9
        );

        $this->assertEquals(Date::GenYear(true, '----'), $want);
    }


    /**
     * test_GenYear_Args4()
     *
     * GenYear()の挙動をテストする（引数4つ）
     */
    public function test_GenYear_Args4()
    {
        $want = array(
            '----' => '----'
        , 2000     => '2000'
        , 2001     => '2001'
        , 2002     => '2002'
        , 2003     => '2003'
        , 2004     => '2004'
        , 2005     => '2005'
        , 2006     => '2006'
        , 2007     => '2007'
        , 2008     => '2008'
        , 2009     => '2009'
        );

        $this->assertEquals(Date::GenYear(true, '----', '----', 2000), $want);
    }

    /**
     * test_GenYear_Args5()
     *
     * GenYear()の挙動をテストする（引数5つ）
     */
    public function test_GenYear_Args5()
    {
        $want = array(
            '----' => '----'
        , 2000     => '2000(平成12年)'
        , 2001     => '2001(平成13年)'
        );

        $this->assertEquals(Date::GenYear(true, '----', '----', 2000, 2, 2), $want);
    }
}
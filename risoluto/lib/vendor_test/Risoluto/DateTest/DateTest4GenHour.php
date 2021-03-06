<?php
/**
 * DateTest4GenHour
 *
 * Date::GenHour用テストケース
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
class DateTest4GenHour extends \PHPUnit_Framework_TestCase
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
     * test_GenHour_NoArgs()
     *
     * GenHour()の挙動をテストする（引数なし）
     */
    public function test_GenHour_NoArgs()
    {
        $want = [
            '00' => '00',
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
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
        ];

        $this->assertEquals( Date::genHour(), $want );
    }

    /**
     * test_GenHour_Args1()
     *
     * GenHour()の挙動をテストする（引数1つ）
     */
    public function test_GenHour_Args1()
    {
        $want = [
            '' => '',
            '00' => '00',
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
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
        ];

        $this->assertEquals( Date::genHour( true ), $want );
    }

    /**
     * test_GenHour_Args2()
     *
     * GenHour()の挙動をテストする（引数2つ）
     */
    public function test_GenHour_Args2()
    {
        $want = [
            '--' => '',
            '00' => '00',
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
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
        ];

        $this->assertEquals( Date::genHour( true, '--' ), $want );
    }

    /**
     * test_GenHour_Args3()
     *
     * GenHour()の挙動をテストする（引数3つ）
     */
    public function test_GenHour_Args3()
    {
        $want = [
            '--' => '--',
            '00' => '00',
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
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
        ];

        $this->assertEquals( Date::genHour( true, '--', '--' ), $want );
    }

    /**
     * test_GenHour_Args4()
     *
     * GenHour()の挙動をテストする（引数4つ）
     */
    public function test_GenHour_Args4()
    {
        $want = [
            '--' => '--',
            '00' => '午前00',
            '01' => '午前01',
            '02' => '午前02',
            '03' => '午前03',
            '04' => '午前04',
            '05' => '午前05',
            '06' => '午前06',
            '07' => '午前07',
            '08' => '午前08',
            '09' => '午前09',
            '10' => '午前10',
            '11' => '午前11',
            '12' => '午後00',
            '13' => '午後01',
            '14' => '午後02',
            '15' => '午後03',
            '16' => '午後04',
            '17' => '午後05',
            '18' => '午後06',
            '19' => '午後07',
            '20' => '午後08',
            '21' => '午後09',
            '22' => '午後10',
            '23' => '午後11',
        ];

        $this->assertEquals( Date::genHour( true, '--', '--', false ), $want );
    }
}
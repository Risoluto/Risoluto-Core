<?php
/**
 * TextTest4CheckFalseVal
 *
 * Text::CheckFalseVal用テストケース
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
class TextTest4CheckFalseVal extends \PHPUnit_Framework_TestCase
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
     * test_CheckFalseVal_true1()
     *
     * checkFalseVal()の挙動をテストする（falseではない文字列、代替文字なし、厳密判定なし）
     */
    public function test_CheckFalseVal_true1()
    {
        $test = 'abcde';
        $want = 'abcde';

        $this->assertEquals( Text::checkFalseVal( $test ), $want );
    }

    /**
     * test_CheckFalseVal_true2()
     *
     * checkFalseVal()の挙動をテストする（falseではない文字列、代替文字あり、厳密判定なし）
     */
    public function test_CheckFalseVal_true2()
    {
        $test = 'abcde';
        $want = 'abcde';

        $this->assertEquals( Text::checkFalseVal( $test, 'test' ), $want );
    }

    /**
     * test_CheckFalseVal_true3()
     *
     * checkFalseVal()の挙動をテストする（falseではない文字列、代替文字あり、厳密判定あり）
     */
    public function test_CheckFalseVal_true3()
    {
        $test = 'abcde';
        $want = 'abcde';

        $this->assertEquals( Text::checkFalseVal( $test, 'test', true ), $want );
    }

    /**
     * test_CheckFalseVal_False1()
     *
     * checkFalseVal()の挙動をテストする（falseな文字列、代替文字列なし、厳密判定なし）
     */
    public function test_CheckFalseVal_False1()
    {
        $test = '0';
        $want = '';

        $this->assertEquals( Text::checkFalseVal( $test ), $want );
    }

    /**
     * test_CheckFalseVal_False2()
     *
     * checkFalseVal()の挙動をテストする（falseな文字列、代替文字列あり、厳密判定なし）
     */
    public function test_CheckFalseVal_False2()
    {
        $test = '0';
        $want = 'test';

        $this->assertEquals( Text::checkFalseVal( $test, 'test' ), $want );
    }

    /**
     * test_CheckFalseVal_False3()
     *
     * checkFalseVal()の挙動をテストする（falseな文字列、代替文字列なし、厳密判定あり）
     */
    public function test_CheckFalseVal_False3()
    {
        $test = '0';
        $want = '0';

        $this->assertEquals( Text::checkFalseVal( $test, 'test', true ), $want );
    }

    /**
     * test_CheckFalseVal_False4()
     *
     * checkFalseVal()の挙動をテストする（false、代替文字列なし、厳密判定あり）
     */
    public function test_CheckFalseVal_False4()
    {
        $test = false;
        $want = 'test';

        $this->assertEquals( Text::checkFalseVal( $test, 'test', true ), $want );
    }
}
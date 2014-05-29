<?php
/**
 * UtilTest
 *
 * Util()用テストケース
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
class UtilTest extends \PHPUnit_Framework_TestCase
{
    //------------------------------------------------------//
    // テストクラス変数定義
    //------------------------------------------------------//
    /**
     * $instance
     * @access protected
     * @var    object    テスト対象インスタンスを保持
     */
    protected $instance;

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
        $this->instance = new Util;
    }

    /**
     * test_GetBaseUrl_WithoutArg()
     *
     * GetBaseUrl()の動作をテストする（引数なし）
     */
    public function test_GetBaseUrl_WithoutArg()
    {
        $want = 'http://localhost/';

        $this->assertEquals($this->instance->GetBaseUrl(), $want);
    }

    /**
     * test_GetBaseUrl_WithNormalPart1()
     *
     * GetBaseUrl()の動作をテストする（ノーマルな指定その1）
     */
    public function test_GetBaseUrl_WithNormalPart1()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '80',
            'PHP_SELF'    => '/index.html'
        );
        $want = 'http://example.com/index.html';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_GetBaseUrl_WithNormalPart2()
     *
     * GetBaseUrl()の動作をテストする（ノーマルな指定その2）
     */
    public function test_GetBaseUrl_WithNormalPart2()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '80',
            'PHP_SELF'    => '/test.php'
        );
        $want = 'http://example.com/test.php';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_GetBaseUrl_WithNormalPart3()
     *
     * GetBaseUrl()の動作をテストする（ノーマルな指定その3）
     */
    public function test_GetBaseUrl_WithNormalPart3()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '80',
            'PHP_SELF'    => '/index.php'
        );
        $want = 'http://example.com/';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_GetBaseUrl_WithSslPart1()
     *
     * GetBaseUrl()の動作をテストする（SSLな指定その1）
     */
    public function test_GetBaseUrl_WithSslPart1()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '443',
            'PHP_SELF'    => '/index.html'
        );
        $want = 'https://example.com/index.html';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_GetBaseUrl_WithSslPart2()
     *
     * GetBaseUrl()の動作をテストする（SSLな指定その2）
     */
    public function test_GetBaseUrl_WithSslPart2()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '443',
            'PHP_SELF'    => '/test.php'
        );
        $want = 'https://example.com/test.php';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_GetBaseUrl_WithNotStdPortPart1()
     *
     * GetBaseUrl()の動作をテストする（8000ポートを指定）
     */
    public function test_GetBaseUrl_WithNotStdPortPart1()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '8080',
            'PHP_SELF'    => '/index.html'
        );
        $want = 'http://example.com:8080/index.html';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_GetBaseUrl_WithNotStdPortPart2()
     *
     * GetBaseUrl()の動作をテストする（8443ポートを指定）
     */
    public function test_GetBaseUrl_WithNotStdPortPart2()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '8443',
            'PHP_SELF'    => '/index.html'
        );
        $want = 'https://example.com:8443/index.html';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_GetBaseUrl_WithNotStdPortPart3()
     *
     * GetBaseUrl()の動作をテストする（8888ポートを指定）
     */
    public function test_GetBaseUrl_WithNotStdPortPart3()
    {
        $test = array(
            'HTTP_HOST'   => 'example.com',
            'SERVER_PORT' => '8888',
            'PHP_SELF'    => '/index.html'
        );
        $want = 'http://example.com:8888/index.html';

        $this->assertEquals($this->instance->GetBaseUrl($test), $want);
    }

    /**
     * test_RedirectTo()
     *
     * RedirectTo()の挙動をテストする【FIXME】
     */
    public function test_RedirectTo()
    {
        $this->markTestIncomplete();
    }

    /**
     * test_StatChecker()
     *
     * StatChecker()の挙動をテストする【FIXME】
     */
    public function test_StatChecker()
    {
        $this->markTestIncomplete();
    }

    /**
     * test_FileOperator()
     *
     * FileOperator()の挙動をテストする【FIXME】
     */
    public function test_FileOperator()
    {
        $this->markTestIncomplete();
    }

    /**
     * test_AutoUrlLink_WithNoLinks()
     *
     * AutoUrlLink()の挙動をテストする（URLが含まれないテキストの場合）
     */
    public function test_AutoUrlLink_WithNoLinks()
    {
        $test = '<p>Risoluto is PHP Framework.</p>';
        $want = '<p>Risoluto is PHP Framework.</p>';

        $this->assertEquals($this->instance->AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpLink()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が１つだけ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithOneHttpLink()
    {
        $test = '<p>See: http://www.example.com/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\' target=\'_blank\'>http://www.example.com/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpsLink()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が１つだけ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithOneHttpsLink()
    {
        $test = '<p>See: https://www.example.com/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\' target=\'_blank\'>https://www.example.com/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpLinks()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が２つ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithTwoHttpLinks()
    {
        $test = '<p>See: http://www.example.com/ and http://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\' target=\'_blank\'>http://www.example.com/</a> and <a href=\'http://www.example.org/\' target=\'_blank\'>http://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpsLinks()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が２つ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithTwoHttpsLinks()
    {
        $test = '<p>See: https://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\' target=\'_blank\'>https://www.example.com/</a> and <a href=\'https://www.example.org/\' target=\'_blank\'>https://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithHttpAndHttpLinks()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～とhttps://～）が２つ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithHttpAndHttpLinks()
    {
        $test = '<p>See: http://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\' target=\'_blank\'>http://www.example.com/</a> and <a href=\'https://www.example.org/\' target=\'_blank\'>https://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithNoLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URLが含まれないテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithNoLinks_WithoutNewWindow()
    {
        $test = '<p>Risoluto is PHP Framework.</p>';
        $want = '<p>Risoluto is PHP Framework.</p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow()
    {
        $test = '<p>See: http://www.example.com/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\'>http://www.example.com/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow()
    {
        $test = '<p>See: https://www.example.com/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\'>https://www.example.com/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow()
    {
        $test = '<p>See: http://www.example.com/ and http://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\'>http://www.example.com/</a> and <a href=\'http://www.example.org/\'>http://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow()
    {
        $test = '<p>See: https://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\'>https://www.example.com/</a> and <a href=\'https://www.example.org/\'>https://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～とhttps://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow()
    {
        $test = '<p>See: http://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\'>http://www.example.com/</a> and <a href=\'https://www.example.org/\'>https://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithNoLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URLが含まれないテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithNoLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>Risoluto is PHP Framework.</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>Risoluto is PHP Framework.</p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: http://www.example.com/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'http://www.example.com/\' class=\'dummy\'>http://www.example.com/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: https://www.example.com/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'https://www.example.com/\' class=\'dummy\'>https://www.example.com/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: http://www.example.com/ and http://www.example.org/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'http://www.example.com/\' class=\'dummy\'>http://www.example.com/</a> and <a href=\'http://www.example.org/\' class=\'dummy\'>http://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: https://www.example.com/ and https://www.example.org/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'https://www.example.com/\' class=\'dummy\'>https://www.example.com/</a> and <a href=\'https://www.example.org/\' class=\'dummy\'>https://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～とhttps://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: http://www.example.com/ and https://www.example.org/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'http://www.example.com/\' class=\'dummy\'>http://www.example.com/</a> and <a href=\'https://www.example.org/\' class=\'dummy\'>https://www.example.org/</a></p>';

        $this->assertEquals($this->instance->AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_IsEmailAddr_InvalidTextPart1()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスじゃない文字列その1）
     */
    public function test_IsEmailAddr_InvalidTextPart1()
    {
        $test = '@risoluto This is test!';

        $this->assertFalse($this->instance->IsEmailAddr($test));
    }

    /**
     * test_IsEmailAddr_InvalidText()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスじゃない文字列その2）
     */
    public function test_IsEmailAddr_InvalidTextPart2()
    {
        $test = 'test+test-test.test@risoluto_test-test+test.jp';

        $this->assertFalse($this->instance->IsEmailAddr($test));
    }

    /**
     * test_IsEmailAddr_ValidTextPart1()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスな文字列その1）
     */
    public function test_IsEmailAddr_ValidTextPart1()
    {
        $test = 'webmaster@example.net';

        $this->assertTrue($this->instance->IsEmailAddr($test));
    }

    /**
     * test_IsEmailAddr_ValidTextPart2()
     *
     * IsEmailAddr()の挙動をテストする（メールアドレスな文字列その2）
     */
    public function test_IsEmailAddr_ValidTextPart2()
    {
        $test = 'web_master+test-test.test@example.gr.jp';

        $this->assertTrue($this->instance->IsEmailAddr($test));
    }

    /**
     * test_IsHalfWidth_HalfNumeric()
     *
     * IsHalfWidth()の挙動をテストする（半角数字）
     */
    public function test_IsHalfWidth_HalfNumeric()
    {
        $test = '0';

        $this->assertTrue($this->instance->IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_HalfAlphabet()
     *
     * IsHalfWidth()の挙動をテストする（半角英字）
     */
    public function test_IsHalfWidth_HalfAlphabet()
    {
        $test = 'A';

        $this->assertTrue($this->instance->IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_HalfSymbol()
     *
     * IsHalfWidth()の挙動をテストする（半角記号）
     */
    public function test_IsHalfWidth_HalfSymbol()
    {
        $test = '+';

        $this->assertTrue($this->instance->IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_FullNumeric()
     *
     * IsHalfWidth()の挙動をテストする（全角数字）
     */
    public function test_IsHalfWidth_FullNumeric()
    {
        $test = '０';

        $this->assertFalse($this->instance->IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_FullAlphabet()
     *
     * IsHalfWidth()の挙動をテストする（全角英字）
     */
    public function test_IsHalfWidth_FullAlphabet()
    {
        $test = 'Ａ';

        $this->assertFalse($this->instance->IsHalfWidth($test));
    }

    /**
     * test_IsHalfWidth_FullSymbol()
     *
     * IsHalfWidth()の挙動をテストする（全角記号）
     */
    public function test_IsHalfWidth_FullSymbol()
    {
        $test = '＋';

        $this->assertFalse($this->instance->IsHalfWidth($test));
    }

    /**
     * test_IsLeapYear_InvalidArgPart1()
     *
     * IsLeapYear()の挙動をテストする（数字2桁）
     */
    public function test_IsLeapYear_InvalidArgPart1()
    {
        $test = '13';

        $this->assertFalse($this->instance->IsLeapYear($test));
    }

    /**
     * test_IsLeapYear_InvalidArgPart2()
     *
     * IsLeapYear()の挙動をテストする（英字4桁）
     */
    public function test_IsLeapYear_InvalidArgPart2()
    {
        $test = 'AAAA';

        $this->assertFalse($this->instance->IsLeapYear($test));
    }

    /**
     * test_IsLeapYear_ValidArgPart1()
     *
     * IsLeapYear()の挙動をテストする（閏年である）
     */
    public function test_IsLeapYear_ValidArgPart1()
    {
        $test = '2000';

        $this->assertTrue($this->instance->IsLeapYear($test));
    }

    /**
     * test_IsLeapYear_ValidArgPart2()
     *
     * IsLeapYear()の挙動をテストする（閏年でない）
     */
    public function test_IsLeapYear_ValidArgPart2()
    {
        $test = '2013';

        $this->assertFalse($this->instance->IsLeapYear($test));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertTrue($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertFalse($this->instance->IsBetween($test, $low, $high));
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->CnvYear($test), $want);
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

        $this->assertEquals($this->instance->genYear(), $want);
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

        $this->assertEquals($this->instance->genYear(true), $want);
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

        $this->assertEquals($this->instance->genYear(true, '----'), $want);
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

        $this->assertEquals($this->instance->genYear(true, '----', '----', 2000), $want);
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

        $this->assertEquals($this->instance->genYear(true, '----', '----', 2000, 2, 2), $want);
    }

    /**
     * test_GenMonth_NoArgs()
     *
     * GenMonth()の挙動をテストする（引数なし）
     */
    public function test_GenMonth_NoArgs()
    {
        $want = array(
            '01' => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        );

        $this->assertEquals($this->instance->genMonth(), $want);
    }

    /**
     * test_GenMonth_Args1()
     *
     * GenMonth()の挙動をテストする（引数1つ）
     */
    public function test_GenMonth_Args1()
    {
        $want = array(
            '' => ''
        , '01' => '01'
        , '02' => '02'
        , '03' => '03'
        , '04' => '04'
        , '05' => '05'
        , '06' => '06'
        , '07' => '07'
        , '08' => '08'
        , '09' => '09'
        , '10' => '10'
        , '11' => '11'
        , '12' => '12'
        );

        $this->assertEquals($this->instance->genMonth(true), $want);
    }

    /**
     * test_GenMonth_Args2()
     *
     * GenMonth()の挙動をテストする（引数2つ）
     */
    public function test_GenMonth_Args2()
    {
        $want = array(
            '--' => ''
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        );

        $this->assertEquals($this->instance->genMonth(true, '--'), $want);
    }

    /**
     * test_GenMonth_Args3()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenMonth_Args3()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        );

        $this->assertEquals($this->instance->genMonth(true, '--', '--'), $want);
    }

    /**
     * test_GenDay_NoArgs()
     *
     * GenDay()の挙動をテストする（引数なし）
     */
    public function test_GenDay_NoArgs()
    {
        $want = array(
            '01' => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        , '31'   => '31'
        );

        $this->assertEquals($this->instance->genDay(), $want);
    }

    /**
     * test_GenDay_Args1()
     *
     * GenMonth()の挙動をテストする（引数1つ）
     */
    public function test_GenDay_Args1()
    {
        $want = array(
            '' => ''
        , '01' => '01'
        , '02' => '02'
        , '03' => '03'
        , '04' => '04'
        , '05' => '05'
        , '06' => '06'
        , '07' => '07'
        , '08' => '08'
        , '09' => '09'
        , '10' => '10'
        , '11' => '11'
        , '12' => '12'
        , '13' => '13'
        , '14' => '14'
        , '15' => '15'
        , '16' => '16'
        , '17' => '17'
        , '18' => '18'
        , '19' => '19'
        , '20' => '20'
        , '21' => '21'
        , '22' => '22'
        , '23' => '23'
        , '24' => '24'
        , '25' => '25'
        , '26' => '26'
        , '27' => '27'
        , '28' => '28'
        , '29' => '29'
        , '30' => '30'
        , '31' => '31'
        );

        $this->assertEquals($this->instance->genDay(true), $want);
    }

    /**
     * test_GenDay_Args2()
     *
     * GenMonth()の挙動をテストする（引数2つ）
     */
    public function test_GenDay_Args2()
    {
        $want = array(
            '--' => ''
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        , '31'   => '31'
        );

        $this->assertEquals($this->instance->genDay(true, '--'), $want);
    }

    /**
     * test_GenDay_Args3()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenDay_Args3()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        , '31'   => '31'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--'), $want);
    }

    /**
     * test_GenDay_Args4_January()
     *
     * GenMonth()の挙動をテストする（引数4つ）
     */
    public function test_GenDay_Args4_January()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        , '31'   => '31'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--', array('month' => 1, 'year' => '')), $want);
    }

    /**
     * test_GenDay_Args4_February()
     *
     * GenMonth()の挙動をテストする（引数4つ）
     */
    public function test_GenDay_Args4_February()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--', array('month' => 2, 'year' => '2014')), $want);
    }

    /**
     * test_GenDay_Args4_February_LY()
     *
     * GenMonth()の挙動をテストする（引数4つ）
     */
    public function test_GenDay_Args4_February_LY()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--', array('month' => 2, 'year' => '2012')), $want);
    }

    /**
     * test_GenDay_Args4_April()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenDay_Args4_April()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--', array('month' => 4, 'year' => '')), $want);
    }

    /**
     * test_GenDay_Args4_June()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenDay_Args4_June()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--', array('month' => 6, 'year' => '')), $want);
    }

    /**
     * test_GenDay_Args4_September()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenDay_Args4_September()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--', array('month' => 9, 'year' => '')), $want);
    }

    /**
     * test_GenDay_Args4_November()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenDay_Args4_November()
    {
        $want = array(
            '--' => '--'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        );

        $this->assertEquals($this->instance->genDay(true, '--', '--', array('month' => 11, 'year' => '')), $want);
    }

    /**
     * test_GenHour_NoArgs()
     *
     * GenDay()の挙動をテストする（引数なし）
     */
    public function test_GenHour_NoArgs()
    {
        $want = array(
            '00' => '00'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        );

        $this->assertEquals($this->instance->genHour(), $want);
    }

    /**
     * test_GenHour_Args1()
     *
     * GenMonth()の挙動をテストする（引数1つ）
     */
    public function test_GenHour_Args1()
    {
        $want = array(
            '' => ''
        , '00' => '00'
        , '01' => '01'
        , '02' => '02'
        , '03' => '03'
        , '04' => '04'
        , '05' => '05'
        , '06' => '06'
        , '07' => '07'
        , '08' => '08'
        , '09' => '09'
        , '10' => '10'
        , '11' => '11'
        , '12' => '12'
        , '13' => '13'
        , '14' => '14'
        , '15' => '15'
        , '16' => '16'
        , '17' => '17'
        , '18' => '18'
        , '19' => '19'
        , '20' => '20'
        , '21' => '21'
        , '22' => '22'
        , '23' => '23'
        );

        $this->assertEquals($this->instance->genHour(true), $want);
    }

    /**
     * test_GenHour_Args2()
     *
     * GenMonth()の挙動をテストする（引数2つ）
     */
    public function test_GenHour_Args2()
    {
        $want = array(
            '--' => ''
        , '00'   => '00'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        );

        $this->assertEquals($this->instance->genHour(true, '--'), $want);
    }

    /**
     * test_GenHour_Args3()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenHour_Args3()
    {
        $want = array(
            '--' => '--'
        , '00'   => '00'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        );

        $this->assertEquals($this->instance->genHour(true, '--', '--'), $want);
    }

    /**
     * test_GenHour_Args4()
     *
     * GenMonth()の挙動をテストする（引数4つ）
     */
    public function test_GenHour_Args4()
    {
        $want = array(
            '--' => '--'
        , '00'   => '午前00'
        , '01'   => '午前01'
        , '02'   => '午前02'
        , '03'   => '午前03'
        , '04'   => '午前04'
        , '05'   => '午前05'
        , '06'   => '午前06'
        , '07'   => '午前07'
        , '08'   => '午前08'
        , '09'   => '午前09'
        , '10'   => '午前10'
        , '11'   => '午前11'
        , '12'   => '午後00'
        , '13'   => '午後01'
        , '14'   => '午後02'
        , '15'   => '午後03'
        , '16'   => '午後04'
        , '17'   => '午後05'
        , '18'   => '午後06'
        , '19'   => '午後07'
        , '20'   => '午後08'
        , '21'   => '午後09'
        , '22'   => '午後10'
        , '23'   => '午後11'
        );

        $this->assertEquals($this->instance->genHour(true, '--', '--', false), $want);
    }

    /**
     * test_GenMinSec_NoArgs()
     *
     * GenDay()の挙動をテストする（引数なし）
     */
    public function test_MinSec_NoArgs()
    {
        $want = array(
            '00' => '00'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        , '31'   => '31'
        , '32'   => '32'
        , '33'   => '33'
        , '34'   => '34'
        , '35'   => '35'
        , '36'   => '36'
        , '37'   => '37'
        , '38'   => '38'
        , '39'   => '39'
        , '40'   => '40'
        , '41'   => '41'
        , '42'   => '42'
        , '43'   => '43'
        , '44'   => '44'
        , '45'   => '45'
        , '46'   => '46'
        , '47'   => '47'
        , '48'   => '48'
        , '49'   => '49'
        , '50'   => '50'
        , '51'   => '51'
        , '52'   => '52'
        , '53'   => '53'
        , '54'   => '54'
        , '55'   => '55'
        , '56'   => '56'
        , '57'   => '57'
        , '58'   => '58'
        , '59'   => '59'
        );

        $this->assertEquals($this->instance->genMinSec(), $want);
    }

    /**
     * test_GenMinSec_Args1()
     *
     * GenMonth()の挙動をテストする（引数1つ）
     */
    public function test_GenMinSec_Args1()
    {
        $want = array(
            '' => ''
        , '00' => '00'
        , '01' => '01'
        , '02' => '02'
        , '03' => '03'
        , '04' => '04'
        , '05' => '05'
        , '06' => '06'
        , '07' => '07'
        , '08' => '08'
        , '09' => '09'
        , '10' => '10'
        , '11' => '11'
        , '12' => '12'
        , '13' => '13'
        , '14' => '14'
        , '15' => '15'
        , '16' => '16'
        , '17' => '17'
        , '18' => '18'
        , '19' => '19'
        , '20' => '20'
        , '21' => '21'
        , '22' => '22'
        , '23' => '23'
        , '24' => '24'
        , '25' => '25'
        , '26' => '26'
        , '27' => '27'
        , '28' => '28'
        , '29' => '29'
        , '30' => '30'
        , '31' => '31'
        , '32' => '32'
        , '33' => '33'
        , '34' => '34'
        , '35' => '35'
        , '36' => '36'
        , '37' => '37'
        , '38' => '38'
        , '39' => '39'
        , '40' => '40'
        , '41' => '41'
        , '42' => '42'
        , '43' => '43'
        , '44' => '44'
        , '45' => '45'
        , '46' => '46'
        , '47' => '47'
        , '48' => '48'
        , '49' => '49'
        , '50' => '50'
        , '51' => '51'
        , '52' => '52'
        , '53' => '53'
        , '54' => '54'
        , '55' => '55'
        , '56' => '56'
        , '57' => '57'
        , '58' => '58'
        , '59' => '59'
        );

        $this->assertEquals($this->instance->genMinSec(true), $want);
    }

    /**
     * test_GenMinSec_Args2()
     *
     * GenMonth()の挙動をテストする（引数2つ）
     */
    public function test_GenMinSec_Args2()
    {
        $want = array(
            '--' => ''
        , '00'   => '00'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        , '31'   => '31'
        , '32'   => '32'
        , '33'   => '33'
        , '34'   => '34'
        , '35'   => '35'
        , '36'   => '36'
        , '37'   => '37'
        , '38'   => '38'
        , '39'   => '39'
        , '40'   => '40'
        , '41'   => '41'
        , '42'   => '42'
        , '43'   => '43'
        , '44'   => '44'
        , '45'   => '45'
        , '46'   => '46'
        , '47'   => '47'
        , '48'   => '48'
        , '49'   => '49'
        , '50'   => '50'
        , '51'   => '51'
        , '52'   => '52'
        , '53'   => '53'
        , '54'   => '54'
        , '55'   => '55'
        , '56'   => '56'
        , '57'   => '57'
        , '58'   => '58'
        , '59'   => '59'
        );

        $this->assertEquals($this->instance->genMinSec(true, '--'), $want);
    }

    /**
     * test_GenMinSec_Args3()
     *
     * GenMonth()の挙動をテストする（引数3つ）
     */
    public function test_GenMinSec_Args3()
    {
        $want = array(
            '--' => '--'
        , '00'   => '00'
        , '01'   => '01'
        , '02'   => '02'
        , '03'   => '03'
        , '04'   => '04'
        , '05'   => '05'
        , '06'   => '06'
        , '07'   => '07'
        , '08'   => '08'
        , '09'   => '09'
        , '10'   => '10'
        , '11'   => '11'
        , '12'   => '12'
        , '13'   => '13'
        , '14'   => '14'
        , '15'   => '15'
        , '16'   => '16'
        , '17'   => '17'
        , '18'   => '18'
        , '19'   => '19'
        , '20'   => '20'
        , '21'   => '21'
        , '22'   => '22'
        , '23'   => '23'
        , '24'   => '24'
        , '25'   => '25'
        , '26'   => '26'
        , '27'   => '27'
        , '28'   => '28'
        , '29'   => '29'
        , '30'   => '30'
        , '31'   => '31'
        , '32'   => '32'
        , '33'   => '33'
        , '34'   => '34'
        , '35'   => '35'
        , '36'   => '36'
        , '37'   => '37'
        , '38'   => '38'
        , '39'   => '39'
        , '40'   => '40'
        , '41'   => '41'
        , '42'   => '42'
        , '43'   => '43'
        , '44'   => '44'
        , '45'   => '45'
        , '46'   => '46'
        , '47'   => '47'
        , '48'   => '48'
        , '49'   => '49'
        , '50'   => '50'
        , '51'   => '51'
        , '52'   => '52'
        , '53'   => '53'
        , '54'   => '54'
        , '55'   => '55'
        , '56'   => '56'
        , '57'   => '57'
        , '58'   => '58'
        , '59'   => '59'
        );

        $this->assertEquals($this->instance->genMinSec(true, '--', '--'), $want);
    }
}
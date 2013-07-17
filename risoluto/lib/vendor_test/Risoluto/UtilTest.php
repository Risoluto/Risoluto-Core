<?php
/**
 * UtilTest
 *
 * Util()用テストケース
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
use Risoluto\Util;

//------------------------------------------------------//
// テストクラス定義
//------------------------------------------------------//
class UtilTest extends PHPUnit_Framework_TestCase
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
        $this->instance = new Risoluto\Util;
    }

    /**
     * test_GetBaseUrl_WithoutArg()
     *
     * GetBaseUrl()の動作をテストする（引数なし）
     */
    public function test_GetBaseUrl_WithoutArg()
    {
        $test = '';
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '80',
                         'PHP_SELF' => '/index.html'
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '80',
                         'PHP_SELF' => '/test.php'
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '80',
                         'PHP_SELF' => '/index.php'
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '443',
                         'PHP_SELF' => '/index.html'
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '443',
                         'PHP_SELF' => '/test.php'
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '8080',
                         'PHP_SELF' => '/index.html'
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '8443',
                         'PHP_SELF' => '/index.html'
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
                         'HTTP_HOST' => 'example.com',
                         'SERVER_PORT' => '8888',
                         'PHP_SELF' => '/index.html'
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

        $this->assertNull($this->instance->CnvYear($test));
    }

    /**
     * test_CnvYear_InvalidArgPart2()
     *
     * CnvYear()の挙動をテストする（引数が数値4桁じゃない）
     */
    public function test_CnvYear_InvalidArgPart2()
    {
        $test = '13';

        $this->assertNull($this->instance->CnvYear($test));
    }

    /**
     * test_CnvYear_InvalidArgPart3()
     *
     * CnvYear()の挙動をテストする（引数が1868より小さい数値）
     */
    public function test_CnvYear_InvalidArgPart3()
    {
        $test = '1867';

        $this->assertNull($this->instance->CnvYear($test));
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
}

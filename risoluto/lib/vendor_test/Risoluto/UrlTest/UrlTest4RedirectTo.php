<?php
/**
 * UrlTest4RedirectTo
 *
 * Url::RedirectTo用テストケース
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
/**
 * @runTestsInSeparateProcesses
 */
class UrlTest4RedirectTo extends \PHPUnit_Framework_TestCase
{
    //------------------------------------------------------//
    // テストプロパティ定義
    //------------------------------------------------------//
    private static $default_server = array('HTTP_HOST' => 'localhost', 'SERVER_PORT' => '80', 'PHP_SELF' => '/');

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
        // 拡張モジュールがロードされているかをチェック
        if (!extension_loaded('xdebug')) {
            $this->markTestSkipped('Cannot use xdebug expansion module.');
        }
    }

    /**
     * test_RedirectTo_WithoutArgs()
     *
     * redirectTo()の挙動をテストする（引数無し）
     *
     */
    public function test_RedirectTo_WithoutArgs()
    {
        Url::redirectTo(null, array(), null, self::$default_server);
        $output_header = xdebug_get_headers();

        $this->assertContains('Location: http://localhost/', $output_header);
    }

    /**
     * test_RedirectTo_WithTarget()
     *
     * redirectTo()の挙動をテストする（targetのみ指定）
     *
     */
    public function test_RedirectTo_WithTarget()
    {
        Url::redirectTo('Top', array(), null, self::$default_server);
        $output_header = xdebug_get_headers();

        $this->assertContains('Location: http://localhost/?seq=Top', $output_header);
    }

    /**
     * test_RedirectTo_WithTargetAndParam1()
     *
     * redirectTo()の挙動をテストする（targetとparamのみ指定その1）
     *
     */
    public function test_RedirectTo_WithTargetAndParam1()
    {
        Url::redirectTo('Top', array('Foo' => ''), null, self::$default_server);
        $output_header = xdebug_get_headers();

        $this->assertContains('Location: http://localhost/?seq=Top.Foo', $output_header);
    }

    /**
     * test_RedirectTo_WithTargetAndParam2()
     *
     * redirectTo()の挙動をテストする（targetとparamのみ指定その2）
     *
     */
    public function test_RedirectTo_WithTargetAndParam2()
    {
        Url::redirectTo('Top', array('Foo' => 'Bar'), null, self::$default_server);
        $output_header = xdebug_get_headers();

        $this->assertContains('Location: http://localhost/?seq=Top.Foo=Bar', $output_header);
    }

    /**
     * test_RedirectTo_WithTargetAndParam3()
     *
     * redirectTo()の挙動をテストする（targetとparamのみ指定その3）
     *
     */
    public function test_RedirectTo_WithTargetAndParam3()
    {
        Url::redirectTo('Top', array('Foo' => 'Bar', 'Hoge' => ''), null, self::$default_server);
        $output_header = xdebug_get_headers();

        $this->assertContains('Location: http://localhost/?seq=Top.Foo=Bar.Hoge', $output_header);
    }

    /**
     * test_RedirectTo_WithTargetAndParam4()
     *
     * redirectTo()の挙動をテストする（targetとparamのみ指定その4）
     *
     */
    public function test_RedirectTo_WithTargetAndParam4()
    {
        Url::redirectTo('Top', array('Foo' => 'Bar', 'Hoge' => 'Fuga'), null, self::$default_server);
        $output_header = xdebug_get_headers();

        $this->assertContains('Location: http://localhost/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }

    /**
     * test_RedirectTo_WithTargetAndParam5()
     *
     * redirectTo()の挙動をテストする（targetとparamのみ指定その5）
     *
     */
    public function test_RedirectTo_WithTargetAndParam5()
    {
        Url::redirectTo('Top', array('Hoge' => 'Fuga','Foo' => 'Bar'), null, self::$default_server);
        $output_header = xdebug_get_headers();

        $this->assertContains('Location: http://localhost/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }

    /**
     * test_RedirectTo_WithTargetAndParamAndStatuscode()
     *
     * redirectTo()の挙動をテストする（targetとparamとstatuscodeのみ指定）
     *
     */
    public function test_RedirectTo_WithTargetAndParamAndStatuscode()
    {
        Url::redirectTo('Top', array('Hoge' => 'Fuga','Foo' => 'Bar'), '303', self::$default_server);
        $output_header = xdebug_get_headers();
        $this->assertContains('Location: http://localhost/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }

    /**
     * test_RedirectTo_WithFullArgs1()
     *
     * redirectTo()の挙動をテストする（全引数を指定その1）
     *
     */
    public function test_RedirectTo_WithFullArgs1()
    {
        Url::redirectTo('Top', array('Hoge' => 'Fuga','Foo' => 'Bar'), '303', array('HTTP_HOST' => 'example.com', 'SERVER_PORT' => '80', 'PHP_SELF' => '/'));
        $output_header = xdebug_get_headers();
        $this->assertContains('Location: http://example.com/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }

    /**
     * test_RedirectTo_WithFullArgs2()
     *
     * redirectTo()の挙動をテストする（全引数を指定その2）
     *
     */
    public function test_RedirectTo_WithFullArgs2()
    {
        Url::redirectTo('Top', array('Hoge' => 'Fuga','Foo' => 'Bar'), '303', array('HTTP_HOST' => 'example.com', 'SERVER_PORT' => '443', 'PHP_SELF' => '/'));
        $output_header = xdebug_get_headers();
        $this->assertContains('Location: https://example.com/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }

    /**
     * test_RedirectTo_WithFullArgs3()
     *
     * redirectTo()の挙動をテストする（全引数を指定その3）
     *
     */
    public function test_RedirectTo_WithFullArgs3()
    {
        Url::redirectTo('Top', array('Hoge' => 'Fuga','Foo' => 'Bar'), '303', array('HTTP_HOST' => 'example.com', 'SERVER_PORT' => '8080', 'PHP_SELF' => '/'));
        $output_header = xdebug_get_headers();
        $this->assertContains('Location: http://example.com:8080/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }

    /**
     * test_RedirectTo_WithFullArgs4()
     *
     * redirectTo()の挙動をテストする（全引数を指定その4）
     *
     */
    public function test_RedirectTo_WithFullArgs4()
    {
        Url::redirectTo('Top', array('Hoge' => 'Fuga','Foo' => 'Bar'), '303', array('HTTP_HOST' => 'example.com', 'SERVER_PORT' => '8443', 'PHP_SELF' => '/'));
        $output_header = xdebug_get_headers();
        $this->assertContains('Location: https://example.com:8443/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }

    /**
     * test_RedirectTo_WithFullArgs5()
     *
     * redirectTo()の挙動をテストする（全引数を指定その5）
     *
     */
    public function test_RedirectTo_WithFullArgs5()
    {
        Url::redirectTo('Top', array('Hoge' => 'Fuga','Foo' => 'Bar'), '303', array('HTTP_HOST' => 'example.com', 'SERVER_PORT' => '8443', 'PHP_SELF' => '/extra/'));
        $output_header = xdebug_get_headers();
        $this->assertContains('Location: https://example.com:8443/extra/?seq=Top.Foo=Bar.Hoge=Fuga', $output_header);
    }
}
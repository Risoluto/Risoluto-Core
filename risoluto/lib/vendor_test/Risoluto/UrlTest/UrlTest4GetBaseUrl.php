<?php
/**
 * UrlTest4GetBaseUrl
 *
 * Url::GetBaseUrl用テストケース
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
class UrlTest4GetBaseUrl extends \PHPUnit_Framework_TestCase
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
     * test_GetBaseUrl_WithoutArg()
     *
     * getBaseUrl()の動作をテストする（引数なし）
     */
    public function test_GetBaseUrl_WithoutArg()
    {
        $want = 'http://localhost/';

        $this->assertEquals( Url::getBaseUrl(), $want );
    }

    /**
     * test_GetBaseUrl_WithNormalPart1()
     *
     * getBaseUrl()の動作をテストする（ノーマルな指定その1）
     */
    public function test_GetBaseUrl_WithNormalPart1()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '80',
            'PHP_SELF' => '/index.html',
        ];
        $want = 'http://example.com/index.html';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }

    /**
     * test_GetBaseUrl_WithNormalPart2()
     *
     * getBaseUrl()の動作をテストする（ノーマルな指定その2）
     */
    public function test_GetBaseUrl_WithNormalPart2()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '80',
            'PHP_SELF' => '/test.php',
        ];
        $want = 'http://example.com/test.php';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }

    /**
     * test_GetBaseUrl_WithNormalPart3()
     *
     * getBaseUrl()の動作をテストする（ノーマルな指定その3）
     */
    public function test_GetBaseUrl_WithNormalPart3()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '80',
            'PHP_SELF' => '/index.php',
        ];
        $want = 'http://example.com/';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }

    /**
     * test_GetBaseUrl_WithSslPart1()
     *
     * getBaseUrl()の動作をテストする（SSLな指定その1）
     */
    public function test_GetBaseUrl_WithSslPart1()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '443',
            'PHP_SELF' => '/index.html',
        ];
        $want = 'https://example.com/index.html';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }

    /**
     * test_GetBaseUrl_WithSslPart2()
     *
     * getBaseUrl()の動作をテストする（SSLな指定その2）
     */
    public function test_GetBaseUrl_WithSslPart2()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '443',
            'PHP_SELF' => '/test.php',
        ];
        $want = 'https://example.com/test.php';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }

    /**
     * test_GetBaseUrl_WithNotStdPortPart1()
     *
     * getBaseUrl()の動作をテストする（8000ポートを指定）
     */
    public function test_GetBaseUrl_WithNotStdPortPart1()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '8080',
            'PHP_SELF' => '/index.html',
        ];
        $want = 'http://example.com:8080/index.html';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }

    /**
     * test_GetBaseUrl_WithNotStdPortPart2()
     *
     * getBaseUrl()の動作をテストする（8443ポートを指定）
     */
    public function test_GetBaseUrl_WithNotStdPortPart2()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '8443',
            'PHP_SELF' => '/index.html',
        ];
        $want = 'https://example.com:8443/index.html';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }

    /**
     * test_GetBaseUrl_WithNotStdPortPart3()
     *
     * getBaseUrl()の動作をテストする（8888ポートを指定）
     */
    public function test_GetBaseUrl_WithNotStdPortPart3()
    {
        $test = [
            'HTTP_HOST' => 'example.com',
            'SERVER_PORT' => '8888',
            'PHP_SELF' => '/index.html',
        ];
        $want = 'http://example.com:8888/index.html';

        $this->assertEquals( Url::getBaseUrl( $test ), $want );
    }
}
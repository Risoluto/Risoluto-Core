<?php
/**
 * DbTest4GetAttribute
 *
 * Db::GetAttribute()用テストケース
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
class DbTest4GetAttribute extends \PHPUnit_Extensions_Database_TestCase
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
        // 拡張モジュールがロードされているかをチェック
        if (!extension_loaded('mysqli')) {
            $this->markTestSkipped('Cannot use mysqli expansion module.');
        }

        if (!isset($GLOBALS['DB_DRIVER'])) {
            $this->markTestSkipped('DB_DRIVER was not defined. Check phpunit.xml');
        } elseif (!isset($GLOBALS['DB_USER'])) {
            $this->markTestSkipped('DB_USER was not defined. Check phpunit.xml');
        } elseif (!isset($GLOBALS['DB_PASSWORD'])) {
            $this->markTestSkipped('DB_PASSWORD was not defined. Check phpunit.xml');
        } elseif (!isset($GLOBALS['DB_DBNAME'])) {
            $this->markTestSkipped('DB_DBNAME was not defined. Check phpunit.xml');
        } elseif (!isset($GLOBALS['DB_HOST'])) {
            $this->markTestSkipped('DB_HOST was not defined. Check phpunit.xml');
        }

        // DB周りの初期化を行う為に元々のsetUp()をコールする
        parent::setUp();
    }

    /**
     * getConnection()
     *
     * DBテストに必要な接続を実施
     */
    public function getConnection()
    {
        $dsn = $GLOBALS['DB_DRIVER'] . ':dbname=' . $GLOBALS['DB_DBNAME'] . ';host=' . $GLOBALS['DB_HOST'];
        $pdo = new \PDO($dsn, $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);

        return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_DBNAME']);
    }

    /**
     * getDataSet()
     *
     * DBテストに必要なデータセットを実施
     */
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/../../../risoluto_db_test.xml');
    }

    /**
     * testPreCondition()
     *
     * テスト開始前に前提条件をチェックする
     */
    public function testPreCondition()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('risoluto_db_test'));
    }

    /**
     * test_GetAttribute_NoArgs()
     *
     * GetAttribute()のテスト（引数未指定時）
     */
    public function test_GetAttribute_NoArgs()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute();

        $this->assertArrayHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayHasKey('PREFETCH', $tmp_result);
        $this->assertArrayHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayHasKey('ERRMODE', $tmp_result);
        $this->assertArrayHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayHasKey('CASE', $tmp_result);
        $this->assertArrayHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_ALL()
     *
     * GetAttribute()のテスト（引数"ALL"指定時）
     */
    public function test_GetAttribute_ALL()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('ALL');

        $this->assertArrayHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayHasKey('PREFETCH', $tmp_result);
        $this->assertArrayHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayHasKey('ERRMODE', $tmp_result);
        $this->assertArrayHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayHasKey('CASE', $tmp_result);
        $this->assertArrayHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_AUTOCOMMIT()
     *
     * GetAttribute()のテスト（引数"AUTOCOMMIT"指定時）
     */
    public function test_GetAttribute_AUTOCOMMIT()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('AUTOCOMMIT');

        $this->assertArrayHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_PREFETCH()
     *
     * GetAttribute()のテスト（引数"PREFETCH"指定時）
     */
    public function test_GetAttribute_PREFETCH()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('PREFETCH');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_TIMEOUT()
     *
     * GetAttribute()のテスト（引数"TIMEOUT"指定時）
     */
    public function test_GetAttribute_TIMEOUT()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('TIMEOUT');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_ERRMODE()
     *
     * GetAttribute()のテスト（引数"ERRMODE"指定時）
     */
    public function test_GetAttribute_ERRMODE()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('ERRMODE');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_SERVER_VERSION()
     *
     * GetAttribute()のテスト（引数"SERVER_VERSION"指定時）
     */
    public function test_GetAttribute_SERVER_VERSION()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('SERVER_VERSION');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_CLIENT_VERSION()
     *
     * GetAttribute()のテスト（引数"CLIENT_VERSION"指定時）
     */
    public function test_GetAttribute_CLIENT_VERSION()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('CLIENT_VERSION');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_SERVER_INFO()
     *
     * GetAttribute()のテスト（引数"SERVER_INFO"指定時）
     */
    public function test_GetAttribute_SERVER_INFO()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('SERVER_INFO');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_CONNECTION_STATUS()
     *
     * GetAttribute()のテスト（引数"CONNECTION_STATUS"指定時）
     */
    public function test_GetAttribute_CONNECTION_STATUS()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('CONNECTION_STATUS');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_CASE()
     *
     * GetAttribute()のテスト（引数"CASE"指定時）
     */
    public function test_GetAttribute_CASE()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('CASE');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_DRIVER_NAME()
     *
     * GetAttribute()のテスト（引数"DRIVER_NAME"指定時）
     */
    public function test_GetAttribute_DRIVER_NAME()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('DRIVER_NAME');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_ORACLE_NULLS()
     *
     * GetAttribute()のテスト（引数"ORACLE_NULLS"指定時）
     */
    public function test_GetAttribute_ORACLE_NULLS()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('ORACLE_NULLS');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_PERSISTENT()
     *
     * GetAttribute()のテスト（引数"PERSISTENT"指定時）
     */
    public function test_GetAttribute_PERSISTENT()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('PERSISTENT');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_STATEMENT_CLASS()
     *
     * GetAttribute()のテスト（引数"STATEMENT_CLASS"指定時）
     */
    public function test_GetAttribute_STATEMENT_CLASS()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('STATEMENT_CLASS');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayNotHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_GetAttribute_DEFAULT_FETCH_MODE()
     *
     * GetAttribute()のテスト（引数"DEFAULT_FETCH_MODE"指定時）
     */
    public function test_GetAttribute_DEFAULT_FETCH_MODE()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->Connect($params);
        $tmp_result = $instance->GetAttribute('DEFAULT_FETCH_MODE');

        $this->assertArrayNotHasKey('AUTOCOMMIT', $tmp_result);
        $this->assertArrayNotHasKey('PREFETCH', $tmp_result);
        $this->assertArrayNotHasKey('TIMEOUT', $tmp_result);
        $this->assertArrayNotHasKey('ERRMODE', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('CLIENT_VERSION', $tmp_result);
        $this->assertArrayNotHasKey('SERVER_INFO', $tmp_result);
        $this->assertArrayNotHasKey('CONNECTION_STATUS', $tmp_result);
        $this->assertArrayNotHasKey('CASE', $tmp_result);
        $this->assertArrayNotHasKey('DRIVER_NAME', $tmp_result);
        $this->assertArrayNotHasKey('ORACLE_NULLS', $tmp_result);
        $this->assertArrayNotHasKey('PERSISTENT', $tmp_result);
        $this->assertArrayNotHasKey('STATEMENT_CLASS', $tmp_result);
        $this->assertArrayHasKey('DEFAULT_FETCH_MODE', $tmp_result);

        $instance->DisConnect();
        unset($instance);
    }
}
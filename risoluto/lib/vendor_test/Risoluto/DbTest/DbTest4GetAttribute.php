<?php
/**
 * DbTest4getAttribute
 *
 * Db::getAttribute()用テストケース
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
class DbTest4getAttribute extends \PHPUnit_Extensions_Database_TestCase
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
     * getconnection()
     *
     * DBテストに必要な接続を実施
     */
    public function getconnection()
    {
        $dsn = $GLOBALS['DB_DRIVER'] . ':dbname=' . $GLOBALS['DB_DBNAME'] . ';host=' . $GLOBALS['DB_HOST'];
        $pdo = new \PDO($dsn, $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);

        return $this->createDefaultDBconnection($pdo, $GLOBALS['DB_DBNAME']);
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
        $this->assertEquals(2, $this->getconnection()->getRowCount('risoluto_db_test'));
    }

    /**
     * test_getAttribute_NoArgs()
     *
     * getAttribute()のテスト（引数未指定時）
     */
    public function test_getAttribute_NoArgs()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute();

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_ALL()
     *
     * getAttribute()のテスト（引数"ALL"指定時）
     */
    public function test_getAttribute_ALL()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('ALL');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_AUTOCOMMIT()
     *
     * getAttribute()のテスト（引数"AUTOCOMMIT"指定時）
     */
    public function test_getAttribute_AUTOCOMMIT()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('AUTOCOMMIT');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_PREFETCH()
     *
     * getAttribute()のテスト（引数"PREFETCH"指定時）
     */
    public function test_getAttribute_PREFETCH()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('PREFETCH');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_TIMEOUT()
     *
     * getAttribute()のテスト（引数"TIMEOUT"指定時）
     */
    public function test_getAttribute_TIMEOUT()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('TIMEOUT');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_ERRMODE()
     *
     * getAttribute()のテスト（引数"ERRMODE"指定時）
     */
    public function test_getAttribute_ERRMODE()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('ERRMODE');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_SERVER_VERSION()
     *
     * getAttribute()のテスト（引数"SERVER_VERSION"指定時）
     */
    public function test_getAttribute_SERVER_VERSION()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('SERVER_VERSION');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_CLIENT_VERSION()
     *
     * getAttribute()のテスト（引数"CLIENT_VERSION"指定時）
     */
    public function test_getAttribute_CLIENT_VERSION()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('CLIENT_VERSION');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_SERVER_INFO()
     *
     * getAttribute()のテスト（引数"SERVER_INFO"指定時）
     */
    public function test_getAttribute_SERVER_INFO()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('SERVER_INFO');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_CONNECTION_STATUS()
     *
     * getAttribute()のテスト（引数"CONNECTION_STATUS"指定時）
     */
    public function test_getAttribute_CONNECTION_STATUS()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('CONNECTION_STATUS');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_CASE()
     *
     * getAttribute()のテスト（引数"CASE"指定時）
     */
    public function test_getAttribute_CASE()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('CASE');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_DRIVER_NAME()
     *
     * getAttribute()のテスト（引数"DRIVER_NAME"指定時）
     */
    public function test_getAttribute_DRIVER_NAME()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('DRIVER_NAME');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_ORACLE_NULLS()
     *
     * getAttribute()のテスト（引数"ORACLE_NULLS"指定時）
     */
    public function test_getAttribute_ORACLE_NULLS()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('ORACLE_NULLS');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_PERSISTENT()
     *
     * getAttribute()のテスト（引数"PERSISTENT"指定時）
     */
    public function test_getAttribute_PERSISTENT()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('PERSISTENT');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_STATEMENT_CLASS()
     *
     * getAttribute()のテスト（引数"STATEMENT_CLASS"指定時）
     */
    public function test_getAttribute_STATEMENT_CLASS()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('STATEMENT_CLASS');

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

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_getAttribute_DEFAULT_FETCH_MODE()
     *
     * getAttribute()のテスト（引数"DEFAULT_FETCH_MODE"指定時）
     */
    public function test_getAttribute_DEFAULT_FETCH_MODE()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->getAttribute('DEFAULT_FETCH_MODE');

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

        $instance->disConnect();
        unset($instance);
    }
}
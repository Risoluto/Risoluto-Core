<?php
/**
 * DbTest4setAttribute
 *
 * Db::setAttribute()用テストケース
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
class DbTest4setAttribute extends \PHPUnit_Extensions_Database_TestCase
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
     * test_setAttribute_EmptyBoth()
     *
     * setAttribute()のテスト（引数両方未指定時）
     */
    public function test_setAttribute_EmptyBoth()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->setAttribute('', '');

        $this->assertFalse($tmp_result);

        $instance->disconnect();
        unset($instance);
    }

    /**
     * test_setAttribute_Empty1st()
     *
     * setAttribute()のテスト（第1引数未指定時）
     */
    public function test_setAttribute_Empty1st()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->setAttribute('', 'BAR');

        $this->assertFalse($tmp_result);

        $instance->disconnect();
        unset($instance);
    }

    /**
     * test_setAttribute_Empty2nd()
     *
     * setAttribute()のテスト（第2引数未指定時）
     */
    public function test_setAttribute_Empty2nd()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $tmp_result = $instance->setAttribute('FOO', '');

        $this->assertFalse($tmp_result);

        $instance->disconnect();
        unset($instance);
    }

    /**
     * test_setAttribute_withArgs()
     *
     * setAttribute()のテスト（引数指定時）
     */
    public function test_setAttribute_withArgs()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);
        $before_val = $instance->getAttribute('FETCH_MODE');
        $tmp_result = $instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $after_val  = $instance->getAttribute('FETCH_MODE');

        $this->assertTrue($tmp_result);
        $this->assertNotEquals($before_val, $after_val);
        $this->assertNotEquals(\PDO::FETCH_OBJ, $after_val);

        $instance->disconnect();
        unset($instance);
    }
}
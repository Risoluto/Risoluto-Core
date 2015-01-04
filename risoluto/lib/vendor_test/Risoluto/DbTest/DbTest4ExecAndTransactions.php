<?php
/**
 * DbTest4ExecAndTransactions
 *
 * Db::exec()/beginTransaction()/inTransaction()/commit()/rollBack()/lastInsertId()用テストケース
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
class DbTest4ExecAndTransactions extends \PHPUnit_Extensions_Database_TestCase
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
     * test_ExecAndTransaction_ExecWithNoArgs()
     *
     * exec()のテスト（引数なし）
     */
    public function test_ExecAndTransaction_ExecWithNoArgs()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);

        $this->assertFalse($instance->exec(''));

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_ExecAndTransaction_ExecWithNoTrans()
     *
     * exec()のテスト（トランザクションなし）
     */
    public function test_ExecAndTransaction_ExecWithNoTrans()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);

        $this->assertFalse($instance->inTransaction());

        $this->assertEquals(1, $instance->exec('INSERT INTO risoluto_db_test(id, column1, column2) values ("10", "TEST_A", "TEST_B");'));
        $this->assertEquals(3, $this->getconnection()->getRowCount('risoluto_db_test'));

        $this->assertEquals(10, $instance->lastInsertId());
        $this->assertEquals(10, $instance->lastInsertId('id'));

        $this->assertEquals(1, $instance->exec('DELETE FROM risoluto_db_test WHERE id="10";'));
        $this->assertEquals(2, $this->getconnection()->getRowCount('risoluto_db_test'));

        $instance->disConnect();
        unset($instance);
    }

    /**
     * test_ExecAndTransaction_ExecWithInTrans()
     *
     * exec()のテスト（トランザクションあり）
     */
    public function test_ExecAndTransaction_ExecWithInTrans()
    {
        $params = array("driver"     => $GLOBALS['DB_DRIVER'],
                        "user"       => $GLOBALS['DB_USER'],
                        "pass"       => $GLOBALS['DB_PASSWORD'],
                        "dbname"     => $GLOBALS['DB_DBNAME'],
                        "host"       => $GLOBALS['DB_HOST'],
                        "persistent" => false);

        $instance = new Db;
        $instance->connect($params);

        // commit pattern
        $this->assertTrue($instance->beginTransaction());
        $this->assertTrue($instance->inTransaction());

        $this->assertEquals(1, $instance->exec('INSERT INTO risoluto_db_test(id, column1, column2) values ("10", "TEST_A", "TEST_B");'));
        $this->assertEquals(2, $this->getconnection()->getRowCount('risoluto_db_test'));

        $this->assertEquals(10, $instance->lastInsertId());
        $this->assertEquals(10, $instance->lastInsertId('id'));

        $this->assertTrue($instance->commit());
        $this->assertFalse($instance->inTransaction());

        $this->assertEquals(3, $this->getconnection()->getRowCount('risoluto_db_test'));



        // Rollback pattern
        $before_val = $this->getconnection()->createQueryTable('risoluto_db_test', 'SELECT id, column1, column2 FROM risoluto_db_test WHERE id="10";');
        $this->assertTrue($instance->beginTransaction());
        $this->assertTrue($instance->inTransaction());

        $this->assertEquals(1, $instance->exec('UPDATE risoluto_db_test SET column1="TEST_C", column2="TEST_C" WHERE id="10";'));
        $this->assertEquals(3, $this->getconnection()->getRowCount('risoluto_db_test'));

        $this->assertEquals(1, $instance->exec('DELETE FROM risoluto_db_test WHERE id="10";'));
        $this->assertEquals(3, $this->getconnection()->getRowCount('risoluto_db_test'));

        $this->assertTrue($instance->rollBack());
        $this->assertFalse($instance->inTransaction());

        $after_val  = $this->getconnection()->createQueryTable('risoluto_db_test', 'SELECT id, column1, column2 FROM risoluto_db_test WHERE id="10";');
        $this->assertEquals(3, $this->getconnection()->getRowCount('risoluto_db_test'));
        $this->assertTablesEqual($before_val, $after_val);

        // Cleaning
        $this->assertEquals(1, $instance->exec('DELETE FROM risoluto_db_test WHERE id="10";'));
        $this->assertEquals(2, $this->getconnection()->getRowCount('risoluto_db_test'));

        $instance->disConnect();
        unset($instance);
    }
}
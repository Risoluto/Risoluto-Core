<?php
/**
 * DbTest4ExecAndTransactions
 *
 * Db::Exec()/BeginTransaction()/InTransaction()/Commit()/RollBack()/LastInsertId()用テストケース
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
     * test_ExecAndTransaction_ExecWithNoArgs()
     *
     * Exec()のテスト（引数なし）
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
        $instance->Connect($params);

        $this->assertFalse($instance->Exec(''));

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_ExecAndTransaction_ExecWithNoTrans()
     *
     * Exec()のテスト（トランザクションなし）
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
        $instance->Connect($params);

        $this->assertFalse($instance->InTransaction());

        $this->assertEquals(1, $instance->Exec('INSERT INTO risoluto_db_test(id, column1, column2) values ("10", "TEST_A", "TEST_B");'));
        $this->assertEquals(3, $this->getConnection()->getRowCount('risoluto_db_test'));

        $this->assertEquals(10, $instance->LastInsertId());
        $this->assertEquals(10, $instance->LastInsertId('id'));

        $this->assertEquals(1, $instance->Exec('DELETE FROM risoluto_db_test WHERE id="10";'));
        $this->assertEquals(2, $this->getConnection()->getRowCount('risoluto_db_test'));

        $instance->DisConnect();
        unset($instance);
    }

    /**
     * test_ExecAndTransaction_ExecWithInTrans()
     *
     * Exec()のテスト（トランザクションあり）
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
        $instance->Connect($params);

        // Commit pattern
        $this->assertTrue($instance->BeginTransaction());
        $this->assertTrue($instance->InTransaction());

        $this->assertEquals(1, $instance->Exec('INSERT INTO risoluto_db_test(id, column1, column2) values ("10", "TEST_A", "TEST_B");'));
        $this->assertEquals(2, $this->getConnection()->getRowCount('risoluto_db_test'));

        $this->assertEquals(10, $instance->LastInsertId());
        $this->assertEquals(10, $instance->LastInsertId('id'));

        $this->assertTrue($instance->Commit());
        $this->assertFalse($instance->InTransaction());

        $this->assertEquals(3, $this->getConnection()->getRowCount('risoluto_db_test'));



        // Rollback pattern
        $before_val = $this->getConnection()->createQueryTable('risoluto_db_test', 'SELECT id, column1, column2 FROM risoluto_db_test WHERE id="10";');
        $this->assertTrue($instance->BeginTransaction());
        $this->assertTrue($instance->InTransaction());

        $this->assertEquals(1, $instance->Exec('UPDATE risoluto_db_test SET column1="TEST_C", column2="TEST_C" WHERE id="10";'));
        $this->assertEquals(3, $this->getConnection()->getRowCount('risoluto_db_test'));

        $this->assertEquals(1, $instance->Exec('DELETE FROM risoluto_db_test WHERE id="10";'));
        $this->assertEquals(3, $this->getConnection()->getRowCount('risoluto_db_test'));

        $this->assertTrue($instance->RollBack());
        $this->assertFalse($instance->InTransaction());

        $after_val  = $this->getConnection()->createQueryTable('risoluto_db_test', 'SELECT id, column1, column2 FROM risoluto_db_test WHERE id="10";');
        $this->assertEquals(3, $this->getConnection()->getRowCount('risoluto_db_test'));
        $this->assertTablesEqual($before_val, $after_val);

        // Cleaning
        $this->assertEquals(1, $instance->Exec('DELETE FROM risoluto_db_test WHERE id="10";'));
        $this->assertEquals(2, $this->getConnection()->getRowCount('risoluto_db_test'));

        $instance->DisConnect();
        unset($instance);
    }
}
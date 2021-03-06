<?php
/**
 * DbTest4DoQuery
 *
 * Db::doQuery()用テストケース
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
class DbTest4DoQuery extends \PHPUnit_Extensions_Database_TestCase
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
        if (!extension_loaded( 'mysqli' )) {
            $this->markTestSkipped( 'Cannot use mysqli expansion module.' );
        }

        if (!isset( $GLOBALS[ 'DB_DRIVER' ] )) {
            $this->markTestSkipped( 'DB_DRIVER was not defined. Check phpunit.xml' );
        } elseif (!isset( $GLOBALS[ 'DB_USER' ] )) {
            $this->markTestSkipped( 'DB_USER was not defined. Check phpunit.xml' );
        } elseif (!isset( $GLOBALS[ 'DB_PASSWORD' ] )) {
            $this->markTestSkipped( 'DB_PASSWORD was not defined. Check phpunit.xml' );
        } elseif (!isset( $GLOBALS[ 'DB_DBNAME' ] )) {
            $this->markTestSkipped( 'DB_DBNAME was not defined. Check phpunit.xml' );
        } elseif (!isset( $GLOBALS[ 'DB_HOST' ] )) {
            $this->markTestSkipped( 'DB_HOST was not defined. Check phpunit.xml' );
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
        $dsn = $GLOBALS[ 'DB_DRIVER' ] . ':dbname=' . $GLOBALS[ 'DB_DBNAME' ] . ';host=' . $GLOBALS[ 'DB_HOST' ];
        $pdo = new \PDO( $dsn, $GLOBALS[ 'DB_USER' ], $GLOBALS[ 'DB_PASSWORD' ] );

        return $this->createDefaultDBConnection( $pdo, $GLOBALS[ 'DB_DBNAME' ] );
    }

    /**
     * getDataSet()
     *
     * DBテストに必要なデータセットを実施
     */
    public function getDataSet()
    {
        return $this->createXMLDataSet( dirname( __FILE__ ) . '/../../../risoluto_db_test.xml' );
    }

    /**
     * testPreCondition()
     *
     * テスト開始前に前提条件をチェックする
     */
    public function testPreCondition()
    {
        $this->assertEquals( 2, $this->getConnection()->getRowCount( 'risoluto_db_test' ) );
    }

    /**
     * test_DoQuery_NoArgs()
     *
     * doQuery()のテスト（引数なし）
     */
    public function test_DoQuery_NoArgs()
    {
        $params = [
            "driver" => $GLOBALS[ 'DB_DRIVER' ],
            "user" => $GLOBALS[ 'DB_USER' ],
            "pass" => $GLOBALS[ 'DB_PASSWORD' ],
            "dbname" => $GLOBALS[ 'DB_DBNAME' ],
            "host" => $GLOBALS[ 'DB_HOST' ],
            "persistent" => false,
        ];

        $instance = new Db;
        $instance->connect( $params );

        $this->assertFalse( $instance->doQuery() );

        $instance->disConnect();
        unset( $instance );
    }

    /**
     * test_DoQuery_WithSql()
     *
     * doQuery()のテスト（SQLを指定）
     */
    public function test_DoQuery_WithSql()
    {
        $params = [
            "driver" => $GLOBALS[ 'DB_DRIVER' ],
            "user" => $GLOBALS[ 'DB_USER' ],
            "pass" => $GLOBALS[ 'DB_PASSWORD' ],
            "dbname" => $GLOBALS[ 'DB_DBNAME' ],
            "host" => $GLOBALS[ 'DB_HOST' ],
            "persistent" => false,
        ];

        $sql = 'SELECT id, column1, column2 FROM risoluto_db_test;';

        $want = [
            0 => [ 'id' => '1', 'column1' => 'id1:column1', 'column2' => 'id1:column2' ],
            1 => [ 'id' => '2', 'column1' => null, 'column2' => null ],
        ];

        $instance = new Db;
        $instance->connect( $params );

        $tmp_result = $instance->doQuery( $sql );
        $this->assertEquals( $want, $tmp_result );

        $instance->disConnect();
        unset( $instance );
    }


    /**
     * test_DoQuery_WithSqlAndParam()
     *
     * doQuery()のテスト（SQLを指定）
     */
    public function test_DoQuery_WithSqlAndParam()
    {
        $params = [
            "driver" => $GLOBALS[ 'DB_DRIVER' ],
            "user" => $GLOBALS[ 'DB_USER' ],
            "pass" => $GLOBALS[ 'DB_PASSWORD' ],
            "dbname" => $GLOBALS[ 'DB_DBNAME' ],
            "host" => $GLOBALS[ 'DB_HOST' ],
            "persistent" => false,
        ];

        $sql = 'SELECT id, column1, column2 FROM risoluto_db_test WHERE id = :id;';
        $param1 = [
            [ 'id' => ':id', 'value' => 1, 'type' => \PDO::PARAM_INT ]
        ];
        $param2 = [
            [ 'id' => ':id', 'value' => 2, 'type' => \PDO::PARAM_INT, 'length' => 1 ]
        ];

        $want1 = [
            0 => [ 'id' => '1', 'column1' => 'id1:column1', 'column2' => 'id1:column2' ]
        ];
        $want2 = [
            0 => [ 'id' => '2', 'column1' => null, 'column2' => null ]
        ];
        $want3 = [
            0 => [ '0' => '2', '1' => null, '2' => null, 'id' => '2', 'column1' => null, 'column2' => null ]
        ];

        $instance = new Db;
        $instance->connect( $params );

        // Begin, $sql and $param sets.
        $tmp_result = $instance->doQuery( $sql, $param1 );
        $this->assertEquals( $want1, $tmp_result );

        // Next, only $param sets.
        $tmp_result = $instance->doQuery( '', $param2 );
        $this->assertEquals( $want2, $tmp_result );

        // Final, $param and fetch_style set.
        $tmp_result = $instance->doQuery( '', $param2, [ ], \PDO::FETCH_BOTH );
        $this->assertEquals( $want3, $tmp_result );

        $instance->disConnect();
        unset( $instance );
    }
}
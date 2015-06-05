<?php
/**
 * DbTest4DisConnect
 *
 * Db::disConnect()用テストケース
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
class DbTest4DisConnect extends \PHPUnit_Extensions_Database_TestCase
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
     * test_DisConnect()
     *
     * disConnect()のテスト（force未設定時）
     */
    public function test_DisConnect()
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
        $this->assertTrue( $instance->disConnect() );
        unset( $instance );
    }

    /**
     * test_DisConnect_with_force()
     *
     * disConnect()のテスト（force = true時）
     */
    public function test_DisConnect_with_force()
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
        $this->assertTrue( $instance->disConnect( true ) );
        unset( $instance );
    }

    /**
     * test_DisConnect_without_force()
     *
     * disConnect()のテスト（force = false時）
     */
    public function test_DisConnect_without_force()
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
        $this->assertTrue( $instance->disConnect( false ) );
        unset( $instance );
    }
}

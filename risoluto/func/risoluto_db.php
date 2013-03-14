<?php
/**
 * データベースクラス
 *
 * データベース操作のためのファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  /**
   * PEAR::MDB2クラス
   */
  require_once( 'MDB2.php' );

  class RisolutoDb
  {
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * クラスインスタンスを保持する変数
     * @access private
     * @var    array
     */
    private static $obj_instance;

    /**
     * MDB2_Driver_Common情報を保持する変数
     * @access private
     * @var    object
     */
    private static $obj_db;

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * コンストラクタメソッド
     *
     * コンストラクタメソッド
     *
     * @param     void なし
     * @return    void なし
     */
    public function __construct()
    {
    } // end of function:__construct()

    /**
     * クローンメソッド
     *
     * クローンメソッド
     *
     * @param     void なし
     * @return    void なし
     */
    public function __clone()
    {
    } // end of function:__clone()

    /**
     * DB接続メソッド
     *
     * 引数で与えられたdsnのDBに接続する
     *
     * @param     string    $dsnid  iniファイル中に記述したdsnid
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function dbConnect( $dsnid )
    {

      //-- ローカル変数 --//
      $retval = false;

      // 引数が指定されている場合のみ、DBへのコネクション確立を試みる
      if ( !empty( $dsnid ) )
      {

        // 最大で5回分接続のリトライを試みる
        for ( $cnt = 0 ; $cnt < 5 ; $cnt ++ )
        {

          $this->obj_db =& MDB2::singleton( $dsnid );
          if ( !PEAR::isError( $this->obj_db ) )
          {

            // 必要なMDB2モジュールをロードする
            $this->obj_db->loadModule( 'Extended', null, false );
            // オートマジカルにオプションの設定を行う
            $this->dbSetOptions();

            $retval = true;
            break;
          } // end of if
          else
          {
            // 接続に失敗したときは300マイクロ秒待つ
            usleep( 300 );
          } // end of else
        } // end of for

      } // end of if

      // 呼び出し元に戻る
      return $retval;

    } // end of function:dbConnect

    /**
     * DB接続解除メソッド
     *
     * DB接続の解除を行う
     * 
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function dbDisConnect( )
    {

      // 呼び出し元に戻る
      return $this->obj_db->disconnect();

    } // end of function:dbDisConnect

    /**
     * Commitメソッド
     *
     * Commitを行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function dbCommit()
    {

      //-- ローカル変数 --//
      $retval = false;

      if ( !PEAR::isError( $this->obj_db->commit() ) )
      {
        $retval = true;
      } // end of if

      // 呼び出し元に戻る
      return $retval;

    } // end of function:dbCommit

    /**
     * Rollbackメソッド
     *
     * Rollbackを行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function dbRollback()
    {

      //-- ローカル変数 --//
      $retval = false;

      if ( !PEAR::isError( $this->obj_db->rollback() ) )
      {
        $retval = true;
      }

      // 呼び出し元に戻る
      return $retval;

    } // end of function:dbRollback

    /**
     * dbBeginTransactionメソッド
     *
     * トランザクションを開始する
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function dbBeginTransaction()
    {

      //-- ローカル変数 --//
      $retval = false;

      // トランザクションがすでに開始されているか、サポートされていなければ戻る
      if ( $this->obj_db->inTransaction() and !$this->obj_db->supports( 'transactions' ) )
      {
        return false;
      } // end of if

      // トランザクションを開始する
      if ( !PEAR::isError( $this->obj_db->beginTransaction() ) )
      {
        $retval = true;
      } // end of if

      // 呼び出し元に戻る
      return $retval;

    } // end of function:dbBeginTransaction

    /**
     * オプション設定メソッド
     *
     * オプション設定を行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ 常にtrue ）
     */
    public function dbSetOptions( )
    {

      //-- ローカル変数 --//
      $retval = true;

      $this->dbExecSQL( 'SET NAMES utf8'         );
      $this->dbExecSQL( 'SET CHARACTER SET utf8' );
      $this->obj_db->setFetchMode( MDB2_FETCHMODE_ASSOC, 'Query_Result' );

      $this->obj_db->setOption( 'ssl',              false                 );
      $this->obj_db->setOption( 'field_case',       CASE_UPPER            );
      $this->obj_db->setOption( 'result_buffering', false                 );
      $this->obj_db->setOption( 'persistent',       true                  );
      $this->obj_db->setOption( 'debug',            0                     );
      $this->obj_db->setOption( 'use_transactions', true                  );
      $this->obj_db->setOption( 'portability',      MDB2_PORTABILITY_NONE );

      // 呼び出し元に戻る
      return true;

    } // end of function:dbSetOptions

    /**
     * エラーメッセージ取得メソッド
     *
     * DB関連エラー発生時、エラーメッセージの取得を行う
     * エラーが発生した直後に実行されなければならない
     *
     * @param     object $obj_err DB:ERRORオブジェクト（任意）
     * @return    string エラーメッセージ
     */
    public function dbGetErrMsg( $obj_err = null )
    {

      //-- ローカル変数 --//
      $retval = "";

      // 引数が与えられていればそちらからエラーメッセージを取得する
      if ( !empty( $obj_err ) )
      {
        $retval = $obj_err->getMessage();
      } // end of if
      else
      {
        $retval = $this->obj_db->getMessage();
      } // end of else

      // 呼び出し元に戻る
      return $retval;

    } // end of dbGetErrMsg

    /**
     * DBデータ取得メソッド（全データ）
     *
     * 引数で与えられたクエリを実行し全データを取得する
     * 取得した値は配列で返却される
     * 
     * @param     string    $query  実行するSQLクエリ（クエリ中の?はプレースホルダ）
     * @param     string    $param  プレースホルダを置換する値が格納された配列
     * @return    array クエリ実行結果（エラーの場合、DB:ERRORオブジェクト）
     */
    public function dbGetAll( $query, $param = array() )
    {

      // 呼び出し元に戻る
      return $this->obj_db->extended->getAll( $query, null, $param, null, MDB2_FETCHMODE_ASSOC, false );

    } // end of function:dbGetAll

    /**
     * DBデータ取得メソッド（最初の行の値）
     *
     * 引数で与えられたクエリを実行し結果セットの最初の行の値を取得する
     * 取得した値は配列で返却される
     * 
     * @param     string    $query  実行するSQLクエリ（クエリ中の?はプレースホルダ）
     * @param     string    $param  プレースホルダを置換する値が格納された配列
     * @return    array クエリ実行結果（エラーの場合、DB:ERRORオブジェクト）
     */
    public function dbGetRow( $query, $param = array() )
    {

      // 呼び出し元に戻る
      return $this->obj_db->extended->getRow( $query, null, $param, null, MDB2_FETCHMODE_ASSOC );

    } // end of function:dbGetRow

    /**
     * SQL発行メソッド
     *
     * 引数で与えられたクエリ及びバインド変数へ指定する値を使用し、任意のSQLを発行する
     * 取得した値は配列で返却される
     * 
     * @param     string    $query    実行するSQLクエリ（クエリ中の?はプレースホルダ）
     * @param     string    $param    プレースホルダを置換する値が格納された配列
     * @return    mixed     クエリ実行結果（エラーの場合、DB:ERRORオブジェクト）
     */
    public function dbExecSQL( $query, $param = array() )
    {

      //-- ローカル変数 --//
      $retval = false;

      // 指定されたクエリを実行し、結果をチェックする
      $readySQL = $this->obj_db->prepare( $query );
      if ( !PEAR::isError( $readySQL ) )
      {
        $retval = $readySQL->execute( $param );
        $readySQL->free();
      } // end of if
      else
      {
        $retval = $readySQL;
      } // end of else

      // 呼び出し元に戻る
      return $retval;

    } // end of function:dbExecSQL

    /**
     * SQL発行メソッド
     *
     * 引数で与えられたファイル内のSQL（各SQLは「;」区切り）を実行する
     * 
     * @param     string    $path   対象となるファイルのパス
     * @param     string    $prefix SQL文中の「[[[_PREFIX]]]」を置換する文字列
     * @return    boolean   実行結果（true: 全て正常に実行された/false: 一部又は全部が失敗）
     */
    public function fileSQLExec( $path, $prefix = null )
    {

      //-- ローカル変数 --//
      $retval = true;

      // ファイルが存在しない場合は、即時return
      if ( ! file_exists( $path ) )
      {
        return false;
      } // end of if

      // ファイルの内容を取得する
      $tmp_sql  = @file_get_contents( $path );
      // ファイル中の改行コードとタブコードは、半角スペース1つに置換する
      $tmp_sql  = preg_replace( '/[\r\n\t]/', ' ', $tmp_sql );
      // 「;」で分割する
      $exec_sql = explode( ';', $tmp_sql );

      // 順番に実行する
      foreach( $exec_sql as $sqldat )
      {
        // 実行すべきものがある場合のみ
        $do_it = trim( $sqldat );
        if ( ! empty( $do_it ) )
        {
          // $prefixがセットされていたら置換処理を実施
          if ( !empty( $prefix ) )
          {
            $do_it = str_replace( '[[[_PREFIX]]]', $prefix, $do_it );
          } // end of if

          // SQLを実行し、失敗したらエラーフラグをfalseにセット
          $exec_result = $this->dbExecSQL( $do_it );
          if ( PEAR::isError( $exec_result ) or $exec_result == false )
          {
            $retval = false;
          } // end of if
        } // end of if
      } // end of foreach

      // 呼び出し元に戻る
      return $retval;

    } // end of function:fileSQLExec

  }  // end of class:RisolutoDb

  /*
    [!!!!WARNING!!!!]This class is defined for keep compatibility. This will be erased in future release. Please use "RisolutoDb".
  */
  class RisoluteDb extends RisolutoDb
  {
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * コンストラクタメソッド
     *
     * コンストラクタメソッド
     *
     * @param     void なし
     * @return    void なし
     */
    public function __construct()
    {
      error_log( '[RisoluteDb]This class is defined for keep compatibility. This will be erased in future release. Please use "RisolutoDb". -> ' . RISOLUTODIR );
    } // end of function:__construct()
  } // end of class:RisolutoDb

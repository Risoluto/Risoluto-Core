<?php
/**
 * ログクラス
 *
 * ログ操作のためのファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  /**
   * コンフィグ操作クラス
   */
  require_once( RISOLUTO_FUNC . 'risoluto_conf.php' );

  class RisolutoLog
  {
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * クラスインスタンスを保持する変数
     * @access private
     * @var    object
     */
    private static $obj_instance;
    /**
     * ログ出力パスを保持する変数
     * @access private
     * @var    string
     */
    private static $str_logPath;

    /**
     * ログレベル閾値情報を保持
     * @var Array $arr_loglevel
     */
    private $arr_loglevel = array(
                       "stop"   => -1
                     , "emerg"  =>  0
                     , "alert"  =>  1
                     , "crit"   =>  2
                     , "error"  =>  3
                     , "warn"   =>  4
                     , "notice" =>  5
                     , "info"   =>  6
                     , "debug"  =>  7
                    );

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * コンストラクタメソッド
     *
     * コントローラのコンストラクタメソッド
     *
     * @param     void なし
     * @return    void なし
     */
    private function __construct()
    {
    } // end of function:__construct()

    /**
     * クローンメソッド
     *
     * コントローラのクローンメソッド
     *
     * @param     void なし
     * @return    void なし
     */
    public function __clone()
    {
    } // end of function:__clone()

    /**
     * シングルトンメソッド
     *
     * コントローラのインスタンスをシングルトンパターンで生成する
     *
     * @param     void なし
     * @return    object インスタンス
     */
    public static function singleton()
    {
        if ( ! isset( self::$obj_instance ) )
        {
            $tmp_myself = __CLASS__;
            self::$obj_instance = new $tmp_myself;
        } // end of if

        return self::$obj_instance;
    }

    /**
     * ログ出力メソッド
     *
     * 引数で与えられた文字列を引数で与えられたログレベルに対応する
     * パスのファイルに出力する
     *
     * @param     string    $loglvl  ログレベル（ stop | emerg | alert | crit | error | warn | notice | info | debug ）
     * @param     string    $logmes  出力するメッセージ
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function logging( $loglvl, $logmes )
    {

      //-- ローカル変数 --//
      $retval = false;
      $logfile= "";

      // iniファイルがロード不可能のときは出力対象外とする
      $conf = new RisolutoConf();
      $conf->parse( RISOLUTO_CONF . 'risoluto.ini' );
      if ( !$conf->is_parsed() )
      {
        return false;
      } // end of if

      // コンフィグで規定されているログレベル以下の場合は出力しない
      if ( $this->arr_loglevel[ $conf->get( "LOGGING", "loglevel" ) ] < $this->arr_loglevel[ $loglvl ] )
      {
        return true;
      } // end of if

      // ファイル名を生成
      $this->str_logPath = RISOLUTO_LOGS . 'risoluto_' . date( 'Ymd' ) . '.log';

      // ファイルをオープンする
      if ( ( $handle = fopen( $this->str_logPath , "a" ) ) )
      {
        // ファイルが無事にオープンできたらファイルロックを試みる
        if ( flock( $handle, LOCK_EX ) )
        {
          $currentDate = date( 'Y/m/d G:i:s(T)' );
          if ( fwrite( $handle, "[ $loglvl at $currentDate] $logmes\n" ) )
          {
            $retval = true;
          } // end of if
        } // end of if
      } // end of if

      // ファイルロックの解放とクローズは必ず行う
      flock ( $handle, LOCK_UN );
      fclose( $handle );

      return $retval;

    } // end of logging

  }  // end of class:RisolutoLog
?>

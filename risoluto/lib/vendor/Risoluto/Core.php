<?php
/**
 * Risolutoコアクラス
 *
 * Risolutoの中核部分に関するメソッドが含まれているクラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto\RisolutoCore;

  class RisolutoCore extends RisolutoHooks
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
     * コンフィグクラスインスタンスを保持する変数
     * @access private
     * @var    object
     */
    private $obj_conf;
    /**
     * ログクラスインスタンスを保持する変数
     * @access private
     * @var    object
     */
    private $obj_log;
    /**
     * セッションクラスインスタンスを保持する変数
     * @access private
     * @var    object
     */
    private $obj_sess;
    /**
     * ユーティリティクラスインスタンスを保持する変数
     * @access private
     * @var    object
     */
    private $obj_util;

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
     * run()
     *
     * コントローラメインロジック
     *
     * @param     void なし
     * @return    void なし
     */
    public function run()
    {

      // フックの呼び出し
      $this->hook_first();

      //------------------------------------------------------//
      // コントローラを初期化する
      //------------------------------------------------------//
      // フックの呼び出し
      $this->hook_beforeInitController();

      // コンフィグオブジェクトの生成
      $this->obj_conf = new RisolutoConf();
      $this->obj_conf->parse( RISOLUTO_CONF . 'risoluto.ini' );
      // ログオブジェクトの生成
      $this->obj_log  = RisolutoLog::singleton();
      // セッションオブジェクトの生成
      $this->obj_sess = RisolutoSession::singleton();
      // ユーティリティオブジェクトの生成
      $this->obj_util = RisolutoUtils::singleton();

      // 現在のload averageを取得し、設定された値以上であれば503を返す
      $tmp_loadavg = sys_getloadavg();
      if ( $tmp_loadavg[ 0 ] > $this->obj_conf->get( 'LIMITS', 'max_loadavg' ) )
      {
        header( 'HTTP/1.1 503 Service Unavailable', true, 503 );
        exit( '503 Service Unavailable' );
      } // end of if

      // フックの呼び出し
      $this->hook_afterInitController();

      //------------------------------------------------------//
      // セッションをスタートする
      //------------------------------------------------------//
      // フックの呼び出し
      $this->hook_beforeStartSession();

      // セッションをスタートする
      $this->obj_sess->sessStart();

      // セッションタイムアウトの処理
      // セッション中に最終アクセス時間の情報があるかを判定
      if ( $this->obj_sess->sessIsThere( 'lastaccess' ) )
      {
        // 現在の時刻とセッション中の時刻情報を比較し、
        // コンフィグファイル中の時間を超過していた場合はタイムアウトしたものとみなす
        if ( $this->obj_conf->get( 'SESSION', 'timeout' ) > 0
             and ( time() - $this->obj_sess->sessLoad( 'lastaccess' ) ) > $this->obj_conf->get( 'SESSION', 'timeout' )
           )
        {
          // 一度セッションを切った後、再度スタートさせる（情報も忘れずセット）
          $this->obj_sess->sessRevoke( 'login_userid'  );
          $this->obj_sess->sessRevoke( 'login_groupid' );
          $this->obj_sess->sessEnd();
          $this->obj_sess->sessStart();
          $this->obj_sess->sessStore( 'lastaccess', time()  );
          $this->obj_sess->sessStore( 'lastact',    'reset' );
          $this->obj_sess->sessStore( 'lastcage',   'reset' );
        } // end of if
        // 超過していなければ情報を更新して終了
        else
        {
          $this->obj_sess->sessStore( 'lastaccess', time() );
          if ( $this->obj_sess->sessIsThere( 'currentact' ) )
          {
            $this->obj_sess->sessStore( 'lastact',    $this->obj_sess->sessLoad( 'currentact'  ) );
          } // end of if
          else
          {
            $this->obj_sess->sessStore( 'lastact',    'unknown' );
          } // end of if

          if ( $this->obj_sess->sessIsThere( 'currentcage' ) )
          {
            $this->obj_sess->sessStore( 'lastcage',   $this->obj_sess->sessLoad( 'currentcage' ) );
          } // end of if
          else
          {
            $this->obj_sess->sessStore( 'lastcage',   'unknown' );
          } // end of else
        } // end of else
      } // end of if
      // 最終アクセス時間の情報がなければ情報をセッションにセットする
      else
      {
        $this->obj_sess->sessStore( 'lastaccess', time() );
        $this->obj_sess->sessStore( 'lastact',    'firsttime' );
        $this->obj_sess->sessStore( 'lastcage',   'firsttime' );
      } // end of else

      // フックの呼び出し
      $this->hook_afterStartSession();

      //------------------------------------------------------//
      // 各画面のクラスをロードする
      //------------------------------------------------------//
      // フックの呼び出し
      $this->hook_beforeLoadClass();

      // 呼び出し対象の決定
      $callTarget = $this->decide();
      // クラスファイルをロードする
      if ( empty( $callTarget[ 'cage' ] ) )
      {
        $execClassFile = RISOLUTO_USERLAND . $callTarget[ 'act' ] . '.php';
      } // end of if
      else
      {
        $execClassFile = RISOLUTO_USERLAND . $callTarget[ 'cage' ] . DIRECTORY_SEPARATOR . $callTarget[ 'act' ] . '.php';
      } // end of else
      require_once( $execClassFile );

      // 現在のCageとActをセッションに格納する
      $this->obj_sess->sessStore( 'currentcage', $callTarget[ 'cage' ] );
      $this->obj_sess->sessStore( 'currentact',  $callTarget[ 'act'  ] );

      // フックの呼び出し
      $this->hook_afterLoadClass();

      //------------------------------------------------------//
      // 各画面のクラスを実行する
      //------------------------------------------------------//
      // フックの呼び出し
      $this->hook_beforeExecuteClass();

      // クラスインスタンスを生成し、実行する
      try
      {
        // インスタンスの生成
        $targetInstance = new $callTarget[ 'act' ];

        // インスタンス中の各メソッドを所定の順番で実行
        // これらのメソッドは異常終了時例外をThrowする必要がある

        // イニシャライズメソッド
        $targetInstance->init();
        // モデルメソッド
        $targetInstance->model();
        // ビューメソッド
        $targetInstance->view();

      } // end of try:Call Class
      // 例外が発生したらインスタンス中のエラーハンドリングメソッドをコールする
      // エラーハンドリングメソッドは例外を発生させてはならない
      catch( Exception $e)
      {
        $this->obj_log->logging( 'error', "[RisolutoCore::run]Error occured : " . print_r( $e, true) );
        $targetInstance->errHandler();
      } // end of catch:Call Class

      // エラーの有無によらず、インスタンス中のクリーニングメソッドをコールする
      // クリーニングメソッドは例外を発生させてはならない
      $targetInstance->clean();

      // フックの呼び出し
      $this->hook_afterExecuteClass();

      //------------------------------------------------------//
      // コントローラのクリーニングを行う
      //------------------------------------------------------//
      // フックの呼び出し
      $this->hook_beforeCleanController();

      // クラス変数をunset()
      unset( $this->obj_conf );
      unset( $this->obj_log  );
      unset( $this->obj_sess );
      unset( $this->obj_util );

      // フックの呼び出し
      $this->hook_afterCleanController();

      // フックの呼び出し
      $this->hook_end();

    } // end of function:run()

    /**
     * decide()
     *
     * ロードするCageとActを決定する
     *
     * @param     void なし
     * @return    array(連想配列： 'cage'=>ロードするCage、NullならCage無し / 'act'=>ロードするAct)
     */
    private function decide()
    {
      //-- ローカル変数 --//
      $retval      = array();
      $cage        = $this->obj_conf->get( 'ACTIONS', 'defaultCAGE' );
      $act         = $this->obj_conf->get( 'ACTIONS', 'defaultACT'  );
      $currentStat = $this->obj_util->serviceStatus();

      // GETで指定されたCageとActを取得する
      if ( !empty( $_GET[ 'cage' ] ) )
      {
        $cage = strip_tags( trim( $_GET[ 'cage' ] ) );
        $cage = str_replace( '../', '', $cage );
      } // end of if
      if ( !empty( $_GET[ 'act' ] ) )
      {
        $act  = strip_tags( trim( $_GET[ 'act' ] ) );
        $act  = str_replace( '../', '', $act );
      } // end of if

      // サービス状態をチェックする
      switch( $currentStat )
      {
        // スーパバイザセッションのみの時
        case 4:
          if ( ! $this->obj_util->is_Supervisor() )
          {
            $cage = $this->obj_conf->get( 'ACTIONS', 'servicestopCAGE' );
            $act  = $this->obj_conf->get( 'ACTIONS', 'servicestopACT'  );
          } // end of if
          break;

        // 管理者セッションのみの時
        case 3:
          if ( ! $this->obj_util->is_Admin() )
          {
            $cage = $this->obj_conf->get( 'ACTIONS', 'servicestopCAGE' );
            $act  = $this->obj_conf->get( 'ACTIONS', 'servicestopACT'  );
          } // end of if
          break;

        // ユーザセッションのみ許可の時
        case 2:
          if ( ! $this->obj_util->is_User() )
          {
            $cage = $this->obj_conf->get( 'ACTIONS', 'servicestopCAGE' );
            $act  = $this->obj_conf->get( 'ACTIONS', 'servicestopACT'  );
          } // end of if
          break;

        // 既存セッションのみ許可の時
        case 1:
          if ( ! $this->obj_util->is_Guest() )
          {
            $cage = $this->obj_conf->get( 'ACTIONS', 'servicestopCAGE' );
            $act  = $this->obj_conf->get( 'ACTIONS', 'servicestopACT'  );
          } // end of if
          break;
      } // end of switch

      // 対象が存在するかをチェック
      if ( empty( $cage ) )
      {
        // Actのみの指定で、所定の位置にActと同一名称のファイルがなければ、エラーとする
        // 「ignore」というファイルがある場合もエラーとする
        clearstatcache();
        if (  ! file_exists( RISOLUTO_USERLAND . $act . '.php' )
             or file_exists( RISOLUTO_USERLAND . 'ignore' )
           )
        {
          $cage = $this->obj_conf->get( 'ACTIONS', 'errorCAGE' );
          $act  = $this->obj_conf->get( 'ACTIONS', 'errorACT'  );
        } // end of if
      } // end of if
      else
      {
        // はじめに指定されたCage中の「.」をDIRECTORY_SEPARATORに変換する
        $cage = str_replace( '.', DIRECTORY_SEPARATOR, $cage );

        // 所定の位置にActと同一名称のファイルがなければ、エラーとする
        // 「ignore」というファイルがある場合もエラーとする
        clearstatcache();
        if (  ! file_exists( RISOLUTO_USERLAND . $cage . DIRECTORY_SEPARATOR . $act . '.php' )
             or file_exists( RISOLUTO_USERLAND . $cage . DIRECTORY_SEPARATOR . 'ignore' )
           )
        {
          $cage = $this->obj_conf->get( 'ACTIONS', 'errorCAGE' );
          $act  = $this->obj_conf->get( 'ACTIONS', 'errorACT'  );
        } // end of if
      } // end of else

      // 呼び出し元に呼び出すべきCageとActを返却する
      return array( 'cage' => $cage, 'act' => $act );

    } // end of function:decide()

  } // end of class:RisolutoCore
?>

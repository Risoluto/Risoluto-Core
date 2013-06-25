<?php
/**
 * デフォルト画面基底クラス
 *
 * デフォルト画面で使用する基底クラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  /**
   * Smartyクラス
   */
  require_once( 'Smarty.class.php' );

  /**
   * セッションクラス
   */
  require_once( RISOLUTO_FUNC . 'risoluto_session.php' );
  /**
   * コンフィグ操作クラス
   */
  require_once( RISOLUTO_FUNC . 'risoluto_conf.php' );
  /**
   * ユーティリティファンクションクラス
   */
  require_once( RISOLUTO_FUNC . 'risoluto_util.php' );

  abstract class welcome_base
  {
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * Smartyインスタンス格納用変数
     * @access protected
     * @var    object
     */
    protected $smarty;
    /**
     * セッションクラスインスタンスを保持する変数
     * @access protected
     * @var    object
     */
    protected $obj_sess;
    /**
     * ユーティリティクラスインスタンスを保持する変数
     * @access protected
     * @var    object
     */
    protected $obj_util;
    /**
     * コンフィグクラスインスタンスを保持する変数
     * @access protected
     * @var    object
     */
    protected $obj_conf;

    //------------------------------------------------------//
    // 抽象クラスメソッド定義
    //------------------------------------------------------//
    abstract function model();
    abstract function view();

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
    public function __construct()
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
     * 初期化メソッド（イニシャライザ）
     *
     * 当該クラスの処理実施に先立ち初期化処理を行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function init()
    {
      // セッションクラスインスタンスの生成
      $this->obj_sess = RisolutoSession::singleton();
      // コンフィグ
      $this->obj_conf = new RisolutoConf();
      $this->obj_conf->parse( RISOLUTO_CONF . 'risoluto.ini' );
      // ユーティリティ
      $this->obj_util = RisolutoUtils::singleton();

      // Smarty関連定義
      $this->smarty                = new Smarty;
      $this->smarty->template_dir  = RISOLUTO_USERLAND . $this->obj_sess->sessLoad( 'currentcage' );
      $this->smarty->config_dir    = RISOLUTO_USERLAND . $this->obj_sess->sessLoad( 'currentcage' );
      $this->smarty->compile_dir   = RISOLUTO_CACHE;
      $this->smarty->cache_dir     = RISOLUTO_CACHE;
      $this->smarty->caching       = false;
      $this->smarty->debugging     = false;
      $this->smarty->force_compile = true;
      $this->smarty->compile_check = true;

      return true;
    } // end of function:initializer()

    /**
     * エラー処理メソッド（エラーハンドラ）
     *
     * 当該クラス内でエラーが発生したときの処理を行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function errHandler()
    {
      // エラー画面に飛ばす
      $this->obj_util->redirectTo( $this->obj_conf->get( 'COMMON', 'error_act'  )
                                 , $this->obj_conf->get( 'COMMON', 'error_cage' ) );
      return true;
    } // end of function:errHandler()

    /**
     * 後処理メソッド（クリーナ）
     *
     * 当該クラス内のすべての処理が終了した後に必ず実行される処理を行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function clean() {
      // クラス変数を解放
      unset( $this->smarty );
      unset( $this->obj_sess );
      unset( $this->obj_conf );
      unset( $this->obj_util );
      return true;
    } // end of function:clean()

  } // end of class:welcome_base
?>

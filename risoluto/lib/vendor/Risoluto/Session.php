<?php
/**
 * セッションクラス
 *
 * セッション操作のためのファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  class RisolutoSession
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
     * セッション名を保持する変数
     * @access private
     * @var    string
     */
    private static $str_sessName;

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
     * セッション生成メソッド
     *
     * セッションを開始する
     * もし、すでにセッションが存在している場合は
     * そのセッションIDを用いてセッションをスタートする
     * セッションが存在しない場合は新規にセッションを生成し、スタートする
     *
     * @param     void なし
     * @return    boolean session_start()実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function sessStart()
    {

      // セッション保存パスの指定
      if ( is_writable( RISOLUTO_SESS ) )
      {
        session_save_path( RISOLUTO_SESS );
      } // end of if
      // セッション保存パスに書き込みができない場合はそのままリターン
      else
      {
        return false;
      } // end of else
  
      // セッション名の指定
      $this->sessName = 'risoluto_sess';
      session_name ( $this->sessName );

      // セッションが存在しない場合の処理
      if ( empty( $_COOKIE[ $this->sessName ] ) )
      {
        // システムよりマイクロセコンドの精度で時刻情報を取得し
        // 乱数のシード（種）にする
        list( $usec, $sec ) = explode( " ", microtime() );
        $RNDseed            = (double)$sec + ( (double)$usec * 100000 );
        // 生成したシードを元に乱数を生成し、セッションIDを合成
        mt_srand( $RNDseed );
        $sessIdBase         = uniqid( mt_rand(), true );
        // 生成したセッションIDを付与する
        session_id( sha1( $sessIdBase ) );
      } // end of if

      // セッションの開始
      return session_start();

    } // end of sessStart

    /**
     * セッション破棄メソッド
     *
     * セッションを終了する
     *
     * @param     void なし
     * @return    boolean session_destroy()実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function sessEnd()
    {
      // クッキーを削除
      setcookie( $this->sessName , "" );
      // スーパーグローバルな$_SESSIONをクリア
      $_SESSION = array();

      return session_destroy();

    } // end of sessEnd 

    /**
     * セッションへの値格納メソッド
     *
     * セッションへ値を格納する
     * 引数で指定された名称の変数へ、同じく引数で指定された値を格納する
     *
     * @param     string    $destination  格納先セッション変数名
     * @param     mixed     $storeVal     格納する値（ number or string ）
     * @return    boolean ファンクション実行結果（ 常に true ）
     */
    public function sessStore( $destination , $storeVal )
    {

      if ( isset( $destination ) and isset( $storeVal ) )
      {
        $_SESSION[ $destination ] = $storeVal;
      } // end of if

      return true;

    } // end of sessStore

    /**
     * セッションからの値取得メソッド
     *
     * セッションから値を取得する
     * 引数で指定された名称のセッション変数から値を取得する
     *
     * @param     string    $from      取得元セッション変数名
     * @return    mixed 取得した値
     */
    public function sessLoad( $from )
    {

      if ( isset( $from ) and isset( $_SESSION[ $from ] ) )
      {
        return $_SESSION[ $from ];
      } // end of if
      else
      {
        return null;
      } // end of else

    } // end of sessLoad

    /**
     * セッション値存在チェックメソッド
     *
     * セッション中に引数で指定された名称を持つ値が存在するかをチェックする
     *
     * @param     string    $chkName   判定対象セッション変数名
     * @return    boolean 存在状況( true:存在する / false:存在しない )
     */
    public function sessIsThere( $chkName )
    {

      return isset( $_SESSION[ $chkName ] );

    } // end of sessIsThere

    /**
     * セッション値抹消メソッド
     *
     * セッション中の引数で指定された名称を持つ値を抹消する
     *
     * @param     string    $delName   抹消対象セッション変数名
     * @return    boolean 常にtrue
     */
    public function sessRevoke( $chkName )
    {

      if ( isset( $_SESSION[ $chkName ] ) )
      {
        unset( $_SESSION[ $chkName ] );
      } // end of if

      return true;

    } // end of sessRevoke

    /**
     * 全セッション値抹消メソッド
     *
     * セッション中のすべての値を抹消する
     *
     * @param     void なし
     * @return    boolean 常にtrue
     */
    public function sessRevokeAll( )
    {

      // セッション変数が存在するかをチェック
      if ( isset( $_SESSION ) )
      {
        // すべての値を抹消する
        foreach ( $_SESSION as $key => $val )
        {
          $this->sessRevoke( $key );
        } // end of foreach
      } // end of if

    } // end of sessRevokeAll

  }  // end of class:RisolutoSession
?>

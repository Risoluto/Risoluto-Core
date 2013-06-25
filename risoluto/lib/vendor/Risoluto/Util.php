<?php
/**
 * ユーティリティクラス
 *
 * ユーティリティファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  /**
   * セッションクラス
   */
  require_once( RISOLUTO_FUNC . 'risoluto_session.php' );
  /**
   * データベース操作クラス
   */
  require_once( RISOLUTO_FUNC . 'risoluto_db.php' );
  /**
   * コンフィグ操作クラス
   */
  require_once( RISOLUTO_FUNC . 'risoluto_conf.php' );

  class RisolutoUtils
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
     * セッションクラスインスタンスを保持する変数
     * @access private
     * @var    object
     */
    private $obj_sess;

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
     * スーパバイザセッション判定メソッド
     *
     * 現在のセッションがスーパバイザセッションかを判定する
     *
     * @param     void なし
     * @return    boolean(true:スーパバイザセッション/false:スーパバイザセッションではない)
     */
    public function is_Supervisor()
    {

      //-- ローカル変数 --//
      $retVal   = false;
      if ( empty( $this->obj_sess ) )
      {
        $this->obj_sess = RisolutoSession::singleton();
      } // end of if
      $sessinfo = $this->obj_sess->sessLoad( 'login_groupid' );

      if ( $sessinfo === '0' )
      {
        $retVal = true;
      } // end of if

      return $retVal;

    } // end of function:is_Supervisor()

    /**
     * アドミンセッション判定メソッド
     *
     * 現在のセッションがアドミンセッションかを判定する
     *
     * @param     void なし
     * @return    boolean(true:アドミンセッション/false:アドミンセッションではない)
     */
    public function is_Admin()
    {

      //-- ローカル変数 --//
      $retVal   = false;
      if ( empty( $this->obj_sess ) )
      {
        $this->obj_sess = RisolutoSession::singleton();
      } // end of if
      $sessinfo = $this->obj_sess->sessLoad( 'login_groupid' );

      if ( $sessinfo === '1' || $this->is_Supervisor() )
      {
        $retVal = true;
      } // end of if

      return $retVal;

    } // end of function:is_Admin()

    /**
     * ユーザセッション判定メソッド
     *
     * 現在のセッションがユーザセッションかを判定する
     *
     * @param     void なし
     * @return    boolean(true:ユーザセッション/false:ユーザセッションではない)
     */
    public function is_User()
    {

      //-- ローカル変数 --//
      $retVal   = false;
      if ( empty( $this->obj_sess ) )
      {
        $this->obj_sess = RisolutoSession::singleton();
      } // end of if
      $sessinfo = $this->obj_sess->sessLoad( 'login_groupid' );

      if ( $sessinfo === '2' || $this->is_Admin() || $this->is_Supervisor() )
      {
        $retVal = true;
      } // end of if

      return $retVal;

    } // end of function:is_User()

    /**
     * ゲストセッション判定メソッド
     *
     * 現在のセッションがゲストセッションかを判定する
     *
     * @param     void なし
     * @return    boolean(true:ゲストセッション/false:ゲストセッションではない)
     */
    public function is_Guest()
    {

      //-- ローカル変数 --//
      $retVal   = false;
      if ( empty( $this->obj_sess ) )
      {
        $this->obj_sess = RisolutoSession::singleton();
      } // end of if
      $lastcage = $this->obj_sess->sessLoad( 'lastcage' );
      $lastact  = $this->obj_sess->sessLoad( 'lastact'  );

      if ( $this->is_User() || $this->is_Admin() || $this->is_Supervisor() )
      {
        $retVal = true;
      } // end of if
      else
      if (
                ! empty( $lastcage ) and $lastcage != 'firsttime' and $lastcage != 'reset' and $lastcage != 'unknown'
           and  ! empty( $lastact  ) and $lastact  != 'firsttime' and $lastact  != 'reset' and $lastact  != 'unknown'
         )
      {
         $retVal = true;
      } // end of if

      return $retVal;

    } // end of function:is_Guest()

    /**
     * ベースURL取得メソッド
     *
     * ベースURLを取得する
     *
     * @param     void なし
     * @access    public
     * @return    string 自身のベースURL
     */
    public function getBaseUrl()
    {

      // 必要なインスタンスを生成
      $obj_conf = new RisolutoConf();
      $obj_conf->parse( RISOLUTO_CONF . 'risoluto.ini' );

      //---スキーマ
      if( $_SERVER[ 'SERVER_PORT' ] != $obj_conf->get( 'PORT', 'secureport' ) )
      {
        $schema = 'http://';
        if ( $_SERVER[ 'SERVER_PORT' ] != '80' )
        {
          $port   = ':' . $_SERVER[ 'SERVER_PORT' ];
        }
        else
        {
          $port   = '';
        }
      }
      else
      {
        $schema = 'https://';
        if ( $obj_conf->get( 'PORT', 'secureport' ) != '443' )
        {
          $port   = ':' . $obj_conf->get( 'PORT', 'secureport' );
        }
        else
        {
          $port   = '';
        }
      }

      //---ホスト名
      $host = $_SERVER[ 'HTTP_HOST' ];

      //---実行ファイル名（デフォルトの「index.php」が付いている場合は消す）
      $self = str_replace( 'index.php', '', $_SERVER[ 'PHP_SELF' ] );

      return $schema . $host . $port . $self;

    } // end of function:getBaseUrl()

    /**
     * Risoluto内画面リダイレクトメソッド
     *
     * 指定された画面へリダイレクトする
     *
     * @param     string $actionId リダイレクト先のAct
     * @param     string $cageId   リダイレクト先のCage
     * @param     array  $getKey   リダイレクト時に付与するGETパラメタのキー部（配列指定）
     * @param     array  $getVal   リダイレクト時に付与するGETパラメタのバリュー部（配列指定）
     * @access    public
     * @return    void なし
     */
    public function redirectTo( $actionId = null, $cageId = null, $getKey = null, $getVal = null )
    {

      // ベースURLを取得する
      $baseURL    = $this->getBaseUrl();
      $otherParam = null;

      // Cage及びActを構成
      unset( $param );
      if ( !empty( $actionId ) )
      {
        $param  = "?act=$actionId";
      } // end of if

      if ( !empty( $cageId ) )
      {
        if ( empty( $param ) )
        {
          $param  = "?cage=$cageId";
        } // end of if
        else
        {
          $param  = $param . "&cage=$cageId";
        } // end of else
      } // end of if

      // 他のパラメタが指定されていたら、それをGetパラメタの形に生成
      if ( ! empty( $getKey ) and ! empty( $getVal ) )
      {
        $tmp_keys   = explode( ',', $getKey );
        $tmp_vals   = explode( ',', $getVal );

        // 両方の要素数が合致しない場合は処理を行わない
        if ( count( $tmp_keys ) == count( $tmp_vals ) )
        {
          for ( $i = 0; $i < count( $tmp_keys ); $i++ )
          {
            $otherParam .= '&' . $tmp_keys[ $i ] . '=' . $tmp_vals[ $i ];
          } // end of for
        } // end of if
      } // end of if

      // ヘッダを出力する
      header("Location: $baseURL$param$otherParam");

    } // end of function:redirectTo()

    /**
     * ファイル／ディレクトリステータスチェックメソッド
     *
     * 指定されたファイルやディレクトリのステータスをチェックする
     *
     * @param     array  $target チェック対象の情報が格納された連想配列
     * @access    public
     * @return    array  チェック結果が格納された連想配列
     */
    public function statChecker( $target )
    {
      // ローカル変数の初期化
      $result = array(
                       'path'     => 'unknown'
                     , 'required' => 'unknown'
                     , 'real'     => 'unknown'
                     , 'result'   => 'unknown'
                     );

      // 引数が配列でない場合は即時return
      if ( ! is_array( $target ) )
      {
        return $result;
      } // end of if

      // 共通情報はまとめてセット
      $result[ 'path'     ] = $target[ 'path' ];
      $result[ 'required' ] = $target[ 'stat' ];

      // 対象が存在しない場合は「missing」をセットし、即時return
      clearstatcache();
      if ( ! file_exists( $target[ 'path' ] ) )
      {
        // 結果をセット
        $result[ 'real'   ] = 'missing';
        $result[ 'result' ] = 'NG';

        return $result;
      } // end of if

      // キャッシュステータスのクリア
      clearstatcache();
      // 判定を実施（defaultは書かない）
      // 評価項目を増やすにはここにcaseを追加してください
      switch( $target[ 'stat' ] )
      {
        // 読込可
        case 'readable':
          if ( is_readable( $target[ 'path' ] ) and ! is_writable( $target[ 'path' ] ) )
          {
            // 結果をセット
            $result[ 'real'   ] = 'readable';
            $result[ 'result' ] = 'OK';
          } // end of if
          else
          {
            // 結果をセット
            $result[ 'real'   ] = 'writable';
            $result[ 'result' ] = 'NG';
          } // end of else
          break;

        // 書込可
        case 'writable':
          if ( is_writable( $target[ 'path' ] ) )
          {
            // 結果をセット
            $result[ 'real'   ] = 'writable';
            $result[ 'result' ] = 'OK';
          } // end of if
          else
          {
            // 結果をセット
            $result[ 'real'   ] = 'readable';
            $result[ 'result' ] = 'NG';
          } // end of else
          break;
      } // end of switch

      return $result;

    } // end of function:statChecker()

    /**
     * ファイル／ディレクトリ操作メソッド
     *
     * 指定されたファイルやディレクトリに対し、作成/コピー/移動/削除等を行う
     *
     * @param     string  $operation   処理内容を示す文字列(make/copy/move/unlink/mkdir/rmdir/symlink)
     * @param     string  $target      対象となるパス
     * @param     string  $destination コピー又は移動先となるパス
     * @param     string  $prefix ファイル中の「[[[_PREFIX]]]」を置換する文字列
     * @access    public
     * @return    boolean 処理結果（true: 成功 / false: 失敗）
     */
    public function fileOperator( $operation, $target, $destination = null, $prefix = null )
    {
      // エラーフラグの初期化
      $result = false;

      // operationの内容によって、処理を分ける
      switch( $operation )
      {
        // make
        case 'make' :
          if ( @touch( $target ) )
          {
            $result = true;
          } // end of if
          break;

        // copy
        case 'copy' :
          if ( @copy( $target, $destination ) )
          {
            $result = true;
          } // end of if
          break;

        // copy with replace
        case 'copy_with_replace' :
          // ファイルの中身を一度すべて取得
          $text = @file_get_contents( $target );
          // $prefixがセットされていたら置換処理を実施
          if ( !empty( $prefix ) )
          {
            $text = str_replace( '[[[_PREFIX]]]', $prefix, $text );
          } // end of if
          // ファイルを出力
          if ( @file_put_contents( $destination, $text ) )
          {
            $result = true;
          } // end of if
          break;

        // move
        case 'move' :
          if ( @rename( $target, $destination ) )
          {
            $result = true;
          } // end of if
          break;

        // unlink
        case 'unlink' :
          if ( @unlink( $target ) )
          {
            $result = true;
          } // end of if
          break;

        // mkdir
        case 'mkdir' :
          if ( @mkdir( $target, 0777, true ) )
          {
            $result = true;
          } // end of if
          break;

        // rmdir
        case 'rmdir' :
          if ( @rmdir( $target ) )
          {
            $result = true;
          } // end of if
          break;

        // symlink
        case 'symlink' :
          if ( @symlink ( $target, $destination ) )
          {
            $result = true;
          } // end of if
          break;

      } // end of switch

      return $result;

    } // end of function:fileOperator()

    /**
     * cuser/muser向け識別子生成メソッド
     *
     * 各種テーブルのcuserまたはmuserにセットするための識別子を生成する
     *
     * @param     void なし
     * @return    string 識別子（何らかの理由で生成できない場合は、null）
     */
    public function answerMyId()
    {

      //-- ローカル変数 --//
      $retval   = false;
      if ( empty( $this->obj_sess ) )
      {
        $this->obj_sess = RisolutoSession::singleton();
      } // end of if
      $currentcage = str_replace( DIRECTORY_SEPARATOR, '.', $this->obj_sess->sessLoad( 'currentcage' ) );
      $currentact  = $this->obj_sess->sessLoad( 'currentact'  );

      // 値が取得できなければ、nullを返す
      if ( empty( $currentcage ) or empty( $currentact ) )
      {
        return null;
      } // end of if

      // 値が取得できないか、現在のcageまたはactが特別な値なら、nullを返す
      if (
              empty( $currentcage ) or $currentcage == 'firsttime' or $currentcage == 'reset' or $currentcage == 'unknown'
           or empty( $currentact  ) or $currentact  == 'firsttime' or $currentact  == 'reset' or $currentact  == 'unknown'
         )
      {
        return null;
      } // end of if

      return substr( $currentcage . '/' . $currentact, 0, 255);

    } // end of function:answerMyId()

    /**
     * serviceStatus()
     *
     * サービスの状態を判定する
     *
     * @param     void なし
     * @return    integer ( 0:オープン/1:既存セッションのみ許可/2:ユーザセッションのみ許可/3:管理者セッションのみ許可/4:スーパバイザセッションのみ許可 )
     */
    public function serviceStatus()
    {

      //-- ローカル変数 --//
      $retval = 0;

      // 必要なインスタンスを生成
      $obj_conf = new RisolutoConf();
      $obj_conf->parse( RISOLUTO_CONF . 'risoluto.ini' );

      // 各サービスストップ関連のファイルが存在するかどうかをチェック
      clearstatcache();
      if ( file_exists( RISOLUTO_SYSROOT . $obj_conf->get( 'SERVICESTOP', 'ServiceStop' ) ) )
      {
        // サービスストップ（＝スーパバイザセッションのみ許可）
        $retVal = 4;
      } // end of if
      else
      if ( file_exists( RISOLUTO_SYSROOT . $obj_conf->get( 'SERVICESTOP', 'AdminOnly' ) ) )
      {
        // 管理者のみ許可
        $retVal = 3;
      } // end of else if
      else
      if ( file_exists( RISOLUTO_SYSROOT . $obj_conf->get( 'SERVICESTOP', 'UserOnly' ) ) )
      {
        // ユーザセッションのみ許可
        $retVal = 2;
      } // end of else if
      else
      if ( file_exists( RISOLUTO_SYSROOT . $obj_conf->get( 'SERVICESTOP', 'CurrentSessionOnly' ) ) )
      {
        // 既存セッションのみ許可
        $retVal = 1;
      } // end of else if
      else
      {
        // オープン（デフォルト）
        $retVal = 0;
      } // end of else

      return $retVal;

    } // end of function:serviceStatus()

    /**
     * 自動リンク設定メソッド
     *
     * 引数で指定された文字列中の特定部分をリンクに変換する
     *
     * @param     string    $target    対象となる文字列
     * @param     boolean   $newwindow 新規ウィンドウモード:true(新規ウィンドウでオープン))
     * @param     string    $extra     リンクタグに付与するアトリビュート（デフォルト:null）
     * @return    string    変換後の文字列
     */
    public function autoUrlLink( $target, $newwindow = true, $extra=null )
    {
      // 一度、一時変数へ格納する
      $tmp_target = $target;

      // オプションの構成
      $tmp_replace_text = "<a href='$0' ";
      //--- 新規ウィンドウモード
      if ( $newwindow )
      {
        $tmp_replace_text .= "onclick=\"window.open('\\0');return false;\" ";
      } // end of if
      //--- リンクタグに付与するアトリビュート
      if ( !empty( $extra ) )
      {
        $tmp_replace_text .= $extra;
      } // end of if
      $tmp_replace_text .= ">$0</a>";

      // 文字列中の「http」又は「https」で始まる部分を、<a>タグに変換する
      $tmp_target = preg_replace( "/(http|https)\:\/\/[[:alnum:]-_.!~*'();\/?:@&=+$,%#]+/i", $tmp_replace_text, $tmp_target );
      // タグの途中で改行が入っている場合、取り除く
      $tmp_target = preg_replace( "/(\r|\n|\r\n)'>/i",    "'>",   $tmp_target );
      $tmp_target = preg_replace( "/(\r|\n|\r\n)<\/a>/i", "</a>", $tmp_target );

      // <a>タグ以外のタグを消し去る
      $tmp_target = strip_tags( $tmp_target, "<a>" );

      return $tmp_target;
    }  // end of function:autoUrlLink()

    /**
     * ヘッダ情報取得メソッド
     *
     * 自身のCageおよびActから、対応するヘッダ情報をDBから取得する
     *
     * @param     void   なし
     * @return    array  取得したヘッダ情報（取得できなければfalseを返却する）
     */
    public function getHeader()
    {

      // 必要なインスタンスを作成する
      if ( empty( $this->obj_sess ) )
      {
        $this->obj_sess = RisolutoSession::singleton();
      } // end of if
      $obj_conf = new RisolutoConf();
      $obj_conf->parse( RISOLUTO_CONF . 'risoluto.ini' );

      $obj_db   = new RisolutoDb();

      // セッションから情報を取得
      $actionId = $this->obj_sess->sessLoad( 'currentact' );
      $cageId   = str_replace( DIRECTORY_SEPARATOR, '.', $this->obj_sess->sessLoad( 'currentcage' ) );

      // データベースに接続する
      if ( $obj_db->dbConnect( $obj_conf->get( 'DBS', 'DEFAULT_DSN' ) ) )
      {

        // 引数の指定に合わせてSQLを変更する
        if ( empty( $cageId ) )
        {
          // SQL文を組み立てる
          $sql =<<<End_Of_SQL

              SELECT `headers`.`robot_index`  -- robots(index)
                   , `headers`.`robot_follow` -- robots(follow)
                   , `headers`.`title`        -- title
                   , `headers`.`description`  -- description
                   , `headers`.`keywords`     -- keywords
                   , `headers`.`author`       -- author
                   , `headers`.`javascript`   -- JavaScriptファイルパス
                   , `headers`.`css`          -- CSSファイルパス
                   , `headers`.`favicon`      -- Faviconファイルパス
                FROM `risoluto_t_headerinfo` headers
               WHERE `headers`.`act`  = ?
                 AND `headers`.`cage` IS NULL

End_Of_SQL;

          // パラメタも用意する
          $param = array(
                          $actionId
                        );
        } // end of if
        else
        {
          // SQL文を組み立てる
          $sql =<<<End_Of_SQL

              SELECT `headers`.`robot_index`  -- robots(index)
                   , `headers`.`robot_follow` -- robots(follow)
                   , `headers`.`title`        -- title
                   , `headers`.`description`  -- description
                   , `headers`.`keywords`     -- keywords
                   , `headers`.`author`       -- author
                   , `headers`.`javascript`   -- JavaScriptファイルパス
                   , `headers`.`css`          -- CSSファイルパス
                   , `headers`.`favicon`      -- Faviconファイルパス
                FROM `risoluto_t_headerinfo` headers
               WHERE `headers`.`act`  = ?
                 AND `headers`.`cage` = ?

End_Of_SQL;

          // パラメタも用意する
          $param = array(
                          $actionId
                        , $cageId
                        );

        } // end of else

        // SQLの実行に失敗した場合は、デフォルトの情報を取得する
        $tmp_result = $obj_db->dbGetRow( $sql, $param );
        if ( PEAR::isError( $tmp_result ) or empty( $tmp_result ) )
        {
          // SQL文を組み立てる
          $sql =<<<End_Of_SQL

              SELECT `headers`.`robot_index`  -- robots(index)
                   , `headers`.`robot_follow` -- robots(follow)
                   , `headers`.`title`        -- title
                   , `headers`.`description`  -- description
                   , `headers`.`keywords`     -- keywords
                   , `headers`.`author`       -- author
                   , `headers`.`javascript`   -- JavaScriptファイルパス
                   , `headers`.`css`          -- CSSファイルパス
                   , `headers`.`favicon`      -- Faviconファイルパス
                FROM `risoluto_t_headerinfo` headers
               WHERE `headers`.`act`  = 'DEFAULT'
                 AND `headers`.`cage` = 'DEFAULT'

End_Of_SQL;

          // パラメタも用意する
          $param = array(
                        );

          // SQLを実行する
          $tmp_result = $obj_db->dbGetRow( $sql, $param );
          if ( PEAR::isError( $tmp_result ) or empty( $tmp_result ) )
          {
            return false;
          } // end of if
          // デフォルト情報の取得が成功したら、それを戻り値にする
          else
          {
            $tmp_val = $tmp_result;
          } // end of else

        } // end of if
        // 取得が成功したら、それを戻り値にする
        else
        {
          $tmp_val = $tmp_result;
        } // end of else

        // 接続に成功している場合は接続をクローズする
        $obj_db->dbDisConnect();
      } // end of if
      // データベースに接続できなかった場合は、falseを返す
      else
      {
        return false;
      } // end of else


      // 不要データの削除
      unset( $tmp_val[ 'robot_index'  ] );
      unset( $tmp_val[ 'robot_follow' ] );

      // 取得した値の加工
      $tmp_val[ 'robots' ] = null;

      // robots(index)
      if( $tmp_result[ 'robot_index' ] == 0 )
      {
        $tmp_val[ 'robots' ] = 'noindex,';
      } // end of if
      else
      {
        $tmp_val[ 'robots' ] = 'index,';
      } // end of else

      // robots(follow)
      if( $tmp_result[ 'robot_follow' ] == 0 )
      {
        $tmp_val[ 'robots' ] .= 'nofollow';
      } // end of if
      else
      {
        $tmp_val[ 'robots' ] .= 'follow';
      } // end of else

      // JavaScript
      $tmp_val[ 'javascript' ] = explode( ',', $tmp_result[ 'javascript' ] );
      // CSS
      $tmp_val[ 'css'        ] = explode( ',', $tmp_result[ 'css'        ] );

      // URL情報等を付け加える
      $tmp_val[ 'normal_url' ] = $this->getBaseUrl();
      $tmp_val[ 'https_url'  ] = str_replace( 'http://',   'https://', $tmp_val[ 'normal_url' ] );
      $tmp_val[ 'http_url'   ] = str_replace( 'https://',  'http://',  $tmp_val[ 'normal_url' ] );

      return $tmp_val;
    }  // end of function:getHeader()

    /**
     * メールアドレス判定メソッド
     *
     * 引数で指定された値がメールアドレスのフォーマットと合致しているか判定する
     *
     * @param     string 検査対象となる値
     * @access    public
     * @return    boolean 判定結果（ true / false ）
     */
    public function is_emailAddr( $value )
    {

      return ( preg_match( '/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i', $value ) ) ? ( true ) : ( false );

    } // end of function:is_emailAddr()

    /**
     * 半角文字列判定メソッド
     *
     * 引数で指定された値が半角文字列のみで構成されているか判定する
     *
     * @param     string 検査対象となる値
     * @access    public
     * @return    boolean 判定結果（ true / false ）
     */
    function is_halfWidth( $value )
    {

      return ( strlen( $value ) == mb_strlen( $value ) ) ? ( true ) : ( false );

    } // end of function:is_halfWidth()

    /**
     * 閏年判定メソッド
     *
     * 引数で指定された値が閏年であるか判定する
     *
     * @param     string 検査対象となる値
     * @access    public
     * @return    boolean 判定結果（ true / false ）
     */
    public function is_leapYear( $value )
    {

      // 引数が4桁の整数値でなければ無条件でfalseを返却する
      if ( ( strlen( $value ) != 4 ) and ( ! is_numeric( $value ) ) )
      {
        return false;
      }

      // 4で割り切れ、100で割り切れず、400で割り切れる場合のみうるう年とみなす
      if ( ( $value % 4 ) == 0 and ( $value % 100 ) != 0 and ( $value % 400 ) == 0 )
      {
        return true;
      } // end of if
      else
      {
        return false;
      } // end of else

    } // end of function:is_leapYear()

    /**
     * 値範囲判定メソッド
     *
     * 引数で指定された値が引数で指定された下限値及び上限値の範囲内にあるかを判定する
     *
     * @param     string 検査対象となる値
     * @param     string 下限値
     * @param     string 上限値
     * @access    public
     * @return    boolean 判定結果（ true / false ）
     */
    public function is_between( $value, $lowerVal, $upperVal )
    {

      // 下限値から上限値の範囲内ならTrueを返却（下限値／上限値自体も範囲に含む）
      if ( ( $lowerVal <= $value ) and ( $upperVal >= $value ) )
      {
        return true;
      } // end of if
      else {
        return false;
      } // end of else

    } // end of function:is_between()

    /**
     * 和暦コンバートメソッド
     *
     * 西暦に対応する和暦を取得する
     *
     * @param     integer 対象となる西暦年
     * @access    public
     * @return    string  引数に指定された西暦年に対応する和暦年（変換に失敗した場合はnullを返却）
     */
    public function cnvYear ( $year )
    {
      // 変数の初期化
      $retVal = null;

      // 引数に指定された値が、1868年より以前か数字4桁でない場合はnullを返却する
      if ( ! is_numeric( $year ) or strlen( $year ) != 4 or $year < 1868 )
      {
        return null;
      } // end of if

      // 明治（1868年1月25日〜1912年7月29日、明治45年まで）
      if ( $this->is_between( $year, 1868, 1912 ) )
      {
        // 算出する
        $tmp_val = ( $year - 1869) + 1;

        // 1年の場合は元年として表示する
        if ( $tmp_val == '1' )
        {
          $retVal = '明治元年';
        } // end of if
        // 年号を生成する
        else
        {
          $retVal = '明治' . $tmp_val . '年';

          // 境界年の場合は、両方の年号を併記する
          if ( $tmp_val == '45' )
          {
            $retVal .= '/ 大正元年';
          } // end of if
        } // end of else
      } // end of if

      // 大正（1912年7月30日〜1926年12月24日、大正15年まで）
      else
      if ( $this->is_between( $year, 1912, 1926 ) )
      {
        // 算出する
        $tmp_val = ( $year - 1912) + 1;

        // 1年の場合は元年として表示する
        if ( $tmp_val == '1' )
        {
          $retVal = '大正元年';
        } // end of if
        // 年号を生成する
        else
        {
          $retVal = '大正' . $tmp_val . '年';

          // 境界年の場合は、両方の年号を併記する
          if ( $tmp_val == '15' )
          {
            $retVal .= '/ 明治元年';
          } // end of if
        } // end of else
      } // end of else if

      // 昭和（1926年12月25日〜1989年1月7日、昭和64年まで）
      else
      if ( $this->is_between( $year, 1926, 1989 ) )
      {
        // 算出する
        $tmp_val = ( $year - 1926) + 1;

        // 1年の場合は元年として表示する
        if ( $tmp_val == '1' )
        {
          $retVal = '昭和元年';
        } // end of if
        // 年号を生成する
        else
        {
          $retVal = '昭和' . $tmp_val . '年';

          // 境界年の場合は、両方の年号を併記する
          if ( $tmp_val == '64' )
          {
            $retVal .= '/ 平成元年';
          } // end of if
        } // end of else
      } // end of else if

      // 平成（1989年1月8日〜）
      else
      {
        // 算出する
        $tmp_val = ( $year - 1989) + 1;

        // 1年の場合は元年として表示する
        if ( $tmp_val == '1' )
        {
          $retVal = '平成元年';
        } // end of if
        // 年号を生成する
        else
        {
          $retVal = '平成' . $tmp_val . '年';
        } // end of else
      } // end of else

      return $retVal;

    } // end of function:cnvYear

    /**
     * 年の配列生成メソッド
     *
     * 「年」の情報が格納された配列を生成する
     *
     * @param     boolean 配列の先頭を「----」にするかどうか（デフォルトfalse、True: ----をセットする / False: ----をセットしない ）
     * @param     integer 生成開始年（西暦指定、デフォルトは現在年 - 5）
     * @param     integer 生成年数（デフォルトは10）
     * @param     integer 返却する配列のタイプ(デフォルト西暦のみ、 0: 西暦のみ / 1: 和暦のみ / 2: 両方 )
     * @access    public
     * @return    array 「年」の情報が格納された配列
     */
    public function genYear ( $firsttype = false, $base = null, $limit = null, $mode = 0 )
    {
      // 配列を初期化
      $tmp_year = array();
      if ( $firsttype )
      {
        $tmp_year[ "----" ] = "----";
      } // end of if

      // 生成開始年の設定
      $beginYear = date( 'Y' ) - 5;
      if ( is_numeric( $base ) and strlen( $base ) == 4 )
      {
        $beginYear = $base;
      } // end of if

      // 生成年数の設定
      $endYearCnt = 10;
      if( is_numeric( $limit ) and $limit > 0 )
      {
        $endYearCnt = $limit;
      } // end of if

      // 配列を生成する
      for ( $cnt = 0; $cnt <= $endYearCnt; $cnt++ )
      {
        // 引数で指定された配列のタイプに合わせて値を作成する
        switch( $mode )
        {
          // 両方の場合
          case 2:
            $tmp_value = sprintf( "%04d", $beginYear + $cnt ) . '(' . $this->cnvYear( sprintf( "%04d", $beginYear + $cnt ) ) . ')';
            break;

          // 和暦のみの場合
          case 1:
            $tmp_value = $this->cnvYear( sprintf( "%04d", $beginYear + $cnt ) );
            break;

          // 西暦のみの場合
          case 0: // FALL THRU
          default:
            $tmp_value = sprintf( "%04d", $beginYear + $cnt );
            break;
        } // end of switch

        // 配列に追加する
        $tmp_year[ $beginYear + $cnt ] = $tmp_value;
      } // end of for

      return $tmp_year;

    } // end of function:genYear

    /**
     * 月の配列生成メソッド
     *
     * 「月」の情報が格納された配列を生成する
     *
     * @param     boolean 配列の先頭を「--」にするかどうか（デフォルトfalse、True: --をセットする / False: --をセットしない ）
     * @access    public
     * @return    array 「月」の情報が格納された配列
     */
    public function genMonth ( $firsttype = false )
    {

      // 配列を初期化
      $tmp_month = array();
      if ( $firsttype )
      {
        $tmp_month[ "--" ] = "--";
      } // end of if

      // 配列を生成する
      for ( $cnt = 1; $cnt <= 12; $cnt++ )
      {
        $tmp_month[ sprintf( "%02d", $cnt ) ] = sprintf( "%02d", $cnt );
      } // end of for

      return $tmp_month;

    } // end of function:genMonth()

    /**
     * 日の配列生成メソッド
     *
     * 「日」の情報が格納された配列を生成する
     *
     * @param     boolean 配列の先頭を「--」にするかどうか（デフォルトfalse、True: --をセットする / False: --をセットしない ）
     * @param     integer 生成対象となる月（値を指定するとその月の日数に基づいた内容が返却される）
     * @param     integer 生成対象となる年（値を指定するとその年がうるう年かどうかを考慮する）
     * @access    public
     * @return    array 「日」の情報が格納された配列
     */
    public function genDay ( $firsttype = false, $targetMonth = null, $targetYear = null )
    {

      // 配列を初期化
      $tmp_day = array();
      if ( $firsttype )
      {
        $tmp_day[ "--" ] = "--";
      } // end of if

      // 月ごとに日数を決定する
      switch( $targetMonth )
      {

        // 2月はうるう年考慮し、28又は29日まで生成
        case 2:
          if ( $this->is_leapYear( $targetYear ) )
          {
            $end_day = 29;
          } // end of if
          else
          {
            $end_day = 28;
          } // end of else
          break;

        // 4,6,9,11月は30日まで生成
        case 4:  // FALL THRU
        case 6:  // FALL THRU
        case 9:  // FALL THRU
        case 11: // FALL THRU
          $end_day = 30;
          break;

        // 上記以外は31日まで生成するケース
        default:
          $end_day = 31;
          break;

      } // end of switch

      // 配列を生成する
      for ( $cnt = 1; $cnt <= $end_day; $cnt++ )
      {
        $tmp_day[ sprintf( "%02d", $cnt ) ] = sprintf( "%02d", $cnt );
      } // end of for

      return $tmp_day;

    } // end of function:genDay()

    /**
     * 時の配列生成メソッド
     *
     * 「時」の情報が格納された配列を生成する
     *
     * @param     boolean 配列の先頭を「--」にするかどうか（デフォルトfalse、True: --をセットする / False: --をセットしない ）
     * @param     boolean 表示を24時制にするかどうか（デフォルトtrue、True: 24時制 / False: 12時制、数字の前に「午前」または「午後」がつく ）
     * @access    public
     * @return    array 「時」の情報が格納された配列
     */
    public function genHour ( $firsttype = false, $hourtype = true )
    {

      // 配列を初期化
      $tmp_hour = array();
      if ( $firsttype )
      {
        $tmp_hour[ "--" ] = "--";
      } // end of if

      // 配列を生成する
      for ( $cnt = 0; $cnt <= 23; $cnt++ )
      {
        // 表示タイプによって生成方法を変える
        if ( $hourtype )
        {
          $tmp_hour[ sprintf( "%02d", $cnt ) ] = sprintf( "%02d", $cnt );
        }
        else
        {
          if ( $cnt <= 11 )
          {
            $tmp_hour[ sprintf( "%02d", $cnt ) ] = sprintf( "午前%d", $cnt );
          } // end of if
          else
          {
            $tmp_hour[ sprintf( "%02d", $cnt ) ] = sprintf( "午後%d", $cnt - 12 );
          } // end of else
        } // end of else
      } // end of for

      return $tmp_hour;

    } // end of function:genHour()

    /**
     * 分または秒の配列生成メソッド
     *
     * 「分」または「秒」の情報が格納された配列を生成する
     *
     * @param     boolean 配列の先頭を「--」にするかどうか（デフォルトfalse、True: --をセットする / False: --をセットしない ）
     * @access    public
     * @return    array 「分」の情報が格納された配列
     */
    public function genMinSec ( $firsttype = false )
    {

      // 配列を初期化
      $tmp_minsec = array();
      if ( $firsttype )
      {
        $tmp_minsec[ "--" ] = "--";
      } // end of if

      // 配列を生成する
      for ( $cnt = 0; $cnt <= 59; $cnt++ )
      {
        $tmp_minsec[ sprintf( "%02d", $cnt ) ] = sprintf( "%02d", $cnt );
      } // end of for

      return $tmp_minsec;

    } // end of function:genMinSec()

  }  // end of class:RisolutoUtils
?>

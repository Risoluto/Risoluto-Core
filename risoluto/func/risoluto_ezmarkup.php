<?php
/**
 * 簡易マークアップクラス
 *
 * 簡易マークアップ関連のファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  /**
   * ユーティリティクラス
   */
//  require_once( RISOLUTO_FUNC . 'risoluto_util.php' );

  class RisolutoEZmarkup
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
     * ユーティリティクラスインスタンスを保持する変数
     * @access private
     * @var    object
     */
    private $obj_util;

    /**
     * 1行コマンド系変換マップを保持する変数
     * @access private
     * @var    array
     */
    private $translate_1ln = array(
                                    '<h1>'                => array(
                                                                    '/^= (.*?)$/'
                                                                  , '<h1>$1</h1>'
                                                                  )
                                  , '<h2>'                => array(
                                                                    '/^== (.*?)$/'
                                                                  , '<h2>$1</h2>'
                                                                  )
                                  , '<h3>'                => array(
                                                                    '/^=== (.*?)$/'
                                                                  , '<h3>$1</h3>'
                                                                  )
                                  , '<h4>'                => array(
                                                                    '/^==== (.*?)$/'
                                                                  , '<h4>$1</h4>'
                                                                  )
                                  , '<h5>'                => array(
                                                                    '/^===== (.*?)$/'
                                                                  , '<h5>$1</h5>'
                                                                  )
                                  , '<h6>'                => array(
                                                                    '/^====== (.*?)$/'
                                                                  , '<h6>$1</h6>'
                                                                  )
                                  , '<hr>'                => array(
                                                                    '/^[\*\-\_\ ]{3,}$/'
                                                                  , '<hr>'
                                                                  )
                                  );

    /**
     * 複数行コマンド系変換マップを保持する変数
     * @access private
     * @var    array
     */
    private $translate_mln = array(
                                    '<ul>'                => array(
                                                                    '/^[\*\-] (.*?)$/m'
                                                                  , '<ul>'
                                                                  , '<li>$1</li>'
                                                                  , '</ul>'
                                                                  )
                                  , '<ol>'                => array(
                                                                    '/^[0-9].*\. (.*?)$/m'
                                                                  , '<ol>'
                                                                  , '<li>$1</li>'
                                                                  , '</ol>'
                                                                  )
                                  , '<blockquote>'        => array(
                                                                    '/^Q (.*?)$/m'
                                                                  , '<blockquote>'
                                                                  , '$1<br>'
                                                                  , '</blockquote>'
                                                                  )
                                  , '<pre><code>'         => array(
                                                                    '/^RAW (.*?)$/m'
                                                                  , '<pre><code>'
                                                                  , '$1'
                                                                  , '</code></pre>'
                                                                  )
                                  );

    /**
     * 文中系変換マップを保持する変数
     * @access private
     * @var    array
     */
    private $translate_inn = array(
                                    '<br>'                => array(
                                                                    '/\[BR\]/'
                                                                  , '<br>'
                                                                  )
                                  , '<strong>'            => array(
                                                                    '/(\*\*|\_\_)(.*?)(\*\*|\_\_)/'
                                                                  , '<strong>$2</strong>'
                                                                  )
                                  , '<em>'                => array(
                                                                    '/(\*|\_)(.*?)(\*|\_)/'
                                                                  , '<em>$2</em>'
                                                                  )
                                  , '<a>'                 => array(
                                                                    '/\[IL\-(.*?)\]\((.*?)\)/'
                                                                  , '<a href="$2">$1</a>'
                                                                  )
                                  , '<a target="_blank">' => array(
                                                                    '/\[EL\-(.*?)\]\((.*?)\)/i'
                                                                  , '<a href="$2" target="_blank">$1</a>'
                                                                  )
                                  , '<img>'               => array(
                                                                    '/\[IM\-(.*?)\]\((.*?)\)/i'
                                                                  , '<img src="$2" alt="$1">'
                                                                  )
                                  , '<code>'              => array(
                                                                    '/\`(.*?)\`/i'
                                                                  , '<code>$1</code>'
                                                                  )
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
     * マークアップメソッド
     *
     * 引数で指定されたテキストをHTMLに変換する
     *
     * @param     string マークアップ対象のテキスト
     * @return    string マークアップ後（HTML）のテキスト
     */
    public function markup( $text )
    {
      // 一時変数の初期化
      $mode   = '';
      $buffer = '';

      $matches = '';
      $retval  = '';

      // 入力値によらずバッファを確実にフラッシュさせるために空行を付与
      $text .= "\n";

      // 入力値を改行コードで分割する
      preg_match_all( '/(.*)\n/', $text, $matches );

      // 1行毎に処理を実行
      foreach( $matches[ 1 ] as $current_line )
      {
        // 空行の場合でモード指定がなされていない場合、改行コードを出力
        if( ! $current_line and ! $mode )
        {
          $retval .= "\n";
        } // end of if
        // 空行の場合でモードが指定されている場合
        else
        if ( ! $current_line and $mode )
        {
          // modeに応じて呼び出すファンクションを選択
          switch( $mode )
          {
            // 単純な次行待ち状態の時：文中系の変換処理を実施
            case 'wait_next':
              $retval .= $this->translate_inn( $buffer );
              break;
            // 現状のまま出力状態の時：何も処理をせずバッファの内容を出力する
            case 'asis':
              $retval .= $buffer;
              break;
            // デフォルト：複数行系変換処理を実施
            default:
              $retval .= $this->translate_mln( $mode, $buffer );
              break;
          } // end of switch

          $buffer = '';
          $mode   = '';
        } // end of elseif
        // デフォルトの場合
        else
        {
          // 単一行系パターンにマッチしていれば単一行系の変換処理を実施
          if( $this->is_do1ln( $current_line ) )
          {
            $retval .= $this->translate_1ln( $current_line );

            $buffer = '';
            $mode   = '';
          } // end of if
          // 複数行系パターンにマッチしていれば複数行系処理待ち扱いでバッファに積む
          else
          if ( $this->is_domln( $current_line ) )
          {
            $buffer .= $current_line . "\n";
            $mode    = $this->getMln( $current_line );
          } // end of elseif
          // 現状のまま出力パターンにマッチしていれば何もせずにバッファに積む
          else
          if ( preg_match( '/^\=\> (.*?)$/m', $current_line ) )
          {
            $buffer .= preg_replace( '/^\=\> (.*?)$/m', '\1', $current_line ) . "\n";
            $mode    = 'asis';
          } // end of elseif
          // いずれにもマッチしていなければ次行待ち扱いでバッファに積む
          else
          {
            $buffer .= $current_line . "\n";
            $mode    = 'wait_next';
          } // end of else
        } // end of elseif
      } // end of foreach

      // 行頭および行末の空白系文字を排除してから
      // マークアップ結果を返却する
      return trim( $retval );
    } // end of function:markup()

    /**
     * 単一行系マークアップ条件該当状況照会メソッド
     *
     * 単一行系マークアップ条件にマッチするかを判定する
     *
     * @param     string  チェック対象のテキスト
     * @return    boolean 該当状況（true: 該当 / false: 非該当）
     */
     private function is_do1ln( $target )
     {
       // マッチするかを判定
       foreach( $this->translate_1ln as $key => $map )
       {
         // マッチしたらtrueを返す
         if ( preg_match( $map[ 0 ], $target ) )
         {
           return true;
         } // end of if
       } // end of foreach

       // マッチしなければfalseを返す
       return false;
     } // end of function:is_do1ln()

    /**
     * 複数行系マークアップ条件該当状況照会メソッド
     *
     * 複数行系マークアップ条件にマッチするかを判定する
     *
     * @param     string  チェック対象のテキスト
     * @return    boolean 該当状況（true: 該当 / false: 非該当）
     */
     private function is_domln( $target )
     {
       // マッチするかを判定
       foreach( $this->translate_mln as $key => $map )
       {
         // マッチしたらtrueを返す
         if ( preg_match( $map[ 0 ], $target ) )
         {
           return true;
         } // end of if
       } // end of foreach

       // マッチしなければfalseを返す
       return false;
     } // end of function:is_domln()

    /**
     * 複数行系モード識別子返却メソッド
     *
     * 複数行系モード識別子を返却する
     *
     * @param     string  判定対象のテキスト
     * @return    boolean 識別子（該当なしの場合は空文字）
     */
     private function getMln( $target )
     {
       // マッチするかを判定
       foreach( $this->translate_mln as $key => $map )
       {
         // マッチしたらtrueを返す
         if ( preg_match( $map[ 0 ], $target ) )
         {
           return $key;
         } // end of if
       } // end of foreach

       // マッチしなければ空文字を返す
       return '';
     } // end of function:getMln()

    /**
     * 複数行系マークアップ変換実施メソッド
     *
     * 変換マップを参照し、マークアップ処理を実施する
     *
     * @param     string モード
     * @param     string 変換対象のテキスト
     * @return    string マークアップ後（HTML）のテキスト
     */
     private function translate_mln( $mode, $target )
     {
       // 一時変数を初期化
       $retval = htmlentities( trim( $target ), ENT_QUOTES, 'UTF-8', false );

       // マークアップを実施
       $retval = preg_replace( $this->translate_mln[ $mode ][ 0 ], $this->translate_mln[ $mode ][ 2 ], $retval );

       // マークアップ後にタグで囲む
       $retval = "\n" . $this->translate_mln[ $mode ][ 1 ] . "\n" . $retval . "\n" . $this->translate_mln[ $mode ][ 3 ] . "\n";

       return $retval;
     } // end of function:translate_1ln()

    /**
     * 単一行系マークアップ変換実施メソッド
     *
     * 変換マップを参照し、マークアップ処理を実施する
     *
     * @param     string 変換対象のテキスト
     * @return    string マークアップ後（HTML）のテキスト
     */
     private function translate_1ln( $target )
     {
       // 一時変数を初期化
       $retval = htmlentities( trim( $target ), ENT_QUOTES, 'UTF-8', false );

       // マークアップを実施
       foreach( $this->translate_1ln as $key => $map )
       {
         $retval = preg_replace( $map[ 0 ], $map[ 1 ], $retval );
       } // end of foreach

       return $retval;
     } // end of function:translate_1ln()

    /**
     * 文中系マークアップ変換実施メソッド
     *
     * 変換マップを参照し、マークアップ処理を実施する
     *
     * @param     string 変換対象のテキスト
     * @return    string マークアップ後（HTML）のテキスト
     */
     private function translate_inn( $target )
     {
       // 一時変数を初期化
       $retval = '';
       $retval = htmlentities( trim( $target ), ENT_QUOTES, 'UTF-8', false );

       // バッファにデータが存在する場合だけマークアップを実施
       if ( $retval )
       {
         foreach( $this->translate_inn as $key => $map )
         {
           $retval = preg_replace( $map[ 0 ], $map[ 1 ], $retval );
         } // end of foreach

         // 全体を<p>タグで囲み不正なタグ構造となる場合の対処を行う
         $retval = "<p>" . $retval . "</p>\n";

         $search  = array( '<p></p>' );
         $replace = array( '' );
         $retval  = str_replace( $search, $replace, $retval );
       } // end of if

       return $retval;
     } // end of function:translate_inn()

  } // end of class:RisolutoEZmarkup

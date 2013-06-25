<?php
/**
 * コンフィグクラス
 *
 * コンフィグ操作のためのファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  class RisolutoConf
  {
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * コンフィグ情報を保持する変数
     * @access private
     * @var    array
     */
    private static $arr_parsedconf;
    /**
     * パース状況を保持する変数
     * @access private
     * @var    boolean
     */
    private static $bool_parsestatus;

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
     * パース状況回答メソッド
     *
     * パース状況を回答する
     *
     * @param     void    なし
     * @return    boolean ファンクション実行結果（ true：パース済み / false: 未パース ）
     */
    public function is_Parsed()
    {
      return $this->bool_parsestatus;
    } // end of is_Parsed

    /**
     * iniファイルパースメソッド
     *
     * 引数で与えられたパスよりiniファイルを読み込みパースする
     *
     * @param     string    $path    iniファイルのパス
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function parse( $path )
    {

      // ファイルが存在しているかをテスト
      clearstatcache();
      if ( is_file( $path ) )
      {
        // ファイルが存在していれば、
        // 指定されたiniファイルをロードし、パースする
        $this->arr_parsedconf   = parse_ini_file( $path, true );
        $this->bool_parsestatus = true;

        return true;
      } // end of if
      // ファイルが存在しない場合（または読めない場合）、
      // そのまま抜ける
      else
      {

        $this->bool_parsestatus = false;

        return false;
      } // end of else

    } // end of parse

    /**
     * iniファイル情報取得メソッド
     *
     * パース済みiniファイルより、セクションのみが指定された場合はセクション内すべての値を配列を。キーが指定された場合はキーが持つ値を返却する
     * パースされていない場合やセクション、キーが存在しない場合は、nullが返却される
     *
     * @param     string    $section  検索対象のセクション
     * @param     string    $key      検索対象のキー
     * @return    string    セクションに対応する配列、またはキーに対応する値。 どちらも存在しない場合は null
     */
    public function get( $section , $key = '' )
    {
      // 一度もパースされていない場合は、nullを返す
      if ( !$this->bool_parsestatus )
      {
        return null;
      } // end of if

      // キーが指定されていればキーに対応する値を、キーが指定されていなければセクション内すべての値を連想配列として取得
      if( !empty( $key ) )
      {
        $gotDat = $this->arr_parsedconf[ $section ][ $key ];
      } // end of if
      else
      {
        $gotDat = $this->arr_parsedconf[ $section ];
      } // end of else

      if ( !empty( $gotDat ) )
      {
        return $gotDat;
      } // end of if
      else
      {
        return null;
      } // end of else

    } // end of get

    /**
     * iniファイル情報全件取得メソッド
     *
     * パース済みiniファイルの内容を全件取得する
     *
     * @return    array    パース済みiniファイルの全内容
     */
    public function getAll( )
    {
      // 一度もパースされていない場合は、nullを返す
      if ( !$this->bool_parsestatus )
      {
        return null;
      } // end of if

      return $this->arr_parsedconf;
    } // end of getAll

  }  // end of class:RisolutoConf
?>

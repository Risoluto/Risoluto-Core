<?php
/**
 * エラー画面クラス
 *
 * エラー画面を実現するためのクラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

  /**
   * 基底クラス
   */
  require_once( 'error_base.inc' );

  class error extends error_base
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
     * modelメソッド（モデル）
     *
     * データ取得等のモデルに相当する部分の処理を行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function model()
    {
      return true;
    } // end of function:model()

    /**
     * viewメソッド（モデル）
     *
     * テンプレート関連処理等のビューに相当する部分の処理を行う
     *
     * @param     void なし
     * @return    boolean ファンクション実行結果（ true：正常終了 / false: 異常終了 ）
     */
    public function view()
    {
      // エラー発生時はセッションを消す
      $this->obj_sess->sessEnd();

      // ヘッダ情報をDBから取得（取得できなかった場合はCSSのみ強制的にセット）
      //--- 取得
      $html_header = $this->obj_util->getHeader();

      //--- CSS情報
      if ( !isset( $html_header[ 'css' ] ) or empty( $html_header[ 'css' ] )  )
      {
        $html_header[ 'css' ] = array( './css/common.css' );
      } // end of if

      // アサイン
      $this->smarty->assign ( 'header', $html_header );

      // 表示
      $this->smarty->display( 'error.tpl' );

      return true;

    } // end of function:view()

  } // end of class:error
?>

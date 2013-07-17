<?php
/**
 * Conf
 *
 * コンフィグ操作のためのファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Conf
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $parsedconf
     * @access private
     * @var    array    パース済みコンフィグ情報
     */
    private $parsedconf = array();

    /**
     * $parsestatus
     * @access private
     * @var    boolean    パース状況
     */
    private $parsestatus = false;

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * GetParseStatus()
     *
     * パース状況を取得する
     *
     * @access    public
     * @param     void    なし
     * @return    boolean パース状況（true：パース済み/false:未パース）
     */
    public function GetParseStatus()
    {
        return $this->parsestatus;
    }

    /**
     * Parse($path)
     *
     * 引数で与えられたパスよりiniファイルを読み込みパースする
     *
     * @access    public
     * @param     string     $path    iniファイルのパス
     * @return    boolean    パース結果（true：正常終了/false:異常終了）
     */
    public function Parse($path)
    {
        // ファイルが存在しているかをテスト
        clearstatcache();
        if (is_file($path)) {
            // ファイルが存在していれば、
            // 指定されたiniファイルをロードし、パースする
            $this->parsedconf   = parse_ini_file($path, true);
            $this->parsestatus = true;
            return true;
        } else {
            // ファイルが存在しない場合（または読めない場合）
            // クラス変数に未パースである旨をセットする
            $this->parsestatus = false;
            return false;
        }
    }

    /**
     * GetIni($section = '', $key = '')
     *
     * パース済みiniファイルより、セクションのみが指定された場合はセクション内すべての値を配列を、
     * キーが指定された場合はキーが持つ値を返却する
     * セクションもキーも指定されていない場合は全体を返却する
     * パースされていない場合やセクション、キーが存在しない場合は、nullが返却される
     *
     * @access    public
     * @param     string    $section    検索対象のセクション
     * @param     string    $key        検索対象のキー
     * @return    string    セクションに対応する配列、またはキーに対応する値。どちらも存在しない場合はnull
     */
    public function GetIni($section = '', $key = '')
    {
        // 一度もパースされていない場合は、nullを返す
        if (!$this->parsestatus) {
          return null;
        }

        // セクションが指定されている場合
        if(!empty($section)) {
          // キーが指定されていればキーに対応する値を取得
          if(!empty($key)) {
              $gotDat = $this->parsedconf[$section][$key];
          // キーが指定されていなければセクション内すべての値を取得
          } else {
              $gotDat = $this->parsedconf[$section];
          }
        // セクションが指定されていない場合はparseしたコンフィグ丸ごと取得
        } else {
            $gotDat = $this->parsedconf;
        }

        // 取得する値があればそのまま返却し、無ければnullを返却
        if (!empty($gotDat)) {
            return $gotDat;
        } else {
            return null;
        }
    }
}

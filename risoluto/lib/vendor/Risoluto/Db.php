<?php
/**
 * Db
 *
 * データベース操作のためのファンクション群
 *
 * @package       risoluto
 * @author        Risoluto Developers
 * @license       http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

use pear\MDB2;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Db
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $conn
     * @access private
     * @var    object    DB接続オブジェクト
     */
    private $conn;

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * Connect($dsn) {
     *
     * 引数で与えられたdsnのDBに接続する
     *
     * @access    public
     *
     * @param     string     iniファイル中に記述したdsn
     *
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function Connect($dsn)
    {
        // 引数が指定されている場合のみ、DBへのコネクション確立を試みる
        if (!empty($dsn)) {
            // 最大で5回分接続のリトライを試みる
            for ($cnt = 0; $cnt < 5; $cnt++) {
                $this->conn =& MDB2::singleton($dsn);

                // エラーでなかった場合
                if (!PEAR::isError($this->conn)) {
                    // 必要なMDB2モジュールをロードする
                    $this->conn->loadModule('Extended', null, false);
                    // オートマジカルにオプションの設定を行う
                    $this->SetOptions();

                    // 正常終了
                    return true;
                    break;
                    // エラーだった場合
                } else {
                    // 接続に失敗したときは300マイクロ秒待つ
                    usleep(300);
                }
            }
        }

        // ここに到達したら接続失敗
        return false;
    }

    /**
     * SetOptions()
     *
     * オプション設定を行う
     *
     * @access    private
     *
     * @param     void なし
     *
     * @return    boolean    常にtrue
     */
    private function SetOptions()
    {
        $this->ExecSQL('SET NAMES utf8');
        $this->ExecSQL('SET CHARACTER SET utf8');

        $this->conn->setFetchMode(MDB2_FETCHMODE_ASSOC, 'Query_Result');

        $this->conn->setOption('ssl', false);
        $this->conn->setOption('field_case', CASE_UPPER);
        $this->conn->setOption('result_buffering', false);
        $this->conn->setOption('persistent', true);
        $this->conn->setOption('debug', 0);
        $this->conn->setOption('use_transactions', true);
        $this->conn->setOption('portability', MDB2_PORTABILITY_NONE);

        return true;
    }

    /**
     * Disconnect()
     *
     * DB接続の解除を行う
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function Disconnect()
    {
        // 呼び出し元に戻る
        return $this->conn->disconnect();
    }

    /**
     * Commit()
     *
     * トランザクションをコミットする
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function Commit()
    {
        return (!PEAR::isError($this->conn->commit()) ? true : false);
    } // end of function:dbCommit

    /**
     * Rollback()
     *
     * トランザクションをロールバックする
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function Rollback()
    {
        return (!PEAR::isError($this->conn->rollback()) ? true : false);
    }

    /**
     * BeginTransaction()
     *
     * トランザクションを開始する
     *
     * @access    public
     *
     * @param     void なし
     *
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function BeginTransaction()
    {
        // トランザクションがすでに開始されているか、サポートされていなければ戻る
        if ($this->conn->inTransaction() and !$this->conn->supports('transactions')) {
            return false;
        }

        // トランザクションを開始する
        return (!PEAR::isError($this->conn->beginTransaction()) ? true : false);
    }

    /**
     * GetErrMsg($obj_err = null)
     *
     * DB関連エラー発生時、エラーメッセージの取得を行う
     * エラーが発生した直後に実行されなければならない
     *
     * @access    public
     *
     * @param     object    MDB2:ERRORオブジェクト
     *
     * @return    string    エラーメッセージ
     */
    public function GetErrMsg($obj_err = null)
    {
        // 引数が与えられていればそちらからエラーメッセージを取得する
        return (!empty($obj_err) ? $obj_err->getMessage() : $this->conn->getMessage());
    }

    /**
     * Query($query, $param = array())
     *
     * 引数で与えられたクエリを実行し全データを取得する
     * 取得した値は配列で返却される
     *
     * @access    public
     *
     * @param     string 実行するSQLクエリ（クエリ中の?はプレースホルダ）
     * @param     string プレースホルダを置換する値が格納された配列
     *
     * @return    array     クエリ実行結果（エラーの場合、MDB2:ERRORオブジェクト）
     */
    public function Query($query, $param = array())
    {
        // SQLを実行し、呼び出し元に戻る
        return $this->conn->extended->getAll($query, null, $param, null, MDB2_FETCHMODE_ASSOC, false);
    } // end of function:dbGetAll

    /**
     * ExecSQL($query, $param = array())
     *
     * 引数で与えられたクエリ及びバインド変数へ指定する値を使用し、任意のSQLを発行する
     * 取得した値は配列で返却される
     *
     * @access    public
     *
     * @param     string 実行するSQLクエリ（クエリ中の?はプレースホルダ）
     * @param     string プレースホルダを置換する値が格納された配列
     *
     * @return    mixed     クエリ実行結果（エラーの場合、MDB2:ERRORオブジェクト）
     */
    public function ExecSQL($query, $param = array())
    {
        // 指定されたクエリを実行し、結果をチェックする
        $readySQL = $this->conn->prepare($query);

        return (!PEAR::isError($readySQL) ? $readySQL->execute($param) : $readySQL);
    }

    /**
     * SQL発行メソッド
     *
     * 引数で与えられたファイル内のSQL（各SQLは「;」区切り）を実行する
     *
     * @access    public
     *
     * @param     string     対象となるファイルのパス
     * @param     string     SQL文中の「[[[_PREFIX]]]」を置換する文字列
     *
     * @return    boolean    実行結果（true:全て正常に実行された/false:一部又は全部が失敗）
     */
    public function FileSQLExec($path, $prefix = null)
    {
        // 戻り値のデフォルトはfalse
        $retval = false;

        // ファイルが存在しない場合は、即時return
        if (!file_exists($path)) {
            return false;
        }

        // ファイルの内容を取得する
        $tmp_sql = @file_get_contents($path);
        // ファイル中の改行コードとタブコードは、半角スペース1つに置換する
        $tmp_sql = preg_replace('/[\r\n\t]/', ' ', $tmp_sql);
        // 「;」で分割する
        $exec_sql = explode(';', $tmp_sql);

        // 順番に実行する
        foreach ($exec_sql as $sqldat) {
            // 実行すべきものがある場合のみ
            $do_it = trim($sqldat);
            if (!empty($do_it)) {
                // $prefixがセットされていたら置換処理を実施
                if (!empty($prefix)) {
                    $do_it = str_replace('[[[_PREFIX]]]', $prefix, $do_it);
                }

                // SQLを実行し、失敗したらエラーフラグをfalseにセット
                $exec_result = $this->ExecSQL($do_it);
                if (PEAR::isError($exec_result) or $exec_result === false) {
                    $retval = false;
                }
            }
        }

        // 呼び出し元に戻る
        return $retval;
    }
}

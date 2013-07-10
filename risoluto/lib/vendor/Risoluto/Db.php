<?php
/**
 * Risoluto\Db
 *
 * データベース操作のためのファンクション群
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto\Db;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Db
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $dbobj
     * @access private
     * @var    object    DB接続オブジェクト
     */
    private $conn;

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * Open($dbinfo)
     *
     * DBに接続する
     *
     * @param     string     DB接続情報（書式は「{USER};{PASSWORD};{DBNAME};{HOST};{PORT};{SOCKET}」）
     * @return    boolean    実行結果（true:正常終了/false:異常終了）
     */
    public function Open($dbinfo)
    {
        // 接続情報の取得
        $dbs = explode( ";", $dbinfo)
        if (count($dbs) == 6) {
            return false;
        } else {
            $user = $dbs[0];
            $pass = $dbs[1];
            $dbnm = $dbs[2];
            $host = $dbs[3];
            $post = $dbs[4];
            $sock = $dbs[5];
        }

        // 接続を試みる
        $this->conn = new mysqli($host, $user, $pass, $dbnm, $port, $sock);

        // 接続の状況に応じて戻り値をセット
        if ($this->conn->connect_error) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * ConnectErrorInfo()
     *
     * 接続エラー情報を取得する
     *
     * @param     void      なし
     * @return    string    エラー情報（取得できないときはfalseを返却）
     */
    public function ConnectErrorInfo()
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // エラー情報を取得し返却する
        } else {
            return 'No:' . $this->conn->connect_errno . ' / Msg:' . $this->conn->connect_error;
        }
    }

    /**
     * ErrorInfo()
     *
     * エラー情報を取得する
     *
     * @param     void      なし
     * @return    string    エラー情報（取得できないときはfalseを返却）
     */
    public function ErrorInfo()
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // エラー情報を取得し返却する
        } else {
            return 'No:' . $this->conn->errno . ' / Msg:' . $this->conn->error;
        }
    }

    /**
     * Close()
     *
     * DB接続の解除を行う
     * 
     *
     * @param     void       なし
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function Close()
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // DB接続を解除する
        } else {
            return $this->conn->close();
        }
    }

    /**
     * AutoCommit($mode = false)
     *
     * オートコミットの設定を行う
     * 
     *
     * @param     boolean    オートコミット状態（true:有効、false:無効）
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function AutoCommit($mode = false)
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // オートコミットを設定する
        } else {
            return $this->conn->autocommit($mode);
        }
    }

    /**
     * Commit()
     * コミットを行う
     *
     * @param     void       なし
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function Commit()
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // コミットする
        } else {
            return $this->conn->commit();
        }
    }

    /**
     * RollBack()
     *
     * ロールバックを行う
     *
     * @param     void       なし
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function RollBack()
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // ロールバックする
        } else {
            return $this->conn->rollback();
        }
    }

    /**
     * SetCharset($charset = 'utf8')
     *
     * クライアントのデフォルトキャラクタセットを設定する
     *
     * @param     string     キャラクタセット
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function SetCharset($charset = 'utf8')
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // クライアントのデフォルトキャラクタセットを設定する
        } else {
            return $this->conn->set_charset($charset);
        }
    }

    /**
     * GetLastId()
     *
     * 最新のAUTO_INCREMENT属性カラム値を取得する
     *
     * @param     void       なし
     * @return    boolean    実行結果（整数値：正常終了/false:異常終了）
     */
    public function GetLastId()
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // 値を取得する
        } else {
            return ($this->conn->insert_id ? $this->conn->insert_id:false);
        }
    }

    /**
     * GetAffectedRows()
     *
     * 変更された行数を取得する
     *
     * @param     void       なし
     * @return    boolean    実行結果（整数値：正常終了/false:異常終了）
     */
    public function GetAffectedRows()
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // 値を取得する
        } else {
            return ($this->conn->affected_rows >= 0? $this->conn->affected_rows:false);
        }
    }

    /**
     * Get($query, $param = array())
     *
     * 引数で与えられたクエリを実行し全データを取得する
     * 取得した値は配列で返却される
     * 
     * @param     string    実行するSQLクエリ（クエリ中の?はプレースホルダ）
     * @param     array     プレースホルダを置換する値が格納された配列
     * @return    array     クエリ実行結果（エラーの場合false）
     */
    public function Get($query, $param = array())
    {
        // 接続オブジェクトがなければそのまま戻る
        if ($this->conn) {
            return false;
        // クエリを実行する
        } else {
            // クエリにパラメタをバインドする
            $stmt = $this->conn->prepare($query);
            if (count($param)) {
                foreach($param as $dat) {
                    // パラメータの書式に併せてバインドをする
                    if (is_bool($dat) or is_int($dat)) {
                        $stmt->bind_param('i', $dat);
                    } elseif (is_float($dat)) {
                        $stmt->bind_param('d', $dat);
                    } elseif (is_string($dat)) {
                        $stmt->bind_param('s', $dat);
                    } else {
                        $stmt->bind_param('b', $dat);
                    }
                }
            }

            // プリペアドステートメントの実行と実行結果の取得
            $rslt = $stmt->get_result();
            return ($rslt->mysqli_fetch_all(MYSQLI_ASSOC));
        }
    }

    /**
     * ExecSQL($query)
     *
     * 引数で与えられたクエリを実行する
     * 
     * @param     string     実行するSQLクエリ（適切なエスケープがなされていること）
     * @return    boolean    実行結果（true：正常終了/false:異常終了）
     */
    public function ExecSQL($query)
    {
        // 接続オブジェクトがなければそのまま戻る
        if (!$this->conn) {
            return false;
        // クエリを実行する
        } else {
            $result = $this->conn->query($query);

            // クエリ実行に失敗した場合
            if ($result === false) {
                return false;
            // クエリ実行に成功した場合
            } else {
                return true;
            }
        }
    }

    /**
     * FileSQLExec($path, $replace = null)
     *
     * 引数で与えられたファイル内のSQL（各SQLは「;」区切り）を一括実行する
     * 
     * @param     string     対象となるファイルのパス
     * @param     string     SQL文中の「[[[_PREFIX]]]」を置換する文字列
     * @return    boolean    実行結果（true: 全て正常に実行された/false: 一部又は全部が失敗）
     */
    public function FileSQLExec($path, $replace = null)
    {
        //-- ローカル変数 --//
        $retval = true;

        // ファイルが存在しない場合は、即時return
        if (!file_exists($path)) {
            return false;
        }

        // ファイルの内容を取得する
        $tmp_sql  = @file_get_contents($path);
        // ファイル中の改行コードとタブコードは、半角スペース1つに置換する
        $tmp_sql  = preg_replace('/[\r\n\t]/', ' ', $tmp_sql);
        // 「;」で分割する
        $exec_sql = explode(';', $tmp_sql);

        // 順番に実行する
        foreach($exec_sql as $sqldat) {
            // 実行すべきものがある場合のみ
            $do_it = trim($sqldat);
            if (!empty($do_it)) {
                // $prefixがセットされていたら置換処理を実施
                if (!empty($prefix)) {
                    $do_it = str_replace('[[[_PREFIX]]]', $prefix, $do_it);
                }

                // SQLを実行し、失敗したらエラーフラグをfalseにセット
                $exec_result = $this->dbExecSQL($do_it);
                if ($exec_result === false) {
                    $retval = false;
                }
            }
        }

        // 呼び出し元に戻る
        return $retval;
    }
}

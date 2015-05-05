<?php
/**
 * Db
 *
 * コンフィグ操作のためのファンクション群
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Db
{ //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $pdo_instance
     * @access private
     * @var    object    PDOクラスインスタンスを保持
     * @instanceof \PDO
     */
    private $pdo_instance = '';

    /**
     * $pdostatement_instance
     * @access private
     * @var    object    PDOStatementクラスインスタンスを保持
     * @instanceof \PDOStatement
     */
    private $pdostatement_instance = '';

    /**
     * $dbinfo
     * @access private
     * @var    array    DB接続に必要な情報
     */
    private $dbinfo = array();

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    use RisolutoErrorLogTrait;

    /**
     * connect(array $param)
     *
     * DBへの接続を開始する
     *
     * @param     array $param  DB接続に必要となる情報を含んだ配列
     * @param     array $option DB接続に指定するオプション情報を含んだ配列
     *
     * @return    boolean 実行結果（true: 成功 / false: 失敗）
     *
     */
    public function connect(array $param, array $option = array())
    {
        // 戻り値を初期化
        $retval = true;

        // 接続情報をクラス変数へセット
        $this->dbinfo = $param;

        // DSNを生成しクラス変数へセット
        if (!array_key_exists('dsn', $this->dbinfo) or empty($this->dbinfo['dsn'])) {
            $this->dbinfo['dsn'] = $this->genDSN();
        }

        // DBへの接続を試みる
        try {
            if (empty($option)) {
                // オプションが指定されていなければそのまま指定する
                $this->pdo_instance = new \PDO($this->dbinfo['dsn'], $this->dbinfo['user'], $this->dbinfo['pass'],
                    array(
                        \PDO::ATTR_PERSISTENT => ($this->dbinfo['persistent'] ? true : false),
                        \PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION,
                    ));
            } else {
                // オプションが指定されていればそれを指定して接続する
                $this->pdo_instance = new \PDO($this->dbinfo['dsn'], $this->dbinfo['user'], $this->dbinfo['pass'],
                    $option);
            }
        } catch (\PDOException $e) {
            // 接続に失敗したらエラーメッセージを生成
            $this->genErrorMsg('pdo', $e->getMessage());
            $retval = false;
        }

        return $retval;
    }

    /**
     * disConnect($force = false)
     *
     * DBへの接続を終了する
     *
     * @param     boolean $force 持続的接続時に切断するか(true: 切断する / false: 切断しない（デフォルト）)
     *
     * @return    boolean 常にtrue
     *
     */
    public function disConnect($force = false)
    {
        // 持続的接続が無効か強制切断が有効なときのみ接続を解除
        if (!$this->dbinfo['persistent'] or $force) {
            $this->pdo_instance = null;
        }

        return true;
    }

    /**
     * getAttribute($attribute)
     *
     * DB接続に関する属性値を取得する
     *
     * @param     string $attribute 取得対象となるアトリビュート（PDO::ATTR_*から「PDO::ATTR_*」を除いたもの、または「ALL」）
     *
     * @return    array 属性値が格納された連想配列
     *
     */
    public function getAttribute($attribute = 'ALL')
    {
        // 接頭語をセット
        $prefix = 'PDO::ATTR_';

        // 引数値をすべて大文字に変更
        $attribute = strtoupper($attribute);

        // 属性値を取得
        switch ($attribute) {
            case 'AUTOCOMMIT': // FALL THRU
            case 'PREFETCH': // FALL THRU
            case 'TIMEOUT': // FALL THRU
            case 'ERRMODE': // FALL THRU
            case 'SERVER_VERSION': // FALL THRU
            case 'CLIENT_VERSION': // FALL THRU
            case 'SERVER_INFO': // FALL THRU
            case 'CONNECTION_STATUS': // FALL THRU
            case 'CASE': // FALL THRU
            case 'DRIVER_NAME': // FALL THRU
            case 'ORACLE_NULLS': // FALL THRU
            case 'PERSISTENT': // FALL THRU
            case 'STATEMENT_CLASS': // FALL THRU
            case 'DEFAULT_FETCH_MODE': // FALL THRU
                if ($this->dbinfo['driver'] == 'mysql' and ($attribute == 'PREFETCH' or $attribute == 'TIMEOUT')) {
                    $retval = array($attribute => 'Not Supported');
                } else {
                    $retval = array(
                        $attribute => $this->pdo_instance->getAttribute(constant($prefix . $attribute))
                    );
                }
                break;

            case 'ALL': // FALL THRU
            default:
                $retval = array(
                    'AUTOCOMMIT'         => $this->pdo_instance->getAttribute(constant($prefix . 'AUTOCOMMIT')),
                    'PREFETCH'           => ($this->dbinfo['driver'] == 'mysql') ? 'Not Supported' : $this->pdo_instance->getAttribute(constant($prefix . 'PREFETCH')),
                    'TIMEOUT'            => ($this->dbinfo['driver'] == 'mysql') ? 'Not Supported' : $this->pdo_instance->getAttribute(constant($prefix . 'TIMEOUT')),
                    'ERRMODE'            => $this->pdo_instance->getAttribute(constant($prefix . 'ERRMODE')),
                    'SERVER_VERSION'     => $this->pdo_instance->getAttribute(constant($prefix . 'SERVER_VERSION')),
                    'CLIENT_VERSION'     => $this->pdo_instance->getAttribute(constant($prefix . 'CLIENT_VERSION')),
                    'SERVER_INFO'        => $this->pdo_instance->getAttribute(constant($prefix . 'SERVER_INFO')),
                    'CONNECTION_STATUS'  => $this->pdo_instance->getAttribute(constant($prefix . 'CONNECTION_STATUS')),
                    'CASE'               => $this->pdo_instance->getAttribute(constant($prefix . 'CASE')),
                    'DRIVER_NAME'        => $this->pdo_instance->getAttribute(constant($prefix . 'DRIVER_NAME')),
                    'ORACLE_NULLS'       => $this->pdo_instance->getAttribute(constant($prefix . 'ORACLE_NULLS')),
                    'PERSISTENT'         => $this->pdo_instance->getAttribute(constant($prefix . 'PERSISTENT')),
                    'STATEMENT_CLASS'    => $this->pdo_instance->getAttribute(constant($prefix . 'STATEMENT_CLASS')),
                    'DEFAULT_FETCH_MODE' => $this->pdo_instance->getAttribute(constant($prefix . 'DEFAULT_FETCH_MODE')),
                );
                break;
        }

        return $retval;
    }

    /**
     * setAttribute($attribute, $value)
     *
     * DB接続に関する属性値をセットする
     *
     * @param     integer $attribute 設定対象となるアトリビュート
     * @param     mixed   $value     設定する値
     *
     * @return    boolean true：正常終了／false:異常終了
     *
     */
    public function setAttribute($attribute, $value)
    {
        if (!empty($attribute) and !empty($value)) {
            return $this->pdo_instance->setAttribute($attribute, $value);
        } else {
            return false;
        }
    }

    /**
     * beginTransaction()
     *
     * トランザクションを開始する
     *
     * @param     void
     *
     * @return    boolean true：正常終了／false:異常終了
     *
     */
    public function beginTransaction()
    {
        return $this->pdo_instance->beginTransaction();
    }

    /**
     * inTransaction()
     *
     * トランザクションが開始しているかを判定する
     *
     * @param     void
     *
     * @return    boolean true：トランザクションが開始している／false:トランザクションが開始していない
     *
     */
    public function inTransaction()
    {
        return $this->pdo_instance->InTransaction();
    }

    /**
     * commit()
     *
     * トランザクションをコミットする
     *
     * @param     void
     *
     * @return    boolean true：正常終了／false:異常終了
     *
     */
    public function commit()
    {
        return $this->pdo_instance->commit();
    }

    /**
     * rollBack()
     *
     * トランザクションをロールバックする
     *
     * @param     void
     *
     * @return    boolean true：正常終了／false:異常終了
     *
     */
    public function rollBack()
    {
        try {
            return $this->pdo_instance->rollBack();
        } catch (\PDOException $e) {
            // ロールバックに失敗したらエラーメッセージを生成
            $this->genErrorMsg('pdo', $e->getMessage());

            return false;
        }
    }

    /**
     * lastInsertId($name)
     *
     * 最後に挿入されたID値を取得する
     *
     * @param     string $name 取得対象となるID値のカラム名
     *
     * @return    string 取得したID値
     *
     */
    public function lastInsertId($name = null)
    {
        try {
            return $this->pdo_instance->lastInsertId($name);
        } catch (\PDOException $e) {
            // 取得に失敗したらエラーメッセージを生成
            $this->genErrorMsg('pdo', $e->getMessage());

            return false;
        }
    }

    /**
     * exec($sql)
     *
     * SQLを実行する
     *
     * @param     string $sql 実行するSQL
     *
     * @return    boolean true:正常終了／false:異常終了
     *
     */
    public function exec($sql)
    {
        if (!empty($sql)) {
            return ($this->pdo_instance->exec($sql) === false ? false : true);
        } else {
            return false;
        }
    }

    /**
     * doQuery($sql = '', array $param = array(), array $query_options = array(), $fetch_style = \PDO::FETCH_ASSOC)
     *
     * SQLを実行する
     *
     * @param     string  $sql           実行するSQL（"clear"が指定された場合はPDOStatementのインスタンスをクリア）
     * @param     array   $param         PDOStatement::bindParam()へ渡すバインドする値（array(id, value, type[, length])）
     * @param     array   $query_options PDO::prepare()へ渡すオプション
     * @param     integer $fetch_style   PDOStatement::fetchAll()へ渡すオプション（\PDO::FETCH_**のいずれか）
     *
     * @return    mixed   SQLの実行結果／false:異常終了
     *
     */
    public function doQuery(
        $sql = '',
        array $param = array(),
        array $query_options = array(),
        $fetch_style = \PDO::FETCH_ASSOC
    ) {
        // SQLの前後についている余分な空白を排除
        $sql = trim($sql);

        // SQLを判定し、SELECTだったときのみデータ取得モードにする
        $tmp_mode = false;
        if (preg_match('/^SELECT/i', $sql)) {
            $tmp_mode = true;
        }

        // SQLが渡されたときはPDOStatementのインスタンスを更新する（既存のインスタンスがなくSQL未指定の場合はfalseを返す）
        try {
            if (strtolower($sql) == 'clear') {
                $this->pdostatement_instance = null;
            } elseif (!empty($sql)) {
                $this->pdostatement_instance = null;
                $this->pdostatement_instance = $this->pdo_instance->prepare($sql, $query_options);
            }

            // PDOStatementクラスのインスタンスが生成済みの時だけSQLを実行
            if (!empty($this->pdostatement_instance)) {
                // パラメタが指定されている時はバインドする
                if (!empty($param) and is_array($param)) {
                    foreach ($param as $dat) {
                        // lengthがセットされているかどうかでbindParam()のコールを変更する
                        if (isset($dat['length']) and !empty($dat['length'])) {
                            /** @noinspection PhpUndefinedMethodInspection */
                            $this->pdostatement_instance->bindParam($dat['id'], $dat['value'], $dat['type'],
                                $dat['length']);
                        } else {
                            /** @noinspection PhpUndefinedMethodInspection */
                            $this->pdostatement_instance->bindParam($dat['id'], $dat['value'], $dat['type']);
                        }
                    }
                }

                // SQLを実行し結果を取得する
                /** @noinspection PhpUndefinedMethodInspection */
                $retval_execute = $this->pdostatement_instance->execute();
                // データ取得モードの時のみfetchする
                if ($tmp_mode) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $retval_fetch = (($fetch_dat = $this->pdostatement_instance->fetchAll($fetch_style)) === false ? false : true);
                } else {
                    $retval_fetch = true;
                    $fetch_dat    = true;
                }
                $retval = (($retval_execute and $retval_fetch) ? $fetch_dat : false);

                return $retval;
            } else {
                $retval = false;
            }
        } catch (\PDOException $e) {
            // 取得に失敗したらエラーメッセージを生成
            $this->genErrorMsg('pdo', $e->getMessage());

            return false;
        }

        return $retval;
    }

    /**
     * genDSN()
     *
     * DSN文字列を生成する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    string DSN文字列
     */
    private function genDSN()
    {
        // 変数の初期化
        $retval = '';

        // ドライバ名のセット
        if (isset($this->dbinfo['driver']) and !empty($this->dbinfo['driver']) and in_array($this->dbinfo['driver'],
                \PDO::getAvailableDrivers())
        ) {
            $retval .= $this->dbinfo['driver'] . ':';
        } else {
            $this->genErrorMsg("undefined", 'driver');
        }

        // DB名のセット
        if (isset($this->dbinfo['dbname']) and !empty($this->dbinfo['dbname'])) {
            $retval .= 'dbname=' . $this->dbinfo['dbname'] . ';';
        } else {
            $this->genErrorMsg("undefined", 'dbname');
        }

        // ホスト名のセット
        if (isset($this->dbinfo['host']) and !empty($this->dbinfo['host'])) {
            $retval .= 'hostname=' . $this->dbinfo['host'] . ';';
        } else {
            $this->genErrorMsg("undefined", 'host');
        }

        // キャラクタセットのセット
        if (isset($this->dbinfo['charset']) and !empty($this->dbinfo['charset'])) {
            $retval .= 'charset=' . $this->dbinfo['charset'];
        } else {
            $this->genErrorMsg("undefined", 'charset');
        }

        return $retval;
    }

    /**
     * genErrorMsg($key = '')
     *
     * クラス内で発生したエラーに対するエラーメッセージを生成する
     *
     * @access    private
     *
     * @param     string $key           エラーを示すキー文字列
     * @param     string $optional_text オプションの文字列
     *
     * @return    string    エラーメッセージ
     */
    private function genErrorMsg($key = '', $optional_text = '')
    {
        // 引数の値に応じてエラーメッセージをセットする
        switch ($key) {
            // 未定義エラーの場合
            case 'undefined':
                $msg = 'Value not set - ' . ((isset($optional_text) and !empty($optional_text)) ? $optional_text : 'unknown');
                break;

            // PDO関連エラーの場合
            case 'pdo':
                $msg = 'PDO error happened - ' . ((isset($optional_text) and !empty($optional_text)) ? $optional_text : 'unknown');
                break;


            // 未定義のエラーの場合
            default:
                $msg = 'Unknown Error occurred';
                break;
        }

        // ログ出力しエラーメッセージを返却
        $this->risolutoErrorLog('error', $msg);

        return $msg;
    }
}

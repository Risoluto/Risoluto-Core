<?php
/**
 * Session
 *
 * セッション操作のためのファンクション群
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

class Session
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $sesspath
     * @access private
     * @var    string    セッションファイル保存ディレクトリ
     */
    private $sesspath = RISOLUTO_SESS;

    /**
     * $sessname
     * @access private
     * @var    string    セッション名
     */
    private $sessname = 'RISOLUTOSESS';

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * start($path = '', $name = '')
     *
     * セッションを開始する
     * もし、すでにセッションが存在している場合は
     * そのセッションIDを用いてセッションをスタートする
     * セッションが存在しない場合は新規にセッションを生成し、スタートする
     *
     * @access    public
     *
     * @param     string $path セッションファイル保存ディレクトリ
     * @param     string $name セッション名
     *
     * @return    boolean    セッション開始結果（true：正常終了/false:異常終了）
     */
    public function start($path = '', $name = '')
    {
        // セッション保存ディレクトリが指定されていたらその値を採用
        if (!empty($path)) {
            $this->sesspath = $path;
        }
        // セッション名が指定されていたらその値を採用
        if (!empty($name)) {
            $this->sessname = $name;
        }

        // セッション保存ディレクトリをセット
        if (!empty($this->sesspath) and is_writable($this->sesspath)) {
            session_save_path($this->sesspath);
            // 指定されていないか書き込めないならfalseを返す
        } else {
            return false;
        }

        // セッション名の指定
        session_name($this->sessname);

        // セッションが存在しない場合の処理
        if (empty($_COOKIE[$this->sessname])) {
            // 生成したセッションIDを付与する
            $base = $this->genRand();
            session_id($base);
        } // end of if

        // セッションの開始
        return session_start();
    }

    /**
     * restart($path = '', $name = '')
     *
     * セッションを再スタートする（）
     *
     * @access    public
     *
     * @param     string $path セッションファイル保存ディレクトリ
     * @param     string $name セッション名
     *
     * @return    boolean    セッション再開始結果（true：正常終了/false:異常終了）
     */
    public function restart($path = '', $name = '')
    {
        // セッションを終了してスタートさせる
        $this->end();

        return $this->start($path, $name);
    }

    /**
     * end()
     *
     * セッションを終了する
     *
     * @access    public
     *
     * @param     void
     *
     * @return    boolean セッション終了結果（true：正常終了/false:異常終了）
     */
    public function end()
    {
        // クッキーを削除
        if (isset($_COOKIE[$this->sessname])) {
            setcookie($this->sessname, '', time() - 42000, '/');
        }

        // スーパーグローバルな$_COOKIEと$_SESSIONをクリア
        $_COOKIE[$this->sessname] = array();
        $_SESSION                 = array();

        // セッションファイルを削除
        $target = $this->sesspath . 'sess_' . session_id();

        clearstatcache(true);
        if (file_exists($target) and is_file($target) and is_writeable($target)) {
            unlink($target);
        }

        return session_destroy();
    }

    /**
     * store($destination, $val)
     *
     * セッションへ値を格納する
     * 引数で指定された名称の変数へ、同じく引数で指定された値を格納する
     *
     * @access    public
     *
     * @param     string $destination 格納先セッション変数名
     * @param     mixed  $val         格納する値（number or string）
     *
     * @return    boolean    常にtrue
     */
    public function store($destination, $val)
    {
        if (isset($destination) and isset($val)) {
            $_SESSION[$destination] = $val;
        }

        return true;
    }

    /**
     * load($from)
     *
     * セッションから値を取得する
     * 引数で指定された名称のセッション変数から値を取得する
     *
     * @access    public
     *
     * @param     string $from 取得元セッション変数名
     *
     * @return    mixed     取得した値
     */
    public function load($from)
    {
        if (isset($from) and isset($_SESSION[$from])) {
            return $_SESSION[$from];
        } else {
            return null;
        }
    }

    /**
     * isThere($chkName)
     *
     * セッション中に引数で指定された名称を持つ値が存在するかをチェックする
     *
     * @access    public
     *
     * @param     string $chkName 判定対象セッション変数名
     *
     * @return    boolean    存在状況(true:存在する/false:存在しない)
     */
    public function isThere($chkName)
    {
        return isset($_SESSION[$chkName]);
    }

    /**
     * revoke($chkName)
     *
     * セッション中の引数で指定された名称を持つ値を抹消する
     *
     * @access    public
     *
     * @param     string $chkName 抹消対象セッション変数名
     *
     * @return    boolean    常にtrue
     */
    public function revoke($chkName)
    {
        if (isset($_SESSION[$chkName])) {
            unset($_SESSION[$chkName]);
        }

        return true;
    }

    /**
     * revokeAll()
     *
     * セッション中のすべての値を抹消する
     *
     * @access    public
     *
     * @param     void
     *
     * @return    boolean    常にtrue
     */
    public function revokeAll()
    {
        // セッション変数が存在するかをチェック
        if (isset($_SESSION)) {
            // すべての値を抹消する
            foreach ($_SESSION as $key) {
                $this->revoke($key);
            }
        }

        return true;
    }

    /**
     * genRand()
     *
     * 乱数を生成する
     *
     * @access    public
     *
     * @param     void
     *
     * @return    string 生成された乱数値
     */
    public function genRand()
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            // openssl_random_pseudo_bytes()が使用できない場合はそれを使って乱数を生成
            $retval = bin2hex(openssl_random_pseudo_bytes(32));
        } else {
            // openssl_random_pseudo_bytes()が使用できない場合は
            // システムよりマイクロセコンドの精度で時刻情報を取得し乱数を生成
            list($usec, $sec) = explode(" ", microtime());
            $seed = (double)$sec + ((double)$usec * 100000);

            mt_srand($seed);
            $retval = mt_rand();
        }

        return $retval;
    }
}

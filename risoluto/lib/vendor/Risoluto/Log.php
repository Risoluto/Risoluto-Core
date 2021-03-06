<?php
/**
 * Log
 *
 * ログ操作のためのファンクション群
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
class Log
{
    //------------------------------------------------------//
    // クラス変数定義
    //------------------------------------------------------//
    /**
     * $logfile
     * @access private
     * @var    string    ログの出力パス
     */
    private $logfile = '';

    /**
     * $currentloglevel
     * @access private
     * @var    string    現在のログレベル
     */
    private $currentloglevel = 'warn';

    /**
     * $loglevel
     * @access private
     * @var    array    ログレベル閾値情報を保持
     */
    private $loglevel = [
        "stop" => 0,
        "emerg" => 1,
        "alert" => 2,
        "crit" => 3,
        "error" => 4,
        "warn" => 5,
        "notice" => 6,
        "info" => 7,
        "debug" => 8,
    ];

    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * __construct()
     *
     * コンストラクタ
     *
     * @access    public
     * @return \Risoluto\Log
     */
    public function __construct()
    {
        $this->logfile = RISOLUTO_LOGS . "risoluto-[[[REPLACED]]].log";
    }

    /**
     * setLogFile($path)
     *
     * ログ出力パスをセットする
     *
     * @access    public
     *
     * @param     string $path ログ出力パス
     *
     * @return    void
     */
    public function setLogFile( $path )
    {
        $this->logfile = $path;
    }

    /**
     * setCurrentLogLevel($loglevel)
     *
     * ログレベルをセットする
     *
     * @access    public
     *
     * @param     string $loglevel ログレベル
     *
     * @return    void
     */
    public function setCurrentLogLevel( $loglevel )
    {
        $this->currentloglevel = $loglevel;
    }

    /**
     * log($loglvl, $logmes)
     *
     * 指定されたログレベルで指定された文字列を出力する
     *
     * @param     string $loglvl ログレベル（stop|emerg|alert|crit|error|warn|notice|info|debug）
     * @param     string $logmes 出力するメッセージ
     *
     * @return    boolean    出力結果（{書き込んだバイト数}：正常終了/false:異常終了）
     */
    public function log( $loglvl, $logmes )
    {
        //-- ローカル変数 --//
        $currentdate = date( \DateTime::W3C );
        $outfile = str_replace( '[[[REPLACED]]]', date( 'Ymd' ), $this->logfile );

        // 現在のログレベル以下の場合は出力しない
        if ($this->loglevel[ $this->currentloglevel ] < $this->loglevel[ $loglvl ]) {
            return true;
        } else {
            return file_put_contents( $outfile, "[$loglvl at $currentdate] $logmes\n", FILE_APPEND | LOCK_EX );
        }
    }
}

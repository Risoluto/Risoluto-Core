<?php
/**
 * RisolutoCliBase
 *
 * ユーザCliアプリ向けコントローラ用基底クラス
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

abstract class RisolutoCliBase
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    use RisolutoErrorLogTrait;

    /**
     * __construct()
     *
     * コンストラクタ
     */
    public function __construct()
    {
    }

    /**
     * readFromStdin($prompt = 'Enter: ', $echoback = false)
     *
     * 標準入力からの入力を処理する
     *
     * @access    protected
     *
     * @param     string  $message ブラウザ側に出力するメッセージ（省略可、デフォルトは'Authorization Required'）
     * @param     boolean $echoback true:エコーバックする/false:エコーバックしない
     *
     * @return    string 入力された内容
     */
    protected function readFromStdin( $prompt = 'Enter: ', $echoback = true )
    {
        // 入出力のファイルハンドラをオープン
        $in = fopen( 'php://stdin', 'r' );
        $out = fopen( 'php://stderr', 'w' );

        // プロンプトを出力し、エコーバックオフが指示されていれば止める
        fwrite( $out, $prompt );
        if (!$echoback) {
            system( 'stty -echo' );
        }

        // 入力をロックし、キー入力を取得する
        flock( $in, LOCK_EX );
        $readtext = fgets( $in );
        flock( $in, LOCK_UN );

        // エコーバックオフが指示されていれば再開し、PHP_EOLを出力
        if (!$echoback) {
            system( 'stty echo' );
        }
        fwrite( $out, PHP_EOL );

        // 入出力のファイルハンドラをクローズ
        fclose( $in );
        fclose( $out );

        // 取得内容を返却する
        return trim( $readtext );
    }

    /**
     * detectSeparator($target)
     *
     * 分割文字を検出する
     *
     * @access    private
     *
     * @param     string $target 対象となる文字列
     *
     * @return    string 検出した分割文字
     */
    private function detectSeparator( $target )
    {
        // 分割文字列として許容する文字列
        $allow_sepchars = [ '=', ',', ':' ];

        // 分割文字を検出する
        $retval = '';
        $before_position = PHP_INT_MAX;
        foreach ($allow_sepchars as $test) {
            $current_position = strpos( $target, $test );

            // 1つ前に検出した分割文字よりも先に存在する場合はそちらを採用
            if ($current_position !== false and $current_position < $before_position) {
                $retval = $test;
                $before_position = $current_position;
            }
        }

        // 検出した分割文字を返却する
        return $retval;
    }

    /**
     * separateOptions($options)
     *
     * オプションを分割する
     *
     * @access    protected
     *
     * @param     string $target 対象となる文字列
     *
     * @return    array 分割後のオプション
     */
    protected function separateOptions( $target )
    {
        // 分割文字を取得する
        $sepchar = $this->detectSeparator( $target );

        // 分割文字列が存在しているかをチェック
        if ($sepchar) {
            // 分割文字が存在した場合はそれで分割する
            $sep = explode( $sepchar, $target );

            if (count( $sep ) > 2) {

                // 2つより多く分割された場合は最初の1つと残りの全部に再構築する
                $command = array_shift( $sep );
                $param = $this->separateOptions( implode( $sepchar, $sep ) );
            } else {
                // 2つ以下ならそのまま（$param側に分割文字がさらに含まれている場合は再帰的に分割する）
                $command = $sep[ 0 ];
                $param = ( isset( $sep[ 1 ] ) ? ( $this->detectSeparator( $sep[ 1 ] ) ? $this->separateOptions( $sep[ 1 ] ) : $sep[ 1 ] ) : '' );
            }
        } else {
            //存在しない場合はそのまま
            $command = $target;
            $param = '';
        }

        // 分割したものを返却する
        return [ 'command' => $command, 'param' => $param ];
    }
}

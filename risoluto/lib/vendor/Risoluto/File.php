<?php
/**
 * File
 *
 * ファイル操作のためのファンクション群
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

class File
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * __construct()
     *
     * コンストラクタ
     */
    private function __construct()
    {
    }

    /**
     * statChecker(array $target)
     *
     * 指定されたファイルやディレクトリのステータスをチェックする
     *
     * @access    public
     *
     * @param     array $target チェック対象の情報が格納された連想配列
     *
     * @return    array    チェック結果が格納された連想配列
     */
    public static function statChecker(array $target)
    {
        // ローカル変数の初期化
        $result = array(
            'path'   => 'unknown'
        , 'required' => 'unknown'
        , 'real'     => 'unknown'
        , 'result'   => 'unknown'
        );

        // 引数が配列でない場合は即時return
        if (!is_array($target)) {
            return $result;
        }

        // 共通情報はまとめてセット
        $result['path']     = $target['path'];
        $result['required'] = $target['stat'];

        // 対象が存在しない場合は「missing」をセットし、即時return
        clearstatcache();
        if (!file_exists($target['path'])) {
            // 結果をセット
            $result['real']   = 'missing';
            $result['result'] = 'NG';

            return $result;
        }

        // キャッシュステータスのクリア
        clearstatcache();
        // 判定を実施（defaultは書かない）
        // 評価項目を増やすにはここにcaseを追加してください
        switch ($target['stat']) {
            // 読込可
            case 'readable':
                $result['real']   = $target['stat'];
                $result['result'] = ((is_readable($target['path']) and !is_writable($target['path'])) ? 'OK' : 'NG');
                break;

            // 書込可
            case 'writable':
                $result['real']   = 'writable';
                $result['result'] = (is_writable($target['path']) ? 'OK' : 'NG');
                break;
        }

        return $result;
    }

    /**
     * fileOperator($operation, $target, $destination = null, $prefix = null)
     *
     * 指定されたファイルやディレクトリに対し、作成/コピー/移動/削除等を行う
     *
     * @access    public
     *
     * @param     string $operation   処理内容を示す文字列(make/copy/move/unlink/mkdir/rmdir/symlink)
     * @param     string $target      対象となるパス
     * @param     string $destination コピー又は移動先となるパス
     * @param     string $prefix      ファイル中の「[[[_PREFIX]]]」を置換する文字列
     *
     * @return    boolean   処理結果（true:成功/false:失敗）
     */
    public static function fileOperator($operation, $target, $destination = null, $prefix = null)
    {
        // 処理結果の初期化
        $retVal = false;

        // operationの内容によって、処理を分ける
        switch ($operation) {
            // make
            case 'make':
                if (@touch($target)) {
                    $retVal = true;
                }
                break;

            // copy
            case 'copy':
                if (@copy($target, $destination)) {
                    $retVal = true;
                }
                break;

            // copy with replace
            case 'copy_with_replace':
                // ファイルの中身を一度すべて取得
                $text = @file_get_contents($target);

                // $prefixがセットされていたら置換処理を実施
                if (!empty($prefix)) {
                    $text = str_replace('[[[_PREFIX]]]', $prefix, $text);
                }

                // ファイルを出力
                if (@file_put_contents($destination, $text)) {
                    $retVal = true;
                }
                break;

            // move
            case 'move':
                if (@rename($target, $destination)) {
                    $retVal = true;
                }
                break;

            // unlink
            case 'unlink':
                if (@unlink($target)) {
                    $retVal = true;
                }
                break;

            // mkdir
            case 'mkdir':
                if (@mkdir($target, 0777, true)) {
                    $retVal = true;
                }
                break;

            // rmdir
            case 'rmdir':
                if (@rmdir($target)) {
                    $retVal = true;
                }
                break;

            // symlink
            case 'symlink':
                if (@symlink($target, $destination)) {
                    $retVal = true;
                }
                break;
        }

        return $retVal;
    }

} 
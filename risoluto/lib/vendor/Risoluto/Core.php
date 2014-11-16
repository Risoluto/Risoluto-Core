<?php
/**
 * Core
 *
 * Risolutoの中核部分に関するメソッドが含まれているクラス
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

class Core
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    use RisolutoErrorLogTrait;

    /**
     * perform()
     *
     * 指定されたアプリケーションを呼び出す
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void
     */
    public function perform()
    {
        //------------------------------------------------------//
        // アプリケーションクラスをロードし実行する
        //------------------------------------------------------//
        // クラスインスタンスを生成し、実行する
        try {
            // 呼び出すクラスを決定する
            $call = $this->findCallClass();

            // インスタンスの生成
            $targetInstance = new $call['load'];

            // イニシャライズメソッドをコール
            if (method_exists($targetInstance, 'init')) {
                $targetInstance->init($call['param']);
            } else {
                // メソッドが存在しなければ例外をThrow
                throw new \Exception($this->coreError('error', 'notfound', 'Init()'));
            }

            // HTTPのメソッドに応じて適切なコントローラをコール
            switch ($_SERVER['REQUEST_METHOD']) {
                // GETの場合
                case 'GET':
                    if (method_exists($targetInstance, 'playGet')) {
                        $targetInstance->playGet();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // POSTの場合
                case 'POST':
                    if (method_exists($targetInstance, 'playPost')) {
                        $targetInstance->playPost();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // PUTの場合
                case 'PUT':
                    if (method_exists($targetInstance, 'playPut')) {
                        $targetInstance->playPut();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // DELETEの場合
                case 'DELETE':
                    if (method_exists($targetInstance, 'playDelete')) {
                        $targetInstance->playDelete();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // OPTIONの場合
                case 'OPTION':
                    if (method_exists($targetInstance, 'playOption')) {
                        $targetInstance->playOption();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // HEADの場合
                case 'HEAD':
                    if (method_exists($targetInstance, 'playHead')) {
                        $targetInstance->playHead();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // TRACEの場合
                case 'TRACE':
                    if (method_exists($targetInstance, 'playTrace')) {
                        $targetInstance->playTrace();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // CONNECTの場合
                case 'CONNECT':
                    if (method_exists($targetInstance, 'playConnect')) {
                        $targetInstance->playConnect();
                    } else {
                        $this->playFuncCall($targetInstance);
                    }
                    break;

                // デフォルトの場合
                default:
                    $this->playFuncCall($targetInstance);
                    break;
            }
        } catch (\Exception $e) {
            // エラーハンドリングメソッドをコール
            if (!empty($targetInstance)) {
                if (method_exists($targetInstance, 'error')) {
                    $targetInstance->error($e);
                } else {
                    // メソッドが存在しなければ強制終了
                    die($this->coreError('error', 'notfound', 'Error()'));
                }
            }
        } finally {
            // クリーニングメソッドをコール
            if (!empty($targetInstance)) {
                if (method_exists($targetInstance, 'clean')) {
                    $targetInstance->clean();
                } else {
                    // メソッドが存在しなければ強制終了
                    die($this->coreError('error', 'notfound', 'Clean()'));
                }
            }
        }
    }

    /**
     * playFuncCall($targetInstance)
     *
     * Play()メソッドをコールする（存在しない場合は例外をThrow）
     *
     * @access private
     *
     * @param object $targetInstance クラスインスタンス
     *
     * @return void
     *
     * @throws \Exception
     */
    private function playFuncCall($targetInstance)
    {
        if (method_exists($targetInstance, 'Play')) {
            $targetInstance->Play();
        } else {
            // メソッドが存在しなければ例外をThrow
            throw new \Exception($this->coreError('error', 'notfound', 'Play*()'));
        }
    }

    /**
     * fixSeqParam($value = '')
     *
     * $_GET['seq']の値から不適切な文字を排除する
     *
     * @access    private
     *
     * @param     String $value $_GET['seq']の値
     *
     * @return    String 適切な状態に加工した$_GET['seq']
     */
    private function fixSeqParam($value = '')
    {
        // 検出対象のリスト
        $searches = array('/\.+/', '/_+/', '/\//', '/\¥/', '/\\\\/', '/[[:blank:]]/', '/[[:cntrl:]]/');

        // 対応する置換文字のリスト
        $replacement = array('.', '_', '', '', '', '', '');

        // 不正な値を除去
        $retval = preg_replace($searches, $replacement, $value);

        return $retval;
    }

    /**
     * isDisabled($dirpath, $target)
     *
     * 無効指定されているかを判定する
     *
     * @access    private
     *
     * @param     String $dirpath 無効指定ファイルの存在チェックを行うパス
     * @param     String $target  無効指定チェック対象となるクラス（RisolutoApps\からのフル指定）
     *
     * @return    Boolean true：無効指定されている／false：無効指定されていない
     */
    private function isDisabled($dirpath, $target)
    {
        // 変数の初期化
        $retval     = false;
        $ignorefile = $dirpath . '/RisolutoIgnore';

        // 無効指定ファイルが存在するかをチェック
        clearstatcache(true);
        if (file_exists($ignorefile) and is_file($ignorefile) and is_readable($ignorefile)) {
            // ファイルの内容を読み込む
            $ignorelist = file($ignorefile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // 無効指定されているかを判定（空の場合は全指定されているとみなす）
            if (empty($ignorelist) or in_array($target, $ignorelist)) {
                $retval = true;
            }
        }

        return $retval;
    }

    /**
     * findCallClass()
     *
     * 呼び出すクラスを決定する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    array   呼び出すクラスの情報等
     */
    private function findCallClass()
    {
        // コンフィグファイルの読み込み
        $conf = new Conf;
        $conf->parse(RISOLUTO_CONF . 'risoluto.ini');

        // デフォルトの情報をセット
        $load  = $conf->getIni('SEQ', 'default');
        $param = array();

        // $_GET['seq']の値をチェックする
        $seq = $this->fixSeqParam((isset($_GET['seq'])) ? $_GET['seq'] : '');

        // GETパラメタ中の情報（「seq」）が指定されていればそれを採用
        if (isset($seq) and !empty($seq)) {
            // 「.」が付いていたらそこで分割
            if (strpos('.', $seq) === false) {
                $sep = explode('.', $seq);

                // 分割後、1つめの要素は画面指定とみなし、2つめ以降の要素はパラメタと見なす
                $load = 'RisolutoApps\\' . $sep[0];

                unset($sep[0]);
                foreach ($sep as $dat) {
                    $param[] = $dat;
                }
                // 「.」が付いていなければそのまま採用する
            } else {
                $load  = 'RisolutoApps\\' . $seq;
                $param = array();
            }

            // $load中の「_」を「\」に置換
            $load = str_replace('_', '\\', $load);

            // 指定されたアプリケーションが存在していないか無効指定されていたらエラーとする
            $target = RISOLUTO_APPS . str_replace('\\', DIRECTORY_SEPARATOR, $load) . '.php';
            clearstatcache(true);
            if (!file_exists($target) or !is_file($target) or !is_readable($target) or $this->isDisabled(dirname($target), $load)) {
                // ログにも記録しておく
                $this->coreError('warn', 'classnotfound', $load . ' (Path: ' . $target . ' ) / Go to Error page.');

                $load  = $conf->getIni('SEQ', 'error');
                $param = array();
            }
        }

        // サービスストップファイルが存在するかロードアベレージが一定値以上ならサービスストップ
        $loadavg     = sys_getloadavg();
        $max_loadavg = $conf->getIni('LIMITS', 'max_loadavg');
        clearstatcache(true);
        if (file_exists(RISOLUTO_SYSROOT . 'ServiceStop') or (!empty($max_loadavg) and $loadavg[0] > $max_loadavg)) {
            // ログにも記録しておく
            $this->coreError('warn', 'servicestop', 'Current Loadavg: ' . $loadavg[0] . ' / Setting: ' . $max_loadavg);

            $load  = $conf->getIni('SEQ', 'servicestop');
            $param = array();
        }

        // 決定した情報を返却する
        $retval = array('load' => $load
        , 'param'              => $param);

        return $retval;
    }

    /**
     * coreError($error_level = 'error', $key = '', $optional_text = 'unknown')
     *
     * クラス内で発生したエラーに対するエラーメッセージを生成する
     *
     * @access    private
     *
     * @param     string $error_level   エラーレベル
     * @param     string $key           エラーを示すキー文字列
     * @param     string $optional_text オプションの文字列
     *
     * @return    string    エラーメッセージ
     */
    private function coreError($error_level = 'error', $key = '', $optional_text = 'unknown')
    {
        // 引数の値に応じてエラーメッセージをセットする
        switch ($key) {
            // 未定義エラーの場合
            case 'notfound':
                $msg = 'Required method is not exists - ' . $optional_text;
                break;

            // URLで指定されたアプリケーションが存在しないか無効指定されている場合
            case 'classnotfound':
                $msg = 'Class not found or disabled - ' . $optional_text;
                break;

            // サービスストップが発生した場合
            case 'servicestop':
                $msg = 'Auto Service Stop - ' . $optional_text;
                break;


            // 未定義のエラーの場合
            default:
                $msg = 'Unknown Error occurred';
                break;
        }

        // ログ出力しエラーメッセージを返却
        $this->risolutoErrorLog($error_level, '[' . __CLASS__ . '/]' . $msg);

        return $msg;
    }
}

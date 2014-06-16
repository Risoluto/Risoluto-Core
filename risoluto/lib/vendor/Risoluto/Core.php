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
    /**
     * Perform()
     *
     * 指定されたアプリケーションを呼び出す
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void
     */
    public function Perform()
    {
        //------------------------------------------------------//
        // アプリケーションクラスをロードし実行する
        //------------------------------------------------------//
        // クラスインスタンスを生成し、実行する
        try {
            // 呼び出すクラスを決定する
            $call = $this->FindCallClass();

            // インスタンスの生成
            $targetInstance = new $call['load'];

            // イニシャライズメソッドをコール
            if (method_exists($targetInstance, 'Init')) {
                $targetInstance->Init($call['param']);
            } else {
                // メソッドが存在しなければ例外をThrow
                throw new \Exception($this->coreError('notfound_init'));
            }

            // HTTPのメソッドに応じて適切なコントローラをコール
            switch ($_SERVER['REQUEST_METHOD']) {
                // GETの場合
                case 'GET':
                    if (method_exists($targetInstance, 'PlayGet')) {
                        $targetInstance->PlayGet();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // POSTの場合
                case 'POST':
                    if (method_exists($targetInstance, 'PlayPost')) {
                        $targetInstance->PlayPost();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // PUTの場合
                case 'PUT':
                    if (method_exists($targetInstance, 'PlayPut')) {
                        $targetInstance->PlayPut();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // DELETEの場合
                case 'DELETE':
                    if (method_exists($targetInstance, 'PlayDelete')) {
                        $targetInstance->PlayDelete();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // OPTIONの場合
                case 'OPTION':
                    if (method_exists($targetInstance, 'PlayOption')) {
                        $targetInstance->PlayOption();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // HEADの場合
                case 'HEAD':
                    if (method_exists($targetInstance, 'PlayHead')) {
                        $targetInstance->PlayHead();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // TRACEの場合
                case 'TRACE':
                    if (method_exists($targetInstance, 'PlayTrace')) {
                        $targetInstance->PlayTrace();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // CONNECTの場合
                case 'CONNECT':
                    if (method_exists($targetInstance, 'PlayConnect')) {
                        $targetInstance->PlayConnect();
                    } else {
                        $this->PlayFuncCall($targetInstance);
                    }
                    break;

                // デフォルトの場合
                default:
                    $this->PlayFuncCall($targetInstance);
                    break;
            }
        } catch (\Exception $e) {
            // エラーハンドリングメソッドをコール
            if (!empty($targetInstance)) {
                if (method_exists($targetInstance, 'Error')) {
                    $targetInstance->Error($e);
                } else {
                    // メソッドが存在しなければ強制終了
                    die($this->coreError('notfound_error'));
                }
            }
        } finally {
            // クリーニングメソッドをコール
            if (!empty($targetInstance)) {
                if (method_exists($targetInstance, 'Clean')) {
                    $targetInstance->Clean();
                } else {
                    // メソッドが存在しなければ強制終了
                    die($this->coreError('notfound_clean'));
                }
            }
        }
    }

    /**
     * PlayFuncCall()
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
    private function PlayFuncCall($targetInstance)
    {
        if (method_exists($targetInstance, 'Play')) {
            $targetInstance->Play();
        } else {
            // メソッドが存在しなければ例外をThrow
            throw new \Exception($this->coreError('notfound_play'));
        }
    }

    /**
     * FindCallClass()
     *
     * 呼び出すクラスを決定する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    array   呼び出すクラスの情報等
     */
    private function FindCallClass()
    {
        // コンフィグファイルの読み込み
        $conf = new Conf;
        $conf->Parse(RISOLUTO_CONF . 'risoluto.ini');

        // デフォルトの情報をセット
        $load  = $conf->GetIni('SEQ', 'default');
        $param = '';

        // GETパラメタ中の情報（「seq」）が指定されていればそれを採用
        if (isset($_GET['seq']) and !empty($_GET['seq'])) {
            // 「.」が付いていたらそこで分割
            if (strpos('.', $_GET['seq']) === false) {
                $sep = explode('.', $_GET['seq']);

                // 分割後、1つめの要素は画面指定とみなし、2つめ以降の要素はパラメタと見なす
                $load = 'RisolutoApps\\' . $sep[0];

                unset($sep[0]);
                foreach ($sep as $dat) {
                    $param[] = $dat;
                }
                // 「.」が付いていなければそのまま採用する
            } else {
                $load  = 'RisolutoApps\\' . $_GET['seq'];
                $param = '';
            }

            // $load中の「_」を「\」に置換
            $load = str_replace('_', '\\', $load);

            // 指定されたアプリケーションが存在していなければエラーとする
            $target = RISOLUTO_APPS . str_replace('\\', DIRECTORY_SEPARATOR, $load) . '.php';
            clearstatcache(true);
            if (!file_exists($target) or !is_file($target) or !is_readable($target)) {
                $load  = $conf->GetIni('SEQ', 'error');
                $param = '';
            }
        }

        // サービスストップファイルが存在するかロードアベレージが一定値以上ならサービスストップ
        $loadavg = sys_getloadavg();
        clearstatcache(true);
        if (file_exists(RISOLUTO_SYSROOT . 'ServiceStop') or $loadavg[0] > $conf->GetIni('LIMITS', 'max_loadavg')) {
            $load  = $conf->GetIni('SEQ', 'servicestop');
            $param = '';
        }

        // 決定した情報を返却する
        $retval = array('load' => $load
        , 'param'              => $param);

        return $retval;
    }

    /**
     * CoreError($key = '')
     *
     * クラス内で発生したエラーに対するエラーメッセージを生成する
     *
     * @access    private
     *
     * @param     string $key なし
     *
     * @return    string    エラーメッセージ
     */
    private function CoreError($key = '')
    {
        // 引数の値に応じてエラーメッセージをセットする
        switch ($key) {
            // イニシャライズメソッド未定義エラーの場合
            case 'notfound_init':
                $msg = 'Required method is not exists - Init()';
                break;

            // コントローラメソッド未定義エラーの場合
            case 'notfound_play':
                $msg = 'Required method is not exists - Play*()';
                break;

            // エラーハンドリングメソッド未定義エラーの場合
            case 'notfound_error':
                $msg = 'Required method is not exists - Error()';
                break;

            // クリーニングメソッド未定義エラーの場合
            case 'notfound_clean':
                $msg = 'Required method is not exists - Clean()';
                break;

            // 未定義のエラーの場合
            default:
                $msg = 'Unknown Error occurred';
                break;
        }

        // ログ出力しエラーメッセージを返却
        $conf = new Conf;
        $conf->Parse(RISOLUTO_CONF . 'risoluto.ini');

        $log = new Log;
        $log->SetCurrentLogLevel($conf->GetIni('LOGGING', 'loglevel'));
        $log->Log('error', $msg);

        return $msg;
    }
}

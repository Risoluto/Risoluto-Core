<?php
/**
 * Risolutoコアクラス
 *
 * Risolutoの中核部分に関するメソッドが含まれているクラス
 *
 * @package   risoluto
 * @author    Risoluto Developers
 * @license   http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto\Core;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
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
     * @param     void    なし
     * @return    void    なし
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
            if(method_exists($targetInstance, 'Init')) {
                $targetInstance->Init($call['param']);
            } else {
                // メソッドが存在しなければ例外をThrow
                throw new Exception($this->coreError('notfound_init'));
            }

            // HTTPのメソッドに応じて適切なコントローラをコール
            switch($_SERVER['REQUEST_METHOD']) {
                // GETの場合
                case 'GET':
                    if(method_exists($targetInstance, 'PlayGet')) {
                        $targetInstance->PlayGet();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // POSTの場合
                case 'POST':
                    if(method_exists($targetInstance, 'PlayPost')) {
                        $targetInstance->PlayPost();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // PUTの場合
                case 'PUT':
                    if(method_exists($targetInstance, 'PlayPut')) {
                        $targetInstance->PlayPut();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // DELETEの場合
                case 'DELETE':
                    if(method_exists($targetInstance, 'PlayDelete')) {
                        $targetInstance->PlayDelete();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // OPTIONの場合
                case 'OPTION':
                    if(method_exists($targetInstance, 'PlayOption')) {
                        $targetInstance->PlayOption();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // HEADの場合
                case 'HEAD':
                    if(method_exists($targetInstance, 'PlayHead')) {
                        $targetInstance->PlayHead();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // TRACEの場合
                case 'TRACE':
                    if(method_exists($targetInstance, 'PlayTrace')) {
                        $targetInstance->PlayTrace();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // CONNECTの場合
                case 'CONNECT':
                    if(method_exists($targetInstance, 'PlayConnect')) {
                        $targetInstance->PlayConnect();
                    } elseif(method_exists($targetInstance, 'Play') {
                        $targetInstance->Play();
                    } else{
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;

                // デフォルトの場合
                default:
                    if(method_exists($targetInstance, 'Play')) {
                        $targetInstance->Play();
                    } else {
                        // メソッドが存在しなければ例外をThrow
                        throw new Exception($this->coreError('notfound_play'));
                    }
                    break;
            }
        } catch( Exception $e) {
            // エラーハンドリングメソッドをコール
            if(method_exists($targetInstance, 'Error')) {
                $targetInstance->Error($e);
            } else {
                // メソッドが存在しなければ強制終了
                die($this->coreError('notfound_error'));
            }
        } finally {
            // クリーニングメソッドをコール
            if(method_exists($targetInstance, 'Clean')) {
                $targetInstance->Clean();
            } else {
                // メソッドが存在しなければ強制終了
                die($this->coreError('notfound_clean'));
            }
        }
    } // end of function:run()

    /**
     * FindCallClass()
     *
     * クラス内で発生したエラーに対するエラーメッセージを生成する
     *
     * @access    private
     * @param     void    なし
     * @return    array   呼び出すクラスの情報等
     */
    private function FindCallClass()
    {
        // デフォルトの情報をセット
        $load  = 'RisolutoApps\\Default';
        $param = '';

        // GETパラメタ中の情報（「seq」）が指定されていればそれを採用
        if(isset($_GET['seq']) and !empty($_GET['seq'])) {
            // 「.」が付いていたらそこで分割
            $sep  = explode('.', $_GET['seq']);

            // 分割後、1つめの要素は画面指定とみなし、2つめの要素はパラメタと見なす
            $load  = 'RisolutoApps\\' . $sep[0];
            $param = (isset($sep[1]) ? $sep[1] : '');

            // 指定されたアプリケーションが存在していなければエラーとする
            $target = str_replace('RisolutoApps\\', RISOLUTO_APPS, str_replace('_', DIRECTORY_SEPARATOR, $load));
            clearstatcache(true);
            if(!file_exists($target) or !is_file($target) or !is_readable($target)) {
                $load  = 'RisolutoApps\\Error';
                $param = '';
            }
        }

        // 決定した情報を返却する
        $retval = array('load'  => $load
                       ,'param' => $param);
        return $retval;
    }

    /**
     * CoreError()
     *
     * クラス内で発生したエラーに対するエラーメッセージを生成する
     *
     * @access    private
     * @param     string    $key    なし
     * @return    string    エラーメッセージ
     */
    private function CoreError($key = '')
    {
        // エラーメッセージ本体の共通部分を初期値としてセット
        $msg = '[Risoluto:FATAL ERROR]';

        // 引数の値に応じてエラーメッセージをセットする
        switch($key) {
            // イニシャライズメソッド未定義エラーの場合
            case 'notfound_init':
                $msg .= 'Required method is not exists - Init()';
                break;

            // コントローラメソッド未定義エラーの場合
            case 'notfound_play':
                $msg .= 'Required method is not exists - Play*()';
                break;

            // エラーハンドリングメソッド未定義エラーの場合
            case 'notfound_error':
                $msg .= 'Required method is not exists - Error()';
                break;

            // クリーニングメソッド未定義エラーの場合
            case 'notfound_clean':
                $msg .= 'Required method is not exists - Clean()';
                break;

            // 未定義のエラーの場合
            default:
                $msg .= 'Unknown Error occurred';
                break;
        }

        // エラーメッセージを返却
        return $msg;
    }
}

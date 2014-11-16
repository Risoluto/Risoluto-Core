<?php
/**
 * Auth
 *
 * 認証のためのファンクション群
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

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Auth
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
     * getEncPass($target)
     *
     * 引数で与えられた文字列をパスワード用にハッシュ化する
     *
     * @access    private
     *
     * @param     string $target パスワード文字列
     *
     * @return    string ハッシュ化したパスワード文字列
     */
    private static function getEncPass($target)
    {
        return password_hash($target, PASSWORD_DEFAULT);
    }

    /**
     * getProvider()
     *
     * 認証プロバイダの情報を取得する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    object    認証プロバイダのインスタンス
     */
    private static function getProvider()
    {
        // コンフィグファイルの読み込み
        $conf = new Conf;
        $conf->parse(RISOLUTO_CONF . 'risoluto.ini');

        // プロバイダ情報を取得
        $tmp_provider = $conf->getIni('AUTH', 'provider');
        $provider     = !empty($tmp_provider) ? $tmp_provider : 'Risoluto\\AuthDb';

        // 取得したプロバイダのインスタンスを生成し返却する
        return ($provider);
    }

    /**
     * getBasicAuthDialog($realm, $message)
     *
     * BASIC認証のダイアログ表示用ヘッダを出力する
     *
     * @access    private
     *
     * @param     string $realm   レルム
     * @param     string $message ブラウザ側に出力するメッセージ
     *
     * @return    void なし
     */
    private static function getBasicAuthDialog($realm, $message)
    {
        // 認証に失敗したらダイアログ表示をセットし、強制終了
        header("WWW-Authenticate: Basic realm=\"$realm\"");
        http_response_code(401);
        echo $message;
        exit;
    }

    /**
     * getBasicAuthDialog($realm, $message)
     *
     * BASIC認証を行う
     *
     * @access    public
     *
     * @param     string $realm   レルム（省略可、デフォルトは'Authorization Required'）
     * @param     string $message ブラウザ側に出力するメッセージ（省略可、デフォルトは'Authorization Required'）
     *
     * @return    mixed ユーザ情報:認証成功時/false: 認証失敗時
     */
    public static function basicAuth($realm = 'Authorization Required', $message = 'Authorization Required')
    {
        // ユーザ情報とパスワード情報を取得する
        $user = isset($_SERVER['PHP_AUTH_USER']) and !empty($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
        $pass = isset($_SERVER['PHP_AUTH_PW']) and !empty($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;

        // 認証に必要な情報がセットされていれば認証ロジックをコール
        if ($user and $pass) {
            // プロバイダのインスタンスを取得し、認証ロジックをコール
            $call_provider = self::getProvider();
            $provider      = new $call_provider;

            // 認証に失敗したときはダイアログを出力
            /** @noinspection PhpUndefinedMethodInspection */
            if (!$provider->doAuth($user, $pass)) {
                self::getBasicAuthDialog($realm, $message);

                return false;
            } else {
                // 認証に成功したらユーザ情報を返却
                /** @noinspection PhpUndefinedMethodInspection */
                return $provider->doOperation('showuser', array('userid' => $user));
            }
        }

        // 認証に必要な情報がセットされていないときはダイアログを出力
        self::getBasicAuthDialog($realm, $message);

        return false;
    }

    /**
     * callProviderMethod()
     *
     * 認証プロバイダのメソッドをコールする
     *
     * @access    public
     *
     * @param     string $operation オペレーション識別子（init/addUser/addGroup/modUser/modGroup/delUser/delGroup/showUser/showGroup/showUserAll/showGroupAll）
     * @param     array  $option    オプション情報（省略可）
     *
     * @return    mixed trueまたは取得内容:成功/false:失敗
     */
    public static function callProviderMethod($operation, array $option = array())
    {
        // プロバイダのインスタンスを取得し、認証ロジックをコール
        $call_provider = self::getProvider();
        $provider      = new $call_provider;

        switch ($operation) {
            // 初期化
            case 'init':
                /** @noinspection PhpUndefinedMethodInspection */
                $retval = $provider->init();
                break;

            // 認証
            case 'doAuth':
                /** @noinspection PhpUndefinedMethodInspection */
                if (isset($option['userid']) and isset($option['password'])) {
                    // メソッドをコール
                    /** @noinspection PhpUndefinedMethodInspection */
                    $retval = $provider->doAuth($option['userid'], $option['password'], $option);
                } else {
                    $retval = false;
                }
                break;

            // ユーザ追加／変更
            case 'addUser': // FALL THRU
            case 'modUser':
                // パラメタのチェック
                if (isset($option['userid']) and isset($option['username']) and isset($option['password']) and isset($option['groupno'])) {
                    // パスワードをハッシュ化したのちメソッドをコール
                    $option['password'] = self::getEncPass($option['password']);
                    /** @noinspection PhpUndefinedMethodInspection */
                    $retval = $provider->doOperation($operation, $option);
                } else {
                    $retval = false;
                }
                break;

            // グループ追加／変更
            case 'addGroup': // FALL THRU
            case 'modGroup':
                // パラメタのチェック
                if (isset($option['groupid']) and isset($option['groupname'])) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $retval = $provider->doOperation($operation, $option);
                } else {
                    $retval = false;
                }
                break;

            // ユーザ削除／情報表示
            case 'delUser': // FALL THRU
            case 'showUser':
                // パラメタのチェック
                if (isset($option['userid'])) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $retval = $provider->doOperation($operation, $option);
                } else {
                    $retval = false;
                }
                break;

            // グループ削除／情報表示
            case 'delGroup': // FALL THRU
            case 'showGroup':
                // パラメタのチェック
                if (isset($option['groupid'])) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $retval = $provider->doOperation($operation, $option);
                } else {
                    $retval = false;
                }
                break;

            // ユーザ／グループ情報全件表示
            case 'showUserAll': // FALL THRU
            case 'showGroupAll':
                /** @noinspection PhpUndefinedMethodInspection */
                $retval = $provider->doOperation($operation, array());
                break;
            // 未定義の場合はfalseを返す
            default:
                $retval = false;
                break;
        }

        return $retval;
    }
}

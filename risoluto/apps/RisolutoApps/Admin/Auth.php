<?php
/**
 * Auth
 *
 * 認証処理を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Admin;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Auth extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
{
    /**
     * play()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function play()
    {
        // セッションをスタート
        $sess = new \Risoluto\Session();
        $sess->start();

        if ($sess->isThere('Auth')) {
            // 認証情報がある場合は、メニュー画面へ遷移する
            \Risoluto\Url::redirectTo('Admin_Menu');
            exit;
        } elseif (isset($_POST['userid']) and isset($_POST['password'])) {
            // 入力値を処理
            $option = array(
                'userid'   => htmlentities($_POST['userid'], ENT_QUOTES, 'UTF-8'),
                'password' => htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8')
            );

            // POSTでユーザIDとパスワードが渡ってきた場合は認証処理を行う
            $auth_result = \Risoluto\Auth::callProviderMethod('doAuth', $option);
            if ($auth_result) {
                // 認証に成功した場合は詳細情報を取得
                $detail                = \Risoluto\Auth::callProviderMethod('showUser', $option);
                $detail[0]['password'] = '********';
                $group                 = \Risoluto\Auth::callProviderMethod('showGroupByNo', array('no' => $detail[0]['groupno']));
                $detail[0]['group']    = $group[0];

                // 認証情報をセッションに追加してメニュー画面へ遷移する
                $sess->store('Auth', $detail[0]);
                $sess->store('csrf_token', $sess->genRand());
                \Risoluto\Url::redirectTo('Admin_Menu');
                exit;
            } else {
                // 認証に失敗した場合はエラー情報をセッションに追加してログイン画面に戻る
                $sess->store('AuthError', 'auth_failure');
                \Risoluto\Url::redirectTo('Admin_Login');
                exit;
            }
        } else {
            // それ以外の時はエラー情報をセッションに追加してログイン画面に戻る
            $sess->store('AuthError', 'invalid_access');
            \Risoluto\Url::redirectTo('Admin_Login');
            exit;
        }
    }
}
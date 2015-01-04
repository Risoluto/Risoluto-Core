<?php
/**
 * Login
 *
 * ログイン画面を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Admin;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class Login extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
{
    // View関連の処理を使用する
    use \Risoluto\RisolutoViewTrait;

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
        }

        $auth_error = '';
        if ($sess->isThere('AuthError')) {
            // 認証エラー情報がある場合は取得する
            $auth_error = $sess->load('AuthError');
            $sess->revoke('AuthError');
        }

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader($header, 'robots', 'NOINDEX,NOFOLLOW');

        // テンプレートエンジン関連の処理
        $assign_value = array('header' => $header, 'autherr' => $auth_error);
        $this->risolutoView($assign_value);
    }
}
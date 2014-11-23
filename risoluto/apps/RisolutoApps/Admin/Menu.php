<?php
/**
 * Menu
 *
 * メニュー画面を実現するためのクラス
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
class Menu extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
            // 認証情報がある場合は取得する
            $detail = $sess->Load('Auth');
        } else {
            // 認証情報がない場合はログイン画面へ遷移する
            $sess->store('AuthError', 'invalid_access');
            \Risoluto\Url::redirectTo('Admin_Login');
            exit;
        }

        // メニュータブ制御
        $params = $this->GetParam();
        if (!empty($params)) {
            $active_tab = htmlentities($params[0], ENT_QUOTES, 'UTF-8');
        } else {
            $active_tab = 'user';
        }
        $allow_admintab = ($detail['groupno'] == 1) ? true : false;

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader($header, 'robots', 'NOINDEX,NOFOLLOW');

        // テンプレートエンジン関連の処理
        $assign_value = array(
            'header'         => $header,
            'detail'         => $detail,
            'active_tab'     => $active_tab,
            'allow_admintab' => $allow_admintab);
        $this->risolutoView($assign_value);
    }
}
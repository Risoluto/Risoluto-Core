<?php
/**
 * ListUsers
 *
 * ユーザ一覧画面を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Admin\UserMng;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class ListUsers extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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

        // 共通処理クラスを呼び出し、必要な情報の取得等を行う
        $common = new \RisolutoApps\Admin\AdminCommon;
        $detail = $common->loginCheck($sess, true);
        $groups = $common->getGroupList('id_and_name');

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader($header, 'robots', 'NOINDEX,NOFOLLOW');

        // テンプレートエンジン関連の処理
        $assign_value = array(
            'header' => $header,
            'detail' => $detail,
            'list'   => \Risoluto\Auth::callProviderMethod('showUserAll'),
            'groups' => $groups
        );
        $this->risolutoView($assign_value);
    }
}
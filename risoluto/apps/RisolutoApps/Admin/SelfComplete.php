<?php
/**
 * SelfComplete
 *
 * ユーザ情報変更画面（完了）を実現するためのクラス
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
class SelfComplete extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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

        // 共通処理クラスを呼び出し
        $common  = new \RisolutoApps\Admin\AdminCommon;
        $detail  = $common->loginCheck($sess, true);
        $entered = $common->checkEnteredSelfData($_POST, $sess->load('csrf_token'), $detail['no']);

        // エラー情報があった場合は入力画面に戻る
        if (!empty($entered['error']['msg']) or !empty($entered['error']['form_crit'])) {
            // 入力情報はセッションに保存
            $sess->store('form', $entered);

            \Risoluto\Url::redirectTo('Admin_SelfEntry');
            exit;
        }

        // DBへの登録を行う
        $options = array(
            'by_who'   => $detail['no'] . ':' . $detail['userid'],
            'no'       => $detail['no'],
            'userid'   => $detail['userid'],
            'username' => $detail['username'],
            'password' => $entered['entered']['password'],
            'groupno'  => $detail['groupno'],
            'status'   => $detail['status']
        );
        $result  = \Risoluto\Auth::callProviderMethod('modUserByNo', $options);

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader($header, 'robots', 'NOINDEX,NOFOLLOW');

        // テンプレートエンジン関連の処理
        $assign_value = array(
            'header' => $header,
            'detail' => $detail,
            'result' => $result
        );
        $this->risolutoView($assign_value);
    }
}
<?php
/**
 * DelComplete
 *
 * グループ削除画面（完了）を実現するためのクラス
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoApps\Admin\GroupMng;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class DelComplete extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
        $common = new \RisolutoApps\Admin\AdminCommon;
        $detail = $common->loginCheck($sess, true);

        // セッションにフォーム入力情報が存在した場合は取得
        $entered = array();
        if ($sess->isThere('form')) {
            $entered = $sess->load('form');
            $sess->revoke('form');
        }

        // DBへの登録を行う
        $options = array(
            'no' => $entered['entered']['no']
        );
        $result  = \Risoluto\Auth::callProviderMethod('delGroupByNo', $options);

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
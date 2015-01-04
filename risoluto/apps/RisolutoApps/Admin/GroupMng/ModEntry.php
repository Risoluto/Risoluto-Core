<?php
/**
 * ModEntry
 *
 * グループ情報変更画面（入力）を実現するためのクラス
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
class ModEntry extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
     * @throws    \Exception フォームデータを取得できなかった場合はThrow
     */
    public function play()
    {
        // セッションをスタート
        $sess = new \Risoluto\Session();
        $sess->start();

        // 共通処理クラスを呼び出し
        $common = new \RisolutoApps\Admin\AdminCommon;
        $detail = $common->loginCheck($sess, true);

        if ($sess->isThere('form')) {
            // セッションにフォーム入力情報が存在した場合は取得
            $entered = $sess->load('form');
            $sess->revoke('form');
        } else {
            // 存在しない場合は例外をThrow
            throw new \Exception('Cannot get form data.');
        }

        // ヘッダ情報のセット
        $header = $this->getDefaultHeader();
        $header = $this->replaceHeader($header, 'robots', 'NOINDEX,NOFOLLOW');

        // テンプレートエンジン関連の処理
        $assign_value = array(
            'header'     => $header,
            'detail'     => $detail,
            'entered'    => $entered,
            'csrf_token' => $sess->load('csrf_token')
        );
        $this->risolutoView($assign_value);
    }
}
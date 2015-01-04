<?php
/**
 * ModPreload
 *
 * グループ情報変更処理を実現するためのクラス
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
class ModPreload extends \Risoluto\RisolutoControllerBase implements \Risoluto\RisolutoControllerInterface
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
     * @throws    \Exception 必須な情報が渡されていないか情報が取得できない場合はThrow
     */
    public function play()
    {
        // セッションをスタート
        $sess = new \Risoluto\Session();
        $sess->start();

        // 共通処理クラスを呼び出し
        $common = new \RisolutoApps\Admin\AdminCommon;
        /** @noinspection PhpUnusedLocalVariableInspection */
        $detail = $common->loginCheck($sess, true);

        $param = $this->getParam();
        if (is_numeric($param[0])) {
            // 引数値がセットされていれば、それを元に登録情報を呼び出す
            $target = \Risoluto\Auth::callProviderMethod('showGroupByNo', array('no' => $param[0]));
            if (empty($target)) {
                // 情報が取得できなかった場合も例外をThrow
                Throw new \Exception('Cannot load group data');
            }
        } else {
            // 指定されていなければ例外をThrowする
            Throw new \Exception('Require args not found');
        }

        // 情報が取得できたら整形してセッションに保存、入力画面へ遷移する
        $getVals['entered'] = array(
            'no'        => $target[0]['no'],
            'groupid'   => $target[0]['groupid'],
            'groupname' => $target[0]['groupname'],
            'status'    => $target[0]['status']
        );
        $sess->store('form', $getVals);
        \Risoluto\Url::redirectTo('Admin_GroupMng_ModEntry');
        exit;
    }
}
<?php
/**
 * AdminCommon
 *
 * Admin系共通処理処理を実現するためのクラス
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
class AdminCommon
{
    /**
     * loginCheck(\Risoluto\Session $sess, $admin = true)
     *
     * ログインチェック処理を行う
     *
     * @access    public
     *
     * @param     \Risoluto\Session $sess  セッションオブジェクト
     * @param     boolean           $admin 管理者権限必須か否か（true：必須、デフォルト／false：ログイン成功なら誰でもOK）
     *
     * @return    array      認証情報
     * @throws    \Exception 管理者権限必須の時に権限を持ってないユーザの場合はThrow
     */
    public function loginCheck(\Risoluto\Session $sess, $admin = true)
    {
        if ($sess->isThere('Auth')) {
            // 認証情報がある場合は取得する
            $detail = $sess->Load('Auth');

            if ($admin and $detail['groupno'] != 1) {
                // 管理者権限を持っていない場合はエラー
                throw new \Exception('Admin user required');
            } else {
                // 管理者権限を持っている場合はそのまま戻る
                return $detail;
            }
        } else {
            // 認証情報がない場合はログイン画面へ遷移する
            $sess->store('AuthError', 'invalid_access');
            \Risoluto\Url::redirectTo('Admin_Login');
            exit;
        }
    }

    /**
     * getGroupList($mode = '')
     *
     * グループリスト取得処理を行う
     *
     * @access    public
     *
     * @param     string $mode 取得モード（name_only / id_and_name）
     *
     * @return    array    取得したグループリスト
     */
    public function getGroupList($mode = '')
    {
        // まずはグループ情報を普通に取得
        $grouplist = \Risoluto\Auth::callProviderMethod('showGroupAll');
        $retval    = array();

        // 指定されたモードによって返却する配列を変える
        foreach ($grouplist as $dat) {
            switch ($mode) {
                case 'name_only':
                    $retval[$dat['no']] = $dat['groupname'];
                    break;

                case 'id_and_name': // FALL THRU
                default:
                    $retval[$dat['no']] = array('id' => $dat['groupid'], 'name' => $dat['groupname']);
                    break;
            }
        }

        // 処理結果を返却する
        return $retval;
    }

    /**
     * checkEnteredUserData($target, $csrf_token)
     *
     * 入力内容のチェック処理を行う
     *
     * @access    public
     *
     * @param     array   $target     チェック対象となるデータが格納された配列
     * @param     string  $csrf_token CSRF対策のためのトークン
     * @param     integer $selfno     自分自身のユーザno（省略可、省略された場合はユーザIDの重複チェック時に考慮）
     *
     * @return    array      チェック結果
     * @throws    \Exception CSRFトークンが一致しなかった場合はThrow
     */
    public function checkEnteredUserData($target, $csrf_token, $selfno = '')
    {
        // 戻り値を初期化
        $retval                       = array();
        $retval['entered']            = array();
        $retval['error']['msg']       = array();
        $retval['error']['form_crit'] = array();

        //--- ユーザIDのチェック
        $dup_master                  = \Risoluto\Auth::callProviderMethod('showUser', array('userid' => $target['userid']));
        $retval['entered']['userid'] = htmlentities($target['userid'], ENT_QUOTES, 'UTF-8');
        if (isset($target['userid']) and !empty($target['userid'])) {
            if (!empty($selfno)) {
                // 自分自身のユーザnoがセットされている場合は、重複データにそれが含まれていないかを確認する
                $retval['entered']['no'] = $selfno;
                $dups                    = array();
                foreach ($dup_master as $dat) {
                    if ($dat['no'] != $selfno) {
                        $dups[] = $dat;
                    }
                }
            } else {
                // セットされていない場合は取得したものをそのまま使う
                $dups = $dup_master;
            }

            // フォーマットチェック
            if (!preg_match('/[[:alnum:]\_\-\@\.]{1,255}/', $target['userid']) or count($dups) > 0) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_userid';
                $retval['error']['form_crit'][] = 'userid';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['userid']    = '';
            $retval['error']['msg'][]       = 'empty_userid';
            $retval['error']['form_crit'][] = 'userid';
        }

        //--- ユーザ名のチェック
        $retval['entered']['username'] = htmlentities($target['username'], ENT_QUOTES, 'UTF-8');
        if (isset($target['username']) and !empty($target['username'])) {
            // フォーマットチェック
            if (strlen($target['username']) > 255) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_username';
                $retval['error']['form_crit'][] = 'username';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['username']  = '';
            $retval['error']['msg'][]       = 'empty_username';
            $retval['error']['form_crit'][] = 'username';
        }

        //--- パスワードのチェック
        $retval['entered']['password']         = htmlentities($target['password'], ENT_QUOTES, 'UTF-8');
        $retval['entered']['password_confirm'] = $retval['entered']['password'];
        if (isset($target['password']) and !empty($target['password'])) {
            // フォーマットチェック
            if ($target['password'] != $target['password_confirm']) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_password';
                $retval['error']['form_crit'][] = 'password';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['password']         = '';
            $retval['entered']['password_confirm'] = '';
            $retval['error']['msg'][]              = 'empty_password';
            $retval['error']['form_crit'][]        = 'password';
        }

        //--- 所属グループのチェック
        $retval['entered']['groupno'] = htmlentities($target['groupno'], ENT_QUOTES, 'UTF-8');
        if (isset($target['groupno'])) {
            // フォーマットチェック
            if (!preg_match('/\d{1,}/', $target['groupno'])) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_groupno';
                $retval['error']['form_crit'][] = 'groupno';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['groupno']   = '';
            $retval['error']['msg'][]       = 'empty_groupno';
            $retval['error']['form_crit'][] = 'groupno';
        }

        //--- ステータスのチェック
        $retval['entered']['status'] = htmlentities($target['status'], ENT_QUOTES, 'UTF-8');
        if (isset($target['status'])) {
            // フォーマットチェック
            if (!preg_match('/\d{1,}/', $target['status'])) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_status';
                $retval['error']['form_crit'][] = 'status';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['status']    = '';
            $retval['error']['msg'][]       = 'empty_status';
            $retval['error']['form_crit'][] = 'status';
        }

        //--- CSRFトークンのチェック
        if ($target['csrf_token'] != $csrf_token) {
            throw new \Exception('CSRF Check Error');
        }

        // エラー関係の配列から重複を排除する
        $retval['error']['msg']       = array_unique($retval['error']['msg']);
        $retval['error']['form_crit'] = array_unique($retval['error']['form_crit']);

        // 処理結果を返却する
        return $retval;
    }

    /**
     * checkEnteredGroupData($target, $csrf_token)
     *
     * 入力内容のチェック処理を行う
     *
     * @access    public
     *
     * @param     array   $target     チェック対象となるデータが格納された配列
     * @param     string  $csrf_token CSRF対策のためのトークン
     * @param     integer $selfno     自分自身のユーザno（省略可、省略された場合はユーザIDの重複チェック時に考慮）
     *
     * @return    array      チェック結果
     * @throws    \Exception CSRFトークンが一致しなかった場合はThrow
     */
    public function checkEnteredGroupData($target, $csrf_token, $selfno = '')
    {
        // 戻り値を初期化
        $retval                       = array();
        $retval['entered']            = array();
        $retval['error']['msg']       = array();
        $retval['error']['form_crit'] = array();

        //--- グループIDのチェック
        $dup_master                   = \Risoluto\Auth::callProviderMethod('showGroup', array('groupid' => $target['groupid']));
        $retval['entered']['groupid'] = htmlentities($target['groupid'], ENT_QUOTES, 'UTF-8');
        if (isset($target['groupid']) and !empty($target['groupid'])) {
            if (!empty($selfno)) {
                // 自分自身のユーザnoがセットされている場合は、重複データにそれが含まれていないかを確認する
                $retval['entered']['no'] = $selfno;
                $dups                    = array();
                foreach ($dup_master as $dat) {
                    if ($dat['no'] != $selfno) {
                        $dups[] = $dat;
                    }
                }
            } else {
                // セットされていない場合は取得したものをそのまま使う
                $dups = $dup_master;
            }

            // フォーマットチェック
            if (!preg_match('/[[:alnum:]\_\-\@\.]{1,255}/', $target['groupid']) or count($dups) > 0) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_groupid';
                $retval['error']['form_crit'][] = 'groupid';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['groupid']   = '';
            $retval['error']['msg'][]       = 'empty_groupid';
            $retval['error']['form_crit'][] = 'groupid';
        }

        //--- グループ名のチェック
        $retval['entered']['groupname'] = htmlentities($target['groupname'], ENT_QUOTES, 'UTF-8');
        if (isset($target['groupname']) and !empty($target['groupname'])) {
            // フォーマットチェック
            if (strlen($target['groupname']) > 255) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_groupname';
                $retval['error']['form_crit'][] = 'groupname';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['groupname'] = '';
            $retval['error']['msg'][]       = 'empty_groupname';
            $retval['error']['form_crit'][] = 'groupname';
        }

        //--- ステータスのチェック
        $retval['entered']['status'] = htmlentities($target['status'], ENT_QUOTES, 'UTF-8');
        if (isset($target['status'])) {
            // フォーマットチェック
            if (!preg_match('/\d{1,}/', $target['status'])) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_status';
                $retval['error']['form_crit'][] = 'status';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['status']    = '';
            $retval['error']['msg'][]       = 'empty_status';
            $retval['error']['form_crit'][] = 'status';
        }

        //--- CSRFトークンのチェック
        if ($target['csrf_token'] != $csrf_token) {
            throw new \Exception('CSRF Check Error');
        }

        // エラー関係の配列から重複を排除する
        $retval['error']['msg']       = array_unique($retval['error']['msg']);
        $retval['error']['form_crit'] = array_unique($retval['error']['form_crit']);

        // 処理結果を返却する
        return $retval;
    }

    /**
     * checkEnteredSelfData($target, $csrf_token)
     *
     * 入力内容のチェック処理を行う
     *
     * @access    public
     *
     * @param     array   $target     チェック対象となるデータが格納された配列
     * @param     string  $csrf_token CSRF対策のためのトークン
     * @param     integer $no         ユーザ識別用のNo
     *
     * @return    array      チェック結果
     * @throws    \Exception CSRFトークンが一致しなかった場合はThrow
     */
    public function checkEnteredSelfData($target, $csrf_token, $no)
    {
        // 戻り値を初期化
        $retval                       = array();
        $retval['entered']            = array();
        $retval['error']['msg']       = array();
        $retval['error']['form_crit'] = array();

        //--- 現在のパスワードのチェック
        $retval['entered']['current_password'] = htmlentities($target['current_password'], ENT_QUOTES, 'UTF-8');
        $current_pw_db                         = \Risoluto\Auth::callProviderMethod('showUserByNo', array('no' => $no));
        if (isset($target['current_password']) and !empty($target['current_password'])) {
            // フォーマットチェック
            if (!password_verify($target['current_password'], $current_pw_db[0]['password'])) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_current_password';
                $retval['error']['form_crit'][] = 'current_password';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['current_password'] = '';
            $retval['error']['msg'][]              = 'empty_current_password';
            $retval['error']['form_crit'][]        = 'current_password';
        }

        //--- 変更後のパスワードのチェック
        $retval['entered']['password']         = htmlentities($target['password'], ENT_QUOTES, 'UTF-8');
        $retval['entered']['password_confirm'] = $retval['entered']['password'];
        if (isset($target['password']) and !empty($target['password'])) {
            // フォーマットチェック
            if ($target['password'] != $target['password_confirm']) {
                // フォーマットにそぐわない場合はエラーにする
                $retval['error']['msg'][]       = 'invalid_password';
                $retval['error']['form_crit'][] = 'password';
            }
        } else {
            // 未入力の場合はエラーにする
            $retval['entered']['password']         = '';
            $retval['entered']['password_confirm'] = '';
            $retval['error']['msg'][]              = 'empty_password';
            $retval['error']['form_crit'][]        = 'password';
        }

        //--- CSRFトークンのチェック
        if ($target['csrf_token'] != $csrf_token) {
            throw new \Exception('CSRF Check Error');
        }

        // エラー関係の配列から重複を排除する
        $retval['error']['msg']       = array_unique($retval['error']['msg']);
        $retval['error']['form_crit'] = array_unique($retval['error']['form_crit']);

        // 処理結果を返却する
        return $retval;
    }
}
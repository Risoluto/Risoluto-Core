<?php
/**
 * AuthManager
 *
 * Authクラスで使用するユーザやグループ情報を操作する
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoCli;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class AuthManager extends \Risoluto\RisolutoCliBase implements \Risoluto\RisolutoCliInterface
{
    /**
     * run()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     array $options オプション情報
     *
     * @return    void    なし
     */
    public function run(array $options)
    {
        // 引数がなければ使用方法を表示する
        if (empty($options) or (count($options) > 1)) {
            $this->usage();
            exit;
        }

        // 引数を分解し適切な処理を行う
        $operations = $this->separateOptions($options[0]);
        switch (strtolower($operations['command'])) {
            case 'init':
                $this->init();
                break;

            case 'adduser':
                $this->addUser();
                break;

            case 'addgroup':
                $this->addGroup();
                break;

            case 'moduser':
                $this->modUser();
                break;

            case 'modgroup':
                $this->modGroup();
                break;

            case 'deluser':
                $this->delUser();
                break;

            case 'delgroup':
                $this->delGroup();
                break;

            case 'showuser':
                $this->showUser();
                break;

            case 'showgroup':
                $this->showGroup();
                break;

            case 'showuserall':
                $this->showUserAll();
                break;

            case 'showgroupall':
                $this->showGroupAll();
                break;

            // 未定義なら使用方法を表示
            default :
                $this->usage();
                break;
        }
    }

    /**
     * init()
     *
     * 認証情報初期化処理を行う
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function init()
    {
        // 警告メッセージを表示し、承諾した場合のみ処理を実行する
        $enter = $this->readFromStdin("Delete all user/group data. Continue?[y/N]");
        if (strtolower($enter) == 'y') {
            if (\Risoluto\Auth::callProviderMethod('init', array())) {
                echo "All OK!" . PHP_EOL;
            } else {
                echo "Oops! Error happened." . PHP_EOL;
            }
        } else {
            echo "Canceled." . PHP_EOL;
        }
    }

    /**
     * addUser()
     *
     * ユーザー追加処理を行う
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function addUser()
    {
        // 登録に必要な情報を順番に取得していく
        $option['by_who'] = 'Risoluto CLI - ' . RISOLUTOCLI_SELF;
        $option['status'] = 1;

        do {
            $option['userid'] = $this->readFromStdin("Enter user id: ");
        } while (empty($option['userid']));
        do {
            $option['username'] = $this->readFromStdin("Enter user name: ");
        } while (empty($option['username']));
        do {
            $option['password']       = $this->readFromStdin("Enter user password: ", false);
            $option['password_again'] = $this->readFromStdin("Enter user password again: ", false);
        } while (empty($option['password']) or $option['password'] != $option['password_again']);
        do {
            $option['groupno'] = $this->readFromStdin("Enter group no: ");
        } while (empty($option['groupno']) or !is_numeric($option['groupno']));

        // 確認メッセージを表示し、承諾した場合のみ処理を実行する
        $enter = $this->readFromStdin("Add this user data. Continue?[y/N]");
        if (strtolower($enter) == 'y') {
            if (\Risoluto\Auth::callProviderMethod('addUser', $option)) {
                echo "All OK!" . PHP_EOL;
            } else {
                echo "Oops! Error happened." . PHP_EOL;
            }
        } else {
            echo "Canceled." . PHP_EOL;
        }
    }

    /**
     * addGroup()
     *
     * グループ追加処理を行う
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function addGroup()
    {
        // 登録に必要な情報を順番に取得していく
        $option['by_who'] = 'Risoluto CLI - ' . RISOLUTOCLI_SELF;
        $option['status'] = 1;

        do {
            $option['groupid'] = $this->readFromStdin("Enter group id: ");
        } while (empty($option['groupid']));
        do {
            $option['groupname'] = $this->readFromStdin("Enter group name: ");
        } while (empty($option['groupname']));

        // 確認メッセージを表示し、承諾した場合のみ処理を実行する
        $enter = $this->readFromStdin("Add this group data. Continue?[y/N]");
        if (strtolower($enter) == 'y') {
            if (\Risoluto\Auth::callProviderMethod('addGroup', $option)) {
                echo "All OK!" . PHP_EOL;
            } else {
                echo "Oops! Error happened." . PHP_EOL;
            }
        } else {
            echo "Canceled." . PHP_EOL;
        }
    }

    /**
     * modUser()
     *
     * ユーザー情報変更処理を行う
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function modUser()
    {
        // 変更処理に必要な情報を順番に取得していく
        $option['by_who'] = 'Risoluto CLI - ' . RISOLUTOCLI_SELF;

        do {
            $option['userid'] = $this->readFromStdin("Enter user id: ");
        } while (empty($option['userid']));
        do {
            $option['username'] = $this->readFromStdin("Enter user name: ");
        } while (empty($option['username']));
        do {
            $option['password']       = $this->readFromStdin("Enter user password: ", false);
            $option['password_again'] = $this->readFromStdin("Enter user password again: ", false);
        } while (empty($option['password']) or $option['password'] != $option['password_again']);
        do {
            $option['groupno'] = $this->readFromStdin("Enter group no: ");
        } while (empty($option['groupno']) or !is_numeric($option['groupno']));
        do {
            $option['status'] = $this->readFromStdin("Enter status: ");
        } while (!is_numeric($option['status']));

        // 確認メッセージを表示し、承諾した場合のみ処理を実行する
        $enter = $this->readFromStdin("Modify this user data. Continue?[y/N]");
        if (strtolower($enter) == 'y') {
            if (\Risoluto\Auth::callProviderMethod('modUser', $option)) {
                echo "All OK!" . PHP_EOL;
            } else {
                echo "Oops! Error happened." . PHP_EOL;
            }
        } else {
            echo "Canceled." . PHP_EOL;
        }
    }

    /**
     * modGroup()
     *
     * グループ情報変更処理を行う
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function modGroup()
    {
        // 変更処理に必要な情報を順番に取得していく
        $option['by_who'] = 'Risoluto CLI - ' . RISOLUTOCLI_SELF;

        do {
            $option['groupid'] = $this->readFromStdin("Enter group id: ");
        } while (empty($option['groupid']));
        do {
            $option['groupname'] = $this->readFromStdin("Enter group name: ");
        } while (empty($option['groupname']));
        do {
            $option['status'] = $this->readFromStdin("Enter status: ");
        } while (!is_numeric($option['status']));

        // 確認メッセージを表示し、承諾した場合のみ処理を実行する
        $enter = $this->readFromStdin("Modify this group data. Continue?[y/N]");
        if (strtolower($enter) == 'y') {
            if (\Risoluto\Auth::callProviderMethod('modGroup', $option)) {
                echo "All OK!" . PHP_EOL;
            } else {
                echo "Oops! Error happened." . PHP_EOL;
            }
        } else {
            echo "Canceled." . PHP_EOL;
        }
    }

    /**
     * delUser()
     *
     * ユーザー情報削除処理を行う
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function delUser()
    {
        // 削除に必要な情報を順番に取得していく
        do {
            $option['userid'] = $this->readFromStdin("Enter user id: ");
        } while (empty($option['userid']));

        // 確認メッセージを表示し、承諾した場合のみ処理を実行する
        $enter = $this->readFromStdin("Delete this user data. Continue?[y/N]");
        if (strtolower($enter) == 'y') {
            if (\Risoluto\Auth::callProviderMethod('delUser', $option)) {
                echo "All OK!" . PHP_EOL;
            } else {
                echo "Oops! Error happened." . PHP_EOL;
            }
        } else {
            echo "Canceled." . PHP_EOL;
        }
    }

    /**
     * delGroup()
     *
     * グループ情報削除処理を行う
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function delGroup()
    {
        // ユーザ登録に必要な情報を順番に取得していく
        do {
            $option['groupid'] = $this->readFromStdin("Enter group id: ");
        } while (empty($option['groupid']));

        // 確認メッセージを表示し、承諾した場合のみ処理を実行する
        $enter = $this->readFromStdin("Delete this group data. Continue?[y/N]");
        if (strtolower($enter) == 'y') {
            if (\Risoluto\Auth::callProviderMethod('delGroup', $option)) {
                echo "All OK!" . PHP_EOL;
            } else {
                echo "Oops! Error happened." . PHP_EOL;
            }
        } else {
            echo "Canceled." . PHP_EOL;
        }
    }

    /**
     * showUser()
     *
     * ユーザー情報を表示する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function showUser()
    {
        // 表示に必要な情報を順番に取得していく
        do {
            $option['userid'] = $this->readFromStdin("Enter user id: ");
        } while (empty($option['userid']));

        // 表示処理を呼び出す
        print_r(\Risoluto\Auth::callProviderMethod('showUser', $option));
    }

    /**
     * showGroup()
     *
     * グループ情報を表示する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function showGroup()
    {
        // 表示に必要な情報を順番に取得していく
        do {
            $option['groupid'] = $this->readFromStdin("Enter group id: ");
        } while (empty($option['groupid']));

        // 表示処理を呼び出す
        print_r(\Risoluto\Auth::callProviderMethod('showGroup', $option));
    }


    /**
     * showUserAll()
     *
     * ユーザー情報をすべて表示する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function showUserAll()
    {
        // 表示処理を呼び出す
        print_r(\Risoluto\Auth::callProviderMethod('showUserAll'));
    }

    /**
     * showGroupAll()
     *
     * グループ情報をすべて表示する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function showGroupAll()
    {
        // 表示処理を呼び出す
        print_r(\Risoluto\Auth::callProviderMethod('showGroupAll'));
    }

    /**
     * usage()
     *
     * 使用方法を表示する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    void    なし
     */
    private function usage()
    {
        // 引数がなければ使い方を表示する
        echo '[Risoluto AuthManager]' . PHP_EOL;
        echo 'Usage: php ' . RISOLUTOCLI_PGM . ' ' . RISOLUTOCLI_SELF . ' {COMMAND}' . PHP_EOL;
        echo PHP_EOL;
        echo '- COMMAND LIST -' . PHP_EOL;
        echo 'init         - Initialize user and group data.' . PHP_EOL;
        echo PHP_EOL;
        echo 'adduser      - Add new user' . PHP_EOL;
        echo 'addgroup     - Add new group' . PHP_EOL;
        echo 'moduser      - Modify user data' . PHP_EOL;
        echo 'modgroup     - Modify group data' . PHP_EOL;
        echo 'deluser      - Delete user' . PHP_EOL;
        echo 'delgroup     - Delete group' . PHP_EOL;
        echo PHP_EOL;
        echo 'showuser     - Show user data' . PHP_EOL;
        echo 'showgroup    - Show group data' . PHP_EOL;
        echo 'showuserall  - Show All user data' . PHP_EOL;
        echo 'showgroupall - Show All group data' . PHP_EOL;
    }
}
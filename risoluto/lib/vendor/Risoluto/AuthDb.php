<?php
/**
 * AuthDb
 *
 * BASIC認証のためのファンクション群（AuthProvider）
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2015 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class AuthDb implements \Risoluto\AuthProviderInterface
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * getSqlInitUserTbl()
     *
     * ユーザ情報テーブル初期化のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlInitUserTbl( $tablename )
    {
        $sql = <<<END_OF_SQL
DROP TABLE IF EXISTS $tablename;
CREATE TABLE IF NOT EXISTS $tablename
(
      `created_at`  DATETIME     NOT NULL
    , `created_by`  VARCHAR(255) NOT NULL
    , `modified_at` DATETIME     NOT NULL
    , `modified_by` VARCHAR(255) NOT NULL
    , `no`          INT UNSIGNED NOT NULL AUTO_INCREMENT
    , `userid`      VARCHAR(255) NOT NULL UNIQUE
    , `username`    VARCHAR(255) NOT NULL
    , `password`    VARCHAR(255) NOT NULL
    , `groupno`     INT UNSIGNED NOT NULL
    , `status`      TINYINT(1)   NOT NULL DEFAULT 1
    , PRIMARY KEY  (
                     `no`
                   )
) ENGINE=InnoDB CHARACTER SET utf8;

INSERT INTO $tablename(
      `created_at`
    , `created_by`
    , `modified_at`
    , `modified_by`
    , `no`
    , `userid`
    , `username`
    , `password`
    , `groupno`
    , `status`
) VALUES (
      now()
    , 'Risoluto AuthDb Init'
    , now()
    , 'Risoluto AuthDb Init'
    , 1
    , 'admin'
    , 'Risoluto Admin'
    , '$2y$10\$Z.74cnnXxRHjlUfDaVA/5e9wCTG7DzZ1fRFJQPwHjQYdVInSB0eKO'
    , 1
    , 1
);
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlInitGroupTbl()
     *
     * グループ情報テーブル初期化のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename グループ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlInitGroupTbl( $tablename )
    {
        $sql = <<<END_OF_SQL
DROP TABLE IF EXISTS $tablename;
CREATE TABLE IF NOT EXISTS $tablename
(
      `created_at`  DATETIME     NOT NULL
    , `created_by`  VARCHAR(255) NOT NULL
    , `modified_at` DATETIME     NOT NULL
    , `modified_by` VARCHAR(255) NOT NULL
    , `no`          INT UNSIGNED NOT NULL AUTO_INCREMENT
    , `groupid`     VARCHAR(255) NOT NULL UNIQUE
    , `groupname`   VARCHAR(255) NOT NULL
    , `status`      TINYINT(1)   NOT NULL DEFAULT 1
    , PRIMARY KEY  (
                     `no`
                   )
) ENGINE=InnoDB CHARACTER SET utf8;

INSERT INTO $tablename (
      `created_at`
    , `created_by`
    , `modified_at`
    , `modified_by`
    , `no`
    , `groupid`
    , `groupname`
    , `status`
) VALUES (
      now()
    , 'Risoluto AuthDb Init'
    , now()
    , 'Risoluto AuthDb Init'
    , 1
    , 'admin'
    , 'Risoluto Admin Group'
    , 1
);
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlAddUser()
     *
     * ユーザ追加のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlAddUser( $tablename )
    {
        $sql = <<<END_OF_SQL
INSERT INTO $tablename (
      `created_at`
    , `created_by`
    , `modified_at`
    , `modified_by`
    , `userid`
    , `username`
    , `password`
    , `groupno`
    , `status`
) values (
      now()
    , :by_who
    , now()
    , :by_who
    , :userid
    , :username
    , :password
    , :groupno
    , :status
);
END_OF_SQL;

        return $sql;
    }


    /**
     * getSqlAddGroup()
     *
     * グループ追加のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlAddGroup( $tablename )
    {
        $sql = <<<END_OF_SQL
INSERT INTO $tablename (
      `created_at`
    , `created_by`
    , `modified_at`
    , `modified_by`
    , `groupid`
    , `groupname`
    , `status`
) values (
      now()
    , :by_who
    , now()
    , :by_who
    , :groupid
    , :groupname
    , :status
);
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlModUser()
     *
     * ユーザ情報変更のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlModUser( $tablename )
    {
        $sql = <<<END_OF_SQL
UPDATE $tablename
   SET `modified_at` = now()
     , `modified_by` = :by_who
     , `username`    = :username
     , `password`    = :password
     , `groupno`     = :groupno
     , `status`      = :status
 WHERE `userid`      = :userid;
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlModGroup()
     *
     * グループ情報変更のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    初期化用SQL
     */
    private function getSqlModGroup( $tablename )
    {
        $sql = <<<END_OF_SQL
UPDATE $tablename
   SET `modified_at` = now()
     , `modified_by` = :by_who
     , `groupname`   = :groupname
     , `status`      = :status
 WHERE `groupid`     = :groupid;
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlModUserByNo()
     *
     * ユーザ情報変更のためのSQLを生成する（Noでの更新用）
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlModUserByNo( $tablename )
    {
        $sql = <<<END_OF_SQL
UPDATE $tablename
   SET `modified_at` = now()
     , `modified_by` = :by_who
     , `userid`      = :userid
     , `username`    = :username
     , `password`    = :password
     , `groupno`     = :groupno
     , `status`      = :status
 WHERE `no`          = :no;
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlModGroupByNo()
     *
     * グループ情報変更のためのSQLを生成する（Noでの更新用）
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    初期化用SQL
     */
    private function getSqlModGroupByNo( $tablename )
    {
        $sql = <<<END_OF_SQL
UPDATE $tablename
   SET `modified_at` = now()
     , `modified_by` = :by_who
     , `groupid`     = :groupid
     , `groupname`   = :groupname
     , `status`      = :status
 WHERE `no`          = :no;
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlDelUser()
     *
     * ユーザ情報削除のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    初期化用SQL
     */
    private function getSqlDelUser( $tablename )
    {
        $sql = <<<END_OF_SQL
DELETE FROM $tablename
 WHERE `userid` = :userid;
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlDelGroup()
     *
     * グループ情報削除のためのSQLを生成する（Noでの削除用）
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    初期化用SQL
     */
    private function getSqlDelGroup( $tablename )
    {
        $sql = <<<END_OF_SQL
DELETE FROM $tablename
 WHERE `groupid` = :groupid;
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlDelUserGroupByNo()
     *
     * ユーザ／グループ情報削除のためのSQLを生成する（Noでの削除用）
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    初期化用SQL
     */
    private function getSqlDelUserGroupByNo( $tablename )
    {
        $sql = <<<END_OF_SQL
DELETE FROM $tablename
 WHERE `no` = :no;
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlShowUserAll()
     *
     * ユーザ情報表示のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlShowUserAll( $tablename )
    {
        $sql = <<<END_OF_SQL
SELECT
       `created_at`
     , `created_by`
     , `modified_at`
     , `modified_by`
     , `no`
     , `userid`
     , `username`
     , `password`
     , `groupno`
     , `status`
 FROM $tablename
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlShowGroupAll()
     *
     * グループ情報表示のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename グループ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlShowGroupAll( $tablename )
    {
        $sql = <<<END_OF_SQL
SELECT
       `created_at`
     , `created_by`
     , `modified_at`
     , `modified_by`
     , `no`
     , `groupid`
     , `groupname`
     , `status`
 FROM $tablename
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlShowUser()
     *
     * ユーザ情報表示のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename ユーザ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlShowUser( $tablename )
    {
        $sql = <<<END_OF_SQL
SELECT
       `created_at`
     , `created_by`
     , `modified_at`
     , `modified_by`
     , `no`
     , `userid`
     , `username`
     , `password`
     , `groupno`
     , `status`
 FROM $tablename
WHERE `userid` = :userid
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlShowGroup()
     *
     * グループ情報表示のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename グループ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlShowGroup( $tablename )
    {
        $sql = <<<END_OF_SQL
SELECT
       `created_at`
     , `created_by`
     , `modified_at`
     , `modified_by`
     , `no`
     , `groupid`
     , `groupname`
     , `status`
 FROM $tablename
WHERE `groupid` = :groupid
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlShowUserByNo()
     *
     * Noでのユーザ情報表示のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename グループ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlShowUserByNo( $tablename )
    {
        $sql = <<<END_OF_SQL
SELECT
       `created_at`
     , `created_by`
     , `modified_at`
     , `modified_by`
     , `no`
     , `userid`
     , `username`
     , `password`
     , `groupno`
     , `status`
 FROM $tablename
WHERE `no` = :no
END_OF_SQL;

        return $sql;
    }

    /**
     * getSqlShowGroupByNo()
     *
     * noでのグループ情報表示のためのSQLを生成する
     *
     * @access    private
     *
     * @param     string $tablename グループ情報テーブル名
     *
     * @return    SQL
     */
    private function getSqlShowGroupByNo( $tablename )
    {
        $sql = <<<END_OF_SQL
SELECT
       `created_at`
     , `created_by`
     , `modified_at`
     , `modified_by`
     , `no`
     , `groupid`
     , `groupname`
     , `status`
 FROM $tablename
WHERE `no` = :no
END_OF_SQL;

        return $sql;
    }

    /**
     * getParams()
     *
     * DBアクセス用のパラメタ情報を取得する
     *
     * @access    private
     *
     * @param     string $type 識別子
     * @param     string $option オプション情報
     *
     * @return    array パラメタ情報が格納された配列
     */
    private function getParams( $type, $option )
    {
        // 識別子に応じて戻す配列を変更する
        switch ($type) {
            // ユーザ追加／更新向け
            case 'UserAddMod':
                $retval = [
                    [
                        'id' => ':by_who',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'by_who' ], 'Risoluto' ),
                        'type' => \PDO::PARAM_STR
                    ],
                    [ 'id' => ':userid', 'value' => $option[ 'userid' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':username', 'value' => $option[ 'username' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':password', 'value' => $option[ 'password' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':groupno', 'value' => $option[ 'groupno' ], 'type' => \PDO::PARAM_INT ],
                    [
                        'id' => ':status',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'status' ], 1, true ),
                        'type' => \PDO::PARAM_INT
                    ],
                ];
                break;

            // グループ追加／更新向け
            case 'GroupAddMod':
                $retval = [
                    [
                        'id' => ':by_who',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'by_who' ], 'Risoluto' ),
                        'type' => \PDO::PARAM_STR
                    ],
                    [ 'id' => ':groupid', 'value' => $option[ 'groupid' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':groupname', 'value' => $option[ 'groupname' ], 'type' => \PDO::PARAM_STR ],
                    [
                        'id' => ':status',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'status' ], 1, true ),
                        'type' => \PDO::PARAM_INT
                    ],
                ];
                break;

            // ユーザ更新（No使用）向け
            case 'UserModByNo':
                $retval = [
                    [
                        'id' => ':by_who',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'by_who' ], 'Risoluto' ),
                        'type' => \PDO::PARAM_STR
                    ],
                    [ 'id' => ':no', 'value' => $option[ 'no' ], 'type' => \PDO::PARAM_INT ],
                    [ 'id' => ':userid', 'value' => $option[ 'userid' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':username', 'value' => $option[ 'username' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':password', 'value' => $option[ 'password' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':groupno', 'value' => $option[ 'groupno' ], 'type' => \PDO::PARAM_INT ],
                    [
                        'id' => ':status',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'status' ], 1, true ),
                        'type' => \PDO::PARAM_INT
                    ],
                ];
                break;

            // グループ更新（No使用）向け
            case 'GroupModByNo':
                $retval = [
                    [
                        'id' => ':by_who',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'by_who' ], 'Risoluto' ),
                        'type' => \PDO::PARAM_STR
                    ],
                    [ 'id' => ':no', 'value' => $option[ 'no' ], 'type' => \PDO::PARAM_INT ],
                    [ 'id' => ':groupid', 'value' => $option[ 'groupid' ], 'type' => \PDO::PARAM_STR ],
                    [ 'id' => ':groupname', 'value' => $option[ 'groupname' ], 'type' => \PDO::PARAM_STR ],
                    [
                        'id' => ':status',
                        'value' => \Risoluto\Text::checkFalseVal( $option[ 'status' ], 1, true ),
                        'type' => \PDO::PARAM_INT
                    ],
                ];
                break;

            // ユーザIDのみ
            case 'UserID':
                $retval = [
                    [ 'id' => ':userid', 'value' => $option[ 'userid' ], 'type' => \PDO::PARAM_STR ],
                ];
                break;

            // グループIDのみ
            case 'GroupID':
                $retval = [
                    [ 'id' => ':groupid', 'value' => $option[ 'groupid' ], 'type' => \PDO::PARAM_STR ],
                ];
                break;

            // Noのみ
            case 'No':
                $retval = [
                    [ 'id' => ':no', 'value' => $option[ 'no' ], 'type' => \PDO::PARAM_INT ],
                ];
                break;

            // デフォルトの場合は空配列を返す
            default:
                $retval = [ ];
        }

        return $retval;
    }

    /**
     * getInfoFromConf()
     *
     * コンフィグから認証情報ファイルの情報を取得する
     *
     * @access    private
     *
     * @param     void
     *
     * @return    array 認証情報ファイルの情報
     */
    private function getInfoFromConf()
    {
        // コンフィグファイルの読み込み
        $conf = new Conf;
        $conf->parse( RISOLUTO_CONF . 'risoluto.ini' );

        // コンフィグファイルの読み込み
        $dbconf = new Conf;
        $dbconf->parse( RISOLUTO_CONF . 'risoluto_db.ini' );

        // コンフィグからファイル名情報を取得する
        return [
            'usertable' => $conf->getIni( "AUTH", "users" ),
            'grouptable' => $conf->getIni( "AUTH", "groups" ),
            'db' => $dbconf->getIni( "DB" )
        ];
    }

    /**
     * init()
     *
     * 認証情報保持テーブルの初期化を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    boolean true:成功/false:失敗
     */
    public function init()
    {
        // 情報を取得
        $info = $this->getInfoFromConf();

        // DBインスタンスを生成してDBに接続
        $retval = true;
        $instance = new \Risoluto\Db();
        if ($instance->connect( $info[ 'db' ] )) {
            if (!$instance->exec( $this->getSqlInitUserTbl( $info[ 'usertable' ] ) )) {
                $retval = false;
            }

            if (!$instance->exec( $this->getSqlInitGroupTbl( $info[ 'grouptable' ] ) )) {
                $retval = false;
            }

            // DB接続のクローズ
            if (!$instance->disConnect( true )) {
                $retval = false;
            }
        } else {
            $retval = false;
        }

        return $retval;
    }

    /**
     * doAuth($user, $pass, array $option = [])
     *
     * 認証を行う
     *
     * @access    public
     *
     * @param     string $user ユーザID
     * @param     string $pass パスワード
     * @param     array  $option オプション情報（省略可）
     *
     * @return    boolean true:認証成功/false:認証失敗
     */
    public function doAuth( $user, $pass, array $option = [ ] )
    {
        // ユーザ情報を取得
        $get_user = $this->doOperation( 'showUser', [ 'userid' => $user ] );

        // 複数権取得できた場合や無効なユーザの場合はエラー
        if (count( $get_user ) > 1 or $get_user[ 0 ][ 'status' ] != '1') {
            return false;
        } else {
            $auth_user = $get_user[ 0 ];
        }

        // DBから取得したユーザ情報のパスワードと引数で与えられたパスワードを比較する
        if (password_verify( $pass, $auth_user[ 'password' ] ) and $auth_user[ 'status' ] == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * doOperation(array $option = [])
     *
     * 認証情報操作に関する処理を行う
     *
     * @access    public
     *
     * @param     string $operation オペレーション識別子（addUser/addGroup/modUser/modGroup/delUser/delGroup/showUser/showGroup/showUserAll/showGroupAll）
     * @param     array  $option オプション情報（省略可）
     *
     * @return    mixed trueまたは取得内容:成功/false:失敗
     */
    public function doOperation( $operation, array $option = [ ] )
    {
        // 情報を取得
        $info = $this->getInfoFromConf();

        // DBインスタンスを生成してDBに接続
        $instance = new \Risoluto\Db();
        if ($instance->connect( $info[ 'db' ] )) {

            // オペレーション識別子に応じて処理を行う
            switch ($operation) {
                case 'addUser':
                    $get_data = $instance->doQuery( $this->getSqlAddUser( $info[ 'usertable' ] ),
                        $this->getParams( 'UserAddMod', $option ) );
                    break;

                case 'addGroup':
                    $get_data = $instance->doQuery( $this->getSqlAddGroup( $info[ 'grouptable' ] ),
                        $this->getParams( 'GroupAddMod', $option ) );
                    break;

                case 'modUser':
                    $get_data = $instance->doQuery( $this->getSqlModUser( $info[ 'usertable' ] ),
                        $this->getParams( 'UserAddMod', $option ) );
                    break;

                case 'modGroup':
                    $get_data = $instance->doQuery( $this->getSqlModGroup( $info[ 'grouptable' ] ),
                        $this->getParams( 'GroupAddMod', $option ) );
                    break;

                case 'modUserByNo':
                    $get_data = $instance->doQuery( $this->getSqlModUserByNo( $info[ 'usertable' ] ),
                        $this->getParams( 'UserModByNo', $option ) );
                    break;

                case 'modGroupByNo':
                    $get_data = $instance->doQuery( $this->getSqlModGroupByNo( $info[ 'grouptable' ] ),
                        $this->getParams( 'GroupModByNo', $option ) );
                    break;

                case 'delUser':
                    $get_data = $instance->doQuery( $this->getSqlDelUser( $info[ 'usertable' ] ),
                        $this->getParams( 'UserID', $option ) );
                    break;

                case 'delGroup':
                    $get_data = $instance->doQuery( $this->getSqlDelGroup( $info[ 'grouptable' ] ),
                        $this->getParams( 'GroupID', $option ) );
                    break;

                case 'delUserByNo':
                    $get_data = $instance->doQuery( $this->getSqlDelUserGroupByNo( $info[ 'usertable' ] ),
                        $this->getParams( 'No', $option ) );
                    break;

                case 'delGroupByNo':
                    $get_data = $instance->doQuery( $this->getSqlDelUserGroupByNo( $info[ 'grouptable' ] ),
                        $this->getParams( 'No', $option ) );
                    break;

                case 'showUser':
                    $get_data = $instance->doQuery( $this->getSqlShowUser( $info[ 'usertable' ] ),
                        $this->getParams( 'UserID', $option ) );
                    break;

                case 'showGroup':
                    $get_data = $instance->doQuery( $this->getSqlShowGroup( $info[ 'grouptable' ] ),
                        $this->getParams( 'GroupID', $option ) );
                    break;

                case 'showUserAll':
                    $get_data = $instance->doQuery( $this->getSqlShowUserAll( $info[ 'usertable' ] ) );
                    break;

                case 'showGroupAll':
                    $get_data = $instance->doQuery( $this->getSqlShowGroupAll( $info[ 'grouptable' ] ) );
                    break;

                case 'showUserByNo':
                    $get_data = $instance->doQuery( $this->getSqlShowUserByNo( $info[ 'usertable' ] ),
                        $this->getParams( 'No', $option ) );
                    break;

                case 'showGroupByNo':
                    $get_data = $instance->doQuery( $this->getSqlShowGroupByNo( $info[ 'grouptable' ] ),
                        $this->getParams( 'No', $option ) );
                    break;

                // 未定義の識別子の場合は無条件でfalseを返す
                default:
                    $get_data = false;
            }

            // 戻り値をチェック
            if ($get_data === false) {
                $retval = false;
            } else {
                // 表示系のものについては戻り値がfalseでないものはtrue扱いにする
                switch ($operation) {
                    case 'showUser':
                    case 'showGroup':
                    case 'showUserAll':
                    case 'showGroupAll':
                    case 'showUserByNo':
                    case 'showGroupByNo':
                        $retval = $get_data;
                        break;

                    default:
                        $retval = true;
                        break;
                }
            }

            // DB接続のクローズ
            if (!$instance->disConnect( true )) {
                $retval = false;
            }
        } else {
            $retval = false;
        }

        return $retval;
    }
}

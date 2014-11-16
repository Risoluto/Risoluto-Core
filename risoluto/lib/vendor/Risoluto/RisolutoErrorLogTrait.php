<?php
/**
 * RisolutoErrorLogTrait
 *
 * エラーログ出力用メソッドTrait
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace Risoluto;

trait RisolutoErrorLogTrait
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//

    /**
     * risolutoErrorLog($loglevel, $msg)
     *
     * エラーログを出力する
     *
     * @access    private
     *
     * @param     string $loglevel 出力するメッセージのログレベル
     * @param     string $msg      出力するメッセージ
     *
     * @return    boolean 常にTrue
     */
    private function risolutoErrorLog($loglevel, $msg)
    {
        // ログ出力しエラーメッセージを返却
        $conf = new Conf;
        $conf->parse(RISOLUTO_CONF . 'risoluto.ini');

        $log = new Log;
        $log->setCurrentLogLevel($conf->getIni('LOGGING', 'loglevel'));
        $log->log($loglevel, $msg);
    }
}
<?php
/**
 * SampleCli
 *
 * RisolutoのCLIプログラムサンプル
 *
 * @package           risoluto
 * @author            Risoluto Developers
 * @license           http://opensource.org/licenses/bsd-license.php new BSD license
 * @copyright     (C) 2008-2014 Risoluto Developers / All Rights Reserved.
 */

//------------------------------------------------------//
// 名前空間の定義
//------------------------------------------------------//
namespace RisolutoCli;

//------------------------------------------------------//
// クラス定義
//------------------------------------------------------//
class SampleCli extends \Risoluto\RisolutoCliBase implements \Risoluto\RisolutoCliInterface
{
    /**
     * run()
     *
     * 主処理を行う
     *
     * @access    public
     *
     * @param     void
     *
     * @return    void    なし
     */
    public function run(array $options)
    {
        var_dump($options);
    }
}
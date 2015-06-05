<?php
/**
 * RisolutoCliInterface
 *
 * Cliユーザアプリ用インタフェース定義
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

interface RisolutoCliInterface
{
    public function run( array $param );
}

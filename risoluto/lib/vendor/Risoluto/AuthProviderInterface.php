<?php
/**
 * AuthProviderInterface
 *
 * 認証provider用インタフェース定義
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

interface AuthProviderInterface
{
    public function init();

    public function doAuth($user, $pass, array $option = array());

    public function doOperation($operation, array $option = array());
}

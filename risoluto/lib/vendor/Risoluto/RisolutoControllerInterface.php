<?php
/**
 * RisolutoControllerInterface
 *
 * ユーザアプリ向けコントローラ用インタフェース定義
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

interface RisolutoControllerInterface
{
    public function Init(array $param);

    public function Play();

    public function Error(\Exception $errobj);

    public function Clean();
}

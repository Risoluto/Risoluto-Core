<?php
/**
 * Validate
 *
 * データ検証のためのファンクション群
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

class Validate
{
    //------------------------------------------------------//
    // クラスメソッド定義
    //------------------------------------------------------//
    /**
     * __construct()
     *
     * コンストラクタ
     */
    private function __construct()
    {
    }

    /**
     * isEmailAddr($value)
     *
     * 引数で指定された値がメールアドレスのフォーマットと合致しているか判定する
     *
     * @access    public
     *
     * @param     string $value 検査対象となる値
     *
     * @return    boolean    判定結果（true/false）
     */
    public static function isEmailAddr($value)
    {
        return (preg_match('/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i', $value)) ? (true) : (false);
    }

    /**
     * isHalfWidth($value)
     *
     * 引数で指定された値が半角文字列のみで構成されているか判定する
     *
     * @access    public
     *
     * @param     string $value 検査対象となる値
     *
     * @return    boolean    判定結果（true/false）
     */
    public static function isHalfWidth($value)
    {
        return (strlen($value) == mb_strlen($value, 'UTF-8')) ? (true) : (false);
    }

    /**
     * isLeapYear($value)
     *
     * 引数で指定された値が閏年であるか判定する
     *
     * @access    public
     *
     * @param     string $value 検査対象となる値
     *
     * @return    boolean    判定結果（true/false）
     */
    public static function isLeapYear($value)
    {
        // 引数が4桁の整数値でなければ無条件でfalseを返却する
        if ((strlen($value) != 4) or (!is_numeric($value))) {
            return false;
        }

        // 4で割り切れる年は閏年、100で割り切れる年は閏年じゃないが400で割り切れれば閏年
        if (($value % 4) == 0 and ($value % 100) != 0 or ($value % 400) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * isBetween($value, $lowerval, $upperval)
     *
     * 引数で指定された値が引数で指定された下限値及び上限値の範囲内にあるかを判定する
     *
     * @access    public
     *
     * @param     string $value    検査対象となる値
     * @param     string $lowerval 下限値
     * @param     string $upperval 上限値
     *
     * @return    boolean    判定結果（true/false）
     */
    public static function isBetween($value, $lowerval, $upperval)
    {
        // 下限値から上限値の範囲内ならtrueを返却（下限値／上限値自体も範囲に含む）
        if (($lowerval <= $value) and ($upperval >= $value)) {
            return true;
        } else {
            return false;
        }
    }
}
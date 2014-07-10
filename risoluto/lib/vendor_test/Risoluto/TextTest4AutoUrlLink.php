<?php
/**
 * TextTest4AutoUrlLink
 *
 * Text::AutoUrlLink用テストケース
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

//------------------------------------------------------//
// テストクラス定義
//------------------------------------------------------//
class TextTest4AutoUrlLink extends \PHPUnit_Framework_TestCase
{
    //------------------------------------------------------//
    // テストメソッド定義
    //------------------------------------------------------//
    /**
     * setUp()
     *
     * テストに必要な準備を実施
     */
    protected function setUp()
    {
    }

    /**
     * test_AutoUrlLink_WithNoLinks()
     *
     * AutoUrlLink()の挙動をテストする（URLが含まれないテキストの場合）
     */
    public function test_AutoUrlLink_WithNoLinks()
    {
        $test = '<p>Risoluto is PHP Framework.</p>';
        $want = '<p>Risoluto is PHP Framework.</p>';

        $this->assertEquals(Text::AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpLink()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が１つだけ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithOneHttpLink()
    {
        $test = '<p>See: http://www.example.com/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\' target=\'_blank\'>http://www.example.com/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpsLink()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が１つだけ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithOneHttpsLink()
    {
        $test = '<p>See: https://www.example.com/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\' target=\'_blank\'>https://www.example.com/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpLinks()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が２つ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithTwoHttpLinks()
    {
        $test = '<p>See: http://www.example.com/ and http://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\' target=\'_blank\'>http://www.example.com/</a> and <a href=\'http://www.example.org/\' target=\'_blank\'>http://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpsLinks()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が２つ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithTwoHttpsLinks()
    {
        $test = '<p>See: https://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\' target=\'_blank\'>https://www.example.com/</a> and <a href=\'https://www.example.org/\' target=\'_blank\'>https://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithHttpAndHttpLinks()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～とhttps://～）が２つ含まれるテキストの場合）
     */
    public function test_AutoUrlLink_WithHttpAndHttpLinks()
    {
        $test = '<p>See: http://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\' target=\'_blank\'>http://www.example.com/</a> and <a href=\'https://www.example.org/\' target=\'_blank\'>https://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test), $want);
    }

    /**
     * test_AutoUrlLink_WithNoLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URLが含まれないテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithNoLinks_WithoutNewWindow()
    {
        $test = '<p>Risoluto is PHP Framework.</p>';
        $want = '<p>Risoluto is PHP Framework.</p>';

        $this->assertEquals(Text::AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow()
    {
        $test = '<p>See: http://www.example.com/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\'>http://www.example.com/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow()
    {
        $test = '<p>See: https://www.example.com/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\'>https://www.example.com/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow()
    {
        $test = '<p>See: http://www.example.com/ and http://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\'>http://www.example.com/</a> and <a href=\'http://www.example.org/\'>http://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow()
    {
        $test = '<p>See: https://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'https://www.example.com/\'>https://www.example.com/</a> and <a href=\'https://www.example.org/\'>https://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～とhttps://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF）
     */
    public function test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow()
    {
        $test = '<p>See: http://www.example.com/ and https://www.example.org/</p>';
        $want = '<p>See: <a href=\'http://www.example.com/\'>http://www.example.com/</a> and <a href=\'https://www.example.org/\'>https://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false), $want);
    }

    /**
     * test_AutoUrlLink_WithNoLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URLが含まれないテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithNoLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>Risoluto is PHP Framework.</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>Risoluto is PHP Framework.</p>';

        $this->assertEquals(Text::AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithOneHttpLink_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: http://www.example.com/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'http://www.example.com/\' class=\'dummy\'>http://www.example.com/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が１つだけ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithOneHttpsLink_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: https://www.example.com/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'https://www.example.com/\' class=\'dummy\'>https://www.example.com/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithTwoHttpLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: http://www.example.com/ and http://www.example.org/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'http://www.example.com/\' class=\'dummy\'>http://www.example.com/</a> and <a href=\'http://www.example.org/\' class=\'dummy\'>http://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（https://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithTwoHttpsLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: https://www.example.com/ and https://www.example.org/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'https://www.example.com/\' class=\'dummy\'>https://www.example.com/</a> and <a href=\'https://www.example.org/\' class=\'dummy\'>https://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false, $attr), $want);
    }

    /**
     * test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow_WithExtraAttr()
     *
     * AutoUrlLink()の挙動をテストする（URL（http://～とhttps://～）が２つ含まれるテキストの場合、新規ウインドウモードOFF、アトリビュート有り）
     */
    public function test_AutoUrlLink_WithHttpAndHttpsLinks_WithoutNewWindow_WithExtraAttr()
    {
        $test = '<p>See: http://www.example.com/ and https://www.example.org/</p>';
        $attr = 'class=\'dummy\'';
        $want = '<p>See: <a href=\'http://www.example.com/\' class=\'dummy\'>http://www.example.com/</a> and <a href=\'https://www.example.org/\' class=\'dummy\'>https://www.example.org/</a></p>';

        $this->assertEquals(Text::AutoUrlLink($test, false, $attr), $want);
    }
}
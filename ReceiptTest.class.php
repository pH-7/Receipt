<?php
/**
 * @author           Pierre-Henry Soria <pierrehenrysoria@gmail.com>
 * @copyright        (c) 2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @link             http://github.com/pH-7/
 */

require 'Receipt.class.php';
require 'vendor/autoload.php'; // Include PHPUnit from Composer in order to respect TDD principles

class ReceiptTest extends PHPUnit_Framework_TestCase
{

    private $_oReceipt;

    public function __construct()
    {
        $this->_oReceipt = new Receipt('baskets.data.php');
    }

    public function testSalesTaxes()
    {
        $aExpected = array(1.5, 7.63, 6.66);

        $this->_oReceipt->retrieve();
        $fRes = $this->_oReceipt->getSaleTax();
        $this->assertEquals(true, in_array($fRes, $aExpected));
    }

}

try
{
    $oReceiptText = new ReceiptTest;

    $oReceiptText->testSalesTaxes();
}
catch(Exception $oExcept)
{
    echo $oExcept->getMessage();
}

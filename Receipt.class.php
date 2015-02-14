<?php
/**
 * @author           Pierre-Henry Soria <pierrehenrysoria@gmail.com>
 * @copyright        (c) 2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @link             http://github.com/pH-7/
 */

class Receipt
{

    private $_sRet = '', $_aContents, $_fTaxAmount, $_fTotalAmount;

    /**
     * Get the receipts
     *
     * @return string
     */
    public function __construct($sBasketPath)
    {
        $this->_aContents = include($sBasketPath);
    }

    public function __toString()
    {
        return $this->retrieve();
    }

    public function retrieve()
    {
        foreach ($this->_aContents as $aIds)
        {
            $this->_fTaxAmount = $this->_fTotalAmount = 0; // Initialize the values

            foreach ($aIds as $iId => $aId)
            {
                $iTaxPercent = 0;

                if (!$this->isExcepted($aId['type']))
                {
                    $this->_fTaxAmount += $aId['price']*0.10; // Because it is Tax, we have to do "0.10" and not "*10/100", otherwise the result may be wrong
                    $iTaxPercent += 0.10;
                }

                if ($aId['is_imported']) // If the item is imported, it adds 5% of additional tax
                {
                    $this->_fTaxAmount += $aId['price']*0.05;
                    $iTaxPercent += 0.05;
                }

                $this->_fTotalAmount += $aId['price'];
                $this->_sRet .= $aId['quantity'] . ' ' . $aId['item'] . ': ' . $this->round($aId['price']+= $aId['price']*$iTaxPercent) . "\n\r";
            }

            $this->_outputDesign();
        }

        return $this->_sRet;
    }

    protected function isExcepted($sType)
    {
        return ($sType == 'book' || $sType == 'medical' || $sType == 'food');
    }

    protected function round($fPrice)
    {
        return round($fPrice, 2, PHP_ROUND_HALF_UP);
    }

    public function getSaleTax()
    {
        return $this->round($this->getTaxAmount()); // Round the amount
    }

    public function getTaxAmount()
    {
        return $this->_fTaxAmount;
    }

    public function getTotalAmount()
    {
        return $this->_fTotalAmount;
    }

    private function _outputDesign()
    {
        $this->_sRet .= 'Sales Taxes: ' . $this->getSaleTax() . "\n\r";
        $this->_sRet .= 'Total: ' . ($this->getTotalAmount()+$this->getSaleTax()) . "\n\r";
        $this->_sRet .= "\n\r ---------- \n\r";
    }

}

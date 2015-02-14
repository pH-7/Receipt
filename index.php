<?php
/**
 * @author           Pierre-Henry Soria <pierrehenrysoria@gmail.com>
 * @copyright        (c) 2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @link             http://github.com/pH-7/
 */

require 'Receipt.class.php';

echo '<div style="align:center">' . nl2br(new Receipt('baskets.data.php')) . '</div>';

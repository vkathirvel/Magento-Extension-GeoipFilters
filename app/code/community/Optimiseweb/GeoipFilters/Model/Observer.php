<?php

/**
 * Optimiseweb GeoipFilters Model Redirector
 *
 * @package     Optimiseweb_GeoipFilters
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_GeoipFilters_Model_Observer extends Varien_Object
{

    public function paymentMethodIsActive($evt)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $developmentMode = TRUE;
        if ($developmentMode) {
            if (isset($ip) AND ( $ip == '188.39.236.202')) {
                $developmentMode = TRUE;
            } else {
                $developmentMode = FALSE;
            }
        }

        $event = $evt->getEvent();
        $requestUrl = $event->getRequestUrl();

        $method = $event->getMethodInstance();
        $quote = $event->getQuote();
        $result = $event->getResult();

        if ($developmentMode) {
            $country_code_geoip = Mage::helper('aligent_geoip')->autodetectCountry();
            if (($method->getCode() == 'sagepayserver') OR ( $method->getCode() == 'sagepaydirectpro')) {
                if ($quote->getBillingAddress()->getCountryId() != 'GB') {
                    $result->isAvailable = false;
                }
            }
        }

        /*
          foreach ($quote->getAllItems() as $item) {
          if ($item->getProductType() == 'YourProductType') {

          }
          }
         */
    }
}

<?php

namespace Nails\Analytics\Driver;

use Nails\Analytics\Driver\HotJar\Settings;
use Nails\Analytics\Interfaces;
use Nails\Common\Driver\Base;
use Nails\Common\Service\Asset;
use Nails\Environment;
use Nails\Factory;

class HotJar extends Base implements Interfaces\Driver
{
    /**
     * @return \Nails\Analytics\Interfaces\Driver
     * @throws \Nails\Common\Exception\AssetException
     * @throws \Nails\Common\Exception\FactoryException
     */
    public function boot(): Interfaces\Driver
    {
        $aEnvironment = $this->getSetting(Settings\HotJar::KEY_ENVIRONMENTS);
        if (!in_array(Environment::get(), $aEnvironment)) {
            return $this;
        }

        /** @var Asset $oAsset */
        $oAsset = Factory::service('Asset');

        $sProfileId = trim($this->getSetting(Settings\HotJar::KEY_PROFILE_ID));

        if (!empty($sProfileId)) {
            $oAsset
                ->inline(
                    "(function(h,o,t,j,a,r){
                    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                    h._hjSettings={hjid:" . $sProfileId . ",hjsv:6};
                    a=o.getElementsByTagName('head')[0];
                    r=o.createElement('script');r.async=1;
                    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                    a.appendChild(r);
                    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');",
                    $oAsset::TYPE_JS_INLINE_HEADER
                );
        }

        return $this;
    }
}

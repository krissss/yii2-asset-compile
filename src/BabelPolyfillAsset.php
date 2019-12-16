<?php

namespace kriss\assetCompile;

use yii\web\AssetBundle;

class BabelPolyfillAsset extends AssetBundle
{
    public $sourcePath = '@npm/@babel/polyfill/dist';

    public function init()
    {
        if ($this->isNeed()) {
            $this->js[] = 'polyfill.min.js';
        }
        parent::init();
    }

    protected function isNeed()
    {
        return preg_match('/MSIE|Trident/i', $_SERVER['HTTP_USER_AGENT']);
    }
}

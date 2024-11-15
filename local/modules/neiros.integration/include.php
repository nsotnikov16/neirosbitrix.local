<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;

if (!function_exists('addNeirosScript')) {
    function addNeirosScript()
    {
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        if ($request->isAdminSection()) return;

        $module_id = pathinfo(__DIR__)['basename'];
        $neiros_counter_id = Option::get($module_id, 'id_counter', '');

        if (!$neiros_counter_id) return;

        $file_script_path = __DIR__ . '/include/script_counter.html';

        if (!file_exists($file_script_path)) return;

        $script = file_get_contents($file_script_path);
        $script = str_replace('#id_counter#', $neiros_counter_id, $script);

        Asset::getInstance()->addString(
            $script,
            true,
            AssetLocation::BODY_END
        );
    }
}

addNeirosScript();

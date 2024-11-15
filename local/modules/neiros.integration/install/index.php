<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class neiros_integration extends CModule
{
    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . "/version.php");

        $this->MODULE_ID = "neiros.integration";
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("MODULE_DESCRIPTION");

        $this->PARTNER_NAME = Loc::getMessage("PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("PARTNER_URI");
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if ($this->isVersionD7()) {
            ModuleManager::registerModule($this->MODULE_ID);
            $this->installDB();
            $this->installFiles();
            $this->installEvents();
            $this->registerAgent();
        } else {
            $APPLICATION->ThrowException(Loc::getMessage('MODULE_D7_REQUIRED'));
        }
    }

    public function DoUninstall()
    {
        $this->unregisterAgent();
        $this->uninstallEvents();
        $this->uninstallFiles();
        $this->uninstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function installDB()
    {
        return true;
    }

    public function uninstallDB($arParams = array())
    {
        COption::RemoveOption($this->MODULE_ID, 'id_counter');
        return true;
    }

    public function installFiles() {}

    public function uninstallFiles() {}

    public function installEvents() {}

    public function uninstallEvents() {}

    public function registerAgent() {}

    public function unregisterAgent() {}

    private function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion("main"), "14.00.00");
    }
}

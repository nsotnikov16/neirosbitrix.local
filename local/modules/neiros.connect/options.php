<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialchars($request->get('mid'));
Loader::includeModule($module_id);
$currentUrl = $APPLICATION->getCurPage() . '?mid=' . $module_id . '&lang=' . LANGUAGE_ID . '&mid_menu=' . $request->get('mid_menu');
$message = null;
$arError = [];

if ($request->isPost()) {
    Option::set($module_id, 'id_counter', $request->get('id_counter'));
    LocalRedirect($currentUrl);
}

if (isset($message) && $message)
    echo $message->Show();

$aTabs = array(
    array("DIV" => "tab1", "TAB" => Loc::getMessage("NEIROS_OPTIONS_TAB_GENERAL"), "TITLE" => Loc::getMessage("NEIROS_OPTIONS_TAB_GENERAL"))
);

$form = new CAdminForm("neiros_form", $aTabs);

$form->Begin([
    "FORM_ACTION" => $_SERVER['REQUEST_URI'],
]);

$form->BeginNextFormTab();

bitrix_sessid_post();

$form->BeginCustomField("MESSAGE", Loc::getMessage("NEIROS_OPTIONS_MESSAGE")); ?>
<tr>
    <td width="100%" colspan="2">
        <p style="margin: 0 auto;"><? echo $form->GetCustomLabel(false, '') ?></p>
    </td>
</tr>
<?
$form->EndCustomField("ID", '');

$form->AddEditField("id_counter", Loc::getMessage("NEIROS_OPTIONS_ID_COUNTER"), true, [], Option::get($module_id, 'id_counter', ''));
$form->Buttons(["back_url" => $APPLICATION->GetCurPage(), 'btnApply' => false]);
$form->Show();
$form->EndTab();
$form->End();

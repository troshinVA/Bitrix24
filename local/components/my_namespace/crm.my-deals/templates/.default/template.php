<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
?>

<div class="crm-preview">
    <table class="crm-preview-info">
        <?php foreach ($arResult as $row) { ?>
            <tr>
                <td><?php print_r($row['TITLE']); ?></td>
                <td><?php print_r($row['CONTACT_FULL_NAME']); ?> </td>
                <td><?php print_r($row['COMPANY_TITLE']); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(11, "mci_Cate1logo", $Language->MenuPhrase("11", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mi_clase_cuenta", $Language->MenuPhrase("1", "MenuText"), "clase_cuentalist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mi_grupo_cuenta", $Language->MenuPhrase("5", "MenuText"), "grupo_cuentalist.php?cmd=resetall", 1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(10, "mi_subgrupo_cuenta", $Language->MenuPhrase("10", "MenuText"), "subgrupo_cuentalist.php?cmd=resetall", 5, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mi_cuenta_mayor_auxiliar", $Language->MenuPhrase("3", "MenuText"), "cuenta_mayor_auxiliarlist.php?cmd=resetall", 10, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mi_cuenta_mayor_principal", $Language->MenuPhrase("4", "MenuText"), "cuenta_mayor_principallist.php?cmd=resetall", 3, "", TRUE, FALSE);
$RootMenu->AddMenuItem(9, "mi_subcuenta", $Language->MenuPhrase("9", "MenuText"), "subcuentalist.php?cmd=resetall", 4, "", TRUE, FALSE);
$RootMenu->AddMenuItem(6, "mi_pais", $Language->MenuPhrase("6", "MenuText"), "paislist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(12, "mci_CRM", $Language->MenuPhrase("12", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(8, "mi_persona", $Language->MenuPhrase("8", "MenuText"), "personalist.php?cmd=resetall", 12, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->

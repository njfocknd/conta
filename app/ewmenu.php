<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mi_clase_cuenta", $Language->MenuPhrase("1", "MenuText"), "clase_cuentalist.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mi_grupo_cuenta", $Language->MenuPhrase("5", "MenuText"), "grupo_cuentalist.php?cmd=resetall", 1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(8, "mi_subgrupo_cuenta", $Language->MenuPhrase("8", "MenuText"), "subgrupo_cuentalist.php?cmd=resetall", 5, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mi_cuenta_mayor_principal", $Language->MenuPhrase("4", "MenuText"), "cuenta_mayor_principallist.php?cmd=resetall", 8, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mi_cuenta_mayor_auxiliar", $Language->MenuPhrase("3", "MenuText"), "cuenta_mayor_auxiliarlist.php?cmd=resetall", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->

<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mmi_clase_cuenta", $Language->MenuPhrase("1", "MenuText"), "clase_cuentalist.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_grupo_cuenta", $Language->MenuPhrase("5", "MenuText"), "grupo_cuentalist.php?cmd=resetall", 1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_subgrupo_cuenta", $Language->MenuPhrase("8", "MenuText"), "subgrupo_cuentalist.php?cmd=resetall", 5, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_cuenta_mayor_principal", $Language->MenuPhrase("4", "MenuText"), "cuenta_mayor_principallist.php?cmd=resetall", 8, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_cuenta_mayor_auxiliar", $Language->MenuPhrase("3", "MenuText"), "cuenta_mayor_auxiliarlist.php?cmd=resetall", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->

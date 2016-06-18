<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(106, "mci_Balance_General", $Language->MenuPhrase("106", "MenuText"), "gen_balance_general.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(130, "mci_Ane1lisis_Balance_General", $Language->MenuPhrase("130", "MenuText"), "rep_balance_general.php", 106, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(15, "mi_balance_general", $Language->MenuPhrase("15", "MenuText"), "balance_generallist.php?cmd=resetall", 106, "", TRUE, FALSE);
$RootMenu->AddMenuItem(105, "mci_Estado_de_Resultado", $Language->MenuPhrase("105", "MenuText"), "gen_estado_resultado.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(154, "mci_Ane1lisis_Estado_de_Resultado", $Language->MenuPhrase("154", "MenuText"), "rep_estado_resultado.php", 105, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(17, "mi_estado_resultado", $Language->MenuPhrase("17", "MenuText"), "estado_resultadolist.php", 105, "", TRUE, FALSE);
$RootMenu->AddMenuItem(74, "mci_Flujo_de_Efectivo", $Language->MenuPhrase("74", "MenuText"), "FlujoEfectivo.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(35, "mci_Valor_Futuro", $Language->MenuPhrase("35", "MenuText"), "interes.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(48, "mci_Valor_Presente", $Language->MenuPhrase("48", "MenuText"), "valor_presente.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(61, "mci_Amortizacif3n", $Language->MenuPhrase("61", "MenuText"), "amortizacion.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(11, "mci_Cate1logo", $Language->MenuPhrase("11", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(13, "mi_empresa", $Language->MenuPhrase("13", "MenuText"), "empresalist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(14, "mi_periodo_contable", $Language->MenuPhrase("14", "MenuText"), "periodo_contablelist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(18, "mi_clase_resultado", $Language->MenuPhrase("18", "MenuText"), "clase_resultadolist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(20, "mi_grupo_resultado", $Language->MenuPhrase("20", "MenuText"), "grupo_resultadolist.php?cmd=resetall", 18, "", TRUE, FALSE);
$RootMenu->AddMenuItem(1, "mi_clase_cuenta", $Language->MenuPhrase("1", "MenuText"), "clase_cuentalist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mi_grupo_cuenta", $Language->MenuPhrase("5", "MenuText"), "grupo_cuentalist.php?cmd=resetall", 1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(10, "mi_subgrupo_cuenta", $Language->MenuPhrase("10", "MenuText"), "subgrupo_cuentalist.php?cmd=resetall", 5, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mi_cuenta_mayor_principal", $Language->MenuPhrase("4", "MenuText"), "cuenta_mayor_principallist.php?cmd=resetall", 10, "", TRUE, FALSE);
$RootMenu->AddMenuItem(80, "mi_tipo_razon_financiera", $Language->MenuPhrase("80", "MenuText"), "tipo_razon_financieralist.php", 11, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->

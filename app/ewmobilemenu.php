<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(91, "mmci_Balance_Genaral", $Language->MenuPhrase("91", "MenuText"), "gen_balance_general.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(15, "mmi_balance_general", $Language->MenuPhrase("15", "MenuText"), "balance_generallist.php?cmd=resetall", 91, "", TRUE, FALSE);
$RootMenu->AddMenuItem(92, "mmci_Estado_de_Resultado", $Language->MenuPhrase("92", "MenuText"), "gen_estado_resultado.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(17, "mmi_estado_resultado", $Language->MenuPhrase("17", "MenuText"), "estado_resultadolist.php", 92, "", TRUE, FALSE);
$RootMenu->AddMenuItem(74, "mmci_Flujo_de_Efectivo", $Language->MenuPhrase("74", "MenuText"), "FlujoEfectivo.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(35, "mmci_Valor_Futuro", $Language->MenuPhrase("35", "MenuText"), "interes.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(48, "mmci_Valor_Presente", $Language->MenuPhrase("48", "MenuText"), "valor_presente.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(61, "mmci_Amortizacif3n", $Language->MenuPhrase("61", "MenuText"), "amortizacion.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(11, "mmci_Cate1logo", $Language->MenuPhrase("11", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(13, "mmi_empresa", $Language->MenuPhrase("13", "MenuText"), "empresalist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(14, "mmi_periodo_contable", $Language->MenuPhrase("14", "MenuText"), "periodo_contablelist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(18, "mmi_clase_resultado", $Language->MenuPhrase("18", "MenuText"), "clase_resultadolist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(20, "mmi_grupo_resultado", $Language->MenuPhrase("20", "MenuText"), "grupo_resultadolist.php?cmd=resetall", 18, "", TRUE, FALSE);
$RootMenu->AddMenuItem(1, "mmi_clase_cuenta", $Language->MenuPhrase("1", "MenuText"), "clase_cuentalist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_grupo_cuenta", $Language->MenuPhrase("5", "MenuText"), "grupo_cuentalist.php?cmd=resetall", 1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(10, "mmi_subgrupo_cuenta", $Language->MenuPhrase("10", "MenuText"), "subgrupo_cuentalist.php?cmd=resetall", 5, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_cuenta_mayor_principal", $Language->MenuPhrase("4", "MenuText"), "cuenta_mayor_principallist.php?cmd=resetall", 10, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->

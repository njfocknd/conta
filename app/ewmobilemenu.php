<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(18, "mmi_caja_chica", $Language->MenuPhrase("18", "MenuText"), "caja_chicalist.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(26, "mmi_documento_caja_chica", $Language->MenuPhrase("26", "MenuText"), "documento_caja_chicalist.php?cmd=resetall", 18, "", TRUE, FALSE);
$RootMenu->AddMenuItem(31, "mmi_caja_chica_cheque", $Language->MenuPhrase("31", "MenuText"), "caja_chica_chequelist.php?cmd=resetall", 18, "", TRUE, FALSE);
$RootMenu->AddMenuItem(11, "mmci_Cate1logo", $Language->MenuPhrase("11", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mmi_clase_cuenta", $Language->MenuPhrase("1", "MenuText"), "clase_cuentalist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_grupo_cuenta", $Language->MenuPhrase("5", "MenuText"), "grupo_cuentalist.php?cmd=resetall", 1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(10, "mmi_subgrupo_cuenta", $Language->MenuPhrase("10", "MenuText"), "subgrupo_cuentalist.php?cmd=resetall", 5, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_cuenta_mayor_auxiliar", $Language->MenuPhrase("3", "MenuText"), "cuenta_mayor_auxiliarlist.php?cmd=resetall", 10, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_cuenta_mayor_principal", $Language->MenuPhrase("4", "MenuText"), "cuenta_mayor_principallist.php?cmd=resetall", 3, "", TRUE, FALSE);
$RootMenu->AddMenuItem(9, "mmi_subcuenta", $Language->MenuPhrase("9", "MenuText"), "subcuentalist.php?cmd=resetall", 4, "", TRUE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_cuenta", $Language->MenuPhrase("2", "MenuText"), "cuentalist.php?cmd=resetall", 9, "", TRUE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_pais", $Language->MenuPhrase("6", "MenuText"), "paislist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(14, "mmi_empresa", $Language->MenuPhrase("14", "MenuText"), "empresalist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(15, "mmi_sucursal", $Language->MenuPhrase("15", "MenuText"), "sucursallist.php?cmd=resetall", 14, "", TRUE, FALSE);
$RootMenu->AddMenuItem(16, "mmi_configuracion", $Language->MenuPhrase("16", "MenuText"), "configuracionlist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(17, "mmi_correlativo", $Language->MenuPhrase("17", "MenuText"), "correlativolist.php?cmd=resetall", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(23, "mmi_modulo", $Language->MenuPhrase("23", "MenuText"), "modulolist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(25, "mmi_tipo_documento_modulo", $Language->MenuPhrase("25", "MenuText"), "tipo_documento_modulolist.php?cmd=resetall", 23, "", TRUE, FALSE);
$RootMenu->AddMenuItem(24, "mmi_tipo_documento", $Language->MenuPhrase("24", "MenuText"), "tipo_documentolist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(29, "mmi_banco", $Language->MenuPhrase("29", "MenuText"), "bancolist.php", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(30, "mmi_banco_cuenta", $Language->MenuPhrase("30", "MenuText"), "banco_cuentalist.php?cmd=resetall", 29, "", TRUE, FALSE);
$RootMenu->AddMenuItem(12, "mmci_CRM", $Language->MenuPhrase("12", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(8, "mmi_persona", $Language->MenuPhrase("8", "MenuText"), "personalist.php?cmd=resetall", 12, "", TRUE, FALSE);
$RootMenu->AddMenuItem(19, "mmi_empleado", $Language->MenuPhrase("19", "MenuText"), "empleadolist.php?cmd=resetall", 8, "", TRUE, FALSE);
$RootMenu->AddMenuItem(13, "mmi_cliente", $Language->MenuPhrase("13", "MenuText"), "clientelist.php?cmd=resetall", 8, "", TRUE, FALSE);
$RootMenu->AddMenuItem(22, "mmi_proveedor", $Language->MenuPhrase("22", "MenuText"), "proveedorlist.php?cmd=resetall", 8, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->

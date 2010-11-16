<?php
/*******************************************************************************
VLLasku: web-based invoicing application.
Copyright (C) 2010 Ere Maijala

Portions based on:
PkLasku : web-based invoicing software.
Copyright (C) 2004-2008 Samu Reinikainen

This program is free software. See attached LICENSE.

*******************************************************************************/

/*******************************************************************************
VLLasku: web-pohjainen laskutusohjelma.
Copyright (C) 2010 Ere Maijala

Perustuu osittain sovellukseen:
PkLasku : web-pohjainen laskutusohjelmisto.
Copyright (C) 2004-2008 Samu Reinikainen

T�m� ohjelma on vapaa. Lue oheinen LICENSE.

*******************************************************************************/

/***********************************************************************
 form_switch.php
 
 provides switches for different forms
 
 supported element types:
 
 TEXT : normal textarea
 INTDATE : date textarea with calendar button
 CHECK : checkbox
 LIST : listbox
 IFRAME : simple form in iframe
 IFORM : bit more complex form in iframe
 BUTTON : button for various events
 
***********************************************************************/

for( $i = 1; $i <= 12; $i++ ) {
    $strMonth = strlen($i) == 1 ? "0". $i : $i;
    $strMonthListQuery .= 
        "SELECT '$strMonth' AS id, '".$GLOBALS['locMONTHS2'][$i]."' AS name UNION ";
}
$strMonthListQuery = substr($strMonthListQuery, 0, -6);

for( $i = 1; $i <= 31; $i++ ) {
    $strDate = strlen($i) == 1 ? "0". $i : $i;
    $strDateListQuery .= 
        "SELECT '$strDate' AS id, '$strDate' AS name UNION ";
}
$strDateListQuery = substr($strDateListQuery, 0, -6);

switch ( $strForm ) {

case 'company':
   $strTable = _DB_PREFIX_. "_company";
   $strPrimaryKey = "id";
   $strMainForm = "form.php?selectform=company";
   $astrSearchFields = 
    array( 
        //array("name" => "first_name", "type" => "TEXT"),
        array("name" => "company_name", "type" => "TEXT")
    );
   $astrFormElements =
    array(
     array("label" => $GLOBALS['locLABELCONTACTINFO'], "type" => "LABEL"),
     array(
        "name" => "company_name", "label" => $GLOBALS['locCOMPNAME'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "company_id", "label" => $GLOBALS['locCOMPVATID'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "email", "label" => $GLOBALS['locEMAIL'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "www", "label" => $GLOBALS['locWWW'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "street_address", "label" => $GLOBALS['locSTREETADDR'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "zip_code", "label" => $GLOBALS['locZIPCODE'], "type" => "TEXT", "style" => "short", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "city", "label" => $GLOBALS['locCITY'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "phone", "label" => $GLOBALS['locPHONE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "fax", "label" => $GLOBALS['locFAX'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "gsm", "label" => $GLOBALS['locGSM'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "billing_address", "label" => $GLOBALS['locBILLADDR'], "type" => "AREA", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "info", "label" => $GLOBALS['locINFO'], "type" => "AREA", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "company_contact", "label" => $GLOBALS['locCONTACTS'], "type" => "IFORM", "style" => "full", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE, "parent_key" => "company_id" )
    );
break;

case 'company_contact':
       $strTable = _DB_PREFIX_. "_company_contact";
       $strPrimaryKey = "id";
       $strParentKey = "company_id";
       $strMainForm = "iform.php?selectform=company_contact";
       $astrFormElements =
        array(
         array(
            "name" => "id", "label" => "", "type" => "HID_INT",
            "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => FALSE ),
         array(
            "name" => "contact_person", "label" => $GLOBALS['locCONTACTPERSON'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => FALSE ),
         array(
            "name" => "person_title", "label" => $GLOBALS['locPERSONTITLE'], "type" => "TEXT", "style" => "medium", "listquery" => "SELECT id, name FROM ". _DB_PREFIX_. "_person_title ORDER BY order_no;", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
         array(
            "name" => "phone", "label" => $GLOBALS['locPHONE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
         array("type" => "NEWLINE"),
         array(
            "name" => "gsm", "label" => $GLOBALS['locGSM'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
         array(
            "name" => "email", "label" => $GLOBALS['locEMAIL'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE )
       );
break;

case 'product':
   $strTable = _DB_PREFIX_. "_product";
   $strPrimaryKey = "id";
   $strMainForm = "form.php?selectform=product";
   $astrSearchFields = 
    array( 
        //array("name" => "first_name", "type" => "TEXT"),
        array("name" => "product_name", "type" => "TEXT")
    );
   $astrFormElements =
    array(
     array(
        "name" => "product_name", "label" => $GLOBALS['locPRODUCTNAME'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "description", "label" => $GLOBALS['locPRODUCTDESCRIPTION'], "type" => "TEXT", "style" => "long", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "product_code", "label" => $GLOBALS['locPRODUCTCODE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "product_group", "label" => $GLOBALS['locPRODUCTGROUP'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "internal_info", "label" => $GLOBALS['locINTERNALINFO'], "type" => "AREA", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "unit_price", "label" => $GLOBALS['locUNITPRICE'], "type" => "INT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "type_id", "label" => $GLOBALS['locUNIT'], "type" => "LIST", "style" => "short", "listquery" => "SELECT id, name FROM ". _DB_PREFIX_. "_row_type ORDER BY order_no;", "position" => 0, "default" => "POST", "allow_null" => FALSE ),
     array(
        "name" => "vat_percent", "label" => $GLOBALS['locVATPERCENT'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "vat_included", "label" => $GLOBALS['locVATINCLUDED'], "type" => "CHECK", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
    );
break;

case 'invoice':
   $strTable = _DB_PREFIX_. "_invoice";
   $strPrimaryKey = "id";
   $strMainForm = "form.php?selectform=invoice";
   
   $defaultInvNo = FALSE;
   $defaultRefNo = FALSE;
   if ($addInvoiceNumber || $addReferenceNumber)
   {
     $strQuery = "SELECT max(invoice_no) FROM ". _DB_PREFIX_. "_invoice";
     $intRes = mysql_query($strQuery);
     $intInvNo = mysql_result($intRes, 0, 0) + 1;
     if ($addInvoiceNumber)
       $defaultInvNo = $intInvNo;
     if ($addReferenceNumber)
       $defaultRefNo = $intInvNo . miscCalcCheckNo($intInvNo);
   }
   
   $astrFormElements =
    array(
     array(
        "name" => "base_id", "label" => $GLOBALS['locBILLER'], "type" => "LIST", "style" => "medium", "listquery" => "SELECT id, name FROM ". _DB_PREFIX_. "_base ORDER BY name;", "position" => 0, "default" => 2, "allow_null" => FALSE ),
     array(
        "name" => "name", "label" => $GLOBALS['locINVNAME'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
     /*array(
        "name" => "real_invoice_no", "label" => $GLOBALS['locREALINVNO'], "type" => "INT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),*/
     array(
        "name" => "company_id", "label" => $GLOBALS['locPAYER'], "type" => "LIST", "style" => "medium", "listquery" => "SELECT id, company_name FROM ". _DB_PREFIX_. "_company ORDER BY company_name;", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "reference", "label" => $GLOBALS['locREFERENCE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "invoice_date", "label" => $GLOBALS['locINVDATE'], "type" => "INTDATE", "style" => "date", "listquery" => "", "position" => 1, "default" => "DATE_NOW", "allow_null" => FALSE ),
     array(
     "name" => "due_date", "label" => $GLOBALS['locDUEDATE'], "type" => "INTDATE", "style" => "date", "listquery" => "", "position" => 2, "default" => "DATE_NOW+{$paymentDueDate}", "allow_null" => FALSE ),
     array(
        "name" => "invoice_no", "label" => $GLOBALS['locINVNO'], "type" => "INT", "style" => "medium", "listquery" => "", "position" => 1, "default" => $defaultInvNo, "allow_null" => TRUE ),
     array(
        "name" => "ref_number", "label" => $GLOBALS['locREFNO'], "type" => "INT", "style" => "medium", "listquery" => "", "position" => 2, "default" => $defaultRefNo, "allow_null" => TRUE ),
     array(
        "name" => "state_id", "label" => $GLOBALS['locSTATUS'], "type" => "LIST", "style" => "medium", "listquery" => "SELECT id, name FROM ". _DB_PREFIX_. "_invoice_state ORDER BY order_no;", "position" => 1, "default" => 1, "allow_null" => FALSE ),
     array(
        "name" => "payment_date", "label" => $GLOBALS['locPAYDATE'], "type" => "INTDATE", "style" => "date", "listquery" => "", "position" => 2, "default" => NULL, "allow_null" => TRUE ),
     array(
        "name" => "get", "label" => $GLOBALS['locGETINVNO'], "type" => "BUTTON", "style" => "medium", "listquery" => "'get_invoiceno.php?ses=".$strSesID."&type=comp&id=_ID_', '_new'", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "get", "label" => $GLOBALS['locPRINTINV'], "type" => "BUTTON", "style" => "medium", "listquery" => "'invoice.php?ses=".$strSesID."&type=comp&id=_ID_', '_self'", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "get", "label" => $GLOBALS['locCOPYINV'], "type" => "BUTTON", "style" => "medium", "listquery" => "'copy_invoice.php?ses=".$strSesID."&type=comp&id=_ID_', '_new'", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "invoice_rows", "label" => $GLOBALS['locINVROWS'], "type" => "IFORM", "style" => "xfull", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE, "parent_key" => "invoice_id" )
    );
break;
case 'invoice_rows':
   $strTable = _DB_PREFIX_. "_invoice_row";
   $strPrimaryKey = "id";
   $strParentKey = "invoice_id";
   $strMainForm = "iform.php?selectform=invoice_rows";
   $strOrder = "ORDER BY ". _DB_PREFIX_. "_invoice_row.order_no";
   
   $intProductId = $_GET['new_product'];
   $strDescription = '';
   $intTypeId = 'POST';
   $intPrice = 'POST';
   $intVAT = $defaultVAT;
   $intVATIncluded = 0;
   if ($intProductId)
   {
     // Retrieve default values from the specified product
     $strQuery = 
        "SELECT * ".
        "FROM ". _DB_PREFIX_. "_product ".
        "WHERE id = ". mysql_escape_string($intProductId);
     $intRes = mysql_query($strQuery);
     if( $intRes ) 
     {
       $strDescription = trim(mysql_result($intRes, 0, "description"));
       $intTypeId = mysql_result($intRes, 0, "type_id");
       $intPrice = mysql_result($intRes, 0, "unit_price");
       $intVAT = mysql_result($intRes, 0, "vat_percent");
       $intVATIncluded = mysql_result($intRes, 0, "vat_included");
     }
   }
   
   $productOnChange = <<<EOS
onChange = "var loc = new String(window.location); loc = loc.replace(/&new_product=\d+/, ''); loc += '&new_product=' + document.forms[0].product_id.value; window.location = loc;"
EOS;

   $astrFormElements =
    array(
     array(
        "name" => "id", "label" => "", "type" => "HID_INT",
        "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "product_id", "label" => $GLOBALS['locPRODUCTNAME'], "type" => "LIST", "style" => "small", "listquery" => "SELECT id, product_name FROM ". _DB_PREFIX_. "_product ORDER BY product_name;", "position" => 0, "default" => $intProductId, "allow_null" => TRUE, 'elem_attributes' => $productOnChange ),
     array(
        "name" => "description", "label" => $GLOBALS['locROWDESC'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => $strDescription, "allow_null" => FALSE ),
     array(
        "name" => "row_date", "label" => $GLOBALS['locDATE'], "type" => "INTDATE", "style" => "date", "listquery" => "", "position" => 0, "default" => 'DATE_NOW', "allow_null" => FALSE ),
     array(
        "name" => "pcs", "label" => $GLOBALS['locPCS'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "type_id", "label" => $GLOBALS['locUNIT'], "type" => "LIST", "style" => "short", "listquery" => "SELECT id, name FROM ". _DB_PREFIX_. "_row_type ORDER BY order_no;", "position" => 0, "default" => $intTypeId, "allow_null" => FALSE ),
     array(
        "name" => "price", "label" => $GLOBALS['locPRICE'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 0, "default" => $intPrice, "allow_null" => FALSE ),
     array(
        "name" => "vat", "label" => $GLOBALS['locVAT'], "type" => "INT", "style" => "tiny", "listquery" => "", "position" => 0, "default" => $intVAT, "allow_null" => TRUE ),
     array(
        "name" => "vat_included", "label" => $GLOBALS['locVATINC'], "type" => "CHECK", "style" => "short", "listquery" => "", "position" => 0, "default" => $intVATIncluded, "allow_null" => TRUE ),
     array(
        "name" => "order_no", "label" => $GLOBALS['locROWNO'], "type" => "INT", "style" => "tiny", "listquery" => "SELECT max(order_no)+5 FROM ". _DB_PREFIX_. "_invoice_row WHERE invoice_id = _PARENTID_", "position" => 0, "default" => "ADD+5", "allow_null" => TRUE )
   );
break;
/******************************************************************************
    END SEARCH FORMS - HAUN LOMAKKEET
******************************************************************************/

/******************************************************************************
    SYSTEM FORMS - SYSTEEMILOMAKKEET
******************************************************************************/
case 'base_info':
   $strTable = _DB_PREFIX_. "_base";
   $strPrimaryKey = "id";
   $strMainForm = "form.php?selectform=base_info";
   $astrFormElements =
    array(
     array(
        "name" => "name", "label" => $GLOBALS['locCOMPNAME'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "company_id", "label" => $GLOBALS['locCOMPVATID'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "contact_person", "label" => $GLOBALS['locCONTACTPERS'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "vat_registered", "label" => $GLOBALS['locVATREGISTERED'], "type" => "CHECK", "style" => "short", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "email", "label" => $GLOBALS['locEMAIL'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "www", "label" => $GLOBALS['locWWW'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "street_address", "label" => $GLOBALS['locSTREETADDR'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 0, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "zip_code", "label" => $GLOBALS['locZIPCODE'], "type" => "TEXT", "style" => "short", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "city", "label" => $GLOBALS['locCITY'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "phone", "label" => $GLOBALS['locPHONE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "banksep1", "label" => $GLOBALS['locFIRSTBANK'], "type" => "LABEL"),
     array(
        "name" => "bank_name", "label" => $GLOBALS['locBANK'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "bank_account", "label" => $GLOBALS['locACCOUNT'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "bank_iban", "label" => $GLOBALS['locACCOUNTIBAN'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 3, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "bank_swiftbic", "label" => $GLOBALS['locSWIFTBIC'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 4, "default" => FALSE, "allow_null" => FALSE ),
     array(
        "name" => "banksep2", "label" => $GLOBALS['locSECONDBANK'], "type" => "LABEL"),
     array(
        "name" => "bank_name2", "label" => $GLOBALS['locBANK'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "bank_account2", "label" => $GLOBALS['locACCOUNT'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "bank_iban2", "label" => $GLOBALS['locACCOUNTIBAN'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 3, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "bank_swiftbic2", "label" => $GLOBALS['locSWIFTBIC'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 4, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "banksep3", "label" => $GLOBALS['locTHIRDBANK'], "type" => "LABEL"),
     array(
        "name" => "bank_name3", "label" => $GLOBALS['locBANK'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "bank_account3", "label" => $GLOBALS['locACCOUNT'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "bank_iban3", "label" => $GLOBALS['locACCOUNTIBAN'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 3, "default" => FALSE, "allow_null" => TRUE ),
     array(
        "name" => "bank_swiftbic3", "label" => $GLOBALS['locSWIFTBIC'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 4, "default" => FALSE, "allow_null" => TRUE ),
    );
break;

case 'invoice_state':
    $strTable = _DB_PREFIX_. "_invoice_state";
    $strPrimaryKey = "id";
    $strMainForm = "form.php?selectform=invoice_state";
    $astrFormElements =
        array(
         array(
            "name" => "name", "label" => $GLOBALS['locSTATUS'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
         array(
            "name" => "order_no", "label" => $GLOBALS['locORDERNO'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => FALSE )
    );
break;

case 'row_type':
    $strTable = _DB_PREFIX_. "_row_type";
    $strPrimaryKey = "id";
    $strMainForm = "form.php?selectform=row_type";
    $astrFormElements =
        array(
         array(
            "name" => "name", "label" => $GLOBALS['locROWTYPE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
         array(
            "name" => "order_no", "label" => $GLOBALS['locORDERNO'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => FALSE )
    );
break;

case 'session_type':
    $strTable = _DB_PREFIX_. "_session_type";
    $strPrimaryKey = "id";
    $strMainForm = "form.php?selectform=session_type";
    $astrFormElements =
        array(
            array(
            "name" => "name", "label" => $GLOBALS['locSESSIONTYPE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
            array(
            "name" => "order_no", "label" => $GLOBALS['locORDERNO'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => FALSE ),
            array(
            "name" => "time_out", "label" => $GLOBALS['locTIMEOUT'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 1, "default" => "5400", "allow_null" => FALSE ),
            array(
            "name" => "access_level", "label" => $GLOBALS['locACCESSLEVEL'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 2, "default" => "1", "allow_null" => FALSE )
    );
break;

case 'users':
    $strTable = _DB_PREFIX_. "_users";
    $strPrimaryKey = "id";
    $strMainForm = "form.php?selectform=users";
    $astrFormElements =
        array(
            array(
            "name" => "name", "label" => $GLOBALS['locUSERNAME'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ), 
            array(
            "name" => "login", "label" => $GLOBALS['locLOGONNAME'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
            array(
            "name" => "passwd", "label" => $GLOBALS['locPASSWD'], "type" => "PASSWD", "style" => "medium", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),
            /*array(
            "name" => "get", "label" => $GLOBALS['locGENPASSWD'], "type" => "BUTTON", "style" => "full", "listquery" => "'passwd.php?ses=".$strSesID."&type=pers&id=_ID_', target='_blank'", "position" => 2, "default" => FALSE, "allow_null" => TRUE ),*/
            array(
            "name" => "type_id", "label" => $GLOBALS['locTYPE'], "type" => "LIST", "style" => "medium", "listquery" => "SELECT id, name FROM ". _DB_PREFIX_. "_session_type ORDER BY order_no", "position" => 0, "default" => FALSE, "allow_null" => FALSE )
    );
break;

case 'company_type':
    $strTable = _DB_PREFIX_. "_company_type";
    $strPrimaryKey = "id";
    $strMainForm = "form.php?selectform=company_type";
    $astrFormElements =
        array(
            array(
            "name" => "name", "label" => $GLOBALS['locCOMPTYPE'], "type" => "TEXT", "style" => "medium", "listquery" => "", "position" => 1, "default" => FALSE, "allow_null" => FALSE ),
            array(
            "name" => "order_no", "label" => $GLOBALS['locORDERNO'], "type" => "INT", "style" => "short", "listquery" => "", "position" => 2, "default" => FALSE, "allow_null" => FALSE )
        );
break;

    default :
        echo "What would you like me to do?"; die;
    break;
}

?>

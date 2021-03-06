<?php
/*******************************************************************************
MLInvoice: web-based invoicing application.
Copyright (C) 2010-2012 Ere Maijala

This program is free software. See attached LICENSE.

*******************************************************************************/

/*******************************************************************************
MLInvoice: web-pohjainen laskutusohjelma.
Copyright (C) 2010-2012 Ere Maijala

Tämä ohjelma on vapaa. Lue oheinen LICENSE.

*******************************************************************************/

require_once "localize.php";
require_once "datefuncs.php";
require_once "miscfuncs.php";

function addReminderFees($intInvoiceId)
{
  $strAlert = '';
  $strQuery = 
    'SELECT inv.due_date, inv.state_id, inv.print_date ' .
    'FROM {prefix}invoice inv ' .
    'WHERE inv.id = ?';
  $intRes = mysql_param_query($strQuery, array($intInvoiceId));
  if ($row = mysql_fetch_assoc($intRes)) 
  {
     $intStateId = $row['state_id'];
     $strDueDate = dateConvDBDate2Date($row['due_date']);
     $strPrintDate = $row['print_date'];
  }
  else
  {
    return $GLOBALS['locRecordNotFound'];
  }
  
  $intDaysOverdue = floor((time() - strtotime($strDueDate)) / 60 / 60 / 24);
  if ($intDaysOverdue <= 0)
  {
    $strAlert = addslashes($GLOBALS['locInvoiceNotOverdue']);
  }
  elseif ($intStateId == 3 || $intStateId == 4)
  {
    $strAlert = addslashes($GLOBALS['locWrongStateForReminderFee']);
  }
  else
  {
    // Update invoice state
    if ($intStateId == 1 || $intStateId == 2)
      $intStateId = 5;
    elseif ($intStateId == 5)
      $intStateId = 6;
    mysql_param_query('UPDATE {prefix}invoice SET state_id=? where id=?', array($intStateId, $intInvoiceId));
    
    // Add reminder fee
    if (getSetting('invoice_notification_fee'))
    {
      // Remove old fee from same day
      mysql_param_query('UPDATE {prefix}invoice_row SET deleted=1 WHERE invoice_id=? AND reminder_row=2 AND row_date = ?', array($intInvoiceId, date('Ymd')));
      
      $strQuery = 'INSERT INTO {prefix}invoice_row (invoice_id, description, pcs, price, row_date, vat, vat_included, order_no, reminder_row) ' .
        'VALUES (?, ?, 1, ?, ?, 0, 0, -2, 2)';
      mysql_param_query($strQuery, array($intInvoiceId, $GLOBALS['locReminderFeeDesc'], getSetting('invoice_notification_fee'), date('Ymd')));
    }
    // Add penalty interest
    $penaltyInterest = getSetting('invoice_penalty_interest');
    if ($penaltyInterest)
    {
      // Remove old penalty interest
      mysql_param_query('UPDATE {prefix}invoice_row SET deleted=1 WHERE invoice_id=? AND reminder_row=1', array($intInvoiceId));
      
      // Add new interest
      $intTotSumVAT = 0;
      $strQuery = 
          'SELECT ir.pcs, ir.price, ir.discount, ir.vat, ir.vat_included '.
          'FROM {prefix}invoice_row ir '.
          'WHERE ir.deleted=0 AND ir.invoice_id=?';
      $intRes = mysql_param_query($strQuery, array($intInvoiceId));
      while ($row = mysql_fetch_assoc($intRes))
      {
        list($rowSum, $rowVAT, $rowSumVAT) = calculateRowSum($row['price'], $row['pcs'], $row['vat'], $row['vat_included'], $row['discount']);
        $intTotSumVAT += $rowSumVAT;
      }
      $intPenalty = $intTotSumVAT * $penaltyInterest / 100 * $intDaysOverdue / 360;
      
      $strQuery = 'INSERT INTO {prefix}invoice_row (invoice_id, description, pcs, price, discount, row_date, vat, vat_included, order_no, reminder_row) ' .
        'VALUES (?, ?, 1, ?, 0, ?, 0, 0, -1, 1)';
      mysql_param_query($strQuery, array($intInvoiceId, $GLOBALS['locPenaltyInterestDesc'], $intPenalty, date('Ymd')));
    }
  }
  return $strAlert;  
}

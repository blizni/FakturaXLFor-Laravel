<?php

namespace blizni\FXL\Helpers;

class FakturaXLInvoiceKind
{
    /**
     * Rodzaj faktury - faktura VAT
     */
    const INVOICE_VAT = 0;

    /**
     * Rodzaj faktury - faktura Proforma
     */
    const INVOICE_PROFORMA = 1;

    /**
     * Rodzaj faktury - rachunek
     */
    const BILL = 6;

    /**
     * Rodzaj faktury - paragon
     */
    const RECEIPT = 14;

    /**
     * Rodzaj faktury - faktura zaliczkowa
     */
    const INVOICE_ADVANCE = 11;


    /**
     * Rodzaj faktury - eksport towarów
     */
    const EXPORT_PRODUCTS = 23;
}

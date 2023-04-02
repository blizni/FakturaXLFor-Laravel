<?php

namespace blizni\FXL\Helpers;

class FakturaXLInvoiceStatus
{
    /**
     * Status faktury - wystawiona
     */
    const ISSUED = 0;

    /**
     * Status faktury - opłacona
     */
    const PAID = 2;

    /**
     * Status faktury - częściowo opłacona
     */
    const PARTIAL = 1;
}

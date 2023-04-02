<?php

namespace blizni\FXL\Helpers;

class FakturaXLPaymentMethod
{
    /**
     * Metoda płatności - przelew
     */
    const TRANSFER = "przelew";

    /**
     * Metoda płatności - karta płatnicza
     */
    const CARD = "Karta płatnicza";

    /**
     * Metoda płatności - gotówka
     */
    const CASH = "Gotówka";

    /**
     * Metoda płatności - barter
     */
    const BARTER = "Barter";

    /**
     * Metoda płatności - czek
     */
    const CHEQUE = "Czek";

    /**
     * Metoda płatności - opłata za pobraniem
     */
    const CASH_ON_DELIVERY = "Opłata za pobraniem";

    /**
     * Metoda płatności - kompensata
     */
    const COMPENSATION = "Kompensata";
    
    /**
     * Metoda płatności - PayU
     */
    const PAYU = "PayU";

    /**
     * Metoda płatności - PayPal
     */
    const PAYPAL = "PayPal";

     /**
     * Metoda płatności - nie wyświetlaj
     */
    const HIDE = "off";
}

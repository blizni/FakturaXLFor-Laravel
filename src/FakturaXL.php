<?php

namespace blizni\FXL;

use Illuminate\Support\Facades\Http;
use blizni\FXL\FakturaXLInvoice;

class FakturaXL
{
    private static $token = '';
    private static $domain = '';

    public static function __constructStatic()
    {
        self::$token = config('fakturaxl.token');
        self::$domain = config('fakturaxl.domain');
    }

    private static function buildUrl()
    {
        return "https://" . self::$domain . ".fakturaxl.pl/";
    }

    public static function createInvoice(FakturaXLInvoice $invoice)
    {
        $data = array();
        $data['api_token'] = self::$token;
        $data['invoice'] = $invoice->toArray();

        return Http::accept('application/json')->post(self::buildUrl() . "invoices.json", $data);
    }

    public static function getInvoice(int $id, string $format = 'json')
    {
        return Http::get(self::buildUrl() . "invoices/" . $id . "." . $format . "?api_token=" . self::$token);
    }

    public static function changeInvoiceStatus(int $id, string $status)
    {
        return Http::post(self::buildUrl() . "invoices/" . $id . "/change_status.json?api_token=" . self::$token . "&status=" . $status);
    }

    public static function printInvoiceRaw(int $id)
    {
        return Http::get(self::buildUrl() . "invoices/" . $id . ".pdf?api_token=" . self::$token);
    }

    public static function printInvoice(int $id, string $name)
    {
        $content = self::printInvoiceRaw($id);

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $name . '.pdf', [ 'Content-Type' => 'application/pdf' ]);
    }

    public static function updateInvoice(int $id, array $attributes)
    {
        $data = array();
        $data['api_token'] = self::$token;
        $data['invoice'] = $attributes;

        return Http::accept('application/json')->put(self::buildUrl() . "invoices/" . $id . ".json", $data);
    }

    public static function deleteInvoice(int $id)
    {
        return Http::delete(self::buildUrl() . "invoices/" . $id . ".json?api_token=" . self::$token);
    }
}

FakturaXL::__constructStatic();

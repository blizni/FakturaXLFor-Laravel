# FakturaXL For Laravel

[![Latest Version](https://img.shields.io/github/release/blizni/FakturaXLFor-Laravel.svg?include_prereleases&label=packagist&style=flat-square)](https://packagist.org/packages/blizni/FakturaXLFor-laravel)
[![Last Commit](https://img.shields.io/github/last-commit/blizni/FakturaXLFor-Laravel.svg?style=flat-square)](https://github.com/blizni/FakturaXLFor-Laravel/commit/main)
[![Issues](https://img.shields.io/github/issues/blizni/FakturaXLFor-Laravel.svg?style=flat-square)](https://github.com/blizni/FakturaXLFor-Laravel/issues)
[![License](https://img.shields.io/github/license/blizni/FakturaXLFor-Laravel.svg?style=flat-square)](https://github.com/blizni/FakturaXLFor-Laravel/blob/main/LICENSE)

A Laravel package for easy integration with FakturaXL API ([fakturaxl.pl](https://fakturaxl.pl)). The package contains custom helper classes which allows easy management with invoices. 

## Features of the package

- retrieving invoices
- creating new invoice
- updating an invoice
- deleting an invoice
- printing invoices
- managing positions for invoice

## Installation

The recommended way to install the package is by using
[Composer](https://getcomposer.org/).

```bash
composer require blizni/FakturaXLFor-laravel
```

**After installation make sure to specify in your Laravel project these envelop keys:**

```env
FAKTURAXL_DOMAIN=your_domain_prefix
FAKTURAXL_TOKEN=your_generated_token
```

## Documentation

Documentation for this package can be find in a file [DOCUMENTATION.md](https://github.com/blizni/FakturaXLFor-Laravel/blob/main/DOCUMENTATION.md).

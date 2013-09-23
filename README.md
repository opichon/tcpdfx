tcpdfx
======

An extension of the TCPDF library.

Installation
------------
### Via composer
Add the pagckage to your `composer.json` file:

```json
{
	"require": {
		"uam/tcpdfx": "dev-master",
	},
}
```

Run `composer.phar update`.

Class hierarchy
---------------

UAM\Pdf\TCPDF → fpdi\FPDI → fpdi\FPDI → FPDF\TPL → fpdi\FPDF → \TCPDF

UAM\Pdf\Concat → fpdi\FPDI ...

Usage
-----
### TCPDF

Instantiate a TCPDF document. 

```php
use UAM\Pdf\TCPDF;

$pdf = new TCPDF();
```

`UAM\Pdf\TCPDF` is a sub-class of both fpdi\FPDI and \TCPDF, so all methods from thise classes are available, in addition to the convenience methods defined in UAM\Pdf\TCPDF itself.

### Concatenating files

`UAM\Pdf\ConcatPDF` is a convenience class to concatenate PDF documents.

External libraries
------------------
tcpdfx makes use of:

### TCPDF

The TCPDF library is provided via the "tecnick.com/tcpdf" package, currently at release 6.0.032.

This package is hosted at sourceforge, and because if persistent problems in downloading it, it is also mirrored at git@github.com:opichon/tcpdf.git.

### FPDI

FPDI version 1.4.4 and FPDF_TPL version 1.2.3 are provided via the "onigoetz/fpdi_tcpdf" package.

fpdi
====

Fork of the unofficial PSR-0 compliant version of the FPDI library.


This is version 1.4.2 of FPDI (and version 1.2 of FPDF_TPL) with some minor changes:

* the library is namespaced in fpdi. To create instance use

    $fpdi = new \fpdi\FPDI();

* directory structure follow the PSR-0 standard with src/ as root

* constructors are renamed *__construct* instead of class name

* the library is designed to be used only with TCPDF. The \fpdi\FPDF is a bridge class from FPDI to TCPDF

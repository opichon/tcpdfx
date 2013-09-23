<?php
namespace UAM\Pdf;

$error_reporting = error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

use \fpdi\FPDI;

class TCPDF extends FPDI
{
    protected $name = 'doc.pdf';

    protected $display_mode = 'real';

    protected $bottom_margin = 25;

    protected $header_font_family = 'Georgia';
    protected $header_font_size = 12;
    protected $header_font_style = 'B';
    protected $header_cell = 5;

    // deprecate [OP 2011-03-24]
    protected $footer_margin = 10;
    protected $footer_font_family = 'Verdana';
    protected $footer_font_size = 8;
    protected $footer_font_style = '';
    protected $footer_cell = 4;

    protected $show_page_header = false;
    protected $paginate = false;
    protected $paginate_format = 'p. %page%/%pages%';
    protected $paginate_font_family = 'Verdana';
    protected $paginate_font_size = 8;
    protected $paginate_font_style = '';
    protected $paginate_x;
    protected $paginate_y;

    protected $title;

    protected $font = 'Verdana';
    protected $font_style = '';
    protected $font_size = 10;
    protected $cell_height = 5;

    protected $document_title_font = 'Georgia';
    protected $document_title_size = 16;
    protected $document_title_style = 'B';
    protected $document_title_border = 'B';
    protected $document_title_align = 'C';
    protected $document_title_cell_height = 12;

    protected $title_font = 'Verdana';
    protected $title_size = 11;
    protected $title_style = 'B';
    protected $title_cell_height = 6;
    protected $title_align = 'L';

    protected $subtitle_font = 'Verdana';
    protected $subtitle_size = 11;
    protected $subtitle_style = 'B';
    protected $subtitle_cell_height = 6;

    protected $watermark = null;
    protected $watermark_font = 'Verdana';
    protected $watermark_size = 58;
    protected $watermark_style = 'B';
    protected $watermark_cell = 10;
    protected $watermark_color = array(255, 205, 205);

    protected $default_cell_padding = array('L' => 0.3, 'T' => 0.3, 'R' => 0.3, 'B' => 0.3);

    protected $logo;

    protected $letterhead;
    protected $letterhead_idx;

    protected $name_pattern;

    public function __construct()
    {
        parent::__construct();
        // Set paper format
        $this->setPaperFormat();
        /* Set this to false in various subclasses to embed fonts instead of subsetting them */
        $this->SetFontSubsetting(false);
    }

    protected function init()
    {
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor($this->author);
        $this->SetTitle($this->title);
        $this->SetSubject($this->subject);
        $this->SetKeywords($this->keywords);

        $this->setDisplayMode($this->display_mode);
        $this->SetAutoPageBreak(true, $this->bottom_margin);
        $this->setPrintHeader(true);
        $this->setPrintFooter(true);
        $this->setHeaderFont(array($this->header_font_family, $this->header_font_style, $this->header_font_size));
//    $this->setFooterFont(array($this->footer_font_family, $this->footer_font_style, $this->footer_font_size));
        $this->SetHeaderMargin($this->header_margin);
        $this->SetFooterMargin($this->footer_margin);
        $this->SetFont($this->font, $this->font_style, $this->font_size);

        $this->configure();
    }

    protected function setPaperFormat()
    {
        if (isset($this->paper_format)) {
            $this->setPageFormat($this->paper_format);
        } else {
            /*
             * Determine paper format - to be implemented later
             * For instance - US 'LETTER' (8 1/2" x 11")/(216mm x 279mm)
             * Implementation - $this->setPageFormat('LETTER');
             */
            // Use default page format - 'A4'
            $this->setPageFormat('A4');
        }
    }

    protected function configure() {}

    /*
     * Do not override. Override 'generate' method instead.
     *
     */
    // TODO [OP 2010-05-12] Make final
    public function Output($name = null, $dest = 'D')
    {
        $this->init();
        $this->AddPage();
        $this->generate();
        parent::Output($name ? $name : $this->processName($this->getName()), $dest);
        header_remove('Content-Length');
    }

    protected function processName($name) { return $name; }

    protected function generate() {}

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function resetFont()
    {
        $this->SetFont($this->FontFamily, $this->FontStyle, $this->FontSizePt);
    }

    /*
    public function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
    {
        $old_cell_padding = $this->GetCellPaddings();
        $this->setCellPaddings($this->default_cell_padding['L'],
                                                     $this->default_cell_padding['T'],
                                                     $this->default_cell_padding['R'],
                                                     $this->default_cell_padding['B']);
        parent::MultiCell($w, $h, $txt, $border, $align, $fill, $ln, $x, $y, $reseth, $stretch, $ishtml, $autopadding, $maxh, $valign, $fitcell);
        $this->SetCellPaddings($old_cell_padding['L'], $old_cell_padding['T'], $old_cell_padding['R'], $old_cell_padding['B']);
    }
    */

    public function getNumLines($txt, $w=0, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
    {
        if (empty($txt)) { return 1; } else { return parent::getNumLines($txt, $w, $reseth, $autopadding, $cellpadding, $border); }
    }

    protected function _cell($s, $link = '')
    {
        $this->Cell($this->getStringWidth($s), 6, $s, 0, 0, 'L', 0, $link);
    }

    //public function getCellPadding() { return $this->cMargin; }

    public function printDocumentTitle()
    {
        if (empty($this->title)) { return; }
        $font = $this->getFontFamily();
        $style = $this->getFontStyle();
        $size = $this->getFontSize();
        $this->SetFont($this->document_title_font, $this->document_title_style, $this->document_title_size);
        $this->MultiCell(0, $this->document_title_cell_height, $this->title, $this->document_title_border, $this->document_title_align, 0, 1);
        $this->SetFont($font, $style, $size);
    }

    public function printTitle($title)
    {
        $this->SetFont($this->title_font, $this->title_style, $this->title_size);
        $this->MultiCell(0, $this->title_cell_height, $title, 0, $this->title_align, 0, 1);
        $this->resetFont();
    }

    public function printText($text, $multiline = false)
    {
        $this->resetFont();
        if (!$multiline) {
            $this->Cell(0, $this->cell_height, $text, 0, 1, 'L');
        } else {
            $this->MultiCell(0, $this->cell_height, $text, '', 'L', 0, 1);
        }
    }

    // MultiCell with bullet
    public function MultiCellBlt($w, $h, $blt, $txt, $border = 0, $align = 'J', $fill = 0, $ln = 1)
    {
    //  $font = $this->FontFamily;
    //  $style = $this->FontStyle;
    //  $size = $this->getFontSizePt();
        // $this->setFont('zapfdingbats', '', $size);

        //Get bullet width including margins
        $paddings = $this->getCellPaddings();
        $blt_width = $this->GetStringWidth($blt) + $paddings['L'] + $paddings['R'];

        //Save x
        $bak_x = $this->x;

        //Output bullet
//    $this->Cell($blt_width, $h, $this->unichr(0x0076) , 0, '', $fill);
        $this->Cell($blt_width, $h, $this->unichr(0x2022) , 0, '', $fill);
//    $this->SetFont($font, $style, $size);
        //Output text
        $this->MultiCell($w - $blt_width, $h, $txt, $border, $align, $fill, 1);

        //Restore x
        $this->x = $bak_x;
    }

    public function unichr($c)
    {
        if ($c <= 0x7F) { return chr($c); } elseif ($c <= 0x7FF) { return chr(0xC0 | $c >> 6) . chr(0x80 | $c & 0x3F); } elseif ($c <= 0xFFFF) {
                return chr(0xE0 | $c >> 12) . chr(0x80 | $c >> 6 & 0x3F)
                                                                        . chr(0x80 | $c & 0x3F);
        } elseif ($c <= 0x10FFFF) {
                return chr(0xF0 | $c >> 18) . chr(0x80 | $c >> 12 & 0x3F)
                                                                        . chr(0x80 | $c >> 6 & 0x3F)
                                                                        . chr(0x80 | $c & 0x3F);
        } else { return false; }
    }

    /**
     * TODO [OP 2010-06-24] Refactor method as per docs below.
     * @param Array $data  a multi-dimensional array containing the cell values. Required.
     * @param mixed $width either an integer representing the width of all columns,
     *                     or an array containing the widths of each column. Required.
     * @param mixed $align either a single value representing the alignment applicable
     *                     to the cells of all columns, or an array containing the
     *                     alignment for each column. Allowed values: 'L', 'R', 'C'
     *                     default 'L'.
     * @param mixed $border either a single value defining the borders applicable to
     *                      the cells of all columns, or an array containg the borders
     *                      for each column. Required.
     * @param mixed $font either a single value indicating the font of the cells of
     *                    all columns or an array defining the fonts for each column.
     *                    Required.
     * @param mixed $font_style either a single value indicating the font style of
     *                    the cells of all columns or an array defining the font
     *                    styles for each column. Required.
     * @param mixed $font_size either a single value indicating the font size of the
     *                    cells of all columns or an array defining the font size
     *                    for each column. Required.
     * @param int   $cell_height.   Required.
     * @param int   $min_row_height minimum row height (default 0)
     * @param Array $headers        an array of arrays containing the header information. Each array
     * defines a header row starting from the top (0 => first header row, etc.). Each header
     * row array is an associative array defining the following keys:
     * 'data' => the content of the header cells. Required.
     * 'width => widths of the header cells. Required.
     * 'align' => alignments of header cells. Default 'C'.
     * 'border' => borders of header cells. Required.
     * 'font' => font family of header cells. Required.
     * 'font_style' => font style of header cells. Required.
     * 'font_size' => font size of header cells. Required.
     * 'cell_height' => cell height. Required.
     * 'min_row_height' => minimum row height of header row (default 0)
     * 'fill' => fill values
     * All values except for keys 'data' and 'min_row_height' are either single values
     * (applying to all header cells) or an array containing values for each cell.
     */
    public function generateTable($data, $width, $align = 'L', $border, $font, $font_style, $font_size,
                                                                $cell_height, $min_row_height = 0,
                                                                $headers = array(), $footers = array(),
                                                                $fill = 0) {

        // print headers
        foreach ($headers as $h) {
            $this->__row($h['data'], $h['width'], $h['align'], $h['border'],
                                     $h['font'], $h['font_style'], $h['font_size'],
                                     $h['cell_height'], $h['min_row_height'], 0,
                                     isset($h['fill']) ? $h['fill'] : 0);
        }

        foreach ($data as $row) {
            // add a new page if necessary
            $height = $this->__row_height($row, $width, $align, $border, $font, $font_style, $font_size, $cell_height, $min_row_height);
            $dimensions = $this->getPageDimensions();
            if ($this->getY() + $height + $dimensions['bm'] >= $dimensions['hk']) {
                $x0 = $this->GetX();
                $this->addPage();
                $this->SetX($x0);
                // reprint the headers
                foreach ($headers as $h) {
                    $this->__row($h['data'], $h['width'], $h['align'], $h['border'],
                                             $h['font'], $h['font_style'], $h['font_size'],
                                             $h['cell_height'], $h['min_row_height'], 0,
                                             isset($h['fill']) ? $h['fill'] : 0);
                }
            }

            $this->__row($row, $width, $align, $border,
                                     $font, $font_style, $font_size,
                                     $cell_height, $min_row_height, $height, $fill);
        }

        // print footers
        foreach ($footers as $f) {
            $this->__row($f['data'], $f['width'], $f['align'], $f['border'],
                                     $f['font'], $f['font_style'], $f['font_size'],
                                     $f['cell_height'], $f['min_row_height'],
                                     isset($f['fill']) ? $f['fill'] : 0);
        }
    }

    /**
     * This function calculate table height
     *
     * @param  array $data
     * @param  mixed $width
     * @param  mixed $font
     * @param  mixed $font_style
     * @param  mixed $font_size
     * @param  int   $cell_height
     * @param  array $headers
     * @param  array $footers
     * @return int
     */
    public function getTableHeight($data, $width, $border, $font, $font_style, $font_size,
                                                                 $cell_height, $min_row_height = 0, $headers = array(), $footers = array()) {

        $height = 0;
        foreach ($headers as $h) {
            $height += $this->__row_height($h['data'], $h['width'], $h['align'],
                                                                         $h['border'], $h['font'],
                                                                         $h['font_style'], $h['font_size'],
                                                                         $h['cell_height'], $h['min_row_height']);
        }

        foreach ($data as $row) {
            $height += $this->__row_height($row, $width, '',
                                                                         $border, $font,
                                                                         $font_style, $font_size,
                                                                         $cell_height, $min_row_height);
        }

        foreach ($footers as $f) {
            $height += $this->__row_height($f['data'], $f['width'], $f['align'],
                                                                         $f['border'], $f['font'],
                                                                         $f['font_style'], $f['font_size'],
                                                                         $f['cell_height'], $f['min_row_height']);
        }

        return $height;
    }

    protected function __row($data, $width, $align = 'C', $border, $font, $font_style, $font_size, $cell_height, $min_height = 0, $height = 0, $fill = 0)
    {
        $x0 = $this->GetX();
        $y0 = $this->GetY();

        $x1 = $x0;

        if ($height == 0) {
            $height = $this->__row_height($data, $width, $align, $border, $font, $font_style, $font_size, $cell_height, $min_height);
        }

        $n = count($data);

        for ($i = 0; $i < $n; $i++) {
            $this->SetXY($x1, $y0);
            $this->SetFont(is_array($font) ? $font[$i] : $font,
                                         is_array($font_style) ? $font_style[$i] : $font_style,
                                         is_array($font_size) ? $font_size[$i] : $font_size);
            $this->MultiCell(is_array($width) ? $width[$i] : $width,
                                             $height,
                                             $data[$i],
                                             is_array($border) ? $border[$i] : $border,
                                             is_array($align) ? $align[$i] : $align,
                                             is_array($fill) ? $fill[$i] : $fill,
                                             1);

                $x1 += is_array($width) ? $width[$i] : $width;
                $height = max($height, $this->getY() - $y0);
        }

        $this->SetXY($x0, $y0 + $height);
    }

/**
     * This function calculate row height
     *
     * @param  array $data
     * @param  mixed $width
     * @param  mixed $font
     * @param  mixed $font_style
     * @param  mixed $font_size
     * @param  int   $cell_height
     * @return int
     */
    protected function __row_height($data, $width, $align, $border, $font, $font_style, $font_size, $cell_height, $min_height = 0)
    {
        $lines = array();
        $height = array($cell_height, $min_height);
        $n = count($data);
        $w = is_array($width) ? null : $width;
        for ($i = 0; $i < $n; $i++) {
            $this->SetFont(is_array($font) ? $font[$i] : $font,
                                         is_array($font_style) ? $font_style[$i] : $font_style,
                                         is_array($font_size) ? $font_size[$i] : $font_size);
            $height[] = $this->getStringHeight($w ? $w : $width[$i], $data[$i], false, true, $this->cell_padding, $border);
        }

        return max($height);
    }

    public function Header()
    {
        $this->addLogo();
        $this->addLetterhead();
//    $this->addWatermark();

        if ($this->getShowPageHeader()) {
            $this->SetY(max($this->GetY(), $this->getHeaderMargin()));
            $this->printPageHeader();
        }

        if ($this->getPaginate()) { $this->paginate(); }
    }

    protected function printPageHeader() {}

    public function Footer()
    {
        $cur_y = $this->y;
        $this->printPageFooter();
        $this->SetY($cur_y);
        $this->addWatermark();
    }


    public function printPageFooter() {}

    public function getLogo() { return $this->logo; }

    public function setLogo($logo) { $this->logo = $logo; }

    public function addLogo()
    {
    }

    public function getLetterhead() { return $this->letterhead; }

    public function setLetterhead($letterhead) { $this->letterhead = $letterhead; }

    protected function addLetterhead()
    {
        $letterhead = $this->getLetterhead();
        if (!$letterhead || !file_exists($letterhead) || is_dir($letterhead)) { return; }
        if (is_null($this->letterhead_idx)) {
            $this->setSourceFile($letterhead);
            $this->letterhead_idx = $this->importPage(1);
        }
        $this->useTemplate($this->letterhead_idx);
    }

    public function getWatermark() { return $this->watermark; }

    public function setWatermark($watermark) { $this->watermark = $watermark; }

    protected function addWatermark()
    {
        $watermark = $this->getWatermark();
        if (empty($watermark)) { return; }
        $color = $this->TextColor;
        $x = $this->GetX();
        $y = $this->getY();
        $this->SetFont($this->watermark_font, $this->watermark_style, $this->watermark_size);
        $this->SetTextColorArray($this->watermark_color);
        $this->setXY($this->lMargin, $this->h - $this->bMargin);
        $this->StartTransform();
        if ($this->CurOrientation == 'P') {
            $this->Rotate(60);
            $w = $this->w * 1.5;
        } else {
            $this->Rotate(30);
            $w = $this->h * 1.5;
        }
        $this->MultiCell($w,
                                         $this->watermark_cell,
                                         $watermark,
                                         0, 'C', 0, 0);
        $this->StopTransform();

        $this->SetXY($x, $y);
        $this->resetFont();
        $this->TextColor = $color;
    }

    public function sanitizeName($string = '')
    {
        $string = strtr(utf8_decode($string),
                                        utf8_decode("()!$'?: ,&+-/.ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ"),
                                        "--------------SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
/*
        htmlentities($string);
        $string = preg_replace("/&([a-z])[a-z]+;/i", "$1", $string);
*/
        // Replace all weird characters with dashes
//    $string = preg_replace('/[^\w\-]+/u', '-', $string);
        // Only allow one dash separator at a time (and make string lowercase)
        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }

    public function getPaginate()
    {
        return $this->paginate;
    }

    public function setPaginate($paginate)
    {
        $this->paginate = $paginate;
    }

    public function getPaginateFormat()
    {
        return $this->paginate_format;
    }

    public function setPaginateFormat($format)
    {
        $this->paginate_format = $format;
    }

    public function getShowPageHeader()
    {
        return $this->show_page_header;
    }

    public function setShowPageHeader($show)
    {
        $this->show_page_header = $show;
    }

    protected function paginate()
    {
        $this->SetFont($this->paginate_font_family, $this->paginate_font_style, $this->paginate_font_size);
//    $cell_height = round(($this->getCellHeightRatio() * $headerfont[2]) / $this->getScaleFactor(), 2);

        $this->SetX($this->paginate_x ?
                                    $this->paginate_x :
                                    ($this->getRTL() ? $this->rMargin : $this->lMargin));

        $this->SetY($this->paginate_y ? $this->paginate_y : max($this->getHeaderMargin(), $this->GetY()));

        if ($this->getRTL()) {
            $this->Cell(0, 0, $this->getPagination(), 0, 0, 'L');
        } else {
            $this->Cell(0, 0, $this->getPagination(), 0, 0, 'R');
        }
        $this->resetFont();
    }

    public function getPagination()
    {
        $params = empty($this->pagegroups) ?
                                array('%page%' => $this->getAliasNumPage(),
                                            '%pages%' => $this->getAliasNbPages()) :
                                array('%page%' => $this->getPageNumGroupAlias(),
                                            '%pages%' => $this->getPageGroupAlias());

                return strtr($this->getPaginateFormat(), $params);
    }

}

error_reporting($error_reporting);

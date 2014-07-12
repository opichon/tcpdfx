<?php
/**
 * Stop the original tcpdf config file loading
 */
if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {
	define ('K_TCPDF_EXTERNAL_CONFIG', true);
}

/**
 * path for PDF fonts
 * use K_PATH_MAIN.'fonts/old/' for old non-UTF8 fonts
 */
if (!defined('K_PATH_FONTS')) {
//	define ('K_PATH_FONTS', dirname(__FILE__).'/../data/fonts/');
}

/**
 * cache directory for temporary files (full path)
 */
if (!defined('K_PATH_CACHE')) {
//	define ('K_PATH_CACHE', dirname(__FILE__) . 'cache/');
}

/**
 * images directory
 */
if (!defined('K_PATH_IMAGES')) {
//	define ('K_PATH_IMAGES', K_PATH_MAIN.'images/');
}

/**
 * blank image
 */
if (!defined('K_BLANK_IMAGE')) {
//	define ('K_BLANK_IMAGE', K_PATH_IMAGES.'_blank.png');
}

/**
 * page format
 */
if (!defined('PDF_PAGE_FORMAT')) {
	define ('PDF_PAGE_FORMAT', 'A4');
}

/**
 * page orientation (P=portrait, L=landscape)
 */
if (!defined('PDF_PAGE_ORIENTATION')) {
	define ('PDF_PAGE_ORIENTATION', 'P');
}

/**
 * document creator
 */
if (!defined('PDF_CREATOR')) {
	define ('PDF_CREATOR', 'TCPDF');
}

/**
 * document author
 */
if (!defined('PDF_AUTHOR')) {
	define ('PDF_AUTHOR', 'TCPDF');
}

/**
 * header title
 */
if (!defined('PDF_HEADER_TITLE')) {
	define ('PDF_HEADER_TITLE', 'TCPDF Example');
}

/**
 * header description string
 */
if (!defined('PDF_HEADER_STRING')) {
	define ('PDF_HEADER_STRING', "by Nicola Asuni - Tecnick.com\nwww.tcpdf.org");
}

/**
 * image logo
 */
if (!defined('PDF_HEADER_LOGO')) {
	define ('PDF_HEADER_LOGO', 'tcpdf_logo.jpg');
}

/**
 * header logo image width [mm]
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_HEADER_LOGO_WIDTH', 30);
}

/**
 *  document unit of measure [pt=point, mm=millimeter, cm=centimeter, in=inch]
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_UNIT', 'mm');
}

/**
 * header margin
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_MARGIN_HEADER', 5);
}

/**
 * footer margin
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_MARGIN_FOOTER', 10);
}

/**
 * top margin
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_MARGIN_TOP', 27);
}

/**
 * bottom margin
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_MARGIN_BOTTOM', 25);
}

/**
 * left margin
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_MARGIN_LEFT', 15);
}

/**
 * right margin
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_MARGIN_RIGHT', 15);
}

/**
 * default main font name
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_FONT_NAME_MAIN', 'helvetica');
}

/**
 * default main font size
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_FONT_SIZE_MAIN', 10);
}

/**
 * default data font name
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_FONT_NAME_DATA', 'helvetica');
}

/**
 * default data font size
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_FONT_SIZE_DATA', 8);
}

/**
 * default monospaced font name
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_FONT_MONOSPACED', 'courier');
}

/**
 * ratio used to adjust the conversion of pixels to user units
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define ('PDF_IMAGE_SCALE_RATIO', 1.25);
}

/**
 * magnification factor for titles
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define('HEAD_MAGNIFICATION', 1.1);
}

/**
 * height of cell respect font height
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define('K_CELL_HEIGHT_RATIO', 1.25);
}

/**
 * title magnification respect main font size
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define('K_TITLE_MAGNIFICATION', 1.3);
}

/**
 * reduction factor for small font
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define('K_SMALL_RATIO', 2/3);
}

/**
 * set to true to enable the special procedure used to avoid the overlappind of symbols on Thai language
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define('K_THAI_TOPCHARS', true);
}

/**
 * if true allows to call TCPDF methods using HTML syntax
 * IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
 */
if (!defined('PDF_HEADER_LOGO_WIDTH')) {
	define('K_TCPDF_CALLS_IN_HTML', true);
}
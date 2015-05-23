<?php

namespace UAM\Pdf;

class Sanitizer
{
	private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Sanitizer();
        }

        return self::$instance;
    }

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function sanitizeName($string)
    {
        $string = strtr(
            utf8_decode($string),
            utf8_decode("()!$'?: ,&+-/.ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ"),
            "--------------SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy"
        );

        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }

    public function sanitize($filename)
    {
        $path_parts = pathinfo($filename);

        return sprintf(
            '%s/%s.%s',
            $path_parts['dirname'],
            $this->sanitizeName($path_parts['filename']),
            array_key_exists('extension', $path_parts) ? $path_parts['extension'] : 'pdf'
        );
    }
}
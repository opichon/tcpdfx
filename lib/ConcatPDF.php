<?php

namespace UAM\Pdf;

use FPDI;

class ConcatPDF extends FPDI
{
    protected $files = array();
    protected $files_orientation = array();

    public function setFiles($files, $files_orientation = array())
    {
        $this->files = $files;
        $this->files_orientation = $files_orientation;
    }

    public function concat()
    {
        $this->setDisplayMode('real');

        $this->setPrintHeader(false);

        $this->setPrintFooter(false);

        foreach ($this->files as $num => $file) {
            $pagecount = $this->setSourceFile($file);

            for ($i = 1; $i <= $pagecount; $i++) {
                $tplidx = $this->ImportPage($i);

                $s = $this->getTemplatesize($tplidx);

                $orientation = @$this->files_orientation[$num] ? $this->files_orientation[$num] : ($s['h'] > $s['w'] ? 'P' : 'L');

                $this->AddPage($orientation, array($s['w'], $s['h']));

                $this->useTemplate($tplidx);
            }
        }
    }

    public function Output($name = null, $dest = 'D')
    {
        $this->concat();

        $filename = $this->sanitize($name ? $name : $this->getName());

        parent::Output($name, $dest);

        return $filename;
    }

    protected function sanitize($filename)
    {
        return Sanitizer::getInstance()
            ->sanitize($filename);
    }
}

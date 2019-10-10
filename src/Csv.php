<?php

namespace Stash\Csv;

class Csv
{
    protected $file;

    protected $filePath;

    protected $delimiter = ',';

    protected $enclosure = '"';

    protected $escapeCharacter = '\\';

    public static function create(string $filePath = null)
    {
        $filePath = $filePath ?? sprintf('/tmp/%s.csv', static::randomName());

        return new static($filePath);
    }

    protected function __construct(string $filePath)
    {
        $this->filePath = $filePath;

        $this->file = fopen($filePath, 'w');

        if ($this->file === false) {
            throw new \Exception("Could not open file: $filePath for writing.", 1);
        }
    }

    public function write(array $fields)
    {
        $result = fputcsv($this->file, $fields, $this->delimiter, $this->enclosure, $this->escapeCharacter);

        if (false === $result) {
            throw new \Exception("Could not write to file: $this->filePath.", 1);
        }
    }

    public function filePath()
    {
        return $this->filePath;
    }

    public function delimiter($delimiter = null)
    {
        if (is_null($delimiter)) {
            return $this->delimiter;
        }

        $this->delimiter = $delimiter;

        return $this;
    }

    public function enclosure($enclosure = null)
    {
        if (is_null($enclosure)) {
            return $this->enclosure;
        }

        $this->enclosure = $enclosure;

        return $this;
    }

    public function escapeCharacter($escapeCharacter = null)
    {
        if (is_null($escapeCharacter)) {
            return $this->escapeCharacter;
        }

        $this->escapeCharacter = $escapeCharacter;

        return $this;
    }

    public static function randomName($length = 40)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    public function closeFile()
    {
        return fclose($this->file);
    }

    public function __destruct()
    {
        $this->closeFile();
    }
}

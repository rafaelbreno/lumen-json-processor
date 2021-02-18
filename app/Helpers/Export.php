<?php


namespace App\Helpers;


class Export
{
    private array $data;

    private $file;
    private array $format;
    private string $filename;
    private array $columns = [];
    /**
     * @var string[]
     */
    public array $headers;
    public \Closure $callback;

    public function __construct(array $data, string $filename = 'foo')
    {
        $this->data = $data;
        $this->filename = $filename;
        $this->file = fopen('php://output', 'w');
    }

//    public function __destruct()
//    {
//        fclose($this->file);
//    }

    /*
     * $format = [
     *      'keyInData' => 'keyInCsvColumn'
     * ]
     * */
    public function csv(array $format): Export
    {
        $this->setCsvConfig();

        $this->format = $format;

        $this->setCsvFile();

        return $this;
    }

//    public function getFile()
//    {
//        return $this->file;
//    }

    private function setColumns(): void
    {
        foreach ($this->format as $key => $value) {
            array_push($this->columns, $value);
        }
    }

    private function setCsvFile()
    {
        $this->setColumns();
        $this->callback = function () {
            fputcsv($this->file, $this->columns);
            foreach ($this->data as $key => $value) {
                $row = [];
                foreach ($this->format as $keyInData => $keyInCsv) {
                    $row[$keyInCsv] = $value[$keyInData];
                }
                fputcsv($this->file, $row);
            }
            fclose($this->file);
        };
    }

    private function setCsvConfig()
    {
        $this->filename .= ".csv";
        $this->headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $this->filename,
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
    }
}

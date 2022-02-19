<?php


class ParseCSV {

    public static $delimiter = ',';

    private $filename;
    private $header;
    private $data =[];
    private $row_count =0;

    public function __construct($filename='')
    {
        if($filename != ''){
            $this->file($filename);
        }
    }

    public function file($filename) {
        if(!file_exists($filename)) {
            echo "File is not exist";
            return false;
        } elseif(!is_readable($filename)) {
            echo "File is not readable";
            return false;
        } else {
            $this->filename = $filename;
            return true;
        }
    }

    public function parse() {
        // check if the filename is set
        if(!isset($this->filename)) {
            echo "File is not set.";
            return false;
        }
        // clear previous records 
        $this->reset();
        $file = fopen($this->filename, 'r');
        while(!feof($file)) {
            $row = fgetcsv($file, 0, self::$delimiter);
            if($row == [NULL] || $row === FALSE) { continue; }
            if(!$this->header) {
                $this->header = $row;
            } else {
                $this->data[] = array_combine($this->header, $row);
                $this->row_count++;
            }
        }
        fclose($file);
        return $this->data;
    }
    public function last_result() {
        return $this->data;
    }
    public function row_count(){
        return $this->row_count;
    }
    private function reset() {
        $this->header = NULL;
        $this->data = [];
        $this->row_count = 0;
    }
}

?>

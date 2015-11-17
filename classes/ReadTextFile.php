<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 10/14/2015
 * Time: 10:32 AM
 */

class ReadTextFile {

    private $fName = "";
    private $FilePointer = 0;

    public function __construct($filename){
        $this->fName = $filename;
    }

    // Reads lines of a text file in order
    public function readLine(){
        if (!$this->fName)
            return NULL;    //File not found

        $file_handle = fopen($this->fName, "rb");
        fseek($file_handle, $this->FilePointer);
        if(!feof($file_handle)){
            $value = fgets($file_handle);
            $this->FilePointer += strlen($value);
            fclose($file_handle);
            return $value;
        }
        else
            return NULL;
    }

    // Seeks to an identified line number
    public function seekLine($lineNumber){
        if (!$this->fName)
            return NULL;    //File not found

        $file_handle = fopen($this->fName, "rb");
        $this->resetFilePointer();
        for($i=0; $i<$lineNumber; $i++)
            $this->FilePointer += strlen(fgets($file_handle));
        return $this->FilePointer;
    }

    // Resets file pointer to the first position of the file
    private function resetFilePointer(){
        $this->FilePointer = 0;
    }

    // Returns number of file lines
    public function countLines(){
        if (!$this->fName)
            return NULL;    //File not found

        $file_handle = fopen($this->fName, "rb");
        $count = 0;
        while(!feof($file_handle)) {
            fgets ($file_handle);
            $count ++;
        }
        fclose($file_handle);
        return $count;
    }
}
?>

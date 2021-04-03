<?php

/**
 * @author KaplanOmer
 * @github https://github.com/KaplanOmr
 * @create 2021-04-02 23:00:42
 * @modify 2021-04-02 23:00:42
 * @desc File and Directory Scanner
 */

class FDScanner
{
    protected $mainPath;


    /**
     * @param string $customPath Main Path Costumize
     */
    public function __construct(string $customPath = null)
    {
        $this->mainPath = $customPath != null ? $customPath : dirname(__FILE__);
    }

    /**
     * Directory List
     * @param string $listPath Locked Path - Default: Main Path
     * @return array
     */
    public function list(string $listPath = null): array
    {
        $listPath = $this->implodePath($listPath);

        $respond = [];

        if ($handle = opendir($listPath)) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {
                    array_push($respond, $entry);
                }
            }

            closedir($handle);
        }

        return $this->checkArray($respond);
    }

    /**
     * Read File
     * @param string $readPath Read File Path
     * @return string
     */
    public function oneReadFile(string $readPath): string
    {
        $readPath = $this->implodePath($readPath);

        $file = fopen("$readPath", "r");

        if (!$file) {
            $respond = "Unable to open file!";
            return $this->checkString($respond);
        }

        $fileSize = filesize("$readPath");

        $respond = fread($file, $fileSize);

        fclose($file);

        return $this->checkString($respond);
    }

    /**
     * Read Files
     * @param string $readPath Read Files Path
     * @return array
     */
    public function manyReadFile(string $readPath): array
    {
        $readPath = $this->implodePath($readPath);

        $respond = [];

        if ($handle = opendir($readPath)) {

            while (false !== ($entry = readdir($handle))) {

                $expEntry = explode(".", $entry);
                if(!isset($expEntry[1])) continue;


                if ($entry != "." && $entry != "..") {

                    $file = fopen("$readPath/$entry", "r");

                    if (!$file) {
                        array_push($respond, "Unable to open file!");
                        return $this->checkArray($respond);
                    }

                    $fileSize = filesize("$readPath/$entry");

                    array_push($respond, [
                        "file" => $entry,
                        "content" => fread($file, $fileSize)
                    ]);
                    fclose($file);
                }
            }

            closedir($handle);
        }

        return $this->checkArray($respond);
    }

    /**
     * Search File
     * @param string $fileName Searching File
     * @param string $searchPath Search Path
     * @return array
     */

    public function searchFileName(string $fileName, string $searchPath = null): array
    {
        $searchPath = $this->implodePath($searchPath);

        $respond = [];

        if ($handle = opendir($searchPath)) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {

                    $expEntry = explode('.', $entry);
                    var_dump($expEntry);
                    if (isset($expEntry[1]) && strstr($expEntry[0], $fileName)) {
                        array_push($respond, $entry);
                    }
                }
            }

            closedir($handle);
        }

        return $this->checkArray($respond);
    }

    /**
     * Search File With Extentions
     * @param string $fileNameExtentions Searching File Name Extentions
     * @param string $searchPath Search Path
     * @return array
     */
    public function searchFileNameExtentions(string $fileNameExtentions, string $searchPath = null): array
    {
        $searchPath = $this->implodePath($searchPath);

        $respond = [];

        if ($handle = opendir($searchPath)) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {

                    $expEntry = explode('.', $entry);
                    if (isset($expEntry[1]) && strstr($expEntry[array_key_last($expEntry)], $fileNameExtentions)) {
                        array_push($respond, $entry);
                    }
                }
            }

            closedir($handle);
        }

        return $this->checkArray($respond);
    }

    /**
     * Custom Path Imploder
     * @param string $addingPath Add Path
     * @return string
     */
    private function implodePath(string $addingPath = null): string
    {

        if ($addingPath != null) {
            return $this->mainPath . "/" . $addingPath;
        }

        return $this->mainPath;
    }

    /**
     * Check Respond Array
     * @param array $respond Respond Array
     * @return array
     */
    private function checkArray(array $respond): array
    {
        if (count($respond) == 0) {
            return ["Not Found!"];
        }

        return $respond;
    }

    /**
     * Check Respond String
     * @param array $respond Respond String
     * @return string
     */
    private function checkString(string $respond): string
    {
        if (strlen($respond) == 0) {
            return "Not Found!";
        }

        return $respond;
    }
}

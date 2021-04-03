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

    public function __construct(string $customPath = null)
    {
        $this->mainPath = $customPath != null ? $customPath : dirname(__FILE__);
    }

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

    public function manyReadFile(string $readPath): array
    {
        $readPath = $this->implodePath($readPath);

        $respond = [];

        if ($handle = opendir($readPath)) {

            while (false !== ($entry = readdir($handle))) {

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

    private function implodePath(string $addingPath = null): string
    {

        if ($addingPath != null) {
            return $this->mainPath . "/" . $addingPath;
        }

        return $this->mainPath;
    }

    private function checkArray(array $respond): array
    {
        if (count($respond) == 0) {
            return ["Not Found!"];
        }

        return $respond;
    }

    private function checkString(string $respond): string
    {
        if (strlen($respond) == 0) {
            return "Not Found!";
        }

        return $respond;
    }
}

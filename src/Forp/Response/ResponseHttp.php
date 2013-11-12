<?php
namespace Forp\Response;

/**
 * ResponseHttp
 */
class ResponseHttp extends Response
{
    /**
     * @throws \Forp\OutOfBoundsException
     */
    public function send()
    {
        ob_start();
        forp_json();
        $json = ob_get_clean();

        $parts = explode(
            "\n",
            chunk_split($json, 1000, "\n")
        );
        foreach($parts as $i=>$part) {
            $part = trim($part);
            if(empty($part)) continue;
            echo 'chunk:' . $part . '<br>';
            header("X-Forp-Stack_" . $i . ": _" . $part);
            if ($i > 99999) {
                throw new \Forp\OutOfBoundsException('Can\t exceed 99999 chunks.');
            }
        }
    }
}
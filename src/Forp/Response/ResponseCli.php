<?php
namespace Forp\Response;

/**
 * ResponseCli
 */
class ResponseCli extends Response
{
    public function send()
    {
        forp_print();
    }
}

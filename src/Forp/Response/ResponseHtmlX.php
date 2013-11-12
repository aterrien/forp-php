<?php
namespace Forp\Response;

/**
 * ResponseHtmlX
 */
class ResponseHtmlX extends Response
{
    public function send()
    {
        ?><i/><script type='application/x-forp-stack' id=forpStack>
        <?php forp_json(); ?>
        </script><?php
    }
}
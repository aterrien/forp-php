<?php
namespace Forp;

/**
 * Forp
 *
 * @author aterrien
 */
class Forp {

    /**
     * @var array $conf Default configuration
     */
    private $conf = array(
        'version' => '1.1.0',
        'no_internals' => 1,
        'ui_src' => 'http://aterrien.github.io/forp-ui/javascripts/forp.min.js',
        'async' => false,
    );

    /**
     * @return array Configuration
     */
    public function getConf()
    {
        return $this->conf;
    }

    /**
     * @param array $opts Configuration
     */
    public function start($opts = array())
    {
        if(function_exists('forp_start')) {
            $this->conf = array_merge($this->conf, $opts);
            $self = $this;
            register_shutdown_function(
                /**
                 * @ProfileAlias("forp_end")
                 */
                function() use ($self) {

                    // Prevents to profile Forp himself
                    forp_end();

                    $response = new Response\Response($self->getConf());
                    $response->send();
                }
            );

            // Configure forp extension
            ini_set("forp.no_internals", $this->conf['no_internals']);
            if(php_sapi_name() == "cli") {
                ini_set('forp.max_nesting_level', 2);
            }


            forp_start();
        }
    }

}
/*
require '../autoload.php';
$f = new Forp();
$f->start();
*/
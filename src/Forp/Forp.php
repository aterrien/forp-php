<?php
namespace Forp;

/**
 * Forp
 *
 * @author aterrien
 */
class Forp {

    CONST DEFAULT_UI_SRC = 'http://cdn.forp.io/js/forp.min.js';

    CONST FLAG_TIME       = 0x0001; // 1
    CONST FLAG_MEMORY     = 0x0002; // 2
    CONST FLAG_CPU        = 0x0004; // 4
    CONST FLAG_ALIAS      = 0x0020; // 32
    CONST FLAG_CAPTION    = 0x0040; // 64
    CONST FLAG_GROUPS     = 0x0080; // 128
    CONST FLAG_HIGHLIGHT  = 0x0100; // 256
    CONST FLAG_ANNOTATIONS= 0x01E0; // 480 = ALIAS | CAPTION | GROUPS | HIGHLIGHT
    CONST FLAG_ALL        = 0x03FF; // 1023 = ALL

    /**
     * @var array $conf Default configuration
     */
    private $conf = array(
        'version' => '1.1.0',
        'no_internals' => 1,
        'flags' => self::FLAG_ALL,
        'ui_src' => self::DEFAULT_UI_SRC,
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
            
            // Register for shutdown
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

            // Handles flags
            $flags = 0;
            if(!empty($this->conf['flags'])) {
                (($this->conf['flags'] & self::FLAG_TIME) == self::FLAG_TIME) && $flags |= FORP_FLAG_TIME;
                (($this->conf['flags'] & self::FLAG_MEMORY) == self::FLAG_MEMORY) && $flags |= FORP_FLAG_MEMORY;
                (($this->conf['flags'] & self::FLAG_CPU) == self::FLAG_CPU) && $flags |= FORP_FLAG_CPU;
                (($this->conf['flags'] & self::FLAG_ALIAS) == self::FLAG_ALIAS) && $flags |= FORP_FLAG_ALIAS;
                (($this->conf['flags'] & self::FLAG_CAPTION) == self::FLAG_CAPTION) && $flags |= FORP_FLAG_CAPTION;
                (($this->conf['flags'] & self::FLAG_GROUPS) == self::FLAG_GROUPS) && $flags |= FORP_FLAG_GROUPS;
                (($this->conf['flags'] & self::FLAG_HIGHLIGHT) == self::FLAG_HIGHLIGHT) && $flags |= FORP_FLAG_HIGHLIGHT;
                (($this->conf['flags'] & self::FLAG_ANNOTATIONS) == self::FLAG_ANNOTATIONS) && $flags |= FORP_FLAG_ANNOTATIONS;
                (($this->conf['flags'] & self::FLAG_ALL) == self::FLAG_ALL) && $flags |= FORP_FLAG_ALL;
            }

            // Starts collector
            forp_start($flags);
        }
    }
}
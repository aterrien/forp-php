<?php
namespace Forp\Response;

/**
 * IResponse
 */
interface IResponse
{
    public function send();
}

/**
 * Response
 *
 * IResponse Factory
 *
 * @author aterrien
 */
class Response implements IResponse
{
    /**
     * @var array $conf
     */
    private $conf;

    /**
     * @param array $opts
     * @return \Forp\IResponse
     */
    public function __construct($opts)
    {
        $this->conf = $opts;
    }

    /**
     * @return \Forp\IResponse
     */
    protected function getConf($k)
    {
        return $this->conf[$k];
    }

    /**
     * @return \Forp\IResponse
     */
    protected function getResponse()
    {
        if(php_sapi_name() === "cli") {
            return new ResponseCli($this->conf);
        }

        // priority to send forp datas in HTTP headers
        // forp client is a browser extension
        if(isset($_SERVER)
           && isset($_SERVER['HTTP_X_FORP_VERSION'])
        ) {
            header('X-Forp-Version:'. $this->conf['version']);

            if(
               !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
               && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {
                // send forp datas in HTTP headers
                // XHR communication case
                return new ResponseHttp($this->conf);
            } else {
                // headers size limitation on Chrome
                return new ResponseHtmlX($this->conf);
            }
        }

        // asynchrone JavaScript loading + inline JavaScript
        if($this->getConf('async')) {
            return new ResponseHtmlAsync($this->conf);
        }

        // JavaScript loading + inline JavaScript
        return new ResponseHtml($this->conf);
    }

    /**
     * @return \Forp\IResponse
     */
    public function send()
    {
        $this->getResponse()
             ->send();

        return $this;
    }
}
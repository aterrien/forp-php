<?php
namespace Forp\Response;

/**
 * ResponseHtml
 */
class ResponseHtml extends Response
{
    public function send()
    {
        ?>
        <div class="forp"></div>
        <script src="<?php echo $this->getConf('ui_src'); ?>"></script>
        <script>
            (function($) {
               $(".forp").forp({
                    stack : <?php forp_json(); ?>,
                    mode : "fixed"
                })
            })(jMicro);
        </script>
        <?php
    }
}
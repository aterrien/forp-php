<?php
namespace Forp\Response;

/**
 * ResponseHtmlAsync
 */
class ResponseHtmlAsync extends Response
{
    public function send()
    {
        ?><i/>
<div class="forp"></div>
<script type="text/javascript">
    var _forpguiStack = <?php forp_json(); ?>,
    _forpguiSrc = "<?php echo $this->getConf('ui_src');?>";
</script>
<script type="text/javascript">
(function() {
    var fg = document.createElement('script');
    fg.type = 'text/javascript';
    fg.async = true;
    fg.src = _forpguiSrc;
    fg.onload = (function($) {
       $(".forp").forp({
            stack : _forpguiStack,
            mode : "fixed"
        })
    })(jMicro);
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(fg);
})();
</script>
        <?php
    }
}


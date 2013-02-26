<script type="text/javascript">
$(document).ready(function(){
    $("select").each(function(){
        if ($(this).is('.hide') === false)
        {
            $(this).chosen();
        }
    });
});
</script>

<?php
if (isset($content) === true && is_array($content))
{
    foreach ($content as $piece)
    {
        echo $piece;
    }
}
elseif(isset($content) === true)
{
    echo $content;
}

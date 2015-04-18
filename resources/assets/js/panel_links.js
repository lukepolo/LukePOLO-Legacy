$(document).on('click', '.panel-links .panel-body', function(e)
{
    var href = $(this).find('a').attr('href');
    if(href)
    {
        window.location = href;
    }
});
$(document).on('click', '.panel-links .panel-body', function(e)
{
    var link = $(this).find('a');
    if(link.attr('href'))
    {
        if(link.attr('target'))
        {
            window.open(link.attr('href'), link.attr('target'));
        }
        else
        {
            window.location = link.attr('href');
        }
    }
});
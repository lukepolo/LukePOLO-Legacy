$(document).on('click', 'circle', function()
{
    if($('#'+$(this).data('project_id')).length != 0)
    {
        hide_details();
        show_project($(this).data('project_id'));
    }
});

$(document).on('mouseover', 'circle', function()
{
    var project = $('div[data-project_id="'+ $(this).data('project_id') +'"]').closest('.project');
    project.css('opacity', 1);
});

$(document).on('mouseout', 'circle', function()
{
    var project = $('div[data-project_id="'+ $(this).data('project_id') +'"]').closest('.project');
    project.css('opacity', '');
});

$(document).on('click', '.img-holder', function()
{
    show_project($(this).data('project_id'));
});

$(document).on('click', '.show_projects', function()
{
    show_projects();
    hide_details();
});

var small_bar = $('.mini-bar');

function scroll_to_mini_bar()
{
    if(small_bar.visible() == false)
    {
        $('html, body').animate({
            scrollTop: small_bar.offset().top
        }, 200);
    }
}

function show_project(id)
{
    $('.select-title, .project').hide();
    $('#'+id).show();
    $('body,html').scroll();
    scroll_to_mini_bar();
}

function hide_details()
{
    $('.project-details').hide()
}

function show_projects()
{
    $('.projects').css('opacity', '');
    $('.select-title, .project').show();
}
$(document).on("click", ".confirm", function (e) {
    var link = $(this);
    e.preventDefault();
    bootbox.confirm("Are you sure?", function (response) {
        if (response) {
            window.location = link.attr('href');
        }
    });
});
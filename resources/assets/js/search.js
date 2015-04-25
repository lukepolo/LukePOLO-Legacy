$('#blog-search').select2({
    placeholder: "Search for a blog . . .",
    ajax: {
        url: "/search",
        dataType: 'json',
        delay: 250,
        data: function(params)
        {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function(data, page)
        {
            return {
                results: data
            };
        },
        cache: true
    },
    minimumInputLength: 1,
    escapeMarkup: function(markup)
    {
        return markup;
    },
    templateResult: function(data)
    {
        console.log(data);
        if(data.text)
        {
            return '<span data-url="' + data.action + '">' + data.text + '</span>';
        }
    },
    templateSelection: function(data)
    {
        if(data.action)
        {
            window.location = data.action;
        }
        die;
    }
});
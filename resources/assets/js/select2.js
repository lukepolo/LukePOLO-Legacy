$('select').each(function () {
    if (!$(this).hasClass('phpdebugbar-datasets-switcher')) {
        if (typeof($._data(this).hasDataAttrs) == 'undefined') {
            var selected = '';
            if (!$(this).attr('multiple') && $(this).find('option[selected]').length == 0) {
                selected = 'selected';
            }
            $(this).prepend($('<option ' + selected + '></option>')).select2({placeholder: "Please select an Option"});
        }
    }
});
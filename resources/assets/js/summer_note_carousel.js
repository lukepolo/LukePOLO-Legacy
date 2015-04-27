(function (factory) {
    /* global define */
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals: jQuery
        factory(window.jQuery);
    }
}(function ($) {
    // template
    var tmpl = $.summernote.renderer.getTemplate();

    /**
     * @class plugin.hello
     *
     * Hello Plugin
     */
    $.summernote.addPlugin({
        /** @property {String} name name of plugin */
        name: 'hello',
        /**
         * @property {Object} buttons
         * @property {Function} buttons.hello   function to make button
         */
        buttons: { // buttons
            hello: function () {

                return tmpl.iconButton('fa fa-header', {
                    event : 'hello',
                    title: 'hello',
                    hide: true
                });
            }
        },

        /**
         * @property {Object} events
         * @property {Function} events.hello  run function when button that has a 'hello' event name  fires click
         */
        events: { // events
            hello: function (event, editor, layoutInfo) {
                // Get current editable node
                var $editable = layoutInfo.editable();

                // Call insertText with 'hello'
                editor.insertText($editable, '<div class="owl-carousel">\
                <div><img src=""></div>\
                <div><img src=""></div>\
                <div> Your Content </div>\
                </div>');
            }
        }
    });
}));

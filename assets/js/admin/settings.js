/* globals jQuery, nssAdminSettings */
(function ($) {
    var opts = $.extend({
        textCopyShortcode: '',
        textCopied: ''
    }, nssAdminSettings);

    function ShortcodeGuide() {
        var atts = $('#nss-sg-atts'),
            services = $('#nss-sg-services'),
            template = $('#nss-sg-template'),
            variant = $('#nss-sg-variant');

        var updateAtts = function () {
            var items = [];

            items.push(generateServiceAtts());
            items.push(generateTemplateAtts());
            items.push(generateVariantAtts());

            items = items.filter(function (item) {
                return item.length > 0;
            });

            if (items.length) {
                atts.text(' ' + items.join(' '));
            } else {
                atts.text('');
            }
        };

        var generateServiceAtts = function () {
            var items = services.find('input[type="checkbox"]:checked'),
                checked = [];

            $.each(items, function (idx, item) {
                checked.push(item.value);
            });

            if (checked.length) {
                return 'available="' + checked.join(',') + '"';
            } else {
                return '';
            }
        };

        var generateTemplateAtts = function (e) {
            var value = template.val().trim();

            if (value.trim().length) {
                return 'template="' + value + '"';
            } else {
                return '';
            }
        };

        var generateVariantAtts = function (e) {
            var value = variant.val().trim();

            if (value.trim().length) {
                return 'variant="' + value + '"';
            } else {
                return '';
            }
        }

        this.onSortableUpdate = function () {
            updateAtts();
        };

        services.find('input[type="checkbox"]').on('change', updateAtts);
        template.on('keyup', updateAtts);
        variant.on('keyup', updateAtts);

        $('#nss-sg-copy').on('click', function (e) {
            var target = $(e.target),
                shortcode = $('#nss-sg').text().trim(),
                input;

            e.preventDefault();

            input = $('<input>', {
                type: 'text',
                value: shortcode
            }).appendTo($(document.body));

            input[0].select();
            input[0].setSelectionRange(0, shortcode.length);
            document.execCommand('copy');
            input.remove();

            target.text(opts.textCopied);
            setTimeout(function () {
                target.text(opts.textCopyShortcode);
            }, 3000);
        });

        $('#nss-sg-toggle').on('click', function (e) {
            e.preventDefault();
            $('#nss-sg-wrap').slideToggle();
        });
    }

    $(document).ready(function () {
        var shortcodeGuide = new ShortcodeGuide();

        $('.nss-available-widget').sortable();

        $('#nss-sg-services').sortable({
            update: shortcodeGuide.onSortableUpdate
        });

        window.nssShortcodeGuide = shortcodeGuide;
    });
})(jQuery);

define(["jquery", "Magento_Ui/js/modal/alert"], function ($, alert) {
    $(document).ready(function () {
        $('.weltpixel-quickview').remove();
        $(".multimedia").click(function () {
            var data = $(this).attr('data-youtube');
            $('.param-video').attr('src', data);
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: false,
                title: $.mage.__('Video'),
                closed: function () {
                    $('.param-video').attr('src', '');
                },
                buttons: [{
                        text: $.mage.__('Cerrar'),
                        class: '',
                        click: function () {
                            this.closeModal();
                        }
                    }]
            };
            var mod = $("#popup-multimedia").modal(options);
            mod.modal('openModal');
        });
        $("#share-form").click(function () {
            var data = $(this).attr('data-prod');
            var prodId = $(this).attr('data-id');
            $('#popup-share').attr('data-prod', data);
            $('#popup-share').attr('data-prod', data);
            $('.share-url').attr('value', data);
            $('.share-id').attr('value', prodId);
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: false,
                title: $.mage.__('Share'),
                closed: function () {
                    $('#popup-share').attr('data-prod', '');
                    $('.share-url').attr('value', '');
                    $('.share-id').attr('value', '');
                },
                buttons: [{
                        text: $.mage.__('Cerrar'),
                        class: '',
                        click: function () {
                            this.closeModal();
                        }
                    }]
            };
            var mod = $("#popup-share").modal(options);
            mod.modal('openModal');
        });

    });
});
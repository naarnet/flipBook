define(
        [
            "jquery",
            "mage/storage",
            "Magento_Ui/js/modal/alert"
        ], function ($, storage, alert) {
    'use strict';
    $.widget('qbo.flipbook', {
        options: {
            urlflipbook: ''
        },
        _create: function () {
            $('.weltpixel-quickview').remove();
            this.shareform();
            this.popupflipbook();
            this.popupYoutube();
        },
        popupYoutube: function () {
            $(".multimedia").click(function () {
                console.log('hola');
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
        },
        popupflipbook: function () {
            var that = this;
            $(".showFlipbookAction").click(function () {
                var url = $(this).attr("data-url");

                alert({
                    title: "success",
                    content: '<iframe id="f1" class="demo-iframe" src="' + url + '" seamless="seamless" scrolling="No" frameborder="0" allowtransparency="true" style="height: 100%; width: 100%;"></iframe>',
                    actions: {
                        always: function () {}
                    }
                });

                $(".modal-header").hide();
                $(".modal-footer").hide();
                $(".modal-inner-wrap").css({"width": "100%", "height": "100%", "margin-top": "0", "position": "fixed"});
                $("#iframeflipbook").css({"width": "100%", "height": "100%", "position": "absolute", "left": "0"});
                $(".confirm").addClass("popup-important-flipbook");

                $('<p class="close-popup-flipbook">x</p>').appendTo(".modal-popup");

                $(".modal-content").css({"height": "100%", "width": "100%", "max-height": "100% !important", "padding": "0"});
                $(".modal-content div").css({"height": "100%", "width": "100%"});

                var is_OSX = navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i)
                if (is_OSX) {
                    $(".confirm").addClass("iphoneModalFlip");
                }

                $(".close-popup-flipbook").click(function () {
                    $(".popup-important-flipbook").remove();
                    $(".modals-overlay").remove();
                    $(".modal-header").show();
                    $(".modal-footer").show();
                    $(".modal-content").removeAttr("style");
                    $(".modal-content").css({"height": "100%"});
                    $(".modal-popup").removeAttr("style");
                    $(".modal-popup").css({"z-index": "999"});
                    $(".modal-inner-wrap").removeAttr("style");
                    $(".modal-inner-wrap").css({"height": "100%"});
                    $("#popup-share").css({"height": "100%", "width": "90%"});
                    $(".close-popup-flipbook").remove();
                    $("body").css("overflow", "auto");
                });
            });
        },
        shareform: function () {
            $(".share-form").click(function () {
                var data = $(this).attr('data-prod');
                var prodId = $(this).attr('data-id');
                $('#popup-share').attr('data-prod', data);
                $('#popup-share').attr('data-prod', data);
                $('.share-url').attr('value', data);
                $('.share-id').attr('value', prodId);
                $(".max-recipient-message").hide();
                $("body").css({"overflow": "hidden", "position": "fixed"});
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
                            class: 'action-close',
                            click: function () {
                                this.closeModal();
                            }
                        }]
                };
                var mod = $("#popup-share").modal(options);
                mod.modal('openModal');
                $(".modal-slide").addClass("modal-popup");
                $(".modal-slide").addClass("popup-emailfriend");
                $(".modal-slide").addClass("modal-slide");
                $(".modal-slide").addClass("_inner-scroll");
                $("#sender-message").val("");
                var is_OSX = navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i)
                if (is_OSX) {
                    $(".modal-slide").addClass("iphoneModal");
                }
                if (/Edge\/|Trident\/|MSIE /.test(window.navigator.userAgent)) {
                    $(".modal-content").css("height", "237px");
                }
                $(".action-close").click(function () {
                    $("body").css({"overflow": "auto", "position": "relative"});
                });
                $(".modals-overlay").click(function () {
                    $("body").css({"overflow": "auto", "position": "relative"});
                });
            });
        },
        alertGen: function (title, content) {
            alert({
                title: title,
                content: content,
                actions: {
                    always: function () {}
                }
            });
        }
    });
    return $.qbo.flipbook;
}
);

var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    Pc: function () {
        var OSName = "Unknown OS";
        if (navigator.appVersion.indexOf("Win") != -1)
            OSName = "Windows";
        if (navigator.appVersion.indexOf("Mac") != -1)
            OSName = "MacOS";
        if (navigator.appVersion.indexOf("X11") != -1)
            OSName = "UNIX";
        if (navigator.appVersion.indexOf("Linux") != -1)
            OSName = "Linux";
        return OSName;
    },
    any: function () {
        return (isMobile.BlackBerry() || isMobile.Opera() || isMobile.Windows() || isMobile.Pc());
    }
};

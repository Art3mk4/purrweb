var ConfirmDeleteView = function() {
    var $confirmDeleteBtn = jQuery('.confirmDeleteBtn'),
        $negativeDeleteBtn = jQuery('.negativeDeleteBtn'),
        $popupCloseBtn = jQuery('.a-popup__close'),
        $deleteOperatorPopup = jQuery('.deleteOperatorPopup'),
        that = this;

    this.init = function() {
        bindEvents();  
    };
    var bindEvents = function() {
        $confirmDeleteBtn.on('click', confirmDeleteButton);
        $negativeDeleteBtn.on('click', cancelDeleteRow);
        $popupCloseBtn.on('click', cancelDeleteRow);
    };
    var confirmDeleteButton = function(e) {

        if (that.ids.length != 0) {

            jQuery('body').css('cursor', 'wait');
            appRequest.send(that.url, 'POST', {id: that.ids}, {
                success: function() {
                    jQuery('body').css('cursor', 'default');
                    location.reload();
                },
            });

            $('body').removeClass('m-overlay');
            $deleteOperatorPopup.hide();
        }
        else {
            jQuery('body').css('cursor', 'default');
            alert("Выберите элемент для удаления");
        }
        return false;
    };
    this.show = function(ids, url) {
        this.ids = ids;
        this.url = url;

        $('body').addClass('m-overlay');
        $deleteOperatorPopup.show();
        return false;
    };
    var cancelDeleteRow = function() {
        var body = $('body');
        body.removeClass('m-overlay');
        if (body.hasClass('m-overlayQuote')) {
             body.removeClass('m-overlayQuote');
        }
        $('.popup').hide();

        return false;
    };

    this.init();
};
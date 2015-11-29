jQuery(document).ready(function() {
    var AddSelectOption = function() {
        var $addOptiomBtn = jQuery('.m-addOptionBtn'),
            $confirmAddOptionBtn = jQuery('.confirmAddOptionBtn'),
            that = this;

        this.init = function() {
            $addOptiomBtn.tooltip();
            bindEvents();  
        };
        var bindEvents = function() {
            $addOptiomBtn.on('click', showPopup);
            $confirmAddOptionBtn.on('click', confirmAddOption);

        };
        var confirmAddOption = function(e) {
            e.preventDefault();
            
            var inputVal = $(this).parents('.addOptionPopup').find('.f-fieldSetText').val();
                url = $(this).data('url');
            if (inputVal == "") {
                alert("Введите значение");
            } else {
                appRequest.send(url, 'POST', {addSelect: inputVal}, {
                    success: function() {
                        hideAllPopup();
                        location.reload();
                    },
                });
            }   
            
        };
        var showPopup = function(e) {
            e.preventDefault();
            var popup = $(this).parent().find('.addOptionPopup');

            $('body').addClass('m-overlay');
            popup.show();
        };
        var hideAllPopup = function() {
            $('body').removeClass('m-overlay');
            $('.popup').hide();
        }
        this.init();
    };

    var addSelectOption = new AddSelectOption();
});
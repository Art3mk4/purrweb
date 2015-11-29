
jQuery(document).ready(function() {

    var LoginView = function(option) {
        var $loginForm = jQuery(option.loginForm),
            $loginField = $loginForm.find('.loginForm__row').find('input');
            that = this;

        this.init = function() {
            bindEvents();
        };
        var bindEvents = function() {
            $loginField.on('focus', focusElement);
            $loginField.on('blur', blurElement);
        };
        var focusElement = function(event) {
            jQuery(event.target).parent().addClass('focusElement');
        };
        var blurElement = function(event) {
            jQuery(event.target).parent().removeClass('focusElement');
        };

        this.init();
    };

    var loginView = new LoginView({
        loginForm: '#loginForm'
    });

});

var systemMessage = {

    ERROR: 1,
    INFO: 2,

    show: function(msg, type) {
        _.bindAll(this);

        var template,
            self = this;

        if (type == this.ERROR) {
            template = $('#errorAlert').html();
        } else {
            template = $('#successAlert').html();
        }

        var content = _.template(template, {msg: msg});
        $('.mainContent__header').append(content);

        setTimeout(function() {
            self.hide();
        }, 3000);
    },
    hide: function() {
        $('.mainContent__header').find('.systemMessage').remove();    
    }   
};

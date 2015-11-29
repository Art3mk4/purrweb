var appRequest = {
    send: function(url, type, data, options) {
        var options = options || {};

        $.ajax({
            type: type,
            dataType: "json",
            url: url,   
            data: data,                                 
            success: function (resp) {

                if (resp.success && resp.success == 'true') {
                    if (options.success) {
                        options.success(resp.results);
                    }
                }
                else {
                    systemMessage.show(resp.message, systemMessage.ERROR);

                    if (options.error) {
                        options.error(resp.message);
                    }
                }
            },
            error: function (resp) {
                systemMessage.show(resp.responseText, systemMessage.ERROR);
                if (options.error) {
                    options.error(resp.responseText);
                }
            }                   
        });
    }
};
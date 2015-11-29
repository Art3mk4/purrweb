var alert = alert || function () {'use strict'; },
    alertBox = alertBox || function (msg) { 'use strict'; alert(msg); },
    jobProgress = {};

jobProgress.Widget = (function () {
    'use strict';

    var widget = function (options) {
        _.bindAll(this);
        this.options = {
            containerSelector: ''
        };
        jQuery.extend(this.options, options);
        
        this.model = new jobProgress.Model(options);
        this.container = $(this.options.containerSelector);


        this._render();
        this._callbacks = {};
    };

    widget.prototype._getTemplate = function () {
        this.stopButtonSelector = '.stopProgress';
        this.progressSelector = '.progress';

        return '<div class="runProgress" style="display:none;"> ' +
                    '<div class="progress"></div>' +
                    '<input type="button" class="stopProgress" value="Остановить процесс" />' +
                '</div>';
    };

    widget.prototype._render = function () {
        this.template = $(this._getTemplate());
        this.container.after(this.template);
        this._element = $(this.progressSelector);
        $(this.stopButtonSelector).bind('click', this.stop);

    };

    widget.prototype._show = function () {
        this.container.hide();
        this.template.show();
    };
    
    widget.prototype._hide = function () {
        this.template.hide();
        this.container.show();
    
    };

    widget.prototype.start = function (url, data) {
        var self = this;

        this.model.start(url, data, {
            success: function () {
                self.startProgress();
            },
        });
    };

    widget.prototype.startProgress = function () {
        var self = this;
        this._show();
        this._intervalId = setInterval(function () {
            self.update();
        }, 1000);
    };

    widget.prototype.stopProgress = function () {
        clearInterval(this._intervalId);
        this._hide();
    };

    widget.prototype.stop = function () {
        var self = this;
        this.model.stop({
            sucess: function () {
                self.stopProgress();
            },
            error: function () {
                self.stopProgress();
            }
        });
    };

    widget.prototype._updateProgress = function (progressCount) {
        this._element.progressbar({
            value: progressCount
        });
    };

    widget.prototype.update = function () {
        var self = this;
        this.model.update({
            success: function (results) {
                self._updateProgress(self.model.progressCount);

                if (self.model.isFinish()) {
                    self.triggerEvent('finish', results);
                    self.stopProgress();
                }
            },
            error: function () {
                self.stopProgress();
            }
        });
    };

    widget.prototype.addEvent = function (evname, callback) {
        if (!this._callbacks[evname]) {
            this._callbacks[evname] = $.Callbacks();
        }
        this._callbacks[evname].add(callback);
    };
    
    widget.prototype.removeEvent = function (evname, callback) {
        if (!this._callbacks[evname]) {
            return;
        }
        this._callbacks[evname].remove(callback);
    };

    widget.prototype.triggerEvent = function (evname, params) {
        if (this._callbacks[evname]) {
            this._callbacks[evname].fire(params);
        }
    };

    return widget;
}());

jobProgress.Model = (function () {
    'use strict';

    var model = function (options) {
        _.bindAll(this);
        this.finish = false;
        this.jobId = null;
        this.progressCount = 0;
        this.options = {
            stopUrl: '',
            infoUrl: ''
        };
        jQuery.extend(this.options, options);
    };
    
    model.prototype.start = function (url, data, options) {
        var self = this;
        this.finish = false;
        this.jobId = null;
        this.progressCount = 0;

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json",
            success: function (xhr) {
                if (xhr.results) {
                    alertBox(xhr);

                    self.jobId = xhr.results.job_id;
                    if (options.success) {
                        options.success(xhr.results);
                    }
                }
            },
            error: function (xhr) {
            	alertBox({message: xhr.responseText});
            }
        });
    };
    
    model.prototype.stop = function (options) {
        var self = this;

        $.ajax({
            url: this.options.stopUrl,
            type: "POST",
            data: {job_id: this.jobId},
            dataType: "json",
            success: function (xhr) {
                if (xhr.results && options.success) {
                    options.success(xhr.results);
                }
                self.finish = true;
                alertBox(xhr);
            },
            error: function (xhr) {
            	alertBox({message: xhr.responseText});
                if (options.error) {
                    options.error(xhr);
                }
                self.finish = true;
            }
        });
    };

    model.prototype.update = function (options) {
        var self = this;
        
        $.ajax({
            url: this.options.infoUrl,
            type: "GET",
            data: {job_id: this.jobId},
            dataType: "json",
            success: function (xhr) {
                if (xhr.results) {
                    self.progressCount = parseInt(xhr.results.progress);
                    self.finish = xhr.results.finish;
                    
                    //error or finish
                    if (self.finish) {
                        alertBox(xhr);
                    }
                    if (options.success) {
                        options.success(xhr.results);
                    }
                }
            },
            error: function (xhr) {
                alertBox({message: xhr.responseText});
                if (options.error) {
                    options.error(xhr);
                }
            }
        });
    };

    model.prototype.isFinish = function () {
        return this.finish;
    };

    return model;
}());

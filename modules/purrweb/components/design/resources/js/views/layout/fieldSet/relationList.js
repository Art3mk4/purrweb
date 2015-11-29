var relationList = {};
var console = console || {};
var alertBox = alertBox || function (msg) { 'use strict'; console.log('not define alertBox'); };


relationList.Widget = (function () {
    'use strict';

    var widget = function (el) {
        var self = this;

        this.el = el;
        this.template = this.el.find('.templateRelationList .itemRelationList');
        this.items = [];

        this.urlSave = this.template.find('form').attr('action');
        this.urlRemove = this.template.find('.removeRelationList').attr('href');

        //auto create for exists element + template
        this._addExistItems();

        //button add
        this.el.find('.addRelationList').on('click', function (e) {
            e.stopPropagation();
    
            var newElement = self.template.clone();
            self.el.append(newElement);

            self._createItem(newElement);

            return false;
        });

    };

    widget.prototype._addExistItems = function () {
        var items = this.el.find('.itemRelationList'),
            self = this;

        items.each(function () {
            self._createItem($(this));
        });
    
    };

    widget.prototype.removeItem = function (key) {
        var self = this,
            item = this.items[key];

        if (!item.isNew()) {
            $.ajax({
                url: this.urlRemove,
                dataType: 'json',
                type: 'GET',
                data: {'id' : item.id},
                success: function (response) {
                    if (response.success && response.success === 'true') {
                        self._destroyItem(key);
                    }
                    alertBox(response);
                },
                error: function (xhr) {
                    alertBox({message: xhr.responseText});
                }
            });
        } else {
            this._destroyItem(key);
        }
    };



    widget.prototype._destroyItem = function (key) {
        this.items[key].el.remove();
        this.items[key] = null;
    };


    widget.prototype._createItem = function (element) {
        var item = new relationList.Item(element, this, this.items.length);
        this.items.push(item);

        jQuery(".itemRelationList").each(function(index, el) {
            if(!jQuery(this).parent().hasClass("templateRelationList")) {
                jQuery(this).find("select").chosen();
            } else {
            }
        });
    };


    return widget;
}());


relationList.Item = (function () {
    'use strict';

    var item = function (el, widget, key) {
        var self = this;

        this.el = el;
        this.form = this.el.find('form');
        
        this.widget = widget;
        this.key = key;
        this.id = this.el.data('id');
        
        //bind on delete
        this.el.find('.removeRelationList').on('click', function (event) {
            self.widget.removeItem(self.key);
            return false;
        });

        //bind on submit
        this.form.submit(function () {
            self._save();

            return false;
        });
    };

    item.prototype.isNew = function () {
        return this.id === '';
    };


    item.prototype._save = function () {
        var self = this,
            url = this.widget.urlSave,
            data = this.form.serializeArray();

        if (!this.isNew()) {
            url = url + '?id=' + this.id;
        }
        
        this._clearError();
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            data: data,
            success: function (response) {
                if (response.success && response.success === 'true') {
                    self.id = response.results.id;
                } else {
                    self._setError();
                }
                alertBox(response);
            },
            error: function (xhr) {
                alertBox({message: xhr.responseText});
            }
        });
    };

    item.prototype._clearError = function () {
        this.el.removeClass('error');
    };

    item.prototype._setError = function () {
        this.el.addClass('error');
    };
    return item;

}());

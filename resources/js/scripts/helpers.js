(function (window) {
    window.notice = function (text, title, type) {
        let options = {
            type: type,
            progressBar: true
        };

        switch (type) {
            case 'error':
                // icon = '<i class="fas fa-exclamation-triangle"></i>';
                break;

            case 'success':
                // icon = '<i class="far fa-thumbs-up"></i>';
                options.timeout = 3000;
                break;
        }

        // options.text = icon + " <b>" + title + "</b><br>" + text;
        options.text = "<b>" + title + "</b><br>" + text;

        new Noty(options).show();
    }

    window.ajax = function (options, error) {
        if (error == undefined) {
            error = false;
        }

        if (!('method' in options)) {
            options.method = 'get';
        }

        if (!('data' in options)) {
            options.data = {};
        }

        var headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        };

        if ('headers' in options) {
            for (var k in options.headers) {
                headers[k] = options.headers[k];
            }
        }

        return axios({
            url: options.url,
            method: options.method,
            data: options.data,
            headers: headers
        }).then(json => {
            if (json.data.result == 'success') {
                if (('success' in options)) {
                    options.success(json.data.data);
                }
            } else {
                if (error) {
                    alert_errors(json.data.errors);

                    if (('error' in options)) {
                        var res = null;

                        if ('data' in json.data) {
                            res = json.data.data;
                        }

                        options.error(res);
                    }
                }
            }
        }).catch(function () {
            if (('error' in options)) {
                options.error();
            }
        }).then(function () {
            if (('always' in options)) {
                options.always();
            }
        });
    }

    window.alert_errors = function (array) {
        var errors = [];
        var keys = [];

        for (var i = 0; i < array.length; i++) {
            keys[i] = array[i].code;
            errors[i] = array[i].description;
        }

        notice(errors.join("<br>"), window.lang.alerts.error.title, 'error');
        return keys;
    }
})(window);
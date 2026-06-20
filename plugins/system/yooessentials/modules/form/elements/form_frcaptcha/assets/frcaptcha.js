/* Essentials YOOtheme Pro 1.9.3 build 0125.1555; ZOOlanders https://www.zoolanders.com; Copyright (C) Joolanders, SL; http://www.gnu.org/licenses/gpl.html GNU/GPL */

/* global friendlyChallenge UIkit */

// https://docs.friendlycaptcha.com/#/widget_api
(function () {

    onCaptchaReady(function () {
        const forms = UIkit.util.$$('[data-uk-yooessentials-form]');
        const endpoints = {
            global: 'https://api.friendlycaptcha.com/api/v1/puzzle',
            eu: 'https://eu-api.friendlycaptcha.eu/api/v1/puzzle'
        };

        for (const k in forms) {
            const form = forms[k];
            const element = UIkit.util.$('.frc-captcha', form);

            if (element) {
                const endpoint = element.dataset?.endpoint || 'global';
                const widget = new window.friendlyChallenge.WidgetInstance(element, {
                    puzzleEndpoint: endpoints[endpoint],
                    doneCallback: function () {
                        if (widget.startedByForm) {
                            UIkit.yooessentialsForm(form).doSubmit();
                            widget.startedByForm = null;
                        }
                    }
                });

                UIkit.util.on(form, 'form:submit', function (e) {
                    e.preventDefault();

                    if (widget.valid) {
                        UIkit.yooessentialsForm(form).doSubmit();
                        return;
                    }

                    widget.start();
                    widget.startedByForm = true;
                });

                UIkit.util.on(form, 'form:submission-error', function () {
                    widget.reset();
                });

                UIkit.util.on(form, 'reset', function () {
                    widget.reset();
                });
            }
        }
    });

    function onCaptchaReady(fn) {
        const id = setInterval(function () {
            if (window.friendlyChallenge) {
                fn();
                clearInterval(id);
            }
        }, 100);
    }

})();

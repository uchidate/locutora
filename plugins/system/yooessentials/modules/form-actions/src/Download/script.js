/* Essentials YOOtheme Pro 1.9.3 build 0125.1555; ZOOlanders https://www.zoolanders.com; Copyright (C) Joolanders, SL; http://www.gnu.org/licenses/gpl.html GNU/GPL */

export default ({util: {on}}) => {

    on(document, 'yooessentials-form:submitted', (e, {form, response}) => {

        if (response?.download) {
            window.location = response.download;
        }

    });

};

jQuery.fn.outerHTML = function(s) {
    return (s)
        ? this.before(s).remove()
        : jQuery("<p>").append(this.eq(0).clone()).html();
};

function checkTwitter(link){
    return /^(https?:\/\/)?((w{3}\.)?)twitter\.com\/(#!\/)?[a-z0-9_]+$/i.test(link);
}

function checkVK(link){
    return new RegExp('^(?:https?://)?(?:www\\.)?vk\\.com/(\\w+)$', 'i').test(link);
}

function checkFacebook(link){
    return /^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i.test(link);
}

function cropLink(string, length){
    return cropString(string.split("://").slice(1).join('://'), length);
}
function cropString(string, length){
    return $.trim(string).substring(0, length) + "...";
}
function cropStringBySpaces(string, length){
    return $.trim(string).substring(0, length).split(" ").slice(0, -1).join(" ") + "...";
}

function redirect(url){
    location.href = url;
}

function refresh(){
    location.reload();
}

function checkData(data){
    if(!isObject(data)){
        techErrorNotify();
        return false;
    }
    return true;
}

function techErrorNotify(timeout){
    return warningNoty('Не удалось получить ответ от сервера, проверьте подключение к интернету и попробуйте снова.', timeout);
}

function warningNoty(message, timeout, callback){
    return initNoty(message, 'warning', timeout, callback);
}

function successNoty(message, timeout, callback){
    return initNoty(message, 'success', timeout, callback);
}

function errorNoty(message, timeout, callback){
    return initNoty(message, 'error', timeout, callback);
}

function initNoty(message, type, timeout, callback){
    type = type || 'alert';
    timeout = typeof timeout !== 'undefined' && timeout !== null ? timeout : 2000;
    return noty({
        layout: 'topRight',
        type: type,
        text: message, // can be html or string
        timeout: timeout, // delay for closing event. Set false for sticky notifications
        callback: {
            onClose: callback
        }
    });
}

function isObject(data){
    return !((data === null) || (data === undefined) || (data.constructor !== {}.constructor));
}

function isArray(data){
    return !((data === null) || (data === undefined) || (data.constructor !== [].constructor));
}

var phoneMask = '+7 (999) 999-99-99';
var dateMask  = '99.99.9999';
var phoneExpr = /^\+7 \(\d{3}\) \d{3}\-\d{2}-\d{2}( x\d{1,6})?$/;
var dateExpr  = /^\d\d\.\d\d\.\d\d\d\d$/;
var emailExpr = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

function checkPhone(value){
    return phoneExpr.test(value);
}

function checkDate(value){
    return dateExpr.test(value);
}

function checkEmail(value){
    return emailExpr.test(value);
}

function checkCyrillicString(str){
    return (!/[a-z]+/.test(str) && /[а-я]+/.test(str));
}

/**
 * Позволяет повесить на элемент страницы событие, которое будет вызываться,
 * когда человек закончил вводить что-либо
 */
(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress paste input',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too premptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;

                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);
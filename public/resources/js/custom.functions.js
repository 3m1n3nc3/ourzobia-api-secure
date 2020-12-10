jQuery.fn.forceNumeric = function () {
    return this.each(function () {
        $(this).keydown(function (e) {
            var key = e.which || e.keyCode;

            if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
                    // numbers   
                key >= 48 && key <= 57 ||
                // Numeric keypad
                key >= 96 && key <= 105 ||
                // comma, period and minus, . on keypad
                key == 190 || key == 188 || key == 109 || key == 110 ||
                // Backspace and Tab and Enter
                key == 8 || key == 9 || key == 13 ||
                // Home and End
                key == 35 || key == 36 ||
                // left and right arrows
                key == 37 || key == 39 ||
                // Del and Ins
                key == 46 || key == 45 
            )
                return true;

            return false;
        });
    });
}

jQuery.fn.checkAccountNumberTrigger = function (posn = '') { 
 
    var selector = $("#account_number"+posn);  
    if (typeof selector === 'undefined') {
        var selector = $(this); 
    } 
 
    $( this ).change(function(event) { 

        var vlink           = $("#post_link").data('url') ? $("#post_link").data('url') : 'api/get_account_number'; 
        var account_number = $("#account_number"+posn).val(); 
        var bank_code      = $("select#bank_code"+posn).children("option:selected").val(); 

        $('#avm_'+posn).remove();

        if (account_number.length >= 10) { 
            $(selector).closest('.account_validator').append('<small class="text-info" id="avm_'+posn+'">Checking for account...</small>');
            console.log('Checking Account Number'); 

            $.post(link(vlink), 
                {account_number:account_number,bank_code:bank_code}, 
                function(data, textStatus, xhr) { 
                    var mclass = data.success == true ? 'success' : 'danger';
                    var msg = (data.message) ? data.message : data.name;
                    $('#avm_'+posn).remove();
                    $(selector).closest('.account_validator').append('<small class="text-'+mclass+'" id="avm_'+posn+'">'+msg+'</small>');
                    $(selector).closest('form').children('input[name="fullname"]').val(data.name);
                    if (data.success == true) {
                        $(selector).closest('form').find('button[type="submit"]').removeAttr('disabled');
                    } 
            });
            console.log(account_number.length, account_number, bank_code,); 
        } 
    });
}

jQuery.fn.checkAccountNumber = function (posn = '') { 

    var selector = $(this).selector; 
    if (typeof selector === 'undefined') {
        var selector = $(this); 
    } 

    $( this ).keyup(function(event) {
        var vlink           = $("#post_link").data('url') ? $("#post_link").data('url') : 'api/get_account_number'; 
        var account_number = $("#account_number"+posn).val(); 
        var bank_code      = $("select#bank_code"+posn).children("option:selected").val(); 
        var key            = event.which || event.keyCode;
        var alKey          = key >= 48 && key <= 57 || key >= 96 && key <= 105 || key == 8 || key == 13 || key == 46 || key == 45;
            
        if (account_number.length >= 10 && alKey) { 
            console.log('Checking Account Number'); 
            var message = '<small class="text-info" id="avm_'+posn+'">Checking for account...</small>';
            $('#avm_'+posn).remove();
            $(selector).closest('.account_validator').append(message);

            $.post(link(vlink), 
                {account_number:account_number,bank_code:bank_code}, 
                function(data, textStatus, xhr) {
                    var mclass  = data.success == true ? 'success' : 'danger';
                    var msg = (data.message) ? data.message : data.name;
                    var message = '<small class="text-'+mclass+'" id="avm_'+posn+'">'+msg+'</small>';
                    $('#avm_'+posn).remove();
                    $(selector).closest('.account_validator').append(message);
                    $(selector).closest('form').children('input[name="fullname"]').val(data.name);
                    if (data.success == true) {
                        $(selector).closest('form').find('button[type="submit"]').removeAttr('disabled');
                    }
            });
            console.log(account_number.length, account_number, bank_code,); 
        } 
    })
    .forceNumeric(); 
}

jQuery.fn.terminal = function (data = '', comd = 'log') {
    if (CI_ENVIRONMENT != 'production') { 
        if ($("#console").data("status") !== 'init') {
            var _terminal = $("<div/>", {
                "id":"console",
                "class":"scroll-notifications",
                "data-status":"init",
                "style":"position:fixed; top: 90px; right:30px; z-index: 99000; padding: 5px; width:350px; background-color: #000; color: #fff; font: courier; font-size: 10px; display: none; overflow-y: scroll; max-height: 500px;",
                "html":"<i class=\"fa fa-times text-danger fa-pull-right dismiss\"></i><i class=\"fa fa-minus text-info fa-pull-right hide\"></i>"
            });
            _terminal.appendTo("body"); 
            console.log('Terminal Init');
        } else {
            var _terminal = $("#console");
        }

        // Console control buttons
        _terminal.on('click', '.dismiss', function() {
            $('#console').remove(); 
        });

        _terminal.on('click', '.hide', function() {
            $('#console').hide();
            $('#console .terminal-inner').remove();
        });

        _terminal.append($("<div/>", {
            "class" : "terminal-inner",
            "html" : data
        }));

        _terminal.show(); 
    } 
}


jQuery.fn.alert_notice = function (message = 'A network error occurred!', type = 'warning', dismiss = true) { 
    if (type === 'error') {
        type = 'danger';
    } else if (type === 'notice') {
        type = 'info';
    } 

    let general_notice = $("<div />", {class: "my-1 alert alert-dismissible alert-"+type, id: "create-alert-notice"})
        .append(
            dismiss === true ? 
            $("<button />", {class: "close", type: "button", "data-dismiss": "alert", "aria-hidden": "true", html: "&times;"}) : ""
        )
        .append(message);
  
    $this = $( this ).show().removeClass("d-none").removeClass("hidden").html(general_notice);

    if (dismiss === "auto") {
        setTimeout(function() {
            $this.children("#create-alert-notice").fadeOut("slow");
        }, 4000);
    }
}


jQuery.fn.jsCssLoader = function (filename, type = 'js', callback, test = true) {  
    const regex = /(\w+\b)(\.min\.js\b|\.js|\.min\.css\b|\.css\b|\b|\b\/){1}$/gm.exec(filename);
    if (type === "js") { 
        //if file is a JavaScript file 
        var loader = $('<script />');
        loader.attr("type", "text/javascript");
        loader.attr("src", filename);
    } else if (type === "css") { 
        //if file is a CSS file 
        var loader = $("<link />");
        loader.attr("rel", "stylesheet");
        loader.attr("type", "text/css");
        loader.attr("href", filename);
    } 


    if (regex === null) {
       console.log(filename)
        regex[0] = str_ireplace(["http://","http://", "/", "", filename]);
    }

    loader.attr("id", regex[0]);
    var element = $(document.getElementById(regex[0]), "#" + regex[0]); 
    
    var data = loader;
    data.element = element;

    if (typeof loader !== "undefined" && element.length <= 0) {
        $(this).append(loader);
    }

    $this = $( this );
    
    if(typeof callback == 'function') {
        var callbackTimer = setInterval(function() {
            var call = false;
            console.log($this[0].tagName.toLowerCase() + " loading...");
            try {
                call = test.call(this, data);
            } catch (e) {}

            if (call) {
                clearInterval(callbackTimer);
                callback.call(this, data);
            }
        }, 3000); 
    }
}

function urlParam(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return results ? results[1] : '';
}

// Get file extension
function checkFileExt(filename){
    filename = filename.toLowerCase();
    return filename.split('.').pop();
} 

function number_format(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function ucwords(str) { 
    str = str.toLowerCase();
    var words = str.split(' ');
    str = '';
    for (var i = 0; i < words.length; i++) {
        var word = words[i];
        word = word.charAt(0).toUpperCase() + word.slice(1);
        if (i > 0) { str = str + ' '; }
        str = str + word;
    }
    return str;
}

function validURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
} 

function str_ireplace(search, replace, subject) {
    //  discuss at: http://phpjs.org/functions/str_ireplace/
    // original by: Martijn Wieringa
    //    input by: penutbutterjelly
    //    input by: Brett Zamir (http://brett-zamir.me)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Jack
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Onno Marsman
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Philipp Lenssen
    //   example 1: str_ireplace('l', 'l', 'HeLLo');
    //   returns 1: 'Hello'
    //   example 2: str_ireplace('$', 'foo', '$bar');
    //   returns 2: 'foobar'

    var i, k = '';
    var searchl = 0;
    var reg;

    var escapeRegex = function(s) {
        return s.replace(/([\\\^\$*+\[\]?{}.=!:(|)])/g, '\\$1');
    };

    search += '';
    searchl = search.length;
    if (Object.prototype.toString.call(replace) !== '[object Array]') {
        replace = [replace];
        if (Object.prototype.toString.call(search) === '[object Array]') {
            // If search is an array and replace is a string,
            // then this replacement string is used for every value of search
            while (searchl > replace.length) {
                replace[replace.length] = replace[0];
            }
        }
    }

    if (Object.prototype.toString.call(search) !== '[object Array]') {
        search = [search];
    }
    while (search.length > replace.length) {
        // If replace has fewer values than search,
        // then an empty string is used for the rest of replacement values
        replace[replace.length] = '';
    }

    if (Object.prototype.toString.call(subject) === '[object Array]') {
        // If subject is an array, then the search and replace is performed
        // with every entry of subject , and the return value is an array as well.
        for (k in subject) {
            if (subject.hasOwnProperty(k)) {
                subject[k] = str_ireplace(search, replace, subject[k]);
            }
        }
        return subject;
    }

    searchl = search.length;
    for (i = 0; i < searchl; i++) {
        reg = new RegExp(escapeRegex(search[i]), 'gi');
        subject = subject.replace(reg, replace[i]);
    }

    return subject;
}

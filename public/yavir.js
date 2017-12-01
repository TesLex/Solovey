var XHR = ("onload" in new XMLHttpRequest()) ? XMLHttpRequest : XDomainRequest;
var xhttp = new XHR();

const _ = this;

function x(p) {
    return new X(p)
}

function X(p) {
    _.el = p
}

function fix(callback) {
    if (typeof(_.el) !== "object") {
        document.querySelectorAll(_.el).forEach(function (e) {
            callback(e)
        });
    } else {
        callback(_.el)
    }
}

X.prototype.on = function (type, callback) {
    fix(e => e.addEventListener(type, callback))
};

X.prototype.html = function (html) {
    if (typeof(html) !== "undefined")
        fix(e => e.innerHTML = html);
    else
        fix(e => log(e.innerHTML));
    // return this.hml
};

X.prototype.val = function () {
    fix(e => vals = e.value);
    return vals
};

X.prototype.addClass = function (cls) {
    fix(e => e.classList.add(cls))
};

X.prototype.removeClass = function (cls) {
    fix(e => e.classList.remove(cls))
};

X.prototype.hasClass = function (cls) {
    fix(e => vaebat = e.classList.contains(cls));
    return vaebat
};

X.prototype.style = function (style) {
    fix(e => e.style(style))
};

X.prototype.replace = function (reg, to) {
    fix(e => {

    })
};

X.prototype.createElement = function (element) {
    fix(e => leme = e.createElement(element));
    log(leme);
    return leme;
};

X.prototype.appendChild = function (child) {
    fix(e => leme = e.appendChild(child));
    return leme;
};

X.prototype.request = function (params) {
    if ("undefined" !== typeof params.headers) {
        if (params.headers.length !== 0) {
            params.headers.forEach(function (e) {
                xhttp.setRequestHeader(e.a, e.b)
            });
        }
    }

    xhttp.open(params.method, params.url);
    xhttp.send();

    if ("undefined" !== typeof params.onStart) {
        xhttp.onloadstart = function () {
            params.onStart(xhttp)
        }
    }

    if ("undefined" !== typeof params.onProgress) {
        xhttp.onprogress = function (event) {
            params.onProgress(event)
        }
    }

    if ("undefined" !== typeof params.onAbort) {
        xhttp.onabort = function () {
            params.onAbort(xhttp)
        }
    }

    if ("undefined" !== typeof params.onError) {
        xhttp.onerror = function () {
            params.onError(xhttp)
        }
    }

    if ("undefined" !== typeof params.onSuccess) {
        xhttp.onload = function () {
            params.onSuccess(xhttp)
        }
    }

    if ("undefined" !== typeof params.onTimeout) {
        xhttp.ontimeout = function () {
            params.onTimeout(xhttp)
        }
    }

    if ("undefined" !== typeof params.onComplete) {
        xhttp.onloadend = function () {
            params.onComplete(xhttp)
        }
    }
};

function Yavir(prms) {
    _.Yavor = prms;
}

Yavir.prototype.run = function () {

    if (window.location.hash === "")
        window.location.hash = '/';

    render();
    renderActive();

    x(window).on('hashchange', function () {
        renderActive()
    });

    function render() {
        _.Yavor.components.forEach(e => {
            if (e.route === undefined) {
                x(e.selector).html(e.template);
                if (e.script !== undefined)
                    e.script()
            }
        });
    }

    function renderActive() {
        const found = _.Yavor.components.find(function (e) {
            return e.route === window.location.hash.substr(1, window.location.hash.length);
        });

        if (found) {
            x('view').html('<' + found.selector + '>' + '</' + found.selector + '>');
            x(found.selector).html(found.template);
            if (found.script !== undefined)
                found.script()
        } else {
            x('view').html('404')
        }
    }
};

function log(text) {
    console.log(text)
}
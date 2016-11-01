try {
	window.XTD || (function(window) {
		var apply = Function.prototype.apply;

        function bindContext(fn, thisArg) {
            return function _sdkBound() {
                return apply.call(fn, thisArg, arguments);
            };
        }
        var global = {
            __type: 'JS_SDK_SANDBOX',
            window: window,
            document: window.document
        };
        var sandboxWhitelist = ['setTimeout', 'setInterval', 'clearTimeout', 'clearInterval'];
        for (var i = 0; i < sandboxWhitelist.length; i++) {
            global[sandboxWhitelist[i]] = bindContext(window[sandboxWhitelist[i]], window);
        }
		(function() {
            var self = window;
            var __DEV__ = 0;
            var undefined;
			var appCode = null;
			var config = {
				appId: '',
				version: '1.0',
				secret: ''
			};
			
			var method = {
				GET: 'GET',
				POST: 'POST',
				PUT: 'PUT',
				DELETE: 'DELETE',
			}

            function emptyFunction() {};
			
			this.init = function (o) {
				config = o
				var ac = getCookie('appCode');
				if (ac != '') {
					appCode = ac;
				}
			};
			
			this.api = function (p, m, o, cb) {
				var req = $.ajax({
					url: p,
					type: m,
					data: o,
					beforeSend: function(xhr){
						xhr.setRequestHeader('X-XTD-APP-ID', config.appId);
						xhr.setRequestHeader('X-XTD-APP-VERSION', config.version);
						xhr.setRequestHeader('X-XTD-APP-SECRET', config.secret);
						xhr.setRequestHeader('X-XTD-AUTH-HEADER', appCode);
					},
				});
				req.done(function (ro) {
					if (typeof cb == 'function') {
						cb(ro);
					}
				});
				req.fail(function (xhr, s) {
					alert(s);
				});
			};
			
			this.getLoginStatus = function (cb) {
				__checkAuthResponse(cb);
			};
			
			this.login = function (o) {
				api('/me/login', method.POST, o, function (r) {
					if (r.appCode){
						appCode = r.appCode;
						delete r.appCode;
						setCookie('appCode', appCode, 7);
					}
				});
			};
			
			this.logout = function () {
				api('/me/logout', method.POST, null, function (r) {
					setCookie('appCode', '', -7);
				});
			};
			
			this.__checkAuthResponse = function (cb) {
				api('/me/getLoginStatus', method.POST, o, function (r) {
					if (cb) {
						if (typeof cb == 'function') {
							cb(r);
						};
					}
				});
			};
			
			function setCookie(cname, cvalue, exdays) {
				var d = new Date();
				d.setTime(d.getTime() + (exdays*24*60*60*1000));
				var expires = "expires="+d.toUTCString();
				document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
			}

			function getCookie(cname) {
				var name = cname + "=";
				var ca = document.cookie.split(';');
				for(var i = 0; i < ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) == ' ') {
						c = c.substring(1);
					}
					if (c.indexOf(name) == 0) {
						return c.substring(name.length, c.length);
					}
				}
				return "";
			}
			window.XTD = this;
        }).call(global);
    })(window.inDapIF ? parent.window : window);
} catch (e) {
    console.log(e);
}


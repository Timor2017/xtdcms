$(document).ready(function () {
	
	XTD.init({
		appId: '6d25b55d-987a-41dd-87b3-4db79b81f86c',
		version: '1.0',
		secret: '8861b2e14d94'
	});
	XTD.getLoginStatus(function (data) {
		if (!data.result) {
			if (window.location.href.indexOf('login') < 0) {
				location.href = URL_SIGNIN;
			}
		} else {
			if (window.location.href.indexOf('login') >= 0) {
				location.href = './';
			} else {
				XTD.api('/me/profile', function (data) {
					$(".xtd-display-name").html(data.result.display_name);
					if (data.result.photo != '') {
						$(".xtd-display-photo").attr('src', data.result.photo);
					}
				});
			}
			XTD.translate($('body'));
		}
	});
	
	generateFolders(false);

	var History = window.History;
	if ( !History.enabled ) {
		return false;
	}

	History.Adapter.bind(window,'statechange',function() {
		var State = History.getState();
		$.get(State.url, function(response) {
			$('.control-sidebar').removeClass('control-sidebar-open');
			var html = $(response);
			XTD.translate(html);
			
			var content = html.find('.content-wrapper');
			$('.content-wrapper').html(content.html()); 

			var sidebar = html.find('.control-sidebar');
			$('.control-sidebar').html(sidebar.html()); 
	
			executeDocumentReady();
		});
	});
		
	$('body').on('click', 'a', function (evt) {
		evt.preventDefault();
		if ($(this).attr('href').indexOf('#') < 0) {
			var url = $(this).attr('href');
			if (url.indexOf(BASE_URL) < 0) {
				url = BASE_URL + url;
			}
			History.pushState(null, $(this).text(), url);
		}
	});
	
	var executeDocumentReady = function () {
			if (typeof documentReady === 'function') {
				documentReady();
				documentReady = null;
			}
	}
	executeDocumentReady();
});
	
var signout = function () {
	XTD.logout();
	location.href = URL_SIGNIN;
};

var readText = function () {
	$(".multi-lang").each(function (index, item) {
		console.log($(item).html());
	});
};

var generateFolders = function (refresh) {
	var folders = XTD.getCookie('folders');
	if (folders == '' || refresh) {
		XTD.api('/folder/', function ( data ) {
			if (data.response.code == '0') {
				folders = JSON.stringify(data.result);
				XTD.setCookie('folders', folders, 1);
			}
		});
	}
	if (folders != '') {
		folders = $.parseJSON(folders);
		var ul = addFolders(folders, true);
		ul.prepend($("<li />").addClass("header").html("<span>MAIN NAVIGATION</span>").prepend($("<i />").addClass("fa fa-refresh refresh-menu").css("width", "20px").click(function () {
			generateFolders(true);
		})));
		$(".sidebar-menu").replaceWith(ul);
	}
}
		
var addFolders = function (folders, isTop) {
	var ul = $("<ul />").addClass(isTop ? "sidebar-menu" : "treeview-menu");

	$(folders).each(function(index, folder) {
		var li = $("<li />").addClass(isTop ? "treeview" : "").appendTo(ul);
		var a =$("<a />").attr("href","/folder/"+folder.id).append(
				$("<i />").addClass("fa").addClass("fa-" + folder.icon)
			).append(
				$("<span />").html(folder.name)
			);
		li.append(a);
		if (folder.children.length > 0) {
			$("<span />").addClass("pull-right-container").append($("<i />").addClass("fa fa-angle-left pull-right")).appendTo(a);
			var children = addFolders(folder.children, false);
			li.append(children);
		}
	});
	return ul;
};

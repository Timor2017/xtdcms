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
				profile = getItems('me.profile', '/me/profile');
				//XTD.api('/me/profile', function (data) {
				if (profile) {
					$(".xtd-display-name").html(profile.display_name);
					if (profile.photo != '') {
						$(".xtd-display-photo").attr('src', data.result.photo);
					}
				}
				//});
			}
			XTD.translate($('body'));
		}
	});
	
	generateFolders(false);
	generateGroups(false);
	$(".sidebar-menu").append($("<li />").addClass("header manage").html("<span>"+XTD.__('Manage')+"</span>"));
	$(".sidebar-menu").append($("<li />").addClass("treeview").append(
			$("<a />").attr("href","/member/list").append(
				$("<i />").addClass("fa fa-users")
			).append(
				$("<span />").html(XTD.__('Members'))
			)
		)
	);
	$(".sidebar-menu").append($("<li />").addClass("treeview").append(
			$("<a />").attr("href","/translate").append(
				$("<i />").addClass("fa fa-gears")
			).append(
				$("<span />").html(XTD.__('Translation'))
			)
		)
	);

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
			$('title').html(html.find('title').html());
			
			var content = html.find('.content-wrapper');
			$('.content-wrapper').html(content.html()); 

			var sidebar = html.find('.control-sidebar');
			$('.control-sidebar').html(sidebar.html()); 
	
			executeDocumentReady();
		});
	});
		
	$('body').on('click', 'a', function (evt) {
		evt.preventDefault();
		if ($(this).attr('href')) {
			if ($(this).attr('href').indexOf('#') < 0) {
				var url = $(this).attr('href');
				if (url.indexOf(BASE_URL) < 0) {
					url = BASE_URL + url;
				}
				History.pushState(null, $(this).text(), url);
			}
		}
	});
	
	//$('body').on('click', '.sidebar-menu a', function (evt) {
	//	$('.sidebar-menu .active').removeClass('active');
	//	$(this).closest('li').addClass('active');
	//});	
	
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
	//var folders = XTD.getCookie('folders');
	//if (folders == '' || refresh) {
	//	XTD.api('/folder/', function ( data ) {
	//		if (data.response.code == '0') {
	//			folders = JSON.stringify(data.result);
	//			XTD.setCookie('folders', folders, 1);
	//		}
	//	});
	//}
	var folders = getItems('folders', '/folder/', refresh);
	if (folders != '') {
		//folders = $.parseJSON(folders);
		var ul = addItems(folders, '/folder/', 'folder', true);
		$(".sidebar-menu .folder").remove();
		$(".sidebar-menu").append($("<li />").addClass("header folder").html("<span>"+XTD.__('MAIN NAVIGATION')+"</span>").prepend($("<i />").addClass("fa fa-refresh refresh-menu").css("width", "20px").click(function () {
			generateFolders(true);
		})));
		$(".sidebar-menu").append(ul.html());
	}
}

var generateGroups = function (refresh) {
	//var groups = XTD.getCookie('groups');
	//if (groups == '' || refresh) {
	//	XTD.api('/group/', function ( data ) {
	//		if (data.response.code == '0') {
	//			groups = JSON.stringify(data.result);
	//			XTD.setCookie('groups', groups, 1);
	//		}
	//	});
	//}
	var groups = getItems('groups', '/group/', refresh);
	if (groups != '') {
		//console.log(groups);
		//groups = $.parseJSON(groups);
		var ul = addItems(groups, '/group/', 'group', true);
		$(".sidebar-menu .group").remove();
		$(".sidebar-menu").append($("<li />").addClass("header group").html("<span>"+XTD.__('GROUPS')+"</span>").prepend($("<i />").addClass("fa fa-refresh refresh-menu").css("width", "20px").click(function () {
			generateGroups(true);
		})));
		$(".sidebar-menu").append(ul.html());
	}
}
var getItems = function (key, path, refresh) {
	var items = XTD.getCookie(key);
	if (items == '' || refresh) {
		XTD.syncApi(path, function ( data ) {
			if (data.response.code == '0') {
				items = JSON.stringify(data.result);
				XTD.setCookie(key, items, 1);
			}
		});
	}
	items = $.parseJSON(items);
	
	return items;
}
var addItems = function (items, path, className, isTop) {
	var ul = $("<ul />").addClass(isTop ? "sidebar-menu" : "treeview-menu").addClass(className);

	$(items).each(function(index, item) {
		var li = $("<li />").addClass(isTop ? "treeview" : "").addClass(className).appendTo(ul);
		var a =$("<a />").attr("href",path+item.id).append(
				$("<i />").addClass("fa").addClass("fa-" + item.icon)
			).append(
				$("<span />").html(item.name)
			);
		li.append(a);
		//console.log(item.name);
		//console.log(item.children.length);
		if (item.children.length > 0) {
			$("<span />").addClass("pull-right-container").append($("<i />").addClass("fa fa-angle-left pull-right")).appendTo(a);
			var children = addItems(item.children, path, className, false);
			li.append(children);
		}
	});
	return ul;
};
var findItem = function (items, key, value) {
	var result = null;
	$(items).each(function (index, item) {
		if (item[key] == value) {
			result = item;
		} else if (item.children.length > 0) {
			result = findItem(item.children, key, value);
		}
		if (result) {
			if (result != item) {
				if (!result.parent_id) {
					result.parent_id = item.id;
				}
			}
			return false;
		}
	});
	return result;
}
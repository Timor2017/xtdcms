$(document).ready(function () {
	
	XTD.init({
		appId: '6d25b55d-987a-41dd-87b3-4db79b81f86c',
		version: '1.0',
		secret: '8861b2e14d94'
	});
	XTD.getLoginStatus(function (data) {
		if (!data.result) {
			//console.log(window.location.href.indexOf(URL_SIGNIN) );
			if (window.location.href.indexOf(URL_SIGNIN) < 0) {
				//XTD.logout();
				//location.href = URL_SIGNIN;
				signout();
			}
		} else {
			if (window.location.href.indexOf(URL_SIGNIN) >= 0) {
				location.href = './';
			} else {
				profile = getItems('me.profile', '/me/profile');
				if (profile) {
					$(".xtd-display-name").html(profile.display_name);
					if (profile.photo != '') {
						$(".xtd-display-photo").attr('src', data.result.photo);
					}
				}
	
				generateFolders(false);
				if (profile && profile.is_admin) {
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
				}
			}
			XTD.translate($('body'));
		}
	});

	var History = window.History;
	if ( !History.enabled ) {
		return false;
	}

	History.Adapter.bind(window,'statechange',function() {
		var State = History.getState();
		$('.content-wrapper > div').fadeOut(400, function () {
			$("#loading").show();
			$.get(State.url, function(response) {
				executeDocumentUnload();
				
				$('.control-sidebar').removeClass('control-sidebar-open');
				var html = $(response);
				XTD.translate(html);
				$('title').html(html.find('title').html());
				
				var content = html.find('.content-wrapper > div');
				$('.content-wrapper > div').html(content.html()); 

				var sidebar = html.find('.control-sidebar');
				$('.control-sidebar').html(sidebar.html()); 
				$("#loading").hide();
				$('.content-wrapper > div').fadeIn();
				
				executeDocumentReady();
			});
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
				var parent = $(this).parents("ul").last();
				parent.find("li.active").removeClass("active");
				$(this).parent("li").addClass("active");
				
				History.pushState(null, $(this).text(), url);
			}
		}
	});
	
	var executeDocumentReady = function () {
			if (typeof documentReady === 'function') {
				documentReady();
				documentReady = null;
			}
	}
	var executeDocumentUnload = function () {
			if (typeof documentUnload === 'function') {
				documentUnload();
				documentUnload = null;
			}
	}
	executeDocumentReady();
	$("#loading").hide();
});
	
var signout = function () {
	XTD.logout(function () {
		location.href = URL_SIGNIN;
	});
};

var readText = function () {
	$(".multi-lang").each(function (index, item) {
		console.log($(item).html());
	});
};

var generateFolders = function (refresh) {
	var folders = getItems('folders', '/folder/', refresh);
	var ul = addItems(folders, {folder: '/folder/', form: { create: '/form/', list: '/form/list/' }}, 'folder', true);
	if ($(".sidebar-menu .folder-title").size() == 0) {
		$(".sidebar-menu").append($("<li />").addClass("header folder-title").html("<span>"+XTD.__('MAIN NAVIGATION')+"</span>").prepend($("<i />").addClass("fa fa-refresh refresh-menu").css("width", "20px").click(function () {
			generateFolders(true);
		})));
	}
	if (folders != '') {
		if ($(".sidebar-menu .folder").size() > 0) {
			$(".sidebar-menu .folder").remove();
		}
		$(ul.html()).insertAfter($(".sidebar-menu .folder-title"));
	}
}

var generateGroups = function (refresh) {
	var groups = getItems('groups', '/group/', refresh);
	var ul = addItems(groups, '/group/', 'group', true);
	if ($(".sidebar-menu .group-title").size() == 0) {
		$(".sidebar-menu").append($("<li />").addClass("header group-title").html("<span>"+XTD.__('GROUPS')+"</span>").prepend($("<i />").addClass("fa fa-refresh refresh-menu").css("width", "20px").click(function () {
			generateGroups(true);
		})));
	}
	if (groups != '') {
		if ($(".sidebar-menu .group").size() > 0) {
			$(".sidebar-menu .group").remove();
		}
		$(ul.html()).insertAfter($(".sidebar-menu .group-title"));
	}
}
var getItems = function (key, path, refresh) {
	var items = XTD.getStore(key);
	if (!items || items == '' || refresh) {
		XTD.syncApi(path, function ( data ) {
			if (data.response.code == '0') {
				items = JSON.stringify(data.result);
				XTD.setStore(key, items);
			} else {
				XTD.setStore(key, 'N/A');
			}
		});
	}
	if (items != 'N/A') {
		items = $.parseJSON(items);
	} else {
		items = null;
	}
	
	return items;
}
var addItems = function (items, path, className, isTop) {
	//var ul = $("<ul />").addClass(isTop ? "sidebar-menu" : "treeview-menu").addClass(className);
	var ul = $("<ul />").addClass(isTop ? "sidebar-menu" : "treeview-menu").addClass(className);
	$.each(items, function(index, item) {
		currentPath = (typeof path == 'object') ? (item.icon) ? path.folder : item.can_read ? path.form.list : item.can_create ? path.form.create : '' : path;
		var li = $("<li />").addClass(isTop ? "treeview" : "").addClass(className).appendTo(ul);
		var a =$("<a />").attr("href",currentPath+item.id).append(
				$("<i />").addClass("fa").addClass("fa-" + ((item.icon) ? item.icon : 'edit'))
			).append(
				$("<span />").html(item.name)
			);
		li.append(a);
		//console.log(item.name);
		//console.log(item.children);
		//console.log(item.children.length);
		if ($(item.children).size() > 0) {
			//$("<span />").addClass("pull-right-container toggle-open").append($("<i />").addClass("fa fa-angle-left pull-right")).appendTo(a);
			if ($(item.children.folders) .size() > 0) {
				var children = addItems(item.children.folders, path, className, false);
				li.append(children);
			}
			if ($(item.children.forms).size() > 0) {
				//$("<span />").addClass("pull-right-container").append($("<i />").addClass("fa fa-angle-left pull-right")).appendTo(a);
				var children = addItems(item.children.forms, path, className, false);
				li.append(children);
			}
			if (!item.children.folders && !item.children.forms) {
				//$("<span />").addClass("pull-right-container").append($("<i />").addClass("fa fa-angle-left pull-right")).appendTo(a);
				var children = addItems(item.children, path, className, false);
				li.append(children);
			}
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

var generatePaging = function (options) {
	var table = $("<table />").addClass("paging");
	showPage = 40;
	start_page = Math.max(options.current_page - (showPage / 2), 1);
	end_page = Math.min(start_page + (showPage - 1), options.total_page);
	start_page = Math.max(end_page - showPage, 1);
	
	var footer = $("<tr />").appendTo(table);
	var paging = $("<td />").appendTo(footer);
	for (var i = start_page; i <= end_page; i++) {
		if (i == options.current_page) {
			$("<span/>").html(i).appendTo(paging);
		} else {
			$("<a />").html(i).data("page", i).appendTo(paging);
		}
		$("<span>&nbsp;</span>").appendTo(paging);
	}
	if (start_page > 1) {
		paging.prepend($("<span>&nbsp;</span>"));
		paging.prepend($("<a />").data("page", Math.max(options.current_page - showPage, 1)).html("..."));
	}
	if (end_page < options.total_page) {
		paging.append($("<a />").data("page", Math.min(options.current_page + showPage, options.total_page)).html("..."));
		$("<span>&nbsp;</span>").appendTo(paging);
	}
	
	var dataOptions = options.options;
	paging.find("a").click(function () {
		var page = $(this).data('page');
		dataOptions.page = page;
		$("#loading").show();
		XTD.api(options.url, XTD.method.POST, dataOptions, function (data) {
			if (data.result){
				data.result.url = options.url;
				data.result.callback = options.callback;
				$("#loading").hide();
				options.callback(data.result);
			}
		});
	});
	return table;
}
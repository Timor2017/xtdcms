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
					console.log(data);
					$(".xtd-display-name").html(data.result.display_name);
					if (data.result.photo != '') {
						$(".xtd-display-photo").attr('src', data.result.photo);
					}
				});
			}
		}
	});
	
	XTD.api('/folder/', function ( data ) {
		if (data.response.code == '0') {
			var folders = data.result;
			var ul = addFolders(folders, true);
			ul.prepend($("<li />").addClass("header").html("MAIN NAVIGATION"));
			$(".sidebar-menu").replaceWith(ul);
		}
	});
		
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

	var History = window.History;
	if ( !History.enabled ) {
		return false;
	}

	History.Adapter.bind(window,'statechange',function() {
		var State = History.getState();
		$.get(State.url, function(response) {
			$('.control-sidebar').removeClass('control-sidebar-open');
			$('.content-wrapper').html($(response).find('.content-wrapper').html()); 
			$('.control-sidebar').html($(response).find('.control-sidebar').html()); 
			console.log($(response).find('.script_block').html());
			$('.script_block').empty().html($(response).find('.script_block').html()); 
		});
	});
		
	$('body').on('click', 'a', function (evt) {
		evt.preventDefault();
		if ($(this).attr('href') != '#'){
			History.pushState(null, $(this).text(), BASE_URL+$(this).attr('href'));
		}
	});
});
	
var signout = function () {
	XTD.logout();
	location.href = URL_SIGNIN;
};

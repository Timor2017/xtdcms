$(document).ready(function () {
	XTD.init({
			appId: '6d25b55d-987a-41dd-87b3-4db79b81f86c',
			version: '1.0',
			secret: '8861b2e14d94'
			});
	XTD.getLoginStatus(function (data) {
		if (!data.result) {
			//auto login for debug
			XTD.login({'username':'admin','password':'admin'}, function (data) {
			});
			//else redirect to login
			//location.href = URL_SIGNIN;
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
			var a =$("<a />").attr("href","./folder/"+folder.id).append(
					$("<i />").addClass("fa").addClass("fa-" + folder.icon)
				).append(
					$("<span />").html(folder.name)
				);
			li.append(a);
			console.log(folder);
			if (folder.children.length > 0) {
				$("<span />").addClass("pull-right-container").append($("<i />").addClass("fa fa-angle-left pull-right")).appendTo(a);
				var children = addFolders(folder.children, false);
				li.append(children);
			}
		});
		return ul;
	};
});
/*
 * 用戶登陸
 */
function usrLogin(username, password) {
	$.post("../service/Routers.php", {
			action: "usrLogin",
			user: username,
			pwd: password
		},
		function(data) {
			alert($.parseJSON(data));
			console.info($.parseJSON(data));
		});
}

/*===========                   DOM 元素                           =================*/
/*
 * jquery 响应方法
 */

// 登陆响应
$("#login-btn").click(function() {
/*	var obj = $("#login-btn").data();
	obj.name = "绑定数据名称";
	console.info(obj);*/
	usrLogin($("#login-account").val(), $("#loginpwd").val());
});
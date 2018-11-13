// 用户安全管理

function usrLogin() {
	CodeZComponents.postRequest({
		action: CodeZ.ACTION_LOGIN,
		user: $('#form-username').val(),
		pwd: $('#password').val()
	}, function(data) {
		if(data.success) {
			window.location.href = CodeZ.HTML_PAGE_INDEX;
		} else {
			CodeZComponents.showErrorTip({
				text: data.error
			});
		}
	});
}

$("#toolbar").click(function() {
	changeToUserDetailInfo({
		tag: CodeZ.TAG_USER_ADD,
		href: CodeZ.HTML_PAGE_USER_ADD,
		title: '新增用户',
		actived: true,
	});
});

// 修改用户
function editUser(data) {
	var bindData = {
		tag: CodeZ.TAG_USER_EDIT,
		href: CodeZ.HTML_PAGE_USER_EDIT,
		title: '修改用户',
		actived: true,
		bindData: data
	};
	$.session.set('bindData', JSON.stringify(bindData));
	changeToUserDetailInfo(bindData);
}

function userList() {
	changeToUserDetailInfo({
		tag: CodeZ.TAG_USER_LIST,
		href: CodeZ.HTML_PAGE_USER_LIST,
		title: '用户列表',
		actived: true,
	});
}

function changeToUserDetailInfo(data) {
	var ulDom = $(window.parent.document).find('.breadcrumb');
	BreadMenu.updateBread(ulDom, data);
	directHref(data.href);
}

function editData() {
	var ulDom = $(window.parent.document).find('.active');
	var dataObj = JSON.parse($.session.get('bindData'));
	if(dataObj != undefined) {
		if(dataObj.tag == CodeZ.TAG_USER_EDIT) {
			console.info('111');
			var userObj = dataObj.bindData;
			console.info(userObj);
			$('#userName').val(userObj.userName);
			$('#userRole').val(userObj.role.roleId);
			$('#userAccount').val(userObj.userAccount);
			$('#userpassword').val(userObj.password);
			$('#dep').val(userObj.dep);
		}
		return;
	}
}

function check() {
	addIframe($('#userFrame'), $(event.target).constructor.data.href)
	BreadMenu.updateBread($(event.target).parent().parent(), $(event.target).constructor.data);
}

// 更新用户信息
function updateUser(userObj, callback) {}

var UserMan = {
	// 注销用户
	banObject: function(data, fn) {
		BootstrapDialog.show({
			title: BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_WARNING],
			message: '是否确认注销该用户',
			type: BootstrapDialog.TYPE_PRIMARY,
			cssClass: "login-dialog",
			data: {
				'bindData': data
			},
			buttons: [{
				label: '确定',
				action: function(dialog) {
					dialog.close();
					CodeZComponents.showSuccessTip({
						title: '提示',
						text: '注销成功'
					});
					var user = dialog.getData('bindData');
					user.deleted = 1;
					updateUser(user, function(success) {
						if(success) {
							if(fn) {
								fn(user);
							}
						}
					});
				}
			}, {
				label: '取消',
				action: function(dialog) {
					dialog.close();
				}
			}]
		});
		// BootstrapDialog.confirm("确认提示框");
		// BootstrapDialog.warning("警告框");
		// BootstrapDialog.danger("危险框");
	},

	// 激活用户
	activeObject: function(data, fn) {
		CodeZComponents.showSuccessTip({
			title: '提示',
			text: '激活成功'
		});
		var user = data;
		user.deleted = 0;
		if(fn) {
			fn(user);
		}
	},

	/*
	{
	  uri : ,
	  params : {},
	  rowStyle : fn,
	  column : [],
	  pageSize : ,
	  localData : [],
	  showSearch : true,
	  refresh : true,
	  currentPage : 1,
	  showPager : true
	}
	*/
	configureUserList: function() {
		CodeZComponents.postRequest({
			action: CodeZ.ACTION_USR_LIST
		}, function(data) {
			if(data.success) {
				var dataRow = data.data;
				UserMan.showUserList(dataRow);
			}
		});

	},

	showUserList: function(dataList) {
		var datas = {
			parentDom: $("#table-container"),
			pageSize: 8,
			refresh: function(params) {
				UserMan.configureUserList();
			},
			loadSuccessFn: function(data) {
				console.info(data);
			},
			loadFailedFn: function(success) {
				console.info(success);
			},
			rowStyle: function(row, index) {
				if(row == undefined) {
					return {};
				}
				if(row.deleted == 1 || row.deleted == "1") {
					return {
						classes: "danger"
					};
				}
				return {};
			},
			column: [{
				field: "userId",
				title: "用户ID",
				width: 1000,
			}, {
				field: "userAccount",
				title: "账号",
				width: 1000
			}, {
				field: "userName",
				title: "用户",
				width: 1000
			}, {
				field: "deleted",
				title: "状态",
				align: "center",
				sortable: true,
				formatter: function(value, row, index) {
					if(value == 1 || value == '1') {
						return "<a href=\"#\" class=\"tooltip-show\" data-toggle=\"tooltip\" title=\"未激活\"><span class= \"fa fa-ban fa-fw text-warning\"></span></a>";
					} else {
						return "<a href=\"#\" class=\"tooltip-show\" data-toggle=\"tooltip\" title=\"已激活\"><span class= \"fa fa-check fa-fw text-success\"></span></a>";
					}
				},
				width: 1000
			}, {
				field: "action",
				title: "操作",
				width: 500,
				formatter: function(value, row, index) {
					if(row.deleted == "0" || row.deleted == 0) {
						return "<div class=\"row\">" +
							"<div class=\"col-md-12\">" +
							"<a href=\"#\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-pencil fa-fw\"></span></a>" +
							"<a href=\"#\" class=\"tooltip-show cancel\" data-toggle=\"tooltip\" title=\"注销\"><span class=\"fa fa-user-times text-danger fa-fw\"></span></a>" +
							"</div></div>";
					}
					return "<div class=\"row\">" +
						"<div class=\"col-md-12\">" +
						"<a href=\"#\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-pencil fa-fw\"></span></a>" +
						"<a href=\"#\" class=\"tooltip-show activited\" data-toggle=\"tooltip\" title=\"启用\"><span class=\"fa fa-circle-o-notch fa-fw text-success\"></span></a>" +
						"</div></div>";
				},
				events: {
					"click .edit": function(e, value, row, index) {
						editUser(row);
					},
					"click .cancel": function(e, value, row, index) {
						UserMan.banObject(row, function(data) {
							datas.parentDom.bootstrapTable('updateRow', {
								index: index,
								row: data
							});
						});
					},
					"click .activited": function(e, value, row, index) {
						UserMan.activeObject(row, function(data) {
							datas.parentDom.bootstrapTable('updateRow', {
								index: index,
								row: data
							});
						})
					}
				}
			}],
			datas: dataList,
		};

		CodeZComponents.tablePlugins(datas.parentDom, datas.uri, datas.queryParams, datas.rowStyle, datas.showSearch, datas.refresh, datas.currentPage, datas.pageSize, datas.showPager, datas.column, datas.datas);
	},
}
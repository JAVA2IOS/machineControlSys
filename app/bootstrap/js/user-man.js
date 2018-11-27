// 用户安全管理

function usrLogin() {
	CodeZComponents.postRequest({
		action: CodeZ.ACTION_LOGIN,
		user: $('#form-username').val(),
		pwd: $('#password').val()
	}, function(data) {
		if(data.success) {
			$.session.set('user', JSON.stringify(data.data));
			window.location.href = CodeZ.HTML_PAGE_INDEX;
		} else {
			CodeZComponents.showErrorTip({
				text: data.error
			});
		}
	});
}

function usrLogout() {
	$.ajax({
		type: 'post',
		url: CodeZ.RQUEST_URI,
		data: {
			action: CodeZ.ACTION_LOGOUT,
		},
		success: function(result) {
			$.session.remove('user');
			goLogin();
		}
	});
}

$('#log-out').click(function() {
	usrLogout();
});

$("#toolbar").click(function() {
	$.session.remove('bindData');
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
	$.session.remove('bindData');
	var frameDom = $(window.top.document).find('#contentFrame');
	frameDom.attr('src', CodeZ.URI_SECURITY_MAN.USERMAN);
}

function changeToUserDetailInfo(data) {
	var ulDom = $(window.parent.document).find('.breadcrumb');
	ulDom.show();
	BreadMenu.updateBread(ulDom, data);
	directHref(data.href);
}

function editData() {
	var dataObj;
	var cacheData = $.session.get('bindData');
	CodeZComponents.postRequest({
		action: CodeZ.ACTION_ROLEMAN.LIST,
		data: true
	}, function(data) {
		if(data.success) {
			var optionData = data.data;
			$.map(optionData, function(option, index) {
				option.id = option.roleId;
				option.text = option.roleName;
			});
			$('#userRole').select2({
				data: optionData
			});
		}
	});
	if(cacheData != undefined || cacheData != null) {
		dataObj = JSON.parse(cacheData);
	}
	if(dataObj != undefined) {
		if(dataObj.tag != CodeZ.TAG_USER_ADD) {
			var userObj = dataObj.bindData;
			$("#userAccount").attr("disabled", "disabled");
			$('#userName').val(userObj.userName);
			// $('#userRole').val(userObj.role.roleId);
			$('#userRole').select2({
				id: userObj.role.roleId
			});
			$('#userAccount').val(userObj.userAccount);
			$('#userpassword').val(userObj.password);
			$('#dep').val(userObj.dep);
		}
	}
}

// 保存更新用户信息
function saveUser(fn) {
	var tag = CodeZ.ACTION_USR_ADD;
	var dataObj = new Object();
	var cacheData = $.session.get('bindData');
	if(cacheData != undefined || cacheData != null) {
		dataObj = JSON.parse(cacheData).bindData;
		tag = CodeZ.ACTION_USR_EDIT;
	}
	dataObj.userName = $('#userName').val();
	if(dataObj.role == undefined) {
		var role = new Object();
		role.roleId = $('#userRole').val();
		dataObj.role = role;
	} else {
		dataObj.role.roleId = $('#userRole').val();
	}
	dataObj.userAccount = $('#userAccount').val();
	dataObj.password = $('#userpassword').val();
	dataObj.dep = $('#dep').val();
	updateUser(tag, dataObj, function(data) {
		if(data.success) {
			CodeZComponents.showSuccessTip({
				title: '提示',
				text: '更新成功'
			});
			if(fn) {
				fn(dataObj);
			}
		} else {
			CodeZComponents.showErrorTip({
				title: '提示',
				text: data.error,
			});
		}
	});
}

// 面包屑导航选择跳转
function breadItemTransfer() {
	addIframe($('#userFrame'), $(event.target).constructor.data.href)
	BreadMenu.updateBread($(event.target).parent().parent(), $(event.target).constructor.data);
}

// 更新用户信息
function updateUser(tag, userObj, callback) {
	CodeZComponents.postRequest({
		action: tag,
		user: JSON.stringify(userObj)
	}, function(data) {
		if(callback) {
			callback(data);
		}
	});
}

var UserMan = {
	updatedUser: function() {
		var dataObj = $.session.get('user');
		if(dataObj) {
			dataObj = JSON.parse(dataObj);
			dataObj.userName = $('#userName').val();
			dataObj.password = $('#user-password').val();
			updateUser(CodeZ.ACTION_USR_EDIT, dataObj, function(data) {
				if(data.success) {
					CodeZComponents.showSuccessTip({
						title: '提示',
						text: data.data,
					});
				} else {
					CodeZComponents.showErrorTip({
						title: '提示',
						text: data.error,
					});
				}
			});
		}
	},
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
					updateUser(CodeZ.ACTION_USR_EDIT, user, function(data) {
						if(data.success) {
							if(fn) {
								fn(user);
							}
						} else {
							CodeZComponents.showErrorTip({
								title: '提示',
								text: data.error,
							});
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
	},

	// 激活用户
	activeObject: function(data, fn) {
		var user = data;
		user.deleted = 0;
		updateUser(CodeZ.ACTION_USR_EDIT, user, function(data) {
			if(data.success) {
				if(fn) {
					fn(user);
				}
			} else {
				CodeZComponents.showErrorTip({
					title: '提示',
					text: data.error,
				});
			}
		});
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
		var ulDom = $(window.parent.document).find('.breadcrumb');
		ulDom.show();
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
							"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-pencil fa-fw\"></span></a>" +
							"<a href=\"javascript:;\" class=\"tooltip-show cancel\" data-toggle=\"tooltip\" title=\"注销\"><span class=\"fa fa-user-times text-danger fa-fw\"></span></a>" +
							"</div></div>";
					}
					return "<div class=\"row\">" +
						"<div class=\"col-md-12\">" +
						"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-pencil fa-fw\"></span></a>" +
						"<a href=\"javascript:;\" class=\"tooltip-show activited\" data-toggle=\"tooltip\" title=\"启用\"><span class=\"fa fa-circle-o-notch fa-fw text-success\"></span></a>" +
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
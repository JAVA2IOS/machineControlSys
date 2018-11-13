// 用户安全管理

$("#toolbar").click(function() {
  changeToUserDetailInfo({
    tag: CodeZ.TAG_USER_ADD,
    href: CodeZ.HTML_PAGE_USER_ADD,
    title: '新增用户',
    actived : true,
  });
});

// 修改用户
function editUser(data) {
  changeToUserDetailInfo({
      tag: CodeZ.TAG_USER_EDIT,
      href: CodeZ.HTML_PAGE_USER_EDIT,
      title: '修改用户',
      actived : true,
      bindData : data
    });
}

function userList() {
  changeToUserDetailInfo({
    tag : CodeZ.TAG_USER_LIST,
    href : CodeZ.HTML_PAGE_USER_LIST,
    title : '用户列表',
    actived : true,
  });
}

function changeToUserDetailInfo(data) {
  var ulDom = $(window.parent.document).find('.breadcrumb');
  BreadMenu.updateBread(ulDom, data);
  // BreadMenu.updateBread($('.breadcrumb'), data);
  directHref(data.href);
}

function editData() {
  // var liDom = $(window.parent.document).find('li .active');
  // if(liDom.constructor.data != undefined) {
  //   if (liDom.constructor.data.tag == CodeZ.TAG_USER_EDIT) {
  //     var userObj = liDom.constructor.data.bindData;
  //     $('#userName').val(userObj.userName);
  //     $('#account').val(userObj.account);
  //     $('#password').val(userObj.password);
  //     $('#userRole').val(userObj.role.roleId);
  //   }
  //   return;
  // }

  $('#userName').val('userName');
  $('#userAccount').val('admin');
  $('#userpassword').val('default123');
  $('#dep').val('部门');
  $('#userRole').val('0');
}

function check(){
	addIframe($('#userFrame'),$(event.target).constructor.data.href)
	BreadMenu.updateBread($(event.target).parent().parent(), $(event.target).constructor.data);
}

// 面包屑导航栏
var BreadMenu = {
	addItem: function(data) {
		var item = CodeZComponents.addLi({
			css: 'userNav',
			data: data,
		});
		item.constructor.data = data;

		if(data.actived) {
			item.attr('class', 'active');
			item.html(data.title);
		} else {
			var href = CodeZComponents.addHref({
				css: 'breadItem',
				href : 'javascript:;',
				value: data.title,
			});
			href.attr('onClick', 'check()');
			item.append(href);
		}

		return item;
	},
	/*
	 * {
	 *  tag : '',
	 *  href : '',
	 *  title : ''
	 * }
	 */
	init: function(parentDomId, data) {
		var parentDom = $('#' + parentDomId);
		var breadMenu = $('<ul class="breadcrumb" style="background-color: #FFFFFF; padding-left: 15px;"></ul>');
		data.forEach(function(i, index) {
			var actived = false;
			if(index == parseInt(data.length - 1)) {
				actived = true;
			}
			i.actived = actived;
			breadMenu.append(BreadMenu.addItem(i));
		});

		parentDom.append(breadMenu);
	},

	updateBread: function(ulDom, data) {
		var childs = ulDom.children();
		var existed = false;
		if(childs.length > 1) {
			childs.each(function(args){
				var liDom = $(this);
				var bindData = liDom.constructor.data;
				if(bindData.tag == data.tag) {
					liDom.empty();
					liDom.attr('class', 'active');
					liDom.html(bindData.title);
					existed = true;
					liDom.nextAll().remove();
					return false;
				}
			});
		} else {
			if(childs.constructor.data.tag == data.tag) {
				childs.empty();
				childs.attr('class', 'active');
				childs.html(childs.constructor.data.title);
				existed = true;
				childs.nextAll().remove();
			}
		}

		if(!existed) {
			var lastActiveDom = ulDom.find('.active');
			var text = lastActiveDom.html();
			$(lastActiveDom).removeClass('active');
			lastActiveDom.empty();
			var hrefDom = CodeZComponents.addHref({
				css: 'breadItem',
				value: text,
				href : 'javascript:;',
			})
			hrefDom.attr('onClick', 'check()');
			$(lastActiveDom).append(hrefDom);
			
			ulDom.append(this.addItem(data));
			
		}
	},
}




var UserMan = {
  // 注销用户
	banObject: function(data, fn) {
		BootstrapDialog.show({
			title: BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_WARNING],
			message: '是否确认注销该用户',
			type: BootstrapDialog.TYPE_PRIMARY,
			cssClass: "login-dialog",
			data: {'bindData' : data},
			buttons: [{
				label: '确定',
				action: function(dialog) {
					dialog.close();
          CodeZComponents.showSuccessTip({title : '提示',text : '注销成功'});
          var user = dialog.getData('bindData');
          user.deleted = 1;
          if (fn) {
            fn(user);
          }
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
    CodeZComponents.showSuccessTip({title : '提示',text : '激活成功'});
    var user = data;
    user.deleted = 0;
    if (fn) {
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
    var dataRow = new Array();
    for (var i = 0; i < parseInt(Math.random(1, 1000) * 1000); i++) {
      var user = new User();
      user.userId = parseInt(Math.random(1, 1000) * 1000);
      user.userName = 'admin';
      user.account = 'admin' + parseInt(Math.random(100, 1000) * 100) + '';
      user.password = 'password123';
      user.dep = '部门' + Math.random(100, 1000) * 100 + '';
      user.deleted = parseInt(Math.random(10, 100) * 100 % 2);
      var role = new Role();
      role.roleId = parseInt(Math.random(10, 100) * 100 / 2);
      role.roleName = role.roleId ? '系统管理员' : '普通用户';
      role.description = '角色描述';
      role.deleted = parseInt(Math.random(10, 100) * 100 % 2);
      user.role = role;

      dataRow.push(user);
    }

		var datas = {
			queryParams: function(params) {
				return {action : 'usrList'};
			},
			// uri: '/machineControlSys/service/Routers.php',
			parentDom: $("#table-container"),
			pageSize: 8,
			refresh: function(params) {
				UserMan.configureUserList();
			},
			rowStyle: function(row, index) {
				if(row == undefined){
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
				field: "account",
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
						UserMan.banObject(row, function(data){
              datas.parentDom.bootstrapTable('updateRow', {index : index, row : data});
            });
					},
					"click .activited": function(e, value, row, index) {
            UserMan.activeObject(row, function(data) {
              datas.parentDom.bootstrapTable('updateRow', {index : index, row : data});
            })
					}
				}
			}],
      datas : dataRow,
		};

		CodeZComponents.tablePlugins(datas.parentDom, datas.uri, datas.queryParams, datas.rowStyle, datas.showSearch, datas.refresh, datas.currentPage, datas.pageSize, datas.showPager, datas.column, datas.datas);
	},
}
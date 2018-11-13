// 软件参数管理

var breadMenuTag = {
	firstMenu : {
		tag : CodeZ.TAG_CONTROL_CFG_LIST,
		href : CodeZ.HTML_PAGE_CTRL_CFG_LIST,
		title : '控制配置',
		actived : true,
	},
	secondMenu : {
		tag : CodeZ.TAG_CONTROL_CFG_LIST,
		href : CodeZ.HTML_PAGE_CTRL_CFG_LIST,
		title : '第二步',
		actived : true,
	}
}

function controlConfigureInit() {
	BreadMenu.init('breadNav', [breadMenuTag.firstMenu]);
	addIframe('#contentFrame', CodeZ.HTML_PAGE_CTRL_CFG_LIST);
}

$("#toolbar").click(function() {
});

function firstMenu() {
  transferToNextPage(breadMenuTag.firstMenu);
}

// 跳转到下一级
function transferToNextPage(data) {
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

// 面包屑导航选择跳转
function breadItemTransfer(){
	addIframe($('#userFrame'),$(event.target).constructor.data.href)
	BreadMenu.updateBread($(event.target).parent().parent(), $(event.target).constructor.data);
}


var SoftMan = {
	/* 
	* =================================
	* 控制配置
	* =================================
	*/
	// 控制配置表格展示
	showControlCfgList: function() {
		var dataRow = new Array();
	    for (var i = 0; i < parseInt(Math.random(1, 1000) * 1000); i++) {
	      var rowObj = {
	      	portName : '压铸机控制端口' + parseInt(Math.random(1, 1000) * 1000),
	      	host : 'ddsrd',
	      	address : '127.0.0.1',
	      	protocol : parseInt(Math.random(10, 100) * 100 % 2) == 1 ? 'tcp/ip' : 'udp',
	      	method : parseInt(Math.random(10, 100) * 100 % 2) == 1 ? '消息' : '命令行',
	      	username : 'admin',
	      	password : 'admin123',
	      	port : parseInt(Math.random(1, 1000) * 1000),
	      	opened : parseInt(Math.random(10, 100) * 100 % 2),
	      };

	      dataRow.push(rowObj);
	    }
		var parameters = {
			pageSize : 10,
			queryFn : function() {
				return {action : ''};
			},
			uri : undefined,
			loadSuccessFn : undefined,
			loadFailedFn : undefined,
			refreshFn : function() {
				SoftMan.showControlCfgList();
			},
			column : [{
				field : 'portName',
				title: "端口名称",
				width: '25%',
				valign : 'middle',
			},{
				field : 'host',
				title: "远程主机名称",
				valign : 'middle',
			},{
				field : 'address',
				title: "远程连接地址",
				width: '20%',
				valign : 'middle',
			},{
				field : 'protocol',
				title: "远程连接协议",
				valign : 'middle',
			},{
				field : 'port',
				title: "端口号",
				valign : 'middle',
			},{
				field : 'method',
				title: "控制方式",
				width: '15%',
				valign : 'middle',
			},{
				field : 'username',
				title: "用户名",
				valign : 'middle',
			},{
				field : 'password',
				title: "密码",
				valign : 'middle',
			},{
				field : 'opened',
				title: "是否打开",
				valign : 'middle',
				formatter: function(value, row, index) {
					if(value == 1 || value == '1') {
            			return "已打开";
					} else {
            			return "未打开";
					}
				},
			}],
			dataRows : dataRow,
			// dataRows : undefined,
			rowStyleFn : function(row, index) {
				return {css :{'font-size' : '10px', 'height' : '40px'}};
			},
			onCheck : function(row, e) {
				
			},
			onUncheck : function(row, e) {
				
			},
			onClick : function(row, e, field) {
				console.info(row);
			},
		};
		this.tablePluginsConfigure(parameters);
	},

	/* 
	* =================================
	* 数据库连接
	* =================================
	*/
	showDataBaseList : function() {
		this.tablePluginsConfigure();
	},

	/*
	* ================================
	* baseComponents
	* ================================
	*/
	tablePluginsConfigure : function(parameters) {
		var datas = {
			queryParams: parameters.queryFn,
			uri : parameters.uri,
			parentDom: $("#table-container"),
			pageSize: parameters.pageSize,
			refresh: parameters.refreshFn,
			rowStyle: parameters.rowStyleFn,
			column: parameters.column,
      		datas : parameters.dataRows,
		};

		CodeZComponents.tablePlugins(datas.parentDom, datas.uri, datas.queryParams, datas.rowStyle, datas.showSearch, datas.refresh, datas.currentPage, datas.pageSize, datas.showPager, datas.column, datas.datas, datas.loadSuccessFn, datas.loadFailedFn, parameters.onClick, parameters.onCheck, parameters.onUncheck);
	}
}


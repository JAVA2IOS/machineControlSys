// 软件参数管理

var breadMenuTag = {
	firstMenu : {
		tag : CodeZ.TAG_CONTROL_CFG_LIST,
		href : CodeZ.HTML_PAGE_CTRL_CFG_LIST,
		title : '控制配置',
		actived : true,
	},
	addMenu : {
		tag : CodeZ.TAG_CONTROL_CFG_ADD,
		href : CodeZ.HTML_PAGE_CTRL_CFG_INFO,
		title : '添加配置',
		actived : true,
	},
	upateMenu : {
		tag : CodeZ.TAG_CONTROL_CFG_EDIT,
		href : CodeZ.HTML_PAGE_CTRL_CFG_INFO,
		title : '修改配置',
		actived : true,
	},
	infoMenu : {
		tag : CodeZ.TAG_CONTROL_CFG_INFO,
		href : CodeZ.HTML_PAGE_CTRL_CFG_INFO,
		title : '修改配置',
		actived : true,
	},
}

function controlConfigureInit() {
	BreadMenu.init('breadNav', [breadMenuTag.firstMenu]);
	addIframe('#contentFrame', CodeZ.HTML_PAGE_CTRL_CFG_LIST);
}

$("#toolbar").click(function() {
	transferToNextPage(breadMenuTag.addMenu);
});

function firstMenu() {
  transferToNextPage(breadMenuTag.firstMenu);
}

// 跳转到下一级
function transferToNextPage(data) {
	 var ulDom = $(window.parent.document).find('.breadcrumb');
	 BreadMenu.updateBread(ulDom, data);
	directHref(data.href);
}

// 面包屑导航选择跳转
function breadItemTransfer() {
	addIframe($('#contentFrame'), $(event.target).constructor.data.href)
	BreadMenu.updateBread($(event.target).parent().parent(), $(event.target).constructor.data);
}

// 编辑是否可连接
function driveConnected(data, connected = false, fn) {
	data.deleted = connected ? '0' : '1';
	data.updateTime = CodeZComponents.getCurrentDate();
	CodeZComponents.postRequest({action : CodeZ.ACTION_PORT_EDIT, port : JSON.stringify(data)}, function(data){
		if(data.success) {
			CodeZComponents.showSuccessTip({
				title: '提示',
				text: '配置成功'
			});
			if(fn) {
				fn(data);
			}
		} else {
			CodeZComponents.showErrorTip({
				title: '提示',
				text: data.error,
			});
		}
	});
}

// 更新数据
function updateData(data) {
	var bindData = breadMenuTag.upateMenu;
	bindData.bindData = data;
	transferToNextPage(bindData);
}

// 配置数据显示
function configureData() {
	// var dataObj = JSON.parse($.session.get('bindData'));
	if(dataObj != undefined) {
		if(dataObj.tag != CodeZ.TAG_CONTROL_CFG_ADD) {
			var userObj = dataObj.bindData;
			// $('#userName').val(userObj.userName);
		}
		return;
	}
}


var SoftMan = {
	/* 
	* =================================
	* 控制配置
	* =================================
	*/
	// 控制配置表格展示
	configureCfgListData : function() {
		CodeZComponents.postRequest({
			action: CodeZ.ACTION_PORT_LIST,
		}, function(data) {
			if(data.success) {
				var dataRow = data.data;
				SoftMan.showControlCfgList(dataRow);
			}
		});
	},
	
	showControlCfgList: function(dataList) {
		var parameters = {
			pageSize : 10,
			uri : undefined,
			loadSuccessFn : undefined,
			loadFailedFn : undefined,
			refreshFn : function() {
				SoftMan.configureCfgListData();
			},
			column : [{
				field : 'portName',
				title: "端口名称",
				width: '25%',
				valign : 'middle',
			},{
				field : 'remoteHost',
				title: "远程主机名称",
				valign : 'middle',
			},{
				field : 'remoteIp',
				title: "远程连接地址",
				width: '20%',
				valign : 'middle',
			},{
				field : 'remoteProtocol',
				title: "远程连接协议",
				valign : 'middle',
			},{
				field : 'remotePort',
				title: "端口号",
				valign : 'middle',
			},{
				field : 'controlMethod',
				title: "控制方式",
				width: '15%',
				valign : 'middle',
			},{
				field : 'remoteUsr',
				title: "用户名",
				valign : 'middle',
			},{
				field : 'deleted',
				title: "状态",
				valign : 'middle',
				width : '10%',
				formatter: function(value, row, index) {
					if(value == 1 || value == '1') {

						return '未连接';
					}

					return '已连接';
				},
			},{
				field : 'updateTime',
				title: "更新时间",
				valign : 'middle',
				width : '20%',
			},{
				field : 'action',
				title: "操作",
				valign : 'middle',
				align : 'center',
				width : '20%',
				formatter: function(value, row, index) {
					if(row.deleted == 1 || row.deleted == '1') {
							return "<div class=\"row\">" +
								"<div class=\"col-sm-8 col-sm-offset-2\">" +
								"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"配置\"><span class=\"fa fa-edit fa-fw\"></span></a>" +
								"<a href=\"javascript:;\" class=\"tooltip-show connect\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"连接\"><span class=\"fa fa-plug fa-fw text-primary\"></span></a>" +
								"</div></div>";
					}
					return "<div class=\"row\">" +
						"<div class=\"col-sm-8 col-sm-offset-2\">" +
						"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"配置\"><span class=\"fa fa-edit fa-fw\"></span></a>" +
						"<a href=\"javascript:;\" class=\"tooltip-show disconnect\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"断开\"><span class=\"fa fa-unlink text-danger fa-fw\"></span></a>" +
						"</div></div>";
				},
				events: {
					'click .edit': function(e, value, row, index) {
						updateData(row);
					},
					"click .disconnect": function(e, value, row, index) {
						driveConnected(row, false, function(data){
							$("#table-container").bootstrapTable('updateRow', {
								index: index,
								row: data
							});
						});
					},
					"click .connect": function(e, value, row, index) {
						driveConnected(row, true, function(data){
							$("#table-container").bootstrapTable('updateRow', {
								index: index,
								row: data
							});
						});
					}
				},
			}],
			dataRows : dataList,
			rowStyleFn : function(row, index) {
				if (row.deleted == 1 || row.deleted == '1') {
					return {css :{'font-size' : '10px', 'height' : '40px'}, classes : 'warning'};
				}
				return {css :{'font-size' : '10px', 'height' : '40px'}};
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

		CodeZComponents.tablePlugins(datas.parentDom, datas.uri, datas.queryParams, datas.rowStyle, datas.showSearch, datas.refresh, datas.currentPage, datas.pageSize, datas.showPager, datas.column, datas.datas, datas.loadSuccessFn, datas.loadFailedFn, parameters.onClick, parameters.onCheck, parameters.onUncheck, null, parameters.showDetail, parameters.detailFormatter);
	}
}


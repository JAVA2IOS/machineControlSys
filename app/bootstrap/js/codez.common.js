var sessionCacheKeyTag = $.session.get('cacheKey');
var categoryTag = JSON.parse($.session.get('tag'));
var actions = JSON.parse($.session.get('action'));
var urls = JSON.parse($.session.get('page'));

var breadMenuTag = {

	indexBread: {
		tag: categoryTag.INDEX,
		href: urls.INDEX,
		title: categoryTag.INDEXTITLE,
		actived: true,
	},

	tableBread: {
		tag: categoryTag.LIST,
		href: urls.LIST,
		title: categoryTag.LISTTITLE,
		actived: true,
	},

	newBread: {
		tag: categoryTag.ADD,
		href: urls.INFO,
		title: categoryTag.ADDTITLE,
		actived: true,
	},

	editBread: {
		tag: categoryTag.EDIT,
		href: urls.INFO,
		title: categoryTag.EDITTITLE,
		actived: true,
	},

	infoBread: {
		tag: categoryTag.INFO,
		href: urls.INFO,
		title: categoryTag.INFOTITLE,
		actived: true,
	}
}

/*
 * ================
 * 传感器
 * ================
 */

// 断开或者启用传感器
function connectedSensor(connectedData, connect = false, fn) {
	updateSingleData(CodeZ.ACTION_SENSOR.EDIT, connectedData, connect ? '已注销传感器' : '注册成功', fn);
}

// 配置列表参数信息
function configureSensorListStyle() {
	var tableParam = {
		column: [{
			field: 'sensorName',
			title: "名称",
			width: '25%',
			valign: 'middle',
		}, {
			field: 'sensorType',
			title: "型号",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'sensorModel',
			title: "类型",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'sensorPort',
			title: "端口号",
			valign: 'middle',
			width: '10%',
		}, {
			field: 'location',
			title: "安装位置",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'address',
			title: "地址编号",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'updateTime',
			title: "更新时间",
			width: '15%',
			valign: 'middle',
		}, {
			field: 'deleted',
			title: "状态",
			valign: 'middle',
			width: '10%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '未注册';
				}

				return '注册';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: '20%',
			formatter: function(value, row, index) {
				if(row.deleted == 1 || row.deleted == '1') {
					return "<div class=\"row\">" +
						"<div class=\"col-sm-8 col-sm-offset-2\">" +
						"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-edit fa-fw\"></span></a>" +
						"<a href=\"javascript:;\" class=\"tooltip-show connect\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"注册\"><span class=\"fa fa-plug fa-fw text-primary\"></span></a>" +
						"</div></div>";
				}
				return "<div class=\"row\">" +
					"<div class=\"col-sm-8 col-sm-offset-2\">" +
					"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-edit fa-fw\"></span></a>" +
					"<a href=\"javascript:;\" class=\"tooltip-show disconnect\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"注销\"><span class=\"fa fa-unlink text-danger fa-fw\"></span></a>" +
					"</div></div>";
			},
			events: {
				'click .edit': function(e, value, row, index) {
					getDetailItemInfo(row);
				},
				"click .disconnect": function(e, value, row, index) {
					connectedSensor(row, true, function(data) {
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: data
						});
					});
				},
				"click .connect": function(e, value, row, index) {
					connectedSensor(row, false, function(data) {
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: data
						});
					});
				}
			},
		}],
		rowStyle: function(row, index) {
			if(row.deleted == 1 || row.deleted == '1') {
				return {
					css: {
						'font-size': '10px',
						'height': '40px'
					},
					classes: 'warning'
				};
			}
			return {
				css: {
					'font-size': '10px',
					'height': '40px'
				}
			};
		},
	};

	return tableParam;
}

// UI配置
function sensorUIComponents() {
	var title = ['用户名', '用户名', '用户名'];
	var identifiers = ['uerName', 'uerName', 'uerName'];
	var inputDoms;
	for (i = 0; i < identifiers.length; i ++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		inputDoms += '<div class="form-group"><label for="' + data + '" class="col-sm-2 control-label text-center">' + itemTitle + '</label><div class="col-sm-9">' +
			'<input required="required" type="text" class="form-control dialog-form" id="' + data + '" placeholder="请输入' + itemTitle + '">' +
			'</div></div>';
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureSensorDataInfo(data) {
	// $('#dd').val(data.userName);
}

// 更新当前的参数数据
function updateSensorData(updatedData) {
	// updatedData.userName = $('#dd').val();

	return updatedData;
}

/*
 * ================
 * 通用
 * ================
 */
/* 跳转首页
 * {
 *	sessionKey : 需要移除的session数据的键值,
 *	uri : 跳转的地址
 * }
 */
function goIndexPage() {
	$.session.remove(sessionCacheKeyTag);
	var frameDom = $(window.top.document).find('#contentFrame');
	frameDom.attr('src', urls.INDEX);
}

/* 表格页面跳转
 * {
 *	breadItem : 面包屑数据,
 *	uri : 跳转的地址
 * }
 */
function goTablePage() {
	$('#panelTitle').html('&nbsp;<h4>' + categoryTag.INDEXTILE + '</h4></div>');
	console.info($('#panelTitle'));
	BreadMenu.init('breadNav', [breadMenuTag.tableBread]);
	addIframe('#contentFrame', urls.LIST);
}

/* 数据新增请求
* {
	action : 请求参数
*	newSensorData : 需要提交的数据,
*	callback : 回调方法
* }
*/
function addNewData(action, newSensorData, callback) {
	updateSingleData(action.ADD, newSensorData, '新增成功', callback);
}

// 进入到详细页面响应方法
function getDetailItemInfo(data) {
	var bindData = breadMenuTag.updateBread;
	if(data) {
		bindData.bindData = data;
	}
	$.session.set(sessionCacheKeyTag, JSON.stringify(bindData));
	transferToNextPage(bindData);
}

// 添加详情页面UI
function configureUIComponents() {
	var categoryStr = sessionCacheKeyTag.substr(0, sessionCacheKeyTag.length - '_key'.length);
	var components;
	switch(categoryStr) {
		case CodeZ.NAV_SOFTPARAMETER.CONTROL_CFG:

		case CodeZ.NAV_SOFTPARAMETER.DATABASE_CONNECT:

			break;
		case CodeZ.NAV_MACHINEMAN.SENSOR:
			//传感器处理
			components = sensorUIComponents();
			break;
		case CodeZ.NAV_MACHINEMAN.MACHINE:

			break;
		case CodeZ.NAV_MACHINEMAN.COUNTER:

			break;
		case CodeZ.NAV_CONTROLPARAMETER:

			break;
		case CodeZ.NAV_AUTO_CONTROL:

			break;
		case CodeZ.NAV_CONTROL_DATA:

			break;
		case CodeZ.NAV_SECURITY_MAN.USERMAN:

			break;
		case CodeZ.NAV_SECURITY_MAN.ROLEMAN:

			break;
		default:
			break;
	}

	// 添加组控件
	$('.form-horizontal').prepend(components);
}

// 添加数据参数显示
function configureItemInfoData() {
	var dataObj;
	var cacheData = $.session.get(sessionCacheKeyTag);
	if(cacheData != undefined || cacheData != null) {
		dataObj = JSON.parse(cacheData);
	}
	if(dataObj != undefined) {
		var categoryStr = sessionCacheKeyTag.substr(0, sessionCacheKeyTag.length - '_key'.length);
		switch(categoryStr) {
			case CodeZ.NAV_SOFTPARAMETER.CONTROL_CFG:

			case CodeZ.NAV_SOFTPARAMETER.DATABASE_CONNECT:

				break;
			case CodeZ.NAV_MACHINEMAN.SENSOR:
				//传感器处理
				confgiureSensorDataInfo(dataObj);
				break;
			case CodeZ.NAV_MACHINEMAN.MACHINE:

				break;
			case CodeZ.NAV_MACHINEMAN.COUNTER:

				break;
			case CodeZ.NAV_CONTROLPARAMETER:

				break;
			case CodeZ.NAV_AUTO_CONTROL:

				break;
			case CodeZ.NAV_CONTROL_DATA:

				break;
			case CodeZ.NAV_SECURITY_MAN.USERMAN:

				break;
			case CodeZ.NAV_SECURITY_MAN.ROLEMAN:

				break;
			default:
				break;
		}
	}
}

// 取消按钮响应
$("#addNewItem").click(function() {
	$.session.remove(sessionCacheKeyTag);
	transferToNextPage(breadMenuTag.newBread);
});

/* ======================= 详情页面 "确认" , "取消" 按钮响应============================ */
// 取消按钮响应
$("#dataCancel").click(function() {
	goIndexPage();
});

// 确认项按钮响应
$("#dataSubmit").click(function() {
	var categoryStr = cacheKey.substr(0, cacheKey.length - '_key'.length);
	var actionParameters = action.ADD;
	var infoTip = '新增成功';
	var dataObj = new Object();
	var cacheData = $.session.get(sessionCacheKeyTag);
	if(cacheData != undefined || cacheData != null) {
		dataObj = JSON.parse(cacheData).bindData;
		actionParameters = action.EDIT;
		infoTip = '更新成功';
	}
	// 配置数据
	switch(categoryStr) {
		case CodeZ.NAV_SOFTPARAMETER.CONTROL_CFG:

		case CodeZ.NAV_SOFTPARAMETER.DATABASE_CONNECT:

			break;
		case CodeZ.NAV_MACHINEMAN.SENSOR:
			//传感器处理
			updateSensorData(dataObj);
			break;
		case CodeZ.NAV_MACHINEMAN.MACHINE:

			break;
		case CodeZ.NAV_MACHINEMAN.COUNTER:

			break;
		case CodeZ.NAV_CONTROLPARAMETER:

			break;
		case CodeZ.NAV_AUTO_CONTROL:

			break;
		case CodeZ.NAV_CONTROL_DATA:

			break;
		case CodeZ.NAV_SECURITY_MAN.USERMAN:

			break;
		case CodeZ.NAV_SECURITY_MAN.ROLEMAN:

			break;
		default:
			break;
	}

	updateSingleData(actionParameters, dataObj, infoTip, function(data) {
		$.session.remove(sessionCacheKeyTag);
		goIndexPage();
	});
});

/*
 * ================
 * 面包屑导航跳转方法
 * ================
 */
// 跳转到下一级
function transferToNextPage(data) {
	var ulDom = $(window.parent.document).find('.breadcrumb');
	ulDom.show();
	BreadMenu.updateBread(ulDom, data);
	directHref(data.href);
}

// 面包屑导航选择跳转
function breadItemTransfer() {
	addIframe($('#contentFrame'), $(event.target).constructor.data.href)
	BreadMenu.updateBread($(event.target).parent().parent(), $(event.target).constructor.data);
}

// 更新数据
function updateSingleData(tag, updatedData, successTip = '更新成功', callback) {
	CodeZComponents.postRequest({
		action: tag,
		data: JSON.stringify(updatedData)
	}, function(data) {
		if(data.success) {
			CodeZComponents.showSuccessTip({
				title: '提示',
				text: successTip,
			});
			if(callback) {
				callback(data);
			}
		} else {
			CodeZComponents.showErrorTip({
				title: '提示',
				text: data.error,
			});
		}
	});
}

/*
 * ================
 * 通用页面数据管理
 * ================
 */
var CommonMan = {
	// /* 
	// * ==========
	// * 压铸机列表
	// * ==========
	// */

	// configureMachineList : function() {
	// 	/*
	// 	var ulDom = $(window.parent.document).find('.breadcrumb');
	// 	ulDom.hide();
	// 	CodeZComponents.postRequest({
	// 		action: '',
	// 	}, function(data) {
	// 		if(data.success) {
	// 			var dataRow = data.data;
	// 			SoftMan.showMachineList(dataRow);
	// 		}
	// 	});
	// 	*/

	// 	//e .g
	// 	this.showMachineList({});
	// },

	// showMachineList : function(dataList) {
	// 	var parameters = {
	// 		pageSize : 10,
	// 		uri : undefined,
	// 		loadSuccessFn : undefined,
	// 		loadFailedFn : undefined,
	// 		refreshFn : function() {
	// 			MachineMan.configureMachineList();
	// 		},
	// 		column : [{
	// 			field : 'dataBaseName',
	// 			title: "数据库名称",
	// 			width: 1000,
	// 			valign : 'middle',
	// 		},{
	// 			field : 'connectable',
	// 			title: "状态",
	// 			valign : 'middle',
	// 			align : 'center',
	// 			width: 1000,
	// 			formatter: function(value, row, index) {
	// 				if(value == 1 || value == '1') {

	// 					return '已打开';
	// 				}

	// 				return '已关闭';
	// 			},
	// 		},{
	// 			field : 'deleted',
	// 			title: "注销",
	// 			valign : 'middle',
	// 			align : 'center',
	// 			width : 1000,
	// 			formatter: function(value, row, index) {
	// 				if(value == 1 || value == '1') {

	// 					return '已注销';
	// 				}

	// 				return '正常';
	// 			},
	// 		},{
	// 			field : 'action',
	// 			title: "操作",
	// 			valign : 'middle',
	// 			align : 'center',
	// 			width : 1000,
	// 			formatter: function(value, row, index) {
	// 				if(row.deleted == 1 || row.deleted == '1') {
	// 						return "<div class=\"row\">" +
	// 							"<div class=\"col-sm-8 col-sm-offset-2\">" +
	// 							"<a href=\"javascript:;\" class=\"tooltip-show open\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"打开\"><span class=\"fa fa-plug fa-fw text-primary\"></span></a>" +
	// 							"</div></div>";
	// 				}
	// 				return "<div class=\"row\">" +
	// 					"<div class=\"col-sm-8 col-sm-offset-2\">" +
	// 					"<a href=\"javascript:;\" class=\"tooltip-show close\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"断开\"><span class=\"fa fa-unlink text-danger fa-fw\"></span></a>" +
	// 					"</div></div>";
	// 			},
	// 			events: {
	// 				"click .close": function(e, value, row, index) {
	// 					$("#table-container").bootstrapTable('updateRow', {
	// 							index: index,
	// 							row: data
	// 						});
	// 				},
	// 				"click .open": function(e, value, row, index) {
	// 					$("#table-container").bootstrapTable('updateRow', {
	// 							index: index,
	// 							row: data
	// 						})
	// 				}
	// 			},
	// 		}],
	// 		dataRows : dataList,
	// 		rowStyleFn : function(row, index) {
	// 			if (row.deleted == 1 || row.deleted == '1') {
	// 				return {css :{'font-size' : '10px', 'height' : '40px'}, classes : 'warning'};
	// 			}
	// 			return {css :{'font-size' : '10px', 'height' : '40px'}};
	// 		},
	// 	};
	// 	this.tablePluginsConfigure(parameters);
	// },

	// /* 
	// * ==========
	// * 计数器列表
	// * ==========
	// */

	// configureCounterList : function() {
	// 	/*
	// 	var ulDom = $(window.parent.document).find('.breadcrumb');
	// 	ulDom.hide();
	// 	CodeZComponents.postRequest({
	// 		action: '',
	// 	}, function(data) {
	// 		if(data.success) {
	// 			var dataRow = data.data;
	// 			SoftMan.showCounterList(dataRow);
	// 		}
	// 	});
	// 	*/

	// 	//e .g
	// 	this.showCounterList({});
	// },

	// showCounterList : function(dataList) {
	// 	var parameters = {
	// 		pageSize : 10,
	// 		uri : undefined,
	// 		loadSuccessFn : undefined,
	// 		loadFailedFn : undefined,
	// 		refreshFn : function() {
	// 			MachineMan.configureCounterList();
	// 		},
	// 		column : [{
	// 			field : 'dataBaseName',
	// 			title: "数据库名称",
	// 			width: 1000,
	// 			valign : 'middle',
	// 		},{
	// 			field : 'connectable',
	// 			title: "状态",
	// 			valign : 'middle',
	// 			align : 'center',
	// 			width: 1000,
	// 			formatter: function(value, row, index) {
	// 				if(value == 1 || value == '1') {

	// 					return '已打开';
	// 				}

	// 				return '已关闭';
	// 			},
	// 		},{
	// 			field : 'deleted',
	// 			title: "注销",
	// 			valign : 'middle',
	// 			align : 'center',
	// 			width : 1000,
	// 			formatter: function(value, row, index) {
	// 				if(value == 1 || value == '1') {

	// 					return '已注销';
	// 				}

	// 				return '正常';
	// 			},
	// 		},{
	// 			field : 'action',
	// 			title: "操作",
	// 			valign : 'middle',
	// 			align : 'center',
	// 			width : 1000,
	// 			formatter: function(value, row, index) {
	// 				if(row.deleted == 1 || row.deleted == '1') {
	// 						return "<div class=\"row\">" +
	// 							"<div class=\"col-sm-8 col-sm-offset-2\">" +
	// 							"<a href=\"javascript:;\" class=\"tooltip-show open\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"打开\"><span class=\"fa fa-plug fa-fw text-primary\"></span></a>" +
	// 							"</div></div>";
	// 				}
	// 				return "<div class=\"row\">" +
	// 					"<div class=\"col-sm-8 col-sm-offset-2\">" +
	// 					"<a href=\"javascript:;\" class=\"tooltip-show close\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"断开\"><span class=\"fa fa-unlink text-danger fa-fw\"></span></a>" +
	// 					"</div></div>";
	// 			},
	// 			events: {
	// 				"click .close": function(e, value, row, index) {
	// 					$("#table-container").bootstrapTable('updateRow', {
	// 							index: index,
	// 							row: data
	// 						});
	// 				},
	// 				"click .open": function(e, value, row, index) {
	// 					$("#table-container").bootstrapTable('updateRow', {
	// 							index: index,
	// 							row: data
	// 						})
	// 				}
	// 			},
	// 		}],
	// 		dataRows : dataList,
	// 		rowStyleFn : function(row, index) {
	// 			if (row.deleted == 1 || row.deleted == '1') {
	// 				return {css :{'font-size' : '10px', 'height' : '40px'}, classes : 'warning'};
	// 			}
	// 			return {css :{'font-size' : '10px', 'height' : '40px'}};
	// 		},
	// 	};
	// 	this.tablePluginsConfigure(parameters);
	// },

	/*
	 * ================================
	 * baseComponents
	 * ================================
	 */
	// 表格数据展示
	configureTableListData: function(parameters) {
		var ulDom = $(window.parent.document).find('.breadcrumb');
		ulDom.hide();
		if(parameters) {
			CommonMan.showTableList(parameters);
		}
	},
	/*
	 * {
	 *	data : [],表格数据
	 *	column : [], 列的格式,
	 *	rowStyle : fn, 行的格式
	 * }
	 */
	showTableList: function(dataSource) {
		var parameters = {
			pageSize: 10,
			refreshFn: function() {
				configureCategoryData();
			},
			column: dataSource.column,
			dataRows: dataSource.data,
			rowStyleFn: dataSource.rowStyle,
		};
		this.tablePluginsConfigure(parameters);
	},

	tablePluginsConfigure: function(parameters) {
		var datas = {
			queryParams: parameters.queryFn,
			uri: parameters.uri,
			parentDom: $("#table-container"),
			pageSize: parameters.pageSize,
			refresh: parameters.refreshFn,
			rowStyle: parameters.rowStyleFn,
			column: parameters.column,
			datas: parameters.dataRows,
		};

		CodeZComponents.tablePlugins(datas.parentDom, datas.uri, datas.queryParams, datas.rowStyle, datas.showSearch, datas.refresh, datas.currentPage, datas.pageSize, datas.showPager, datas.column, datas.datas, datas.loadSuccessFn, datas.loadFailedFn, parameters.onClick, parameters.onCheck, parameters.onUncheck, null, parameters.showDetail, parameters.detailFormatter);
	}
}

// 列表数据展示
function configureCategoryData() {
	var categoryStr = sessionCacheKeyTag.substr(0, sessionCacheKeyTag.length - '_key'.length);
	var tableParam;
	switch(categoryStr) {
		case CodeZ.NAV_SOFTPARAMETER.CONTROL_CFG:

		case CodeZ.NAV_SOFTPARAMETER.DATABASE_CONNECT:

			break;
		case CodeZ.NAV_MACHINEMAN.SENSOR:
			//传感器处理
			{
				tableParam = configureSensorListStyle();
			}
			break;
		case CodeZ.NAV_MACHINEMAN.MACHINE:

			break;
		case CodeZ.NAV_MACHINEMAN.COUNTER:

			break;
		case CodeZ.NAV_CONTROLPARAMETER:

			break;
		case CodeZ.NAV_AUTO_CONTROL:

			break;
		case CodeZ.NAV_CONTROL_DATA:

			break;
		case CodeZ.NAV_SECURITY_MAN.USERMAN:

			break;
		case CodeZ.NAV_SECURITY_MAN.ROLEMAN:

			break;
		default:
			break;
	}
	// 请求数据
	CodeZComponents.postRequest({
		action: actions.LIST,
	}, function(data) {
		if(data.success) {
			tableParam.data = data.data;
			CommonMan.configureTableListData(tableParam);
		}
	});
}
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
 * 数据库
 * ================
 */

// 配置列表参数信息
function configureDataBaseListStyle() {
	var tableParam = {
		column: [{
			field: 'dbName',
			title: "数据库名称",
			width: 1000,
			valign: 'middle',
		}, {
			field: 'opened',
			title: "状态",
			valign: 'middle',
			align: 'center',
			width: 1000,
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {
					return '已打开';
				}

				return '已关闭';
			},
		}, {
			field: 'deleted',
			title: "注销",
			valign: 'middle',
			align: 'center',
			width: 1000,
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '已注销';
				}

				return '正常';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: 1000,
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
					row.deleted = 1;
					updateSingleData(actions.EDIT, row, '数据库注销成功', function(data) {
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: row
						});
					});
				},
				"click .connect": function(e, value, row, index) {
					row.deleted = 0;
					updateSingleData(actions.EDIT, row, '数据库注册成功', function(data) {
						console.info(data);
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: row
						});
					});
				}
			},
		}],
		rowStyle: function(row, index) {
			if(row.connected == 0 || row.connected == '0') {
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
function dataBaseUIComponents() {
	var title = ['数据库名称', '打开数据库'];
	var identifiers = ['dbName', 'opened'];
	var inputDoms = '';
	for(i = 0; i < identifiers.length; i++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		if(data == 'opened') {
			inputDoms += '<div class="form-group">' +
				'<label for="' + data + '" class="col-sm-2 control-label">' + itemTitle + '</label>' +
				'<div class="col-sm-9">' +
				'<select class="form-control" id="' + data + '"><option value="0" selected="selected">关闭</option><option value="1">开启</option>' +
				'</select></div></div>';
			continue;
		}

		inputDoms += '<div class="form-group"><label for="' + data + '" class="col-sm-2 control-label text-center">' + itemTitle + '</label><div class="col-sm-9">' +
			'<input required="required" type="text" class="form-control dialog-form" id="' + data + '" placeholder="请输入' + itemTitle + '">' +
			'</div></div>';
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureDataBaseDataInfo(data) {
	var bindObj = data.bindData;
	if(bindObj) {
		$('#dbName').val(bindObj.dbName);
		$('#opened').val(bindObj.opened);
		if(data.deleted == '1' || data.deleted == 1) {
			$('#opened').attr('disabled', 'disabled');
		}
	}
}

// 更新当前的参数数据
function updateDataBaseData(updatedData) {
	updatedData.dbName = $('#dbName').val();
	updatedData.opened = $('#opened').val();

	return updatedData;
}

/*
 * ================
 * 传感器
 * ================
 */

// 断开或者启用传感器
function connectedSensor(connectedData, connect = false, fn) {
	connectedData.connected = connect ? 1 : 0;
	updateSingleData(CodeZ.ACTION_SENSOR.EDIT, connectedData, !connect ? '已注销传感器' : '传感器注册成功', fn);
}

// 配置列表参数信息
function configureSensorListStyle() {
	var tableParam = {
		column: [{
			field: 'sensorName',
			title: "名称",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'sensorType',
			title: "类型",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'sensorModel',
			title: "型号",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'sensorPort',
			title: "端口号",
			valign: 'middle',
		}, {
			field: 'location',
			title: "安装位置",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'address',
			title: "地址编号",
			valign: 'middle',
		}, {
			field: 'connected',
			title: "状态",
			valign: 'middle',
			width: '20%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '已注册';
				}

				return '未注册';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: '20%',
			formatter: function(value, row, index) {
				if(row.connected == 0 || row.connected == '0') {
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
					connectedSensor(row, false, function(data) {
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: data
						});
					});
				},
				"click .connect": function(e, value, row, index) {
					connectedSensor(row, true, function(data) {
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: data
						});
					});
				}
			},
		}],
		rowStyle: function(row, index) {
			if(row.connected == 0 || row.connected == '0') {
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
	var title = ['名称', '类型', '型号', '端口号', '安装位置', '地址编号'];
	var identifiers = ['sensorName', 'sensorType', 'sensorModel', 'sensorPort', 'location', 'sensorNo'];
	var inputDoms = '';
	for(i = 0; i < identifiers.length; i++) {
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
	var bindObj = data.bindData;
	if(bindObj) {
		$('#sensorName').val(bindObj.sensorName);
		$('#sensorType').val(bindObj.sensorType);
		$('#sensorModel').val(bindObj.sensorModel);
		$('#sensorPort').val(bindObj.sensorPort);
		$('#location').val(bindObj.location);
		$('#sensorNo').val(bindObj.address);
	}
}

// 更新当前的参数数据
function updateSensorData(updatedData) {
	updatedData.sensorName = $('#sensorName').val();
	updatedData.sensorType = $('#sensorType').val();
	updatedData.sensorModel = $('#sensorModel').val();
	updatedData.sensorPort = $('#sensorPort').val();
	updatedData.location = $('#location').val();
	updatedData.address = $('#sensorNo').val();

	return updatedData;
}

/*
 * ================
 * 压铸机配置
 * ================
 */
function configureMachineListStyle() {
	var tableParam = {
		column: [{
			field: 'machineName',
			title: "压铸机名称",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'machineType',
			title: "类型",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'machineModel',
			title: "型号",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'port',
			title: "端口号",
			valign: 'middle',
		}, {
			field: 'location',
			title: "安装位置",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'address',
			title: "地址编号",
			valign: 'middle',
		}, {
			field: 'connectable',
			title: "状态",
			valign: 'middle',
			width: '20%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '可连接';
				}

				return '不可连接';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: '20%',
			formatter: function(value, row, index) {
				if(row.deleted == 0 || row.deleted == '0') {
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
			},
		}],
	};

	return tableParam;
}

// UI配置
function machineUIComponents() {
	var title = ['压铸机名称', '类型', '型号', '端口号', '安装位置', '地址编号'];
	var identifiers = ['machineName', 'machineType', 'machineModel', 'port', 'location', 'address'];
	var inputDoms = '';
	for(i = 0; i < identifiers.length; i++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		inputDoms += '<div class="form-group"><label for="' + data + '" class="col-sm-2 control-label text-center">' + itemTitle + '</label><div class="col-sm-9">' +
			'<input required="required" type="text" class="form-control dialog-form" id="' + data + '" placeholder="请输入' + itemTitle + '">' +
			'</div></div>';
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureMachineDataInfo(data) {
	var bindObj = data.bindData;
	if(bindObj) {
		$('#machineName').val(bindObj.machineName);
		$('#machineType').val(bindObj.machineType);
		$('#machineModel').val(bindObj.machineModel);
		$('#port').val(bindObj.port);
		$('#location').val(bindObj.location);
		$('#address').val(bindObj.address);
	}
}

// 更新当前的参数数据
function updateMachineData(updatedData) {
	updatedData.machineName = $('#machineName').val();
	updatedData.machineType = $('#machineType').val();
	updatedData.machineModel = $('#machineModel').val();
	updatedData.port = $('#port').val();
	updatedData.location = $('#location').val();
	updatedData.address = $('#address').val();

	return updatedData;
}

/*
 * ================
 * 计数器配置
 * ================
 */
function configureCounterListStyle() {
	var tableParam = {
		column: [{
			field: 'counterName',
			title: "计数器名称",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'counterModel',
			title: "型号",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'counterType',
			title: "计数类型",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'counterPort',
			title: "端口号",
			valign: 'middle',
		}, {
			field: 'counterDecimal',
			title: "进制",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'address',
			title: "地址编号",
			valign: 'middle',
		}, {
			field: 'connectable',
			title: "状态",
			valign: 'middle',
			width: '20%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '可连接';
				}

				return '不可连接';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: '20%',
			formatter: function(value, row, index) {
				if(row.deleted == 0 || row.deleted == '0') {
					return "<div class=\"row\">" +
						"<div class=\"col-sm-8 col-sm-offset-2\">" +
						"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-edit fa-fw\"></span></a>" +
						"<a href=\"javascript:;\" class=\"tooltip-show connect\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"恢复\"><span class=\"fa fa-plug fa-fw text-primary\"></span></a>" +
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
			},
		}],
	};

	return tableParam;
}

// UI配置
function counterUIComponents() {
	var title = ['计数器名称', '型号', '计数类型', '端口号', '进制', '地址编号'];
	var identifiers = ['counterName', 'counterModel', 'counterType', 'counterPort', 'counterDecimal', 'address'];
	var inputDoms = '';
	for(i = 0; i < identifiers.length; i++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		inputDoms += '<div class="form-group"><label for="' + data + '" class="col-sm-2 control-label text-center">' + itemTitle + '</label><div class="col-sm-9">' +
			'<input required="required" type="text" class="form-control dialog-form" id="' + data + '" placeholder="请输入' + itemTitle + '">' +
			'</div></div>';
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureCounterDataInfo(data) {
	var bindObj = data.bindData;
	if(bindObj) {
		$('#counterName').val(bindObj.counterName);
		$('#counterModel').val(bindObj.counterModel);
		$('#counterType').val(bindObj.counterType);
		$('#counterPort').val(bindObj.counterPort);
		$('#counterDecimal').val(bindObj.counterDecimal);
		$('#address').val(bindObj.address);
	}
}

// 更新当前的参数数据
function updateCounterData(updatedData) {
	updatedData.counterName = $('#counterName').val();
	updatedData.counterModel = $('#counterModel').val();
	updatedData.counterType = $('#counterType').val();
	updatedData.counterPort = $('#counterPort').val();
	updatedData.counterDecimal = $('#counterDecimal').val();
	updatedData.address = $('#address').val();

	return updatedData;
}

/*
 * ================
 * 标准参数配置
 * ================
 */
function configureParametersListStyle() {
	var tableParam = {
		column: [{
			field: 'rollName',
			title: "连铸连轧名称",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'ctrlNo',
			title: "压铸单号",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'rollWeight',
			title: "连铸连轧重量",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'material',
			title: "材质",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'rollNumber',
			title: "连铸连轧个数",
			valign: 'middle',
		}, {
			field: 'rollIntervals',
			title: "间隔时间",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'rollPressure',
			title: "压铸压力",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'rollTimes',
			title: "连铸连轧次数",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'deleted',
			title: "状态",
			valign: 'middle',
			width: '20%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '已注销';
				}

				return '正常';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: '20%',
			formatter: function(value, row, index) {
				if(row.deleted == 0 || row.deleted == '0') {
					return "<div class=\"row\">" +
						"<div class=\"col-sm-8 col-sm-offset-2\">" +
						"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-edit fa-fw\"></span></a>" +
						"<a href=\"javascript:;\" class=\"tooltip-show connect\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"恢复\"><span class=\"fa fa-plug fa-fw text-primary\"></span></a>" +
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
			},
		}],
	};

	return tableParam;
}

// UI配置
function parametersUIComponents() {
	var title = ['连铸连轧名称', '压铸单号', '连铸连轧重量', '材质', '连铸连轧个数', '间隔时间', '压铸压力', '连铸连轧次数'];
	var identifiers = ['rollName', 'ctrlNo', 'rollWeight', 'material', 'rollNumber', 'rollIntervals', 'rollPressure', 'rollTimes'];
	var inputDoms = '';
	for(i = 0; i < identifiers.length; i++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		inputDoms += '<div class="form-group"><label for="' + data + '" class="col-sm-2 control-label text-center">' + itemTitle + '</label><div class="col-sm-9">' +
			'<input required="required" type="text" class="form-control dialog-form" id="' + data + '" placeholder="请输入' + itemTitle + '">' +
			'</div></div>';
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureParametersDataInfo(data) {
	var bindObj = data.bindData;
	if(bindObj) {
		$('#rollName').val(bindObj.rollName);
		$('#ctrlNo').val(bindObj.ctrlNo);
		$('#rollWeight').val(bindObj.rollWeight);
		$('#material').val(bindObj.material);
		$('#rollNumber').val(bindObj.rollNumber);
		$('#rollIntervals').val(bindObj.rollIntervals);
		$('#rollPressure').val(bindObj.rollPressure);
		$('#rollTimes').val(bindObj.rollTimes);
		$('#ctrlNo').attr("disabled", "disabled");
	}
}

// 更新当前的参数数据
function updateParametersData(updatedData) {
	updatedData.rollName = $('#rollName').val();
	updatedData.ctrlNo = $('#ctrlNo').val();
	updatedData.rollWeight = $('#rollWeight').val();
	updatedData.material = $('#material').val();
	updatedData.rollNumber = $('#rollNumber').val();
	updatedData.rollIntervals = $('#rollIntervals').val();
	updatedData.rollPressure = $('#rollPressure').val();
	updatedData.rollTimes = $('#rollTimes').val();
	return updatedData;
}

/*
 * ================
 * 压铸机智能化控制
 * ================
 */
function configureAutoControlListStyle() {
	var openedStyle = function(value, row, index) {
		if(value == '1' || value == 1) {
			return '<a href=\"javascript:;\" class=\"tooltip-show\" data-toggle=\"tooltip\" title=\"开启\"><span class=\"fa fa-check fa-fw text-success\"></span></a>';
		}
		return '<a href=\"javascript:;\" class=\"tooltip-show\" data-toggle=\"tooltip\" title=\"关闭\"><span class=\"fa fa-close fa-fw text-warning\"></span></a>';
	};
	var tableParam = {
		column: [{
			field: 'ctrlId',
			title: "压铸单号",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'startTime',
			title: "开始时间",
			width: '20%',
			valign: 'middle',
		}, {
			field: 'rollWeight',
			title: "连铸连轧毛重",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'material',
			title: "材质",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'rollPressure',
			title: "压铸压力",
			valign: 'middle',
		}, {
			field: 'rollNumber',
			title: "连铸连轧数量",
			valign: 'middle',
		}, {
			field: 'totalTime',
			title: "总时长",
			valign: 'middle',
			width: '10%',
		}, {
			field: 'rollTimes',
			title: "连铸连轧次数",
			valign: 'middle',
		}, {
			field: 'openedSensor',
			title: "开启质量传感器",
			valign: 'middle',
			align: 'center',
			width: '5%',
			formatter: function(value, row, index) {
				return openedStyle(value, row, index);
			},
		}, {
			field: 'openedCounter',
			title: "开启计数器",
			valign: 'middle',
			align: 'center',
			width: '5%',
			formatter: function(value, row, index) {
				return openedStyle(value, row, index);
			},
		}, {
			field: 'openedMachine',
			title: "开启自动压铸机",
			valign: 'middle',
			align: 'center',
			width: '5%',
			formatter: function(value, row, index) {
				return openedStyle(value, row, index);
			},
		}, {
			field: 'deleted',
			title: "状态",
			valign: 'middle',
			width: '20%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '已注销';
				}

				return '正常';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: '20%',
			formatter: function(value, row, index) {
				return "<div class=\"row center-block \">" +
					"<a href=\"javascript:;\" class=\"tooltip-show search\" data-toggle=\"tooltip\" title=\"查看\"><span class=\"fa fa-clipboard fa-fw\"></span></a></div>";
			},
			events: {
				'click .search': function(e, value, row, index) {
					getDetailItemInfo(row);
				},
			},
		}],
	};

	return tableParam;
}

// UI配置
function autoControlUIComponents() {
	var title = ['压铸单号', '连铸连轧重量', '材质', '连铸连轧个数', '间隔时间', '压铸压力', '连铸连轧次数', '总时长', '开启质量传感器', '开启计数器', '开启自动压铸机'];
	var identifiers = ['ctrlId', 'rollWeight', 'material', 'rollNumber', 'rollIntervals', 'rollPressure', 'rollTimes', 'totalTime', 'openedSensor', 'openedCounter', 'openedMachine'];
	var inputDoms = '';
	for(i = 0; i < parseInt(identifiers.length); i++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		if(data == 'ctrlId') {
			inputDoms += '<div class="form-group">' +
				'<label for="' + data + '" class="col-sm-2 control-label">' + itemTitle + '</label>' +
				'<div class="col-sm-9">' +
				'<select class="form-control" id="' + data + '"></select></div></div>';
			continue;
		}
		if(data == 'openedSensor' || data == 'openedCounter' || data == 'openedMachine') {
			inputDoms += '<div class="form-group">' +
				'<label for="' + data + '" class="col-sm-2 control-label">' + itemTitle + '</label>' +
				'<div class="col-sm-9">' +
				'<select class="form-control" id="' + data + '"><option value="0" selected="selected">关闭</option><option value="1">开启</option>' +
				'</select></div></div>';
		} else {
			inputDoms += '<div class="form-group"><label for="' + data + '" class="col-sm-2 control-label text-center">' + itemTitle + '</label><div class="col-sm-9">' +
				'<input required="required" type="text" class="form-control dialog-form" id="' + data + '" placeholder="请输入' + itemTitle + '">' +
				'</div></div>';
		}
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureAutoControlDataInfo(data) {
	var bindObj = data.bindData;
	console.info(data);
	if(bindObj) {
		$('#ctrlId').select2({
			data: [{
				id: bindObj.ctrlId,
				text: bindObj.ctrlId
			}]
		});
		$('#ctrlId').val(bindObj.ctrlId);
		$('#rollWeight').val(bindObj.rollWeight);
		$('#material').val(bindObj.material);
		$('#rollNumber').val(bindObj.rollNumber);
		$('#rollIntervals').val(bindObj.rollIntervals);
		$('#rollTimes').val(bindObj.rollTimes);
		$('#rollPressure').val(bindObj.rollPressure);
		$('#totalTime').val(bindObj.totalTime);
		$('#openedSensor').val(bindObj.openedSensor);
		$('#openedCounter').val(bindObj.openedCounter);
		$('#openedMachine').val(bindObj.openedMachine);
		$('#ctrlId').attr("disabled", "disabled");
	}
}

// 更新当前的参数数据
function updateAutoControlData(updatedData) {
	updatedData.ctrlId = $('#ctrlId').val();
	updatedData.rollWeight = $('#rollWeight').val();
	updatedData.material = $('#material').val();
	updatedData.rollNumber = $('#rollNumber').val();
	updatedData.rollIntervals = $('#rollIntervals').val();
	updatedData.rollTimes = $('#rollTimes').val();
	updatedData.rollPressure = $('#rollPressure').val();
	updatedData.totalTime = $('#totalTime').val();
	updatedData.openedSensor = $('#openedSensor').val();
	updatedData.openedCounter = $('#openedCounter').val();
	updatedData.openedMachine = $('#openedMachine').val();
	return updatedData;
}

/*
 * ================
 * 控制数据
 * ================
 */

$('#searchByNo').click(function() {
	var ctrlNo = $('#machineNumber').val();
	if($.isEmptyObject(ctrlNo)) {
		CodeZComponents.showErrorTip({
			text: '压铸单号不能为空'
		});
		return;
	}

	var parameters = {
		type: 'SearchNo',
		parameters: ctrlNo
	};
	CodeZComponents.postRequest({
		action: actions.FUZZYSEARCH,
		data: JSON.stringify(parameters)
	}, function(data) {
		if(data.success) {
			$("#table-container").bootstrapTable('destroy');
			tableParam = configureAutoControlListStyle();
			tableParam.data = data.data;
			CommonMan.configureTableListData(tableParam);
		} else {
			CodeZComponents.showErrorTip({
				text: data.error
			});
		}
	});
});

$('#searchByTime').click(function() {
	var startTime = $('#startTime').val();
	var stopTime = $('#endTime').val();
	if($.isEmptyObject(startTime) || $.isEmptyObject(stopTime)) {
		CodeZComponents.showErrorTip({
			text: '时间不能为空'
		});
		return;
	}

	var startDate = CodeZComponents.getFormatterDate(startTime);
	var stopDate = CodeZComponents.getFormatterDate(stopTime);
	if(startDate > stopDate) {
		CodeZComponents.showErrorTip({
			text: '结束时间不能小于开始时间'
		});
		return;
	}

	var parameters = {
		type: 'SearchDate',
		start: startTime,
		stop: stopTime,
	}
	CodeZComponents.postRequest({
		action: actions.FUZZYSEARCH,
		data: JSON.stringify(parameters)
	}, function(data) {
		if(data.success) {
			$("#table-container").bootstrapTable('destroy');
			tableParam = configureAutoControlListStyle();
			tableParam.data = data.data;
			CommonMan.configureTableListData(tableParam);
		} else {
			CodeZComponents.showErrorTip({
				text: data.error
			});
		}
	});
});

function configureControlDataListStyle() {
	var tableParam = {
		showSearch: false,
		column: [{
			field: 'counterName',
			title: "冲压单号",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'counterModel',
			title: "连铸连轧名称",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'counterType',
			title: "材质",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'counterPort',
			title: "单件重量",
			valign: 'middle',
		}, {
			field: 'counterDecimal',
			title: "连冲数量",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'counterDecimal',
			title: "冲压压力",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'counterDecimal',
			title: "连冲次数",
			valign: 'middle',
			width: '20%',
		}, {
			field: 'deleted',
			title: "状态",
			valign: 'middle',
			width: '20%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '已注销';
				}

				return '正常';
			},
		}, {
			field: 'action',
			title: "操作",
			valign: 'middle',
			align: 'center',
			width: '20%',
			formatter: function(value, row, index) {
				return "<div class=\"row center-block \">" +
					"<a href=\"javascript:;\" class=\"tooltip-show search\" data-toggle=\"tooltip\" title=\"查看\"><span class=\"fa fa-clipboard fa-fw\"></span></a></div>";
			},
			events: {
				'click .search': function(e, value, row, index) {
					getDetailItemInfo(row);
				},
			},
		}],
	};

	return tableParam;
}

// UI配置
function controlDataUIComponents() {
	var title = ['冲压单号', '连铸连轧名称', '材质', '单件重量', '连冲数量', '冲压压力', '连冲次数'];
	var identifiers = ['counterName', 'counterModel', 'counterType', 'counterPort', 'counterPort', 'counterPort', 'counterPort', 'counterPort'];
	var inputDoms = '';
	for(i = 0; i < identifiers.length; i++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		inputDoms += '<div class="form-group"><label id="' + data + '" class="col-sm-12 control-label text-center"></label></div>';
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureControlDataDataInfo(data) {
	var bindObj = data.bindData;
	if(bindObj) {
		$('#counterName').html(bindObj.counterName);
		$('#counterModel').html(bindObj.counterModel);
		$('#counterType').html(bindObj.counterType);
		$('#counterPort').html(bindObj.counterPort);
		$('#counterDecimal').html(bindObj.counterDecimal);
		$('#address').html(bindObj.address);
	}
}

// 更新当前的参数数据
function updateControlDataData(updatedData) {

	return updatedData;
}

/*
 * ================
 * 角色权限管理
 * ================
 */
function configureRoleListStyle() {
	var tableParam = {
		column: [{
			field: 'roleName',
			title: "角色名称",
			width: '30%',
			valign: 'middle',
		}, {
			field: 'descript',
			title: "角色描述",
			width: '10%',
			valign: 'middle',
		}, {
			field: 'deleted',
			title: "状态",
			valign: 'middle',
			width: '20%',
			formatter: function(value, row, index) {
				if(value == 1 || value == '1') {

					return '已注销';
				}

				return '正常';
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
						"<a href=\"javascript:;\" class=\"tooltip-show restore\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"恢复\"><span class=\"fa fa-plug fa-fw text-primary\"></span></a>" +
						"</div></div>";
				}
				return "<div class=\"row\">" +
					"<div class=\"col-sm-8 col-sm-offset-2\">" +
					"<a href=\"javascript:;\" class=\"tooltip-show edit\" data-toggle=\"tooltip\" title=\"修改\"><span class=\"fa fa-edit fa-fw\"></span></a>" +
					"<a href=\"javascript:;\" class=\"tooltip-show delete\" style = \"margin-left:10px;\" data-toggle=\"tooltip\" title=\"注销\"><span class=\"fa fa-unlink text-danger fa-fw\"></span></a>" +
					"</div></div>";
			},
			events: {
				'click .edit': function(e, value, row, index) {
					getDetailItemInfo(row);
				},

				'click .restore': function(e, value, row, index) {
					row.deleted = 0;
					updateSingleData(actions.EDIT, row, '恢复成功', function(data) {
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: data
						});
					});
				},

				'click .delete': function(e, value, row, index) {
					row.deleted = 1;
					updateSingleData(actions.EDIT, row, '注销成功', function(data) {
						$("#table-container").bootstrapTable('updateRow', {
							index: index,
							row: data
						});
					});
				},
			},
		}],
	};

	return tableParam;
}

// UI配置
function roleUIComponents() {
	var title = ['角色名称', '角色描述'];
	var identifiers = ['roleName', 'descript'];
	var inputDoms = '';
	for(i = 0; i < identifiers.length; i++) {
		var data = identifiers[i];
		var itemTitle = title[i];
		if(data == 'descript') {
			inputDoms += '<div class="form-group">' +
				'<label for="' + data + '" class="col-sm-2 control-label">' + itemTitle + '</label>' +
				'<div class="col-sm-9">' +
				'<textarea class="form-control" id="' + data + '"></textarea></div></div>';
			break;
		}

		inputDoms += '<div class="form-group"><label for="' + data + '" class="col-sm-2 control-label text-center">' + itemTitle + '</label><div class="col-sm-9">' +
			'<input required="required" type="text" class="form-control dialog-form" id="' + data + '" placeholder="请输入' + itemTitle + '">' +
			'</div></div>';
	}

	return inputDoms;
}

// 配置显示参数数据
function confgiureRoleDataInfo(data) {
	var bindObj = data.bindData;
	if(bindObj) {
		$('#roleName').val(bindObj.roleName);
		console.info(bindObj.descript);
		$('#descript').val(bindObj.descript);
	}
}

// 更新当前的参数数据
function updateRoleData(updatedData) {
	updatedData.roleName = $('#roleName').val();
	updatedData.descript = $('#descript').val();

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
	var bindData = breadMenuTag.editBread;
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
			components = dataBaseUIComponents();
			break;
		case CodeZ.NAV_MACHINEMAN.SENSOR:
			//传感器处理
			components = sensorUIComponents();
			break;
		case CodeZ.NAV_MACHINEMAN.MACHINE:
			components = machineUIComponents();
			break;
		case CodeZ.NAV_MACHINEMAN.COUNTER:
			components = counterUIComponents();
			break;
		case CodeZ.NAV_CONTROLPARAMETER:
			components = parametersUIComponents();
			break;
		case CodeZ.NAV_AUTO_CONTROL:
			components = autoControlUIComponents();
			break;
		case CodeZ.NAV_CONTROL_DATA:
			$('#dataCancel').hide();
			components = controlDataUIComponents();
			break;
		case CodeZ.NAV_SECURITY_MAN.USERMAN:

			break;
		case CodeZ.NAV_SECURITY_MAN.ROLEMAN:
			components = roleUIComponents();
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
	var categoryStr = sessionCacheKeyTag.substr(0, sessionCacheKeyTag.length - '_key'.length);
	if(dataObj != undefined) {
		switch(categoryStr) {
			case CodeZ.NAV_SOFTPARAMETER.CONTROL_CFG:

			case CodeZ.NAV_SOFTPARAMETER.DATABASE_CONNECT:
				confgiureDataBaseDataInfo(dataObj);
				break;
			case CodeZ.NAV_MACHINEMAN.SENSOR:
				//传感器处理
				confgiureSensorDataInfo(dataObj);
				break;
			case CodeZ.NAV_MACHINEMAN.MACHINE:
				confgiureMachineDataInfo(dataObj);
				break;
			case CodeZ.NAV_MACHINEMAN.COUNTER:
				confgiureCounterDataInfo(dataObj);
				break;
			case CodeZ.NAV_CONTROLPARAMETER:
				confgiureParametersDataInfo(dataObj);
				break;
			case CodeZ.NAV_AUTO_CONTROL:
				confgiureAutoControlDataInfo(dataObj);
				break;
			case CodeZ.NAV_CONTROL_DATA:
				confgiureControlDataDataInfo(dataObj);
				break;
			case CodeZ.NAV_SECURITY_MAN.USERMAN:

				break;
			case CodeZ.NAV_SECURITY_MAN.ROLEMAN:
				confgiureRoleDataInfo(dataObj);
				break;
			default:
				break;
		}
	}

	if(categoryStr == CodeZ.NAV_AUTO_CONTROL) {
		$('#ctrlId').select2({
			language: 'zh-CN',
			ajax: {
				url: CodeZ.RQUEST_URI,
				dataType: 'json',
				type: 'post',
				data: function(parameters) {
					return {
						action: CodeZ.ACTION_AUTO_CONTROL.SEARCH,
						data: parameters.term,
					};
				},
				processResults: function(data, params) {
					var mapDataArray = $.map(data.data, function(obj) {
						obj.id = obj.ctrlNo;
						obj.text = obj.ctrlNo;
						return obj;
					});

					return {
						results: mapDataArray,
						pagination: {
							more: false
						}
					};
				},
				cache: true
			},
		});

		$('#ctrlId').on('select2:select', function(e) {
			var dataObj = e.params.data;
			console.info(dataObj);
			$('#rollWeight').val(dataObj.rollWeight);
			$('#material').val(dataObj.material);
			$('#rollNumber').val(dataObj.rollNumber);
			$('#rollIntervals').val(dataObj.rollIntervals);
			$('#rollTimes').val(dataObj.rollTimes);
			$('#rollPressure').val(dataObj.rollPressure);
		});
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
	var categoryStr = sessionCacheKeyTag.substr(0, sessionCacheKeyTag.length - '_key'.length);
	if(categoryTag)
		var actionParameters = actions.ADD;
	var infoTip = '新增成功';
	var dataObj = new Object();
	var cacheData = $.session.get(sessionCacheKeyTag);
	if(cacheData != undefined || cacheData != null) {
		dataObj = JSON.parse(cacheData).bindData;
		actionParameters = actions.EDIT;
		infoTip = '更新成功';
	}
	// 配置数据
	switch(categoryStr) {
		case CodeZ.NAV_SOFTPARAMETER.CONTROL_CFG:

		case CodeZ.NAV_SOFTPARAMETER.DATABASE_CONNECT:
			updateDataBaseData(dataObj);
			break;
		case CodeZ.NAV_MACHINEMAN.SENSOR:
			//传感器处理
			updateSensorData(dataObj);
			break;
		case CodeZ.NAV_MACHINEMAN.MACHINE:
			updateMachineData(dataObj);
			break;
		case CodeZ.NAV_MACHINEMAN.COUNTER:
			updateCounterData(dataObj);
			break;
		case CodeZ.NAV_CONTROLPARAMETER:
			updateParametersData(dataObj);
			break;
		case CodeZ.NAV_AUTO_CONTROL:
			updateAutoControlData(dataObj);
			break;
		case CodeZ.NAV_CONTROL_DATA:
			updateAutoControlData(dataObj);
			break;
		case CodeZ.NAV_SECURITY_MAN.USERMAN:

			break;
		case CodeZ.NAV_SECURITY_MAN.ROLEMAN:
			updateRoleData(dataObj);
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
			showSearch: parameters.showSearch,
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
			tableParam = configureDataBaseListStyle();
			break;
		case CodeZ.NAV_MACHINEMAN.SENSOR:
			//传感器处理
			tableParam = configureSensorListStyle();
			break;
		case CodeZ.NAV_MACHINEMAN.MACHINE:
			tableParam = configureMachineListStyle();
			break;
		case CodeZ.NAV_MACHINEMAN.COUNTER:
			tableParam = configureCounterListStyle();
			break;
		case CodeZ.NAV_CONTROLPARAMETER:
			tableParam = configureParametersListStyle();
			break;
		case CodeZ.NAV_AUTO_CONTROL:
			tableParam = configureAutoControlListStyle();
			break;
		case CodeZ.NAV_CONTROL_DATA:
			tableParam = configureControlDataListStyle();
			break;
		case CodeZ.NAV_SECURITY_MAN.USERMAN:

			break;
		case CodeZ.NAV_SECURITY_MAN.ROLEMAN:
			tableParam = configureRoleListStyle();
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
		} else {
			CodeZComponents.showErrorTip({
				text: data.error
			});
		}
	});
}
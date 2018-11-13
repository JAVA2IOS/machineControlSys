function User(userId, userName, account, password, dep, role = new Role(), deleted = 0) {
	this.userId = userId;
	this.userName = userName;
	this.account = account;
	this.password = password;
	this.dep = dep;
	this.role = role;
	this.deleted = deleted;
}

function Role() {
	this.roleId = '';
	this.roleName = '';
	this.description = '';
	this.deleted = false;
}
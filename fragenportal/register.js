var root = '../';

function ViewModel() {
	var _this = this;
	
	this.userName = ko.observable();
	this.password = ko.observable();
	
	this.onSubmit = function() {
		$.ajax(root + 'ajax/register.php', {
			type: "POST",
			dataType: 'json',
			data: { username: _this.userName(), pw: _this.password() }
		})
		.done(function(rsp) {
			if(rsp.success) {
				location.href = root + 'login.php';
			}
			else {
				alert('Fehler!');
				rsp.messages.forEach(function(m) { alert(m) });
			}
		})
		.fail(function() { 'Verbindungsfehler...' });
		return false;
	};
}

vm = new ViewModel();
ko.applyBindings(vm);
function ViewModel() {
	var _this = this;	
	
	this.desc = {
		showChangeForm: ko.observable(false),
		value: ko.observable(''),
		newValue: ko.observable(''),
		onClickChange: function () {
			_this.desc.newValue(_this.desc.value());
			_this.newTags(_this.tags());
			_this.desc.showChangeForm(!_this.desc.showChangeForm());
		},
		change: function () {
			$.ajax(root + "/ajax/setdesc.php", {
				type: "POST",
				data: { desc: _this.desc.newValue(), tags: _this.newTags() },
				dataType: "json"})
			.done(function(rsp) {
				if(rsp.success) {
					_this.desc.showChangeForm(false);
					_this.desc.value(_this.desc.newValue());
					_this.tags(_this.newTags());
				}
				else {
					for(var i=0; i<rsp.messages.length; ++i) {
						alert(rsp.messages[i]);
					}
				}
			});
		}
	}

	this.answers = ko.observableArray(_answers);
	
	this.party = ko.observable(_party);
	this.newParty = ko.observable();
	this.hideFormChangeParty = ko.observable(true);
	this.onClickChangeParty = function() {
			$.ajax(root + "/ajax/setparty.php", {
				type: "POST",
				data: { party: _this.newParty() },
				dataType: "json"})
			.done(function(rsp) {
				if(rsp.success) {
					_this.hideFormChangeParty(true);
					_this.party(_this.newParty());
				}
				else {
					for(var i=0; i<rsp.messages.length; ++i) {
						alert(rsp.messages[i]);
					}
				}
			});
	};
	this.onClickFormChangeParty = function () {
		_this.newParty(_this.party());
		_this.hideFormChangeParty(!_this.hideFormChangeParty());
	};
	
	this.deleteAnswer = function(a) {
		$.ajax(root + "/ajax/delanswer.php", {
			type: "GET",
			data: { id: a.id },
			dataType: "json"
		})
		.done(function(rsp) {
			alert('Die Antwort wurde erfolgreich gelöscht! Sie sollte nach einem Neuladen der Seite nicht mehr zu sehen sein.');
		})
		.fail(function() {
			alert('Löschen fehlgeschlagen. Melden Sie das bitte unter "Kontakt", dann löscht der Administrator für Sie Ihre Antwort und behebt den Fehler.');
		});
	};
	
	this.newTags = ko.observable(_tags);
	this.tags = ko.observable(_tags);
}

var vm = new ViewModel();
vm.desc.value(_desc);
ko.applyBindings(vm);
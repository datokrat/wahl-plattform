function ViewModel(q, a, isLoggedIn, userName) {
	var _this = this;
	
	this.q = q; this.a = ko.observableArray(a); this.isLoggedIn = isLoggedIn; this.userName = userName;
	
	this.newAnswerForm = {
		show: ko.observable(false),
		toggle: function() { _this.newAnswerForm.show(!_this.newAnswerForm.show()) },
		submit: function() {
			var form = _this.newAnswerForm;
			$.ajax({
				url: "../ajax/addanswer.php",
				type: "POST",
				dataType: "json",
				data: { question: _this.q.id, title: form.title(), text: form.text() }
			})
			.done(function(data) {
				alert('Ihre Antwort sollte jetzt erscheinen. ');
				_this.a.push(data);
			})
			.fail(function(err) {
				alert('Entschuldigung, das hat nicht funktioniert. Melden Sie das bitte dem Verantwortlichen dieses Portals!');
			});
		},
		title: ko.observable(),
		text: ko.observable()
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
}

vm = new ViewModel(_q, _a, _isLoggedIn, _userName);

ko.applyBindings(vm);
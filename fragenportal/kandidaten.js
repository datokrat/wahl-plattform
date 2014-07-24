var root = "..";

function ViewModel() {
	var _this = this;
	
	this.candidatesWidget = new CandidatesWidget();
	this.candidatesWidget.update();
}

vm = new ViewModel();
ko.applyBindings(vm);
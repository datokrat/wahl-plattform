function BrowseWidget() {
	var _this = this;
	
	this.id = BrowseWidget.idCtr++;
	this.title = ko.observable("Suchen");
	
	this.filterTemplate = "none-filter-template";
	
	this.visibleQuestions = ko.observableArray([]);
	this.questionsLoaded = ko.observable(false);
	this.page = ko.observable(1);
	
	this.hasNextPage = ko.observable(false);
	this.hasPrevPage = ko.computed(function () {
		return _this.page() > 1;
	});
	this.usePaging = ko.observable(true);
	
	this.showFilters = ko.observable(true);
	this.filtersCollapsed = ko.observable(true);
	this.toggleFilters = function() {
		_this.filtersCollapsed(!_this.filtersCollapsed());
	};
	
	this.prevPage = function() {
		if(_this.page() > 1) {
			_this.page(_this.page()-1);
			_this.update();
		}
	}

	this.nextPage = function () {
		_this.page(_this.page()+1);
		_this.update();
	}

	this.update = function() {
		alert("Ups, da hat der Programmierer was vergessen. Kannst du ihm das ausrichten? (-> Impressum)");
	}

	this.onClickResult = function() {
		alert("Ups, da hat der Programmierer was vergessen. Kannst du ihm das ausrichten? (-> Impressum)");
	}

	this.itemReference = function() {
		alert("Ups, da hat der Programmierer was vergessen. Kannst du ihm das ausrichten? (-> Impressum)");
	}

	this.getCaption = function() {
		return "Ups, da hat der Programmierer was vergessen. Kannst du ihm das ausrichten? (-> Impressum)";
	}
}
BrowseWidget.idCtr = 0;

function QuestionsWidget() {
	BrowseWidget.call(this);
	var _this = this;
	
	this.title("Fragen");
	
	this.filterTemplate = "questions-filter-template";
	this.filterFeaturedOnly = ko.observable(false);
	this.filterAnswered = ko.observable(true);
	this.filterUnanswered = ko.observable(true);
	
	this.filterFeaturedVal = ko.computed(function() {
		return _this.filterFeaturedOnly() ? 1 : 0;
	});
	
	this.filterAnsweredVal = ko.computed(function() {
		return _this.filterAnswered() - _this.filterUnanswered();
	});
	
	
	this.update = function () {
		$.getJSON(root + "/ajax/questions.php?from=" + (10 * this.page() - 10) + "&count=" + 10 + "&feat=" + this.filterFeaturedVal()
		+ "&answered=" + this.filterAnsweredVal())
		.done(function(rsp) {
			if(rsp.success) {
				_this.hasNextPage(rsp.data.hasNext);
				_this.visibleQuestions(rsp.data.result);
				_this.questionsLoaded(true);
			}
		});
	}

	this.reload = function () {
		_this.page(1);
		_this.update();
	}

	this.itemReference = function ($data) {
		return root + "/fragenportal/frage.php?id=" + $data.id;
	};
	
	this.getCaption = function($data) {
		return $data.title;
	}

	this.filterFeaturedVal.subscribe(_this.reload);
	this.filterAnsweredVal.subscribe(_this.reload);
}

function CandidatesWidget() {
	BrowseWidget.call(this);
	var _this = this;
	
	this.title("Kandidaten");

	this.usePaging(false);
	
	this.update = function() {
		$.getJSON(root + "/ajax/candidates.php?from=" + (200 * this.page() - 200) + "&count=" + 200)
		.done(function(rsp) {
			if(rsp.success) {
				_this.hasNextPage(rsp.data.hasNext);
				_this.visibleQuestions(rsp.data.result);
				_this.questionsLoaded(true);
			}
		});
	}
	
	this.getCaption = function($data) {
		return $data.name;
	}

	this.itemReference = function ($data) {
		return root + "/fragenportal/kandidat.php?id=" + $data.id;
	}
}

function NewQuestionWidget() {
	var _this = this;
	
	this.title = ko.observable("Neue Frage");
	
	this.qTitle = ko.observable();
	this.qText = ko.observable();
	this.qPseudonyme = ko.observable();
	
	this.qAdd = function() {
		$.ajax(root + 'ajax/addquestion.php', {
			data: { title: _this.qTitle(), text: _this.qText(), author: _this.qPseudonyme() },
			type: 'POST',
			dataType: 'json'
		}).done(function(rsp) {
			if(rsp.success)
				location.href = root + 'fragenportal/frage.php?id=' + rsp.data;
			else {
				for(var i=0; i < rsp.messages.length; ++i) {
					alert(rsp.messages[i]);
				}
			}
		});
	};
}
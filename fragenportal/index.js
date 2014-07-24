var root = "../";

function ViewModel() {
	var _this = this;
	
	this.questionsWidget = new QuestionsWidget();
	this.questionsWidget.filterFeaturedOnly(false);
	this.questionsWidget.filtersCollapsed(false);
	
	this.featuredWidget = new QuestionsWidget();
	
	this.featuredWidget.filterFeaturedOnly(true);
	this.featuredWidget.showFilters(false);
	this.featuredWidget.title("Featured");
	
	this.newQuestionWidget = new NewQuestionWidget();
}

vm = {
	visibleQuestions: ko.observableArray([]),
	questionsLoaded: ko.observable(false),
	page: ko.observable(1)
};

vm = new ViewModel();

function loadQuestions() {
	vm.questionsWidget.update();
	vm.featuredWidget.update();
}

ko.applyBindings(vm);

$(function() {
	loadQuestions();
});
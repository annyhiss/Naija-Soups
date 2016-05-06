
var app = angular.module("naijasoup", ['ui.router', 'xeditable', 'ui.bootstrap', 'checklist-model']);


app.config(function($stateProvider, $urlRouterProvider){
   $stateProvider.state('list', {
              url: '/list',
      templateUrl: "templates/list.html"
    }); 
   $urlRouterProvider.otherwise('/list');
});


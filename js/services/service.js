app.factory('soups', ['$http', function($http) {
  return $http.get('js/data.json')
         .success(function(data) {
         	//console.log(data);
           return data;
         })
         .error(function(data) {
           return data;
         });
}]);
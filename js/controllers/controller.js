//var soups = [];
app.controller("listController", ["$scope", "$state", "soups", "$http", function($scope, $state, soups, $http){
	soups.success(function(data) {
	    $scope.soups = data.soup;
	    $scope.extras = data.soup[0].extras;
	});

	/*a pop pluggin inizialized */

	$scope.open1 = function() {
    	$scope.popup1.opened = true;
  	 };
	$scope.popup1 = {
	    opened: false
	};
	/*pop up pluggin inizialization ended */

	//an empty array to collect all soups selected
    $scope.mainOrder =[];
    //an empty array to collect whatever proteins is/are checked.
	 $scope.basket = {
	    extras: []
	 };

	// a fucntion to add soup and corresponding price to mainORDER ARRAY.
	 $scope.checko = function(d, a, b){
	 	$scope.mainOrder.unshift({id: d, main: a, price: b});
	 }

	 // A variable where total checked proteins are stored ib: it's an array.
	 $scope.total = $scope.basket.extras;

	// a function counting total number of things in cart
	$scope.counter = function(){
	    var count = 0;
	    count = $scope.total.length + $scope.mainOrder.length;
	    return count;
	}

	// a function adding prices of proteins cheched.
	$scope.getTotal = function(){
	    var total = 0;
	    for(var i = 0; i < $scope.total.length; i++){
	        total += Math.ceil($scope.total[i].price);
	    }
	    return total;
	}
	// a function adding prices of soups selected.
	$scope.getAnotherTotal = function(){
	    var total = 0;
	    for(var i = 0; i < $scope.mainOrder.length; i++){
	        total += Math.ceil($scope.mainOrder[i].price);
	    }
	    return total;

	}

	//function to remove mainorder(soup) added to the cart
	$scope.remove = function($index){
		$scope.mainOrder.splice($index, 1);
		return $scope.mainOrder;
	}

	//function to remove proteins added to the cart
	$scope.removed = function($index){
		$scope.total.splice($index, 1);
		return $scope.total;
	}

	
	/* 
	FORM SUBMISSION SECTION
	FORM SUBMISSION SECTION
	FORM SUBMISSION SECTION
	*/
// form data to be sent to url console.log this or preview it on view
	$scope.formData = {tId: Date.now(), proteins: $scope.total, soups: $scope.mainOrder}; 
// function to submit the form after all validation has occurred
	$scope.submitForm = function(isValid) {
	    // check to make sure the form is completely valid
	    if (isValid) {
	      	$http({
			  method  : 'POST',
			  url     : 'http://localhost/Naija-Soups/api/public/placeOrder', /*url to send post */
			  data    : $.param($scope.formData),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
		 	})
		  .success(function(data) {
		    console.log(data);

		    if (!data.success) {
		      // if not successful, bind errors to error variables
		      $scope.errorName = data.errors.name; // errors from data coming through url
		      $scope.errorPhone = data.errors.phone;// errors from data coming through url
		      $scope.errorEmail = data.errors.email;// errors from data coming through url
		    } else {
		      // if successful, bind success message to message
		      $scope.message = data.message; // success message to display
          console.log(data.message);
		    }
		  });
	    }
	}

	
}]);

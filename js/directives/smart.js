app.directive('checko', function(){return{restrict: 'A',link: function(scope, element, attr){element.on('click', function(){scope.mainOrder.unshift({main: $(this).parent().prev().html(), priced: $(this).prev().html()});});}}});app.directive('modal', function(){return{restrict: 'A',link: function(scope, element, attr){element.on('click', function(){if(scope.mainOrder.length==0 && scope.total.length==0){scope.notice=[{heading: "Your Basket is empty, turn here to life by picking a product."}]; $('form').hide();return scope.valid="modal";}else{scope.notice=[{heading: 'COMPLETE CHECKOUT', name: 'Name', phone: 'Phone', email: 'Email', address: 'Address'}]; $('form').show();return scope.valid="modal";}});}}});app.directive('tabsoup', function(){return{restrict: 'A',link: function(scope, element, attr){element.on('click', function(){$('#soups').show();$('#extra').hide();$('#menus').hide();});}}});app.directive('tabsextra', function(){return{restrict: 'A',link: function(scope, element, attr){element.on('click', function(){$('#extra').show();$('#soups').hide();$('#menus').hide();});}}});app.directive('tabsmenus', function(){return{restrict: 'A',link: function(scope, element, attr){element.on('click', function(){$('#extra').hide();$('#soups').hide();$('#menus').show();});}}});app.directive('rolo', function($index){return{restrict: 'A',link: function(scope, element, attr){element.on('click', function(){return scope.shake=false;});}}});
app.directive('validation', function(){
	return{
		restrict: 'A',
		link: function(scope, element, attr){
			element.on('click', function(){
				if (true) {}
			});
		}
	}
})
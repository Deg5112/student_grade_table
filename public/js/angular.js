var app = angular.module('SGT', []);

app.service('calcService', function($q){
	var self = this;
	self.average = null;

	self.updateAverage = function(array){
		var gradeSum = 0;
		var average = null;
		if (array <= 0){
			//display grade Avg on screen
			average = 0;
			self.average = average;
		}
		for(var i = 0; i < array.length; i++){
			gradeSum += parseFloat(array[i].grade);
			//add each grade to the sum of grades.. then divide by total # of students
		}
		//calculate average
		average = Math.round(gradeSum/array.length);
		//display grade Avg on screen
		self.average = average;

	};
});

app.controller('formController', function($scope, apiCall, $log, calcService){
	var self = this;
	self.addStudent = function(){
		apiCall.addStudentToDatabase($scope.studentObject.name, $scope.studentObject.course, $scope.studentObject.grade).then(function(response){
			if(response.data.success){
				$scope.studentObject.id = response.data.new_id;
				$scope.studentArray.unshift($scope.studentObject);
				$scope.studentObject = {};

				calcService.updateAverage($scope.studentArray);
			}
		});
	};
});

app.controller('tableController', function($scope, apiCall, calcService, $log){
	var self = this;
	$scope.fieldName = null;
	$scope.reverse = false;
	$scope.searchText = null;

	self.delete = function(gradeId, index){

		apiCall.delete(gradeId).then(function(response){
			if(response.data.success){
				$scope.studentArray.splice(index, 1);
				calcService.updateAverage($scope.studentArray);
			}
		});
	};

	//filter controlls
	self.sort = function(headerClickedString){
		$scope.fieldName = headerClickedString;
		$scope.reverse = ($scope.fieldName == headerClickedString) ? !$scope.reverse : false;
	};
});

app.service('apiCall', function($http, $q){
	var self = this;

	self.getAll = function(){
		var defer = $q.defer();
		$http({
			method: 'GET',
			url: '/get-students',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function(response){
			defer.resolve(response);

		}, function(response){
			defer.reject(response);
		});
		return defer.promise;
	};

	self.delete = function(gradeId){
		self.defer = $q.defer();
		$http({
			method: 'POST',
			data: {grade_id: gradeId},
			url: '/delete',
		}).then(function(response){
			self.defer.resolve(response);
		}, function(response){
			self.defer.reject(response);
		});

		return self.defer.promise;
	};

	self.addStudentToDatabase = function (name, course, grade) {
		var defer = $q.defer();
		var promise = null;

		$http({
			method: 'POST',
			url: '/create',
			data: {name: name, course: course, grade: grade}
		}).then(function (response) {
			defer.resolve(response);
		}, function(response){
			defer.reject(response);
		});
		return defer.promise;
	};
});


app.controller('mainController', function($scope, apiCall, calcService){
	var self = this;
	$scope.average = null;
	$scope.studentObject = {};
	$scope.studentArray = [];


	self.getStudents = function(){
		apiCall.getAll().then(function(response){
			var length = response.data.length;
			for(var i = 0; i<length; i++){
				$scope.studentArray.push(response.data[i]);
			}
			calcService.updateAverage($scope.studentArray);
		});
	};

	self.returnStudentArrayForNgRepeat = function(){
		return $scope.studentArray;
	};

	self.returnCurrentAverage = function(){
		return calcService.average;
	};

	self.getStudents();
});

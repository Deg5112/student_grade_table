<!DOCTYPE html>
<html ng-app="SGT">
<head>
    <meta name="viewport" content="initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!--<script src="script.js"></script>-->


    <link rel='stylesheet' href="{{ URL::asset('/css/stylesheet.css') }}">
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.1/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.1/angular-route.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/angular.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/docReady.js') }}"></script>


</head>
<body ng-controller="mainController as mc">
@verbatim
<div class="container">
    <div class="row container-fluid">
        <!-- only show this element when the isnt on mobile -->
        <h1 class="hidden-xs">Student Grade Table
            <small class="pull-right">Grade Average : <span class="avgGrade label label-default">&nbsp;{{mc.returnCurrentAverage()}}</span></small>
        </h1>
        <!-- only show this element when the user gets to a mobile version -->
        <h3 class = 'visible-xs col-xs-12'>Student Grade Table
            <small class="col-xs-7 pull-right" >Grade Average : <span class="avgGrade label label-default">&nbsp;</span></small>
        </h3>
    </div>
    <hr>
    <form role="form" class="student-add-form col-sm-4 pull-right" ng-controller="formController as fc">
        <h4>Add Student</h4>
        <div class = 'input-group form-group'>
            <span class = 'input-group-addon'>
                <span class="glyphicon glyphicon-user"></span>
            </span>
            <input type="text" class="form-control" name="studentName" id="studentName" placeholder="Student Name" ng-model="studentObject.name">
        </div>

        <div class="input-group form-group">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-list-alt"></span>
            </span>
            <input type="text" class="form-control" name="course" id="course" placeholder="Student Course" ng-model="studentObject.course" >
            <ul id="auto-complete"></ul>
        </div>

        <div class="input-group form-group gradeEl">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-education"></span>
            </span>
            <input type="text" class="form-control" name="studentGrade" id="studentGrade" placeholder="Student Grade" ng-model="studentObject.grade">
        </div>


        <!-- Buttons -->
        <button type="button" class="btn btn-success" style="position: relative; z-index: 300" ng-click="fc.addStudent()" >Add</button>
        <button type="button" class="btn btn-default" style="position: relative; z-index: 200">Cancel</button>
        <!--        <button type="button" data-loading-text="Loading..." class="btn btn-warning" style="position: relative; z-index: 200">Reload From Database</button>-->
    </form>

    <div class="student-list-container col-sm-8"  ng-controller="tableController as tc">
        <div class="col-sm-12">
            <div class = 'input-group form-group filter-group'>
                <span class = 'input-group-addon'>
                    <span class="glyphicon glyphicon-filter"></span>
                </span>
                <input type="text" class="form-control" name="filter" id="filter" placeholder="filter by course" ng-model="searchText">
                <span class = 'input-group-btn hidden-xs'>
                    <button class="btn btn-info" id="filter-button">Filter</button>
                    <button class="btn btn-default" id="clear-filter-button">Clear Filter</button>
                 </span>
                <ul id="filter-auto-complete"></ul>
            </div>
            <span class = 'input-group-btn hidden-sm hidden-md hidden-lg'>
            <button class="btn btn-info" id="filter-button">Filter</button>
            <button class="btn btn-default" id="clear-filter-button">Clear Filter</button>
        </span>
        </div>
        <table class="student-list table">
            <thead>
            <tr id="table-head">
                <th class='table-header' id="name" ng-click="tc.sort('name')">Student Name
                    <span style='display: inline-block;' class="glyphicon glyphicon-sort-by-alphabet"></span>
                    <span style="display: none;" class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
                </th>
                <th class='table-header' id="course" ng-click="tc.sort('course')">Student Course
                    <span style='display: inline-block;' class="glyphicon glyphicon-sort-by-alphabet"></span>
                    <span style="display: none;" class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
                </th>
                <th class='table-header' id="grade" ng-click="tc.sort('grade')">Student Grade <span id='last-span' class="glyphicon glyphicon-sort"></span></th>
                <th>Operations</th>
            </tr>
            </thead>

            <tbody>
            <tr ng-repeat="i in mc.returnStudentArrayForNgRepeat() | orderBy: fieldName: reverse | filter: searchText">
                <td>{{i.name}}</td>
                <td>{{i.course}}</td>
                <td>{{i.grade}}</td>
                <td><button type="button" class="btn btn-danger" ng-click="tc.delete(i.id, $index)">Delete</button></td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
@endverbatim
</body>
</html>


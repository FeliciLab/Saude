(function (angular) {
    "use strict";

    var module = angular.module('category.meta', ['mc.module.notifications']);

    module.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        $httpProvider.defaults.transformRequest = function (data) {
            var result = angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;

            return result;
        };
    }]);

    module.factory('CategoryMetaService', ['$http', function($http) {
        return {
            ping: function() {
                console.log('CategoryMetaService');
            }
        };
    }]);

    module.controller('CategoryMetaController', ['$scope' , '$http','CategoryMetaService', function($scope , $http, CategoryMetaService) {
        CategoryMetaService.ping();
    }]);

})(angular);
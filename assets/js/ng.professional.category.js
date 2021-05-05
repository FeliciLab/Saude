(function (angular) {
    "use strict";

    var module = angular.module('professional.category', ['mc.module.notifications']);

    module.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        $httpProvider.defaults.transformRequest = function (data) {
            var result = angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;

            return result;
        };
    }]);

    module.factory('professionalCategoryService',['$http', function($http){
        return {
            getProfessionalCategory: function() {
                return $http.get(MapasCulturais.baseURL + 'categoria-profissional/allProfessional').then(function successCallback(response) {
                    //console.log(response);
                    return response;
                });
            },
            store: function(data) {
                return $http.post(MapasCulturais.baseURL + 'categoria-profissional/store', data).success(function (data,status){
                    return data;
                })

            //     return $http.post( this.getUrl(), data).
            // success(function (data, status) {
            //     $rootScope.$emit('registration.create', {message: "Opportunity registration was created", data: data, status: status});
            // }).
            // error(function (data, status) {
            //     $rootScope.$emit('error', {message: "Cannot create opportunity registration", data: data, status: status});
            // });
            }
        }
    }]);

    module.controller('professionalCategoryController', ['$scope' , '$http', 'professionalCategoryService', function ($scope , $http, professionalCategoryService) {
        $scope.data = {name : ""};
        $scope.graus = [];
        $scope.allProfessionalCategory = function () {
            professionalCategoryService.getProfessionalCategory().then(function successCallback(response) {
               //console.log(response.data)
               $scope.graus = response.data
                // response.forEach(element => {
                //     $scope.graus.push({'id' : element.id, 'name' : element.name});
                // });
                console.log($scope.graus);
                //return response;
            });
        };
        //professionalCategoryService.getTest();
        $scope.allProfessionalCategory();

        $scope.saveCatPro = function (data) {
            var newdata = {name: data};
            professionalCategoryService.store(newdata).then(function successCallback(response) {
                console.log(response);
                if(response.data.status == 200) {
                    $scope.allProfessionalCategory();
                    alert('Cadastrado');
                }
                //return response;
            });;
        }

    }]);


})(angular);
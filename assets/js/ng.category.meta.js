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
               
            },
            getAll: function(id, type) {
                var data = {
                    id: id,
                    key: type
                }
                return $http.post(MapasCulturais.baseURL + 'categoria-profissional/allCategory', data).then(function successCallback(response) {
                    //console.log(response);
                    return response;
                });
               
            },
            store: function(data) {
                return $http.post(MapasCulturais.baseURL + 'categoria-profissional/categoria_meta', data).success(function (data,status){
                    console.log(data);
                })
            }

        };
    }]);

    module.controller('CategoryMetaController', ['$scope' , '$http','CategoryMetaService', function($scope , $http, CategoryMetaService) {
        
        $scope.catPro = [];
        $scope.data = {
            name : ''
        };
        //BUSCANDO TODAS AS CATEGORIAS RELACIONADA AS ESPECIALIDADES PROFISSIONAL
        
        //$("#createSpecialtyProfessional").serialize();
        $scope.allCategory = function() {
            var id = document.getElementById("idProfessional").value;
            console.log({id})
            CategoryMetaService.getAll(id, 'especialidade').then(function successCallback(response) {
                $scope.catPro = response.data
                console.log($scope.catPro);
            });;
        }
        $scope.allCategory();

        $scope.saveCatMeta = function () {
            var jq = $("#createSpecialtyProfessional").serialize();
            console.log(jq);
            CategoryMetaService.store(jq);
            $scope.allCategory();
            $scope.data.name = "";
        }
    }]);

})(angular);
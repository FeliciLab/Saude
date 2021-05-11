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
            CategoryMetaService.getAll(id, 'especialidade').then(function successCallback(response) {
                $scope.catPro = response.data
            });;
        }
        $scope.allCategory();

        $scope.saveCatMeta = function () {
            var jq = $("#createSpecialtyProfessional").serialize();
            CategoryMetaService.store(jq);
            $scope.allCategory();
            $scope.data.name = "";
        }

        $scope.editCatMeta = function (id) {
            jQuery("#input_"+id).removeAttr('style');
            jQuery("#saveInput_"+id).removeAttr('style');
            jQuery("#cancelarSave_"+id).removeAttr('style');
        }

        $scope.cancelarSave = function (id) {
            jQuery("#input_"+id).css("display", "none");
            jQuery("#saveInput_"+id).css("display", "none");
            jQuery("#cancelarSave_"+id).css("display", "none");
        }

        $scope.alterCatMeta = function($event) {
            var data = {
                id: $event.currentTarget.dataset.cod, 
                name: $event.target.dataset.name,
            };
            $http.post( MapasCulturais.baseURL+'categoria-profissional/updateSpecialty', data).then(function successCallback(response) {
                $scope.allCategory();
                $("#input_"+$event.currentTarget.dataset.cod).css("display","none");
                $("#saveInput_"+$event.currentTarget.dataset.cod).css("display","none");
                new PNotify({
                    icon: 'fa fa-check',
                    title: response.data.title,
                    text: response.data.message,
                    type: response.data.type
                });
            });
        }

        $scope.excluirCatMeta = function(cat) {
            new PNotify({
                title: 'Excluir Especialidade',
                text: 'Você realmente deseja excluir essa especialidade profissional?',
                icon: 'fa fa-question-circle',
                type: 'info',
                hide: false,
                confirm: {
                  confirm: true,
                  buttons: [
                    {
                      text: 'Sim',
                      addClass: 'btn-primary',
                      click: function(notice){
                        $http.delete(MapasCulturais.baseURL+'categoria-profissional/delete/'+cat).then(function (response) {
                            PNotify.removeAll();
                            $scope.allProfessionalCategory();
                            new PNotify({
                                icon: 'fa fa-check',
                                title: response.data.title,
                                text: response.data.message,
                                type: response.data.type
                            });
                        }).catch();
                      }
                    },
                    {
                      text: 'Cancelar',
                      click: function(notice){
                        PNotify.removeAll();
                      }
                    }
                  ]
                },
                buttons: {
                  closer: false,
                  sticker: false
                },
                history: {
                  history: false
                },
                addclass: 'stack-modal',
                stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
              }).get().on('pnotify.confirm', function(){
                alert('Fazer alguma coisa');
              }).on('pnotify.cancel', function(){
               PNotify.removeAll();
              });
        }
    }]);

})(angular);
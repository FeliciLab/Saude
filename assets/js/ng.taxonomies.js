(function (angular) {
    "use strict";
    
    var module = angular.module('taxonomies', ['search.service.find', 'infinite-scroll', 'mc.module.notifications']);

    module.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        $httpProvider.defaults.transformRequest = function (data) {
            var result = angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;

            return result;
        };
    }]);

    module.factory('taxonomiaService',['$http', function($http){
       // var url = new UrlService('taxonmias');
        return {
            consultaDelete: function (id, type, taxo, name) {
                var data = {
                    id: id, type: type, taxo: taxo , value: name
                }
                return $http.post( MapasCulturais.baseURL+'taxonomias/searchTaxo', data)
                .then(function successCallback(response) {
                    return response;
                });
            }
        }
    }]);
    
    module.controller('TaxonomiaController', ['$scope' , '$http', 'taxonomiaService', function ($scope , $http, taxonomiaService) {
        
        $scope.graus = [];
        $scope.data;
        $scope.data = {
            termName: "",
            termDescription: "",
            taxonomy: "",
            nameTaxonomy: "",
            loadLabel: "",
            load: true
        }
        $scope.totalTaxo = 0;
        $scope.getDataGrau = function(params){
            $http.get(MapasCulturais.baseURL+'taxonomias/allData/?params='+params).success(function(response){
                $scope.totalTaxo = response.length;
                response.forEach(element => {
                    $scope.graus.push({'id' : element.id, 'nome' : element.nome});
                });
            });
        }

        $scope.editarTaxo = function (id) {
            jQuery("#input_"+id).removeAttr('style');
            jQuery("#saveInput_"+id).removeAttr('style');
            jQuery("#cancelarSave_"+id).removeAttr('style');
        }

        $scope.alterTaxo = function ($event, taxo) {
            //$event.target.dataset.id
            var data = {id: $event.target.dataset.cod, nome: $event.target.dataset.nome};
            $http.post( MapasCulturais.baseURL+'taxonomias/alterTaxo', data)
            .then(function successCallback(response) {
                $scope.graus = [];
                $("#input_"+$event.target.dataset.cod).css("display","none");
                $("#saveInput_"+$event.target.dataset.cod).css("display","none");
                $scope.getDataGrau(taxo);
                new PNotify({
                    title: 'Sucesso!',
                    text: 'Alteração realizado com sucesso.',
                    type: 'success'
                });
            });
        }

        $scope.cancelarSave = function (id) {
            jQuery("#input_"+id).css("display", "none");
            jQuery("#saveInput_"+id).css("display", "none");
            jQuery("#cancelarSave_"+id).css("display", "none");
        }

        $scope.saveTaxo = function (dados) {
            //$event.target.dataset.id
            var data = {taxonomy: dados.taxonomy ,term: dados.termName, description: dados.termDescription};
            $http.post( MapasCulturais.baseURL+'taxonomias/create', data)
            .then(function successCallback(response) {
                $scope.graus = [];
                $scope.data.termName = "";
                //Exercitationem repre
                $scope.getDataGrau(response.config.data.taxonomy);
                new PNotify({
                    title: response.data.title,
                    text: response.data.message,
                    type: response.data.type
                });
                
            }).catch(function(e){
                console.log(e)
                $scope.graus = [];
                if(e.config.data.taxonomy == "") {
                    new PNotify({
                        title: e.data.title,
                        text: e.data.message,
                        type: e.data.type
                    });
                }else if(e.status == 500){
                    $scope.getDataGrau(e.config.data.taxonomy);
                    new PNotify({
                        title: 'Ops!',
                        text: 'Valor duplicado ou ocorreu um erro inesperado.',
                        type: 'error'
                    });
                    throw e;
                }
                
            }).finally(function() {
                console.log('This finally block');
            });
        }
        $scope.load = function () {
            new PNotify({
                title: 'Aguarde',
                type: 'notice',
                hide: false,
                icon: 'fa fa-spinner fa-spin fa-2x fa-fw',
                stack: {"dir1": "down", "dir2": "right", "push": "top", "modal": true, "overlay_close": true}
              });
        }

        $scope.excluirTaxo = function (id, taxo, name) {
            $scope.load();
            var type = MapasCulturais.deleteType;
            taxonomiaService.consultaDelete(id, type, taxo, name).then( function(response){
                if(response.data.status == 'success'){
                    PNotify.removeAll();
                    new PNotify({
                        title: 'Confirmação!',
                        text: 'Deseja realmente excluir esse registro?',
                        hide: false,
                        type: 'info',
                        closer: false,
                        sticker: false,
                        destroy: true,
                        stack: {"dir1": "down", "dir2": "right", "push": "top", "modal": true, "overlay_close": true},
                        confirm: {
                            confirm: true,
                            buttons: [{
                                text: 'Sim',
                                addClass: 'btn btn-default pull-left',
                                click: function(notice) {
                                    $http.delete( MapasCulturais.baseURL+'taxonomias/delete/'+id)
                                    .then(function successCallback(response) {
                                        notice.remove();
                                        $scope.graus = [];
                                        $scope.getDataGrau(taxo);
                                        new PNotify({
                                            title: 'Excluído!',
                                            text: 'Cadastro excluido com sucesso.',
                                            type: 'success'
                                        });
                                    }).catch(function(e){
                                        console.log(e)
                                        throw e;
                                    }).finally(function() {
                                        console.log('This finally block');
                                    });
                                }
                            
                            }, {
                                text: 'Não, cancelar',
                                addClass: 'btn btn-default',
                                click: function(notice) {
                                    notice.remove();
                                }
                            }]
                        },
                        buttons: {
                            closer: false,
                            sticker: false
                        },
                        history: {
                            history: false
                        },
                    });
                }else{
                    PNotify.removeAll();
                    new PNotify({
                        title: 'Exclusão não permitida!',
                        text: response.data.message,
                        delay: 1500,
                        type: 'error'
                    });
                }
            });
        }

        $scope.chamaTabela = function (params, name) {
            $scope.graus = [];
            $scope.data.nameTaxonomy = name;
            $scope.data.taxonomy = params;
            $scope.getDataGrau(params);
        }

        $scope.SyncTaxo = function (taxo, entity) {
            var data = {
                'taxo'   : taxo,
                'entity' : entity
            };
            $http.post(MapasCulturais.baseURL+'taxonomias/syncTaxo' , data).then(function successCallback(response) {
                if(response.status == 200) {
                    new PNotify({
                        title: 'Sucesso!',
                        text: 'Type de projeto alterado com sucesso.',
                        type: 'success'
                    });
                }
            }).catch(function(e){
                new PNotify({
                    title: 'Ops!',
                    text: 'A Sincronização já foi feita ou contate o administrador.',
                    type: 'error'
                });
            });
        }

    }]);


})(angular);

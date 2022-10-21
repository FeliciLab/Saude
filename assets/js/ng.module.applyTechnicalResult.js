// arquivo assets/js/meu-plugin/ng.module.applytechnicalresult.js

(function (angular) {
    var module = angular.module('module.applyTechnicalResult', ['ngSanitize']);

    // modifica as requisições POST para que sejam lidas corretamente pelo Slim
    module.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common['X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $httpProvider.defaults.transformRequest = function (data) {
            var result = angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;

            return result;
        };
    }]);

    // Seriço que executa no servidor as requisições HTTP
    module.factory('ApplyTechnicalResultService', ['$http', function ($http) {
        return {
            updateStatusNote: function (opportunity) {
                var dataOpp = {
                    id: opportunity
                }
                return $http.post(MapasCulturais.baseURL + 'opportunity/updateStatusNote', dataOpp);
            },
            setAllStatusToApproved: function() {
                var dataStatus = {opportunity: MapasCulturais.entity.id}
                return $http.post(MapasCulturais.baseURL+'opportunity/setAllStatusToApproved', dataStatus).
                success(function(data, status){
                    PNotify.removeAll();
                    new PNotify({
                        title: 'Sucesso!',
                        text: data.length + " inscrições atualizadas",
                        type: 'success',
                        icon: 'fa fa-check',
                        shadow: true
                    }); 
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }).
                error(function(error, status){
                    new PNotify({
                        title: 'Erro!',
                        text: 'Ocorreu um erro inesperado',
                        type: 'error',
                        icon: 'fa fa-exclamation-circle',
                        shadow: true
                    }); 
                });
            }
        };
    }]);

    // Controlador da interface
    module.controller('ApplyTechnicalResultController', ['$scope', 'ApplyTechnicalResultService', function ($scope, ApplyTechnicalResultService) {
        $scope.data = {
            teste: 'OK OK OK!'
        };

        $scope.updateStatusNote = function () {
            new PNotify({
                title: 'Um minuto!',
                text: 'Já estamos processando a alteração...',
                type: 'info',
                width: "400px",
                icon: 'fa fa-spinner fa-pulse fa-3x fa-fw',
                shadow: true,
                hide: false,
                addclass: 'stack-modal',
                stack: { 'dir1': 'down', 'dir2': 'right', 'modal': true }
            });
            
            var idEntity = MapasCulturais.entity.id;
            var note = ApplyTechnicalResultService.updateStatusNote(idEntity).
                success(function (data) {
                    PNotify.removeAll();
                    new PNotify({
                        title: 'Sucesso!',
                        text: data.length + " inscrições atualizadas",
                        type: 'success',
                        width: "400px",
                        icon: 'fa fa-check'
                    });
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                    
                }).
                error(function(error, status) {
                    PNotify.removeAll();
                    new PNotify({
                        title: 'Erro!',
                        text: error.data,
                        type: 'error',
                        icon: 'fa fa-exclamation-circle',
                        shadow: true
                    }); 
                });
        }

        $scope.setAllStatusToApproved = function () {
            new PNotify({
                title: 'Um minuto!',
                text: 'Já estamos processando a alteração...',
                type: 'info',
                width: "400px",
                icon: 'fa fa-spinner fa-pulse fa-3x fa-fw',
                shadow: true,
                hide: false,
                addclass: 'stack-modal',
                stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
            }); 
            ApplyTechnicalResultService.setAllStatusToApproved();
        }

    }]);
})(angular);

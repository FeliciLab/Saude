(function (angular) {
    var module = angular.module('errorValidation', ['ngSanitize']);
    console.log('errorValidation');
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
    // module.factory('ValidationService', ['$http', function ($http) {
    //     return {};
    // }]);

module.factory('ValidationService', ['$http', '$rootScope', '$q', 'UrlService',
 function ($http, $rootScope, $q, UrlService) {
    var url = new UrlService('registration');
    var labels = MapasCulturais.gettext.moduleOpportunity;

    return {
        getUrl: function(action, registrationId){
            return url.create(action, registrationId);
        },

        send: function(registrationId){
            return $http.post(this.getUrl('send', registrationId)).
            success(function(data, status){
                $rootScope.$emit('registration.send', {message: "Opportunity registration was send ", data: data, status: status});
            }).
            error(function(data, status){
                $rootScope.$emit('error', {message: "Cannot send opportunity registration", data: data, status: status});
            });
        },

        save: function () {
            //jQuery('a.js-submit-button').click();
        },

    };
}]);

    // Controlador da interface
    module.controller('ValidationController', ['$scope', '$rootScope', '$location', '$anchorScroll', 
        '$timeout', 'ValidationService', '$http', '$window', function ($scope, $rootScope, $location, 
            $anchorScroll, $timeout, ValidationService, $http, $window) {
        
        $scope.data = {};
        $scope.data.propLabels = [];

        for(var name in MapasCulturais.labels.agent){
            var label = MapasCulturais.labels.agent[name];
            $scope.data.propLabels.push({
                name: name,
                label: label
            });
        }
        
        $scope.data.entity = MapasCulturais.entity;
        $scope.sendRegistration = function(redirectUrl){
        ValidationService.send($scope.data.entity.id).success(function(response){
            $('.js-response-error').remove();
            if(response.error){
                var focused = false;
                Object.keys(response.data).forEach(function(field, index){
                    var $el;
                    if(field === 'projectName'){
                        $el = $('#projectName').parent().find('.label');
                    }else if(field === 'category'){
                        $el = $('#category').parent().find('.attachment-description');
                    }else if(field.indexOf('agent') !== -1){
                        $el = $('#' + field).parent().find('.registration-label');
                    }else if(field.indexOf('space') !== -1){
                        $el = $('#registration-space-title').parent().find('.registration-label');
                    }else {
                        $el = $('#' + field).find('div:first');
                    }
                    console.log($el);
                    // var message = response.data[field] instanceof Array ? response.data[field].join(' ') : response.data[field];
                    // message = message.replace(/"/g, '&quot;');
                    // $scope.data.propLabels.forEach(function(prop){
                    //     message = message.replace('{{'+prop.name+'}}', prop.label);
                    // });
                    // $el.append('<span title="' + message + '" class="danger hltip js-response-error" data-hltip-classes="hltip-danger"></span>');
                    // if(!focused && $el.parents('li').lenght > 0){
                    //     $('html,body').animate({scrollTop: $el.parents('li').get(0).offsetTop - 10}, 300);
                    //     focused = true;
                    // }
                });
                MapasCulturais.Messages.error('Error Validation');
            }else{
                $scope.data.sent = true;
                MapasCulturais.Messages.success(labels['registrationSent']);

                if (redirectUrl) {
                    document.location = redirectUrl;
                } 
                else if(redirectUrl === undefined) {
                    document.location = response.redirect || response.singleUrl;
                } 
            }
        });

        $('[data-remodal-id=modal-info-registration-confirm]').remodal().close();
    };


    }]);


})(angular);
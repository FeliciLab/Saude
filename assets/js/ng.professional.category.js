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
      console.log('professionalCategoryController');
        $scope.data = {name : ""};
        $scope.cat = [];
        $scope.allProfessionalCategory = function () {
            professionalCategoryService.getProfessionalCategory().then(function successCallback(response) {
               //console.log(response.data)
               $scope.cat = response.data
                // response.forEach(element => {
                //     $scope.graus.push({'id' : element.id, 'name' : element.name});
                // });
                
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
                    $scope.data.name = "";
                    new PNotify({
                        icon: 'fa fa-check',
                        title: response.data.title,
                        text: response.data.message,
                        type: response.data.type
                    });
                }
                //return response;
            });;
        }
        //CLICK QUE MOSTRA O INPUT PARA EDIÇÃO E OS BOTÕES
        $scope.editCatPro = function (id) {
            console.log({id})
            jQuery("#input_"+id).removeAttr('style');
            jQuery("#saveInput_"+id).removeAttr('style');
            jQuery("#cancelarSave_"+id).removeAttr('style');
        }
        //CLICK PARA CANCELAR EDIÇÃO
        $scope.cancelarSave = function (id) {
            jQuery("#input_"+id).css("display", "none");
            jQuery("#saveInput_"+id).css("display", "none");
            jQuery("#cancelarSave_"+id).css("display", "none");
        }

        $scope.alterCat = function($event) {
            console.log($event)
            var data = {id: $event.currentTarget.dataset.cod, name: $event.target.dataset.name};
            console.log(data);
            $http.post( MapasCulturais.baseURL+'categoria-profissional/update', data).then(function successCallback(response) {
                $scope.allProfessionalCategory();
                $("#input_"+$event.currentTarget.dataset.cod).css("display","none");
                $("#saveInput_"+$event.currentTarget.dataset.cod).css("display","none");
                // //$scope.getDataGrau(taxo);
                new PNotify({
                    icon: 'fa fa-exclamation-circle',
                    title: 'Sucesso!',
                    text: 'Alteração realizado com sucesso.',
                    type: 'success'
                });
            });
        }

        $scope.excluirCat = function(cat) {
            console.log({cat})
            new PNotify({
                title: 'Excluir Categoria',
                text: 'Você realmente deseja excluir essa categoria profissional?',
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
                            console.log(response)
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
                        notice.update({
                          title: 'You\'ve Chosen a Side', text: 'You want mashed potatoes.', icon: true, type: 'info', hide: true,
                          confirm: {
                            confirm: false
                          },
                          buttons: {
                            closer: true,
                            sticker: true
                          }
                        });
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

$(document).ready(function () {
  //REQUISITANDO AS ESPECIALIDADES
  getAllCategoryProfessional();
  getAllSpecialtyProfessional();
  $("#btnSaveCatSpecialty").css('display', 'none');
  $("#professionalCategory").change(function (e) { 
    e.preventDefault();
    console.log($( "#professionalCategory option:selected" ).text());
    getSpecialtyProfessional($( "#professionalCategory" ).val());
    
  });

  $("#btnSaveCatSpecialty").click(function (e) { 
    e.preventDefault();
    var dataPost = {
      id: MapasCulturais.entity.id,
      idCat: $("#professionalCategory").val(),
      idSpe: $("#specialtyCategoryProfessional").val()
    }
    $.ajax({
      type: "POST",
      url: MapasCulturais.baseURL+'categoria-profissional/alterAgentMeta',
      data: dataPost,
      dataType: "json",
      success: function (response) {
        console.log(response);
        $("#labelEspecialidadeProfissional span").remove();
        $("#labelCategoriaProfissional span").remove();
        getAllCategoryProfessional();
        getAllSpecialtyProfessional();
        $('#professionalCategory option[value=0]').attr('selected');
        $("#professionalCategory").val(0);
        getSpecialtyProfessional(0);
      }
    });
  });

  $("#specialtyCategoryProfessional").on('change', function () {
    var allSpe = [];
    allSpe.push($("#specialtyCategoryProfessional").val());
    console.log(allSpe);
  });

  
});

function getAllCategoryProfessional() {
  $.get(MapasCulturais.baseURL+'categoria-profissional/getCategoryProfessional/'+MapasCulturais.entity.id,
  function (response, textStatus, jqXHR) {
      //POPULANDO O SELECT      
    $.each(response, function (indexInArray, value) { 
      $("#labelCategoriaProfissional").append('<span class="badge_default">'+value.text+'<a href="#" class="closeCategoryProfessional" onclick="deleteCategory('+value.id+')"><i class="fa fa-close">'+
      '</a></span>')
    });
    }
  );
}

function getAllSpecialtyProfessional() {
  $.get(MapasCulturais.baseURL+'categoria-profissional/getSpecialtyProfessional/'+MapasCulturais.entity.id,
    function (response, textStatus, jqXHR) {
      //POPULANDO O SELECT
    $.each(response, function (indexInArray, value) { 
      var text = value.text;
      $("#labelEspecialidadeProfissional").append('<span class="badge_default" style="margin: 2px;">'+value.text+'<a href="#" class="closeCategoryProfessional" onclick="deleteSpecialty(\''+value.text+'\')"><i class="fa fa-close">'+
      '</a></span>')
    });
    }
  );
}
$('#specialtyCategoryProfessional').select2();
function deleteSpecialty(text) {
  var dataDelete = {
    id: MapasCulturais.entity.id,
    value: text
  }
  $.ajax({
    type: "delete",
    url: MapasCulturais.baseURL+'categoria-profissional/deleteSpecialty',
    data: dataDelete,
    dataType: "json",
    success: function (response) {
      console.log(response)
      $("#labelEspecialidadeProfissional span").remove();
      $("#labelCategoriaProfissional span").remove();
      getAllCategoryProfessional();
      getAllSpecialtyProfessional();
    }
  });
}

function deleteCategory(id) {
  console.log({id});
  var dataDelete = {
    idEntity: MapasCulturais.entity.id,
    idCat: id
  }
  $.ajax({
    type: "delete",
    url: MapasCulturais.baseURL+'categoria-profissional/deleteCategory',
    data: dataDelete,
    dataType: "json",
    success: function (response) {
      console.log(response)
      $("#labelEspecialidadeProfissional span").remove();
      $("#labelCategoriaProfissional span").remove();
      getAllCategoryProfessional();
      getAllSpecialtyProfessional();
    }
  });
}

function getSpecialtyProfessional(id) {
  var dataPost = {
    id: id,
    type: 'especialidade'
  }
  $.ajax({
    type: "POST",
    url: MapasCulturais.baseURL+'categoria-profissional/categoriaEspecialidade',
    data: dataPost,
    dataType: 'json',
    success: function (response) {
      if(response.length == 0) {
        $("#btnSaveCatSpecialty").css('display', 'none');
      }else{
        $("#btnSaveCatSpecialty").css('display', 'block');
      }
      $('#specialtyCategoryProfessional').select2({
          data: response,
          multiple: true,
          placeholder: 'Selecione uma ou mais especialidade'
      });
    }
  });
}
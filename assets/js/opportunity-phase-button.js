$(document).ready(function () {
   let li = $("div[class='opportunity-phases clear']").children().children();
   let href_value = $("div[class='opportunity-phases clear']").children().children().children()[0].href;
   if(href_value){
        li.css("display", "flex");
        li.prepend(`<button class="btn-access" style="float: left;" > <i class="fa fa-check-circle-o" aria-hidden="true"></i><a style="color: #fff;text-decoration: none;" href="${href_value}" >Acessar</a></button>`);
   }
});
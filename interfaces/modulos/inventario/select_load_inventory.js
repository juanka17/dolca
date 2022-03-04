angular.module('inventoryApp', []).controller('inventoryController', function ($scope, $http) {

    $scope.usuario_en_sesion = usuario_en_sesion;   
    console.log('user', usuario_en_sesion);
    

$scope.select_almacenes = function ()
{
    
    $http({
        method: "GET", url: "php/modulos/inventario/select_almacenes.php",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}

    }).success(function (data) {
       $scope.almacenes = data.data;
    });
 
};

$scope.select_categoria_productos = function ()
{
    
    $http({
        method: "GET", url: "php/modulos/inventario/select_categoria_productos.php",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}

    }).success(function (data) {
     
            $scope.categoria_productos = data.data;
   
    });
 
};    


$scope.select_load_inventory = function ()
{
    /*
    $http({
        method: "GET", url: "php/modulos/inventario/select_load_inventory.php",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}

    }).success(function (data) {
        if (data.error == "")
        {
            CallBack(data.data);
        } else
        {
            console.log(data);
            $scope.errorGeneral = data.error;
        }
    });
    */

   $('#myTable').DataTable( {
    ajax: 'php/modulos/inventario/select_load_inventory.php?search=id&id_inventario_lista='+ $scope.usuario_en_sesion.cedula,
    language: {
        url: 'js/i18n/spanish.json',
        },
    columns: [
        { data: 'id_inventario_lista' },
        //{ data: 'cedula_usuario' },
        //{ data: 'id_usuarios' },
        { data: 'created_at' },
        { data: 'fecha' },
        { data: 'almacen' },
        { data: 'producto' },        
        { data: 'cantidad' },   
        { data: 'espesor' }
    ]
} );
 
};

$scope.select_load_inventory_general = function ()
{


   $('#myTable').DataTable( {
    ajax: 'php/modulos/inventario/select_load_inventory.php?search=general',
    language: {
        url: 'js/i18n/spanish.json',
        },
    columns: [
        { data: 'id_inventario_lista' },
        { data: 'cedula_usuario' },
        { data: 'id_usuarios' },  
        { data: 'created_at' },          
        { data: 'fecha' },
        { data: 'almacen' },
        { data: 'producto' },
        { data: 'espesor' },
        { data: 'milimetros' }
    ]
} );
 
};    

$scope.insert_load_inventory = function ()
{

    var formData = new FormData(document.getElementById("dataForm"));    
/*
    jQuery.post($(this).attr("action"), formData, function(data) {
        console.log(data);
    });

    var formData = new FormData();

 jQuery.each(jQuery('#file')[0].files, function (i, file) {
        formData.append('file-' + i, file);
    });        
    */

   formData.append("cedula", $scope.usuario_en_sesion.cedula);
   formData.append("id_usuarios", $scope.usuario_en_sesion.id);
   formData.append("id_almacenes", $("#id_almacenes").val());



    /// formData.append('fecha_factura', $("#fecha_factura").val());
    jQuery.ajax({
        url: 'php/modulos/inventario/insert_load_inventory.php',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function (data) {
            console.log(data);
            location.reload();
        }
    });

    

};


$("#dataForm").submit(function(e) {

e.preventDefault(); // avoid to execute the actual submit of the form.

var form = $(this);
// var url = form.attr('action');
var url = 'php/modulos/inventario/insert_inventory.php';

$.ajax({
       type: "POST",
       url: url,
       data: form.serialize(), // serializes the form's elements.
       success: function(data)
       {
            console.log(data); // show response from the php script.
            if(data.success){
            alert('registro almacenado');
            location.reload();
        }

       }
     });

    
});

});
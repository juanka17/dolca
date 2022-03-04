angular.module('inventoryApp', []).controller('inventoryController', function($scope, $http) {

    // init variable
    $scope.usuario_en_sesion = usuario_en_sesion;
    console.log($scope.usuario_en_sesion);

    $scope.formUser = {
        id_negacion_factura_tipo: '',
        id_negacion_archivo: ''
    };

    $scope.dataModal = {
        id: '',

    };

    // method
    $scope.BringView = function(url, idModal, data) {
        console.log('modal', idModal);
        console.log('url', url);
        console.log('dataModal', data);
        $scope.path = url;
        $scope.dataModal = data;

        $scope.formUser.id_negacion_archivo = data.id



        setTimeout(function() {
            //$('#' + idModal).modal({ show: true });
            //$('#' + idModal).foundation('reveal', 'open');
            $("#" + idModal).modal({
                escapeClose: true,
                clickClose: true,
                showClose: true
            });
        }, 500);


        $scope.$apply();
    };

    $scope.select_estado_cuenta = function() {

        $('#myTable').DataTable({
            ajax: 'php/modulos/inventario/select_estado_cuenta.php?search=id&id_usuario=' + $scope.usuario_en_sesion.id,
            language: {
                url: 'js/i18n/spanish.json',
            },
            columns: [
                { data: 'id' },
                { data: 'id_usuario' },
                { data: 'nombre' },
                { data: 'creado' },
                { data: 'fecha_factura' },
                { data: 'almacen' },
                { data: 'producto' },
                { data: 'metros' },
                { data: 'milimetros' },
                { data: 'puntos' },
                { data: 'num_factura' },
            ]
        });
    };

    $scope.select_estado_cuenta_general = function() {


        $('#myTable').DataTable({
            ajax: 'php/modulos/inventario/select_estado_cuenta.php?search=general',
            language: {
                url: 'js/i18n/spanish.json',
            },
            columns: [
                { data: 'id' },
                { data: 'id_usuario' },
                { data: 'nombre' },
                { data: 'fecha_factura' },
                { data: 'almacen' },
                { data: 'nombre_producto_negocio' },
                { data: 'nombre_producto_homologado' },
                { data: 'cantidad' },
                { data: 'puntos' },
                { data: 'num_factura' },
                {
                    title: 'imagen',
                    visible: true,
                    searchable: false,
                    render: function(data, type, full) {
                        return '<a target="_blank" href="clases/archivos/' + full.id_usuario + '/' + full.img_factura + '"><i  class="fa fa-eye"></i><a/>';
                    }
                },
                {
                    title: 'validar',
                    visible: true,
                    searchable: false,
                    render: function(data, type, full) {
                        if (full.validacion === '0') {
                            return '<a ><i  class="fa fa-close"></i><a/> <br> <hr> <a ><i  class="fa fa-trash"></i><a/>';
                        } else {
                            return '<i  class="fa fa-check"></i>';
                        }

                    }
                }
            ],
            rowCallback: function(row, data, index) {

                const self = this;

                $('i.fa-close', row).bind('click', () => {
                    var r = confirm("Desea Aceptar la validacion");
                    if (r == true) {
                        $scope.insert_estado_cuenta(data);
                        return row;

                    } else {
                        return row;
                    }
                });

                $('i.fa-trash', row).bind('click', () => {

                    console.log(data);

                    $scope.BringView('./modal/validar_estado_cuenta.html', 'modalViewValidar', data);
                    //$scope.$apply();

                    return row;
                });


            }

        });
    };

    $scope.HttpNegacionFactura = function() {

        var url = 'php/modulos/inventario/select_negacion_tipos.php';

        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                console.log('select_negacion_tipos', response); // show response from the php script.
                if (response.success) {
                    $scope.select_negacion_factura_tipo = response.data;

                } else { alert(response.msj); }

            }
        });

    };

    $scope.insert_estado_cuenta = function(data) {
        console.log(data);


        var url = 'php/modulos/inventario/insert_estado_cuenta.php';

        $.ajax({
            type: "POST",
            url: url,
            data: data, // serializes the form's elements.
            success: function(data) {
                console.log(data); // show response from the php script.
                if (data.success) {
                    alert('registro almacenado');
                    location.reload();
                } else { alert(data.msj); }

            }
        });

    };

    $scope.insert_negacion_estado_cuenta = function(data) {
        console.log(data);


        var url = 'php/modulos/inventario/update_negacion_estado_cuenta.php';

        $.ajax({
            type: "POST",
            url: url,
            data: data, // serializes the form's elements.
            success: function(data) {
                console.log(data); // show response from the php script.
                if (data.success) {
                    alert('registro almacenado');
                    location.reload();
                } else { alert(data.msj); }

            }
        });



    }

    // init method

    $scope.HttpNegacionFactura();

    // END CONTROLLER
});
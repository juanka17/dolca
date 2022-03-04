angular.module('graficaApp', []).controller('graficaController', function($scope, $http, ) {

    $scope.ObtenerGraficaProductos = function() {
        var parametros = {
            catalogo: "grafica_productos"
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarGrafica);
    };

    $scope.MostrarGrafica = function(data) {
        $scope.grafica = data;
        grafica = $scope.grafica;

        let datos_ventas = [];
        datos_ventas["Cantidad"] = [];
        let categories = [];

        for (i in grafica) {
            datos_ventas["Cantidad"].push(grafica[i]["total"]);

            categories.push(grafica[i]["producto"]);
        }

        let series_ventas = [];
        for (tipo in datos_ventas) {
            series_ventas.push({
                name: tipo,
                data: datos_ventas[tipo],
            });
        }

        var options = {
            series: series_ventas,
            chart: {
                height: 400,
                type: "line",
                zoom: {
                    enabled: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "straight",
            },
            title: {
                text: "Productos Registrados",
                align: "left",
            },
            grid: {
                row: {
                    colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                    opacity: 0.5,
                },
            },
            xaxis: {
                categories: categories
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


        $scope.ObtenerGraficaValores();
    };

    $scope.ObtenerGraficaValores = function() {
        var parametros = {
            catalogo: "grafica_valores"
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarGraficaValores);
    };

    $scope.MostrarGraficaValores = function(data) {

        let grafica_valores = data;

        let datos_valores = [];
        datos_valores["Total"] = [];

        let categorias = [];

        for (i in grafica_valores) {
            datos_valores["Total"].push(grafica_valores[i]["total"]);

            categorias.push(grafica_valores[i]["valor"]);
        }



        let series_valores = [];
        for (tipo in datos_valores) {
            series_valores.push(
                datos_valores[tipo],
            );
        }

        var options = {
            series: [{
                name: 'Total',
                data: series_valores[0]
            }],

            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false

            },
            labels: {
                formatter: function(y) {
                    return y.toFixed(0) + "%";
                }
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: categorias,

            },
            yaxis: {
                title: {
                    text: 'Bonos entregados'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return (
                            "$" +
                            val.toLocaleString(undefined, {
                                minimumFractionDigits: 0,
                            })
                        );
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart_valores"), options);
        chart.render();

        $scope.ObtenerGraficaDias();
    };

    $scope.ObtenerGraficaDias = function() {
        var parametros = {
            catalogo: "grafica_dias"
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarGraficaDias);
    };

    $scope.MostrarGraficaDias = function(data) {

        let grafica_valores = data;

        let datos_participantes = [];
        datos_participantes["Registros"] = [];

        let datos_bonos = [];
        datos_bonos["Bonos"] = [];

        let categorias = [];

        for (i in grafica_valores) {
            datos_participantes["Registros"].push(grafica_valores[i]["registros"]);
            datos_bonos["Bonos"].push(grafica_valores[i]["bonos"]);

            categorias.push(grafica_valores[i]["fecha"]);
        }

        let series_participantes = [];

        for (tipo in datos_participantes) {
            series_participantes.push({
                name: 'Participantes',
                type: 'column',
                data: datos_participantes[tipo]
            });
        }

        for (tipo in datos_bonos) {
            series_participantes.push({
                name: 'Bonos',
                type: 'line',
                data: datos_bonos[tipo],
            });
        }

        var options = {
            series: series_participantes,
            chart: {
                height: 700,
                type: 'line',
            },
            stroke: {
                width: [0, 4]
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [1]
            },
            labels: categorias,
            xaxis: {
                type: 'date',
                labels: {
                    rotate: -90,
                    tickPlacement: 'on'
                },
            },
            yaxis: [{
                title: {
                    text: 'Participantes',
                },

            }, {
                opposite: true,
                title: {
                    text: 'Bonos'
                }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#chart_dias"), options);
        chart.render();
    };

    $scope.EjecutarLlamado = function(modelo, operacion, parametros, CallBack) {
        $http({
            method: "POST",
            url: "clases/jarvis.php",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: { modelo: modelo, operacion: operacion, parametros: parametros }
        }).success(function(data) {
            if (data.error == "") {
                CallBack(data.data);
            } else {
                console.log(data);
                $scope.errorGeneral = data.error;
            }
        });
    };

    $scope.ObtenerGraficaProductos();
});
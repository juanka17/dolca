# MODULOS DEL PROYECTO.

## MODULO 1

1.       Crear el módulo para Distribuidoras donde se pueda subir el inventario por mes y fecha bien sea manual o por archivo de Excel. Este debe generar reporte y dejar capturar la información de:

a.       Tipo de Vidrio (en filtro igual que cuando se sube la foto)

b.       Mes (fecha)

c.       Milímetros

d.       Cantidad (m2)

## MODULO 2

2.       Generar alerta cuando se exceda el inventario del Distribuidor, es decir cuando los vidrieros registren más M2 de los que hay en inventario.

a.       Debe existir un reporte de inventario donde se visualice: Distribuidor/mes(periodo)/ producto/milímetros/inventario en m2/ producto reportado*vidriero/ saldo/

b.       Reporte con la misma información pero por Vidrieria

## MODULO 3 

3.       Motor de puntos, una vez se registre la foto y la información del vidrio comprado, debe salir un mensaje que diga “Tu compra está en proceso de validación para asignación de puntos”


a.       Habilitar perfil de call center y administrativos para que den validar a la compra.

b.       Una vez se de validar, se debe asignar los puntos de acuerdo a la mecánica que es por cada 1m2 registrado 1 punto,

c.       Si registra una lámina o el equivalente en m2 que es 7,92 o 7,42   lo aproximamos a 8 m2

d.       Puede registrar en decimales, pero aproximamos a mas, es decir a entero si pasa los 0,5, sino los vamos sumando hasta que lleguen a entero, pero hacemos corte en el fin de mes.

e.       Si el participante no registra los datos completos de la compra y foto debe salir una nota que indique que no puede continuar por que le falta XXXXXX

## MODULO 4 

4.       Estado de cuenta: debe registrar toda la información con fecha/factura/tipo de producto/ metros.

SOLUCIONES


validar usuario administrador -> modulo 3

validad  carga del estado de cuenta al importar

ocultar el boton de borrar la imagen de la validacion de la compra.

guardar el id del usuario en el inventario y manualmente y la carga tambien, 

lista desplegable con una lista en el formulario manual.

agregar un campo al inventario identificando el almacen.

al ingresar manualmente se debe seleccionar el almacen a ingresar.
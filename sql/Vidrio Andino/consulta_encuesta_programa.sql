select
usu.id id_usuario,
usu.cedula,
usu.nombre,
alm.nombre almacen,
case
when enp.p1 = 1 then 'Programa que lo incentiva para aumentar sus ventas'
when enp.p1 = 2 then 'Un programa que le permite acceder a grandiosos premios y beneficios'
when enp.p1 = 3 then 'Un programa al cual No le ven ningún valor agregado'
when enp.p1 = 4 then 'Otro'
end '¿Que opina del programa banco de sueños y el catálogo de premios?',
case
when enp.p2 = 1 then 'Apropiado'
when enp.p2 = 2 then 'Demorado'
end '¿Como han sido los tiempos de cargue de puntos?',
case
when enp.p3 = 1 then 'Apropiado'
when enp.p3 = 2 then 'Demorado'
end '¿Como han sido los tiempos de canje de redención de premios?',
case
when enp.p4 = 1 then 'Bueno'
when enp.p4 = 2 then 'Malo'
when enp.p4 = 3 then 'Regular'
when enp.p4 = 4 then 'No aplica'
end '¿Como ha sido el servicio en la línea de atención?',
case
when enp.p5 = 1 then 'Insatisfecho'
when enp.p5 = 2 then 'Regula'
when enp.p5 = 3 then 'Satisfecho'
end 'Califique su nivel de satisfacción con el programa siendo:',
enp.p6 'Que recomendación nos daría con el objetivo de mejorar su experiencia con el programa?',
enp.fecha
from 
encuesta_programa enp
inner join usuarios usu on usu.id = enp.id_usuario
inner join almacenes alm on alm.id = usu.id_almacen
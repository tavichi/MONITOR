#SELECT 	a.codigo,d.id_opcion AS codigoopcion,d.nombre AS descripopcion,d.fuente AS ejecutable,
#		f.id_submenu as area, f.nombre as descriparea, a.codigo
#FROM dbs_usuario a
#INNER JOIN dbs_usuarioper b on(b.id_usuario = a.id_usuario and b.id_estadop = 1)
#INNER JOIN dbs_perfilopc c on(c.id_perfil = b.id_perfil and c.id_estadoop = 1)
#INNER JOIN dbs_opcion d on(d.id_opcion = c.id_opcion and d.id_estadoop = 1)
#INNER JOIN dbs_sistema e on(e.id_sistema = d.id_sistema)
#INNER JOIN dbs_submenu f on(f.id_submenu=d.id_submenu)
#WHERE a.codigo = $usuario
#AND f.id_submenu

#SELECT orden, id_casa, numero
#FROM(
#SELECT lpad(trim(numero),'20','0') as orden, id_casa, numero 
#FROM dbs_casa 
#WHERE id_sector=1
#UNION 
#SELECT '',-1,'Todos'
#)t1 ORDER BY orden ASC;


#select id_casa AS codcasa,sector as nombsector,numero as nocasa,codigo_seg,dir_catastro as dir_completa,
#CONVERT(DATE_FORMAT(f_alta, "%d %M %Y "),CHARACTER) as falta,id_identidad, 
#nombrecliente, sectorcasa
#FROM dbv_periodoxcasa
#WHERE id_sector = 1
DROP VIEW dbv_pagocasas;

CREATE VIEW dbv_pagocasas
AS
#SELECT id_asignacasa, sector, casa, codigo_seg, dir_catastro, nombrecliente, estado, 
#			 id_casa, id_sector, fecha
#FROM (
SELECT ac.id_asignacasa AS id_asignacasa,s.nombre AS sector,
c.numero AS casa, c.codigo_seg AS codigo_seg, 
c.dir_catastro AS dir_catastro,
concat(i.id_identidad,'-',i.nombres,' ',i.apellidos) AS nombrecliente,
ec.nombre as estado, CONCAT(me.nombrec,'-',redt.anno) as fecha, c.id_casa,
s.id_sector, ac.id_identidad, ac.id_rol,c.numcalleave, c.id_tipodireccion,
c.literal, c.numcasa1, c.numcasa2
FROM 
dbs_asignacasa ac 
INNER JOIN dbs_identidad i     on(i.id_identidad=ac.id_identidad) 
INNER JOIN dbs_casa c 	       on(c.id_casa=ac.id_casa) 
INNER JOIN dbs_sector s        on(s.id_sector=c.id_sector) 
LEFT  JOIN dbs_serviciocasa sc on(sc.id_casa=c.id_casa and sc.id_estadoservcasa= 1) 
LEFT  JOIN dbs_estadoservcasa ec on(ec.id_estadoservcasa=sc.id_estadoservcasa)
LEFT  JOIN dbs_listadopa lpa   on(lpa.id_listadopa=sc.id_listadopa and lpa.id_estadolis=1 and lpa.id_producto=1)
LEFT  JOIN dbs_recibo re on(re.id_cliente=ac.id_identidad and re.id_casa=ac.id_casa)
LEFT  JOIN dbs_detallerecibo redt on(redt.id_empresa=re.id_empresa and redt.id_tipodoc=re.id_tipodoc and redt.id_serie=re.id_serie and redt.recibo=re.recibo)
LEFT  JOIN dbs_mes me on(me.id_mes=redt.id_mes)
LEFT  JOIN dbs_producto pro on(pro.id_producto=redt.id_producto and pro.id_tipopro=2)
WHERE ac.id_estadoas=1
GROUP BY ac.id_asignacasa, s.nombre, c.numero, c.codigo_seg, 
c.dir_catastro, i.id_identidad, i.nombres, i.apellidos,
ec.nombre, me.nombrec, c.id_casa, s.id_sector, c.numcalleave, c.id_tipodireccion,
c.literal, c.numcasa1, c.numcasa2
#)t  
#GROUP BY id_asignacasa, sector, casa, codigo_seg, dir_catastro, nombrecliente, 
#estado,id_casa, id_sector;


SELECT a.id_asignacasa, a.sector, a.casa, a.codigo_seg, a.dir_catastro, a.nombrecliente, a.estado, 
			 a.id_casa, a.id_sector, MAX(a.fecha) as fecha, a.id_identidad,
			 numcalleave, id_tipodireccion, literal, numcasa1, numcasa2
FROM dbv_pagocasas a
GROUP BY a.id_asignacasa, a.sector, a.casa, a.codigo_seg, a.dir_catastro, a.nombrecliente, 
a.estado,a.id_casa, a.id_sector,numcalleave, id_tipodireccion, literal, numcasa1, numcasa2;


SELECT CONCAT(b.nombre,': ',a.numero) as contacto
FROM dbs_telefono a
INNER JOIN dbs_tipotel b on(b.id_tipotel=a.id_tipotel)
WHERE id_identidad=1
AND a.f_baja is null;

INSERT INTO dbs_telefono(id_telefono, id_identidad, numero, f_alta, f_baja, bitacora, id_tipotel)
VALUES(1,1,66367890, NOW(),null,'Ingresado por EA',2);

#SELECT * FROM dbs_producto 

#SELECT * FROM dbs_tipopro


SELECT * FROM dbs_sector

SELECT lpad(trim(nombre),'20','0') as orden,id_sector,codigo 
FROM dbs_sector 
WHERE id_estados=1 
UNION 
SELECT '',-1,'Todos'


DROP TABLE IF EXISTS `dbs_tipodireccion`;
CREATE TABLE `dbs_tipodireccion` (
  `id_tipodireccion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `abr` varchar(10) DEFAULT NULL,
  `bitacora` text,
  PRIMARY KEY (`id_tipodireccion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 
COMMENT='Tabla que almacena los tipos de las direcciones de una residencial';

INSERT INTO `dbs_tipodireccion` VALUES (1, 'Avenida', 'Avenida', 'Ins:201803-DataAdministrador 09-Jul-2018 10:30');
INSERT INTO `dbs_tipodireccion` VALUES (2, 'Calle', 'Calle', 'Ins:201803-DataAdministrador 09-Jul-2018 10:30');

SELECT id_tipodireccion as cod, nombre 
FROM dbs_tipodireccion

alter table dbs_casa add numcalleave int(11);
alter table dbs_casa add id_tipodireccion int(11);
alter table dbs_casa add literal varchar(5);
alter table dbs_casa add numcasa1 int(11);
alter table dbs_casa add numcasa2 int(11);
alter table dbs_casa add CONSTRAINT `fk_tipodirec_casa` FOREIGN KEY (`id_tipodireccion`) REFERENCES `dbs_tipodireccion` (`id_tipodireccion`) ON UPDATE CASCADE;








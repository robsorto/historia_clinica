<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	public function listar($fechainicio, $fechafin)
	{
		$sql = "SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,a.fecha,a.hora,
		(select concat(apaterno,' ',amaterno,' ',nombre) 
		from persona where idpersona=a.idusuario) as registrador,
		(select concat(apaterno,' ',amaterno,' ',nombre) 
		from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado 
		FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona 
		inner join servicio s on a.idservicio=s.idservicio WHERE a.estado<>'Anulado' 
		AND a.fecha>='$fechainicio' AND a.fecha<='$fechafin' order by a.idatencion desc";
		return ejecutarConsulta($sql);
	}

	public function listarHistorias($fechainicio, $fechafin)
	{
		$sql = "SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,
		a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador
		,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,
		s.nombre as servicio,a.costo,a.estado FROM atencion a 
		INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio 
		WHERE a.estado='Atendido' AND a.fecha>='$fechainicio' AND a.fecha<='$fechafin' order by a.idatencion desc";
		return ejecutarConsulta($sql);
	}

	public function listarPrenatal($fechainicio, $fechafin)
	{
		$sql = "SELECT p.idpersona, a.idatencion, o.id_obstetrica, 
		a.fecha, a.hora, CONCAT(p.apaterno, ' ', p.amaterno, ' ', p.nombre) paciente, s.nombre as servicio, 
		(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) especialista, 
		a.costo, a.estado, 
		case when o.estado = 'I' then 'Finalizada' ELSE 'Activa' end as estado_consulta
		FROM obstetrica o
		INNER JOIN cntrl_prenatal cp ON (o.id_obstetrica = cp.id_obstetrica)
		INNER JOIN atencion a ON(o.idatencion = a.idatencion)
		INNER JOIN persona p ON (a.idpersona = p.idpersona)
		INNER JOIN servicio s ON(a.idservicio = s.idservicio)
		WHERE a.fecha>='$fechainicio' AND a.fecha<='$fechafin' 
		GROUP BY  p.idpersona, a.idatencion, o.id_obstetrica
		order by a.idatencion desc";

		return ejecutarConsulta($sql);
	}

	public function listarGinecologia($fechainicio, $fechafin)
	{
		$sql = "SELECT 
		p.idpersona, a.idatencion, g.id_ginecologia, 
				a.fecha, a.hora, CONCAT(p.apaterno, ' ', p.amaterno, ' ', p.nombre) paciente, s.nombre as servicio, 
				(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) especialista, 
				a.costo, a.estado
		FROM ginecologia g
		INNER JOIN atencion a ON (g.idatencion = a.idatencion)
		INNER JOIN persona p ON(g.idpersona = p.idpersona)
		INNER JOIN servicio s ON(a.idservicio = s.idservicio)
		AND a.fecha>='$fechainicio' AND a.fecha<='$fechafin' order by a.idatencion desc";
		return ejecutarConsulta($sql);
	}
}

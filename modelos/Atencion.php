<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Atencion
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($idpersona, $idusuario, $idservicio, $idempleado, $costo)
	{
		$costoLocal = 0;
		if (!empty($costo)) {
			$costoLocal = $costo;
		}
		$sql = "INSERT INTO atencion (idpersona,idusuario,fecha,hora,idservicio,idempleado,costo,estado)
		VALUES ('$idpersona','$idusuario',curdate(),curtime(),'$idservicio','$idempleado','$costoLocal','Registrado')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idatencion, $idpersona, $idusuario, $idservicio, $idempleado, $costo)
	{
		$sql = "UPDATE atencion SET idpersona='$idpersona',idservicio='$idservicio',idempleado='$idempleado',costo='$costo' WHERE idatencion='$idatencion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function anular($idatencion)
	{
		$sql = "UPDATE atencion SET estado='Anulado' WHERE idatencion='$idatencion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idatencion)
	{
		$sql = "SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,a.fecha,a.hora,a.idusuario,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,a.idempleado,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,a.idservicio,s.nombre as servicio,a.costo,a.estado FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio WHERE a.idatencion='$idatencion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT a.idatencion,a.idpersona,p.num_documento,CONCAT((YEAR( CURDATE( ) )
		 - YEAR( fecha_nacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fecha_nacimiento), 1, 
		IF ( MONTH(CURDATE( )) = MONTH(fecha_nacimiento),
		IF (DAY( CURDATE( ) ) < DAY( fecha_nacimiento ),1,0 ),0))),' años, ',
		(MONTH(CURDATE()) - MONTH( fecha_nacimiento) + 12 * IF( MONTH(CURDATE())<MONTH(fecha_nacimiento), 1,IF(MONTH(CURDATE())=MONTH(fecha_nacimiento),IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0),0)) - IF(MONTH(CURDATE())<>MONTH(fecha_nacimiento),(DAY(CURDATE())<DAY(fecha_nacimiento)), IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0 ))),' meses, ',(DAY( CURDATE( ) ) - DAY( fecha_nacimiento ) +30 * ( DAY(CURDATE( )) < DAY(fecha_nacimiento) )),' días') as edad,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,
		(select concat(apaterno,' ',amaterno,' ',nombre) 
		from persona where idpersona=a.idempleado) as especialista,
		s.nombre as servicio,a.costo,a.estado 
		FROM atencion a 
		INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio
		 WHERE a.estado<>'Anulado' order by a.idatencion desc limit 0,100";
		return ejecutarConsulta($sql);
	}

	public function listarTriaje()
	{
		$sql = "SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio WHERE a.estado='Registrado' order by a.idatencion asc limit 0,100";
		return ejecutarConsulta($sql);
	}

	public function listarPlan()
	{
		$sql = "SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio 
		WHERE a.estado='En Espera' order by a.idatencion asc limit 0,100";
		return ejecutarConsulta($sql);
	}

	public function listarEscritorioTriaje()
	{
		$sql = "SELECT a.idatencion,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona WHERE a.estado='Registrado' order by a.idatencion asc limit 0,100";
		return ejecutarConsulta($sql);
	}

	public function listarEscritorioPlan()
	{
		$sql = "SELECT a.idatencion,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona 
		WHERE a.estado='En Espera' order by a.idatencion asc limit 0,100";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql = "SELECT * FROM atencion where condicion=1";
		return ejecutarConsulta($sql);
	}

	//Imprimir Atenciones
	public function listarAtenciones($idpersona)
	{
		$sql = "SELECT idatencion,fecha from atencion where idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	public function buscarPorCriterio($criterio, $texto)
	{
		$sql = "SELECT idpersona, concat(apaterno,' ',amaterno,' ',nombre) as nombre, 
		num_documento as documento, telefono, email as correo, fecha_nacimiento as nacimiento
		FROM persona where es_empleado = 'N' ";
		switch ($criterio) {
			case 'documento':
				$sql .= "and num_documento like '%$texto%'";
				break;
			case 'nombre':
				$sql .= "and upper(concat(apaterno,' ',amaterno,' ',nombre)) like upper('%$texto%')";
				break;
			case 'telefono':
				$sql .= "and telefono like '%$texto%'";
				break;
			case 'correo':
				$sql .= "and upper(email) like upper('%$texto%')";
				break;
			default:
				break;
		}
		return ejecutarConsulta($sql);
	}
}

﻿<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Persona
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($apaterno, $amaterno, $nombre, $fecha_nacimiento, $sexo, $estado_civil, $alergia, $intervenciones_quirurgicas, $vacunas_completas, $tipo_documento, $num_documento, $direccion, $telefono, $email, $ocupacion, $persona_responsable, $profesion)
	{
		$sql = "INSERT INTO persona (apaterno,amaterno,nombre,fecha_nacimiento,sexo,estado_civil,
		alergia,intervenciones_quirurgicas,vacunas_completas,tipo_documento,num_documento,direccion,
		telefono,email,ocupacion,persona_responsable, profesion, es_empleado)
		VALUES ('$apaterno','$amaterno','$nombre','$fecha_nacimiento','$sexo','$estado_civil',
		'$alergia','$intervenciones_quirurgicas','$vacunas_completas','$tipo_documento','$num_documento',
		'$direccion','$telefono','$email','$ocupacion','$persona_responsable', '$profesion', 'N')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar(
		$idpersona,
		$apaterno,
		$amaterno,
		$nombre,
		$fecha_nacimiento,
		$sexo,
		$estado_civil,
		$alergia,
		$intervenciones_quirurgicas,
		$vacunas_completas,
		$tipo_documento,
		$num_documento,
		$direccion,
		$telefono,
		$email,
		$ocupacion,
		$persona_responsable,
		$profesion
	) {
		$sql = "UPDATE persona SET apaterno='$apaterno',amaterno='$amaterno', nombre='$nombre',
		fecha_nacimiento='$fecha_nacimiento', sexo='$sexo',estado_civil='$estado_civil',alergia='$alergia',intervenciones_quirurgicas='$intervenciones_quirurgicas',vacunas_completas='$vacunas_completas',tipo_documento='$tipo_documento',
		num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',ocupacion='$ocupacion',persona_responsable='$persona_responsable', profesion ='$profesion' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($idpersona)
	{
		$sql = "DELETE FROM persona WHERE idpersona='$idpersona' and es_empleado = 'N'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idpersona)
	{
		$sql = "SELECT * FROM persona WHERE idpersona='$idpersona' and es_empleado = 'N'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listarp()
	{
		$sql = "SELECT idpersona,concat(apaterno,' ',amaterno,' ',nombre, ' - ',num_documento) as paciente 
		FROM persona where es_empleado = 'N' ";
		return ejecutarConsulta($sql);
	}
	public function listar($texto)
	{
		$sql = "SELECT a.* FROM (SELECT * FROM persona where apaterno 
		like concat('%','$texto','%') or amaterno 
		like concat('%','$texto','%') or num_documento='$texto'
		order by apaterno asc,amaterno asc limit 0,200) a WHERE a.es_empleado = 'N' ";
		return ejecutarConsulta($sql);
	}

	//Listar paciente por dni o por nombre
	public function buscar($idpersona)
	{
		$sql = "SELECT idpersona,apaterno,amaterno,nombre,tipo_documento,num_documento 
		FROM persona where idpersona='$idpersona' and es_empleado = 'N'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los especialistas
	public function select()
	{
		$sql = "SELECT p.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as especialista 
		FROM persona p inner join usuario u on u.idusuario=p.idpersona where p.es_empleado = 'S' 
		and u.cargo in('Doctor')";
		return ejecutarConsulta($sql);
	}

	//Imprimir historia
	public function imprimirHistoria($idatencion)
	{
		$sql = "SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,
		p.fecha_nacimiento,CONCAT((YEAR( CURDATE( ) ) - YEAR( fecha_nacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fecha_nacimiento), 1, 
		IF ( MONTH(CURDATE( )) = MONTH(fecha_nacimiento),IF (DAY( CURDATE( ) ) < DAY( fecha_nacimiento ),1,0 ),0))),' años, ',(MONTH(CURDATE()) - MONTH( fecha_nacimiento) + 12 * IF( MONTH(CURDATE())<MONTH(fecha_nacimiento), 1,IF(MONTH(CURDATE())=MONTH(fecha_nacimiento),IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0),0)) - IF(MONTH(CURDATE())<>MONTH(fecha_nacimiento),(DAY(CURDATE())<DAY(fecha_nacimiento)), IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0 ))),' meses, ',(DAY( CURDATE( ) ) - DAY( fecha_nacimiento ) +30 * ( DAY(CURDATE( )) < DAY(fecha_nacimiento) )),' días') as edad,p.sexo,p.estado_civil,p.alergia,p.intervenciones_quirurgicas,p.vacunas_completas,p.direccion,p.num_documento,p.ocupacion,p.persona_responsable,r.fecha,r.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado,t.presion_arterial,t.temperatura,t.frecuencia_respiratoria,t.frecuencia_cardiaca,t.saturacion,t.peso,t.talla,t.imc,r.motivo_consulta,r.tiempo_enfermedad,r.antecedentes,r.examen_fisico,r.tratamiento,r.proxima_cita,r.plan 
		FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona 
		inner join servicio s on a.idservicio=s.idservicio inner join triaje t on a.idatencion=t.idatencion 
		inner join resultado r on a.idatencion=r.idatencion 
		WHERE a.idatencion='$idatencion' and p.es_empleado = 'N' limit 0,1";
		return ejecutarConsulta($sql);
	}

	public function imprimirDetalleHistoria($idatencion)
	{
		$sql = "SELECT dd.tipo,d.enfermedad,d.codigo FROM detalle_diagnostico dd 
		inner join diagnostico d on d.iddiagnostico=dd.iddiagnostico 
		inner join resultado r on dd.idresultado=r.idresultado 
		inner join atencion a on a.idatencion=r.idatencion 
		WHERE a.idatencion='$idatencion'";
		return ejecutarConsulta($sql);
	}

	public function imprimirReceta($idatencion)
	{
		$sql = "SELECT medicamento,presentacion,dosis,duracion,cantidad FROM receta WHERE idatencion='$idatencion'";
		return ejecutarConsulta($sql);
	}

	public function imprimirCabeceraHistoria($idpersona)
	{
		$sql = "SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,p.fecha_nacimiento,CONCAT((YEAR( CURDATE( ) ) - YEAR( fecha_nacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fecha_nacimiento), 1, 
		IF ( MONTH(CURDATE( )) = MONTH(fecha_nacimiento),IF (DAY( CURDATE( ) ) < DAY( fecha_nacimiento ),1,0 ),0))),' años, ',(MONTH(CURDATE()) - MONTH( fecha_nacimiento) + 12 * IF( MONTH(CURDATE())<MONTH(fecha_nacimiento), 1,IF(MONTH(CURDATE())=MONTH(fecha_nacimiento),IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0),0)) - IF(MONTH(CURDATE())<>MONTH(fecha_nacimiento),(DAY(CURDATE())<DAY(fecha_nacimiento)), IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0 ))),' meses, ',(DAY( CURDATE( ) ) - DAY( fecha_nacimiento ) +30 * ( DAY(CURDATE( )) < DAY(fecha_nacimiento) )),' días') as edad,p.sexo,p.estado_civil,p.alergia,p.intervenciones_quirurgicas,p.vacunas_completas,p.direccion,p.num_documento,p.ocupacion,p.persona_responsable 
		FROM atencion a 
		INNER JOIN persona p ON a.idpersona=p.idpersona WHERE a.idpersona='$idpersona' and p.es_empleado = 'N'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function imprimirAtencionHistoria($idpersona)
	{
		$sql = "SELECT a.idatencion,a.idpersona,a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado,t.presion_arterial,t.temperatura,t.frecuencia_respiratoria,t.frecuencia_cardiaca,t.saturacion,t.peso,t.talla,t.imc,r.motivo_consulta,r.tiempo_enfermedad,r.antecedentes,r.examen_fisico,r.tratamiento,r.proxima_cita,r.plan 
		FROM atencion a 
		inner join servicio s on a.idservicio=s.idservicio inner join triaje t on a.idatencion=t.idatencion
		 inner join resultado r on a.idatencion=r.idatencion WHERE a.idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function obtenerFechaProximaConsulta($idatencion)
	{
		$sql = "SELECT 
		case when s.nombre='Consulta médica general' then (SELECT proxima_cita FROM resultado WHERE idatencion='$idatencion')
				when (s.nombre='Consulta Obstetrica' OR s.nombre='Consulta Control Prenatal') 
				then (SELECT cp.proxima_cita
				FROM cntrl_prenatal cp
				WHERE cp.idatencion ='$idatencion' 
				ORDER BY cp.id_control DESC 
				LIMIT  1
		)
		when s.nombre='Consulta Ginecologica' then (SELECT proxima_cita FROM ginecologia WHERE idatencion='$idatencion')
		ELSE '' END fecha_proxima_cita
		FROM atencion a
		INNER JOIN servicio s ON (a.idservicio = s.idservicio)
		WHERE idatencion='$idatencion'";
		return ejecutarConsulta($sql);
	}
}

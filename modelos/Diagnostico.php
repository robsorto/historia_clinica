<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Diagnostico
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($codigo, $enfermedad)
	{
		$sql = "INSERT INTO diagnostico (codigo,enfermedad)
		VALUES ('$codigo','$enfermedad')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($iddiagnostico, $codigo, $enfermedad)
	{
		$sql = "UPDATE diagnostico SET codigo='$codigo',enfermedad='$enfermedad' WHERE iddiagnostico='$iddiagnostico'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function eliminar($iddiagnostico)
	{
		$sql = "DELETE FROM diagnostico WHERE iddiagnostico='$iddiagnostico'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($iddiagnostico)
	{
		$sql = "SELECT * FROM diagnostico WHERE iddiagnostico='$iddiagnostico'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function mostrarXcodigo($codigo)
	{
		$sql = "SELECT iddiagnostico FROM diagnostico WHERE codigo='$codigo'";
		$resp =  ejecutarConsulta($sql);
		$reg = $resp->fetch_object();

		$data = array($reg->iddiagnostico);
		return $data;
	}

	//Implementar un método para listar los registros
	public function listar($texto)
	{
		$sql = "SELECT * FROM diagnostico where enfermedad like concat('%','$texto','%') or codigo like concat('%','$texto','%') order by enfermedad asc limit 0,200";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listarDiagnostico($texto)
	{
		$sql = "select iddiagnostico,concat(codigo,'-',enfermedad) as nenfermedad from diagnostico where enfermedad like concat('%','$texto','%') or codigo like concat('%','$texto','%')";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql = "SELECT * FROM diagnostico where condicion=1";
		return ejecutarConsulta($sql);
	}
}

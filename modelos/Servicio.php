<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Servicio
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$costo)
	{
		$sql="INSERT INTO servicio (nombre,costo,condicion)
		VALUES ('$nombre','$costo','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idservicio,$nombre,$costo)
	{
		$sql="UPDATE servicio SET nombre='$nombre',costo='$costo' WHERE idservicio='$idservicio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idservicio)
	{
		$sql="UPDATE servicio SET condicion='0' WHERE idservicio='$idservicio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idservicio)
	{
		$sql="UPDATE servicio SET condicion='1' WHERE idservicio='$idservicio'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idservicio)
	{
		$sql="SELECT * FROM servicio WHERE idservicio='$idservicio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM servicio";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM servicio where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

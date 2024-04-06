<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Configuracion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idconfiguracion,$razon_social,$ruc,$email,$telefono,$direccion,$responsable)
	{
		$sql="INSERT INTO configuracion (razon_social,ruc,email,telefono,direccion,responsable)
		VALUES ('$razon_social','$ruc','$email','$telefono','$direccion','$responsable')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idconfiguracion,$razon_social,$ruc,$email,$telefono,$direccion,$responsable)
	{
		$sql="UPDATE configuracion SET razon_social='$razon_social',ruc='$ruc',email='$email', telefono='$telefono',
		direccion='$direccion', responsable='$responsable' WHERE idconfiguracion='$idconfiguracion'";
		return ejecutarConsulta($sql);
	}

	
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idconfiguracion)
	{
		$sql="SELECT * FROM configuracion WHERE idconfiguracion='$idconfiguracion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM configuracion";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM configuracion where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>
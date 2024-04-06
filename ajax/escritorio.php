<?php 
require_once "../modelos/Atencion.php";

$atencion=new Atencion();



switch ($_GET["op"]){
	case 'listarTriaje':
		$num=1;
		$rspta=$atencion->listarEscritorioTriaje();
		echo '<thead>
                <tr>
                    <th style="font-size: 30px">#</th>
                    <th style="font-size: 30px">En Espera</th>
                </tr>
              </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr ><td style="font-size: 30px"><span class="label bg-green">'.$num.'</span></td>
						<td style="font-size: 30px">'.$reg->paciente.'</td></tr>';
					$num=$num+1;
				}
	break;

	case 'listarPlan':
		$num=1;
		$rspta=$atencion->listarEscritorioPlan();
		echo '<thead>
                <tr>
                    <th style="font-size: 30px">#</th>
                    <th style="font-size: 30px">Atención</th>
                </tr>
              </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr ><td style="font-size: 30px"><span class="label bg-red">'.$num.'</span></td>
						<td style="font-size: 30px">'.$reg->paciente.'</td></tr>';
					$num=$num+1;
				}
	break;
}
?>
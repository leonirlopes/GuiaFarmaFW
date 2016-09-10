<?php
header("Cache-Control: max-age=0"); //1dia (60s * 60min * 24h * 1dias) 86400
header('Content-Type: application/json; charset=utf-8');

require '../admin/medoo.min.php'; // framework Medoo.in
$database = new medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'nome-do-banco-de-dados',
	'server' => 'localhost',
	'username' => 'usuario-do-banco-de-dados',
	'password' => 'senha-do-banco-de-dados',
	'charset' => 'utf8',
 
	// optional
	'port' => 3306,
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
]);

?>
{
    "farmacias": [
		<?php
		if($_GET['consulta']=='todos'){
			$countfarmacias = $database->count("farmacias", ["farmacias.id_cidade[=]" => "4308508"]);
			$farmacias = $database->select("farmacias", [
				"[>]cidade" => ["id_cidade" => "id_cidade"]
			],[
				"farmacias.id_farmacias",
				"farmacias.farmacia",
				"farmacias.endereco",
				"farmacias.latitude",
				"farmacias.longitude",
				"farmacias.manipulacao",
				"farmacias.farmaciapopular",
				"farmacias.teleentrega",
				"farmacias.aceitacartao",
				"cidade.nome",
				"cidade.uf"
			],[
				"farmacias.id_cidade[=]" => "4308508",
				"ORDER" => ['farmacias.farmacia DESC']
			]);
		}elseif($_GET['consulta']=='manipulacao'){
			$countfarmacias = $database->count("farmacias", ["AND" => ["farmacias.id_cidade[=]" => "4308508","farmacias.manipulacao[=]" => "1"]]);
			$farmacias = $database->select("farmacias", [
				"[>]cidade" => ["id_cidade" => "id_cidade"]
			],[
				"farmacias.id_farmacias",
				"farmacias.farmacia",
				"farmacias.endereco",
				"farmacias.latitude",
				"farmacias.longitude",
				"farmacias.manipulacao",
				"farmacias.farmaciapopular",
				"farmacias.teleentrega",
				"farmacias.aceitacartao",
				"cidade.nome",
				"cidade.uf"
			],[
				"AND" => [
					"farmacias.id_cidade[=]" => "4308508",
					"farmacias.manipulacao[=]" => "1"
				],
				"ORDER" => ['farmacias.farmacia DESC']
			]);
		}elseif($_GET['consulta']=='entrega'){
			$countfarmacias = $database->count("farmacias", ["AND" => ["farmacias.id_cidade[=]" => "4308508","farmacias.teleentrega[=]" => "1"]]);
			$farmacias = $database->select("farmacias", [
				"[>]cidade" => ["id_cidade" => "id_cidade"]
			],[
				"farmacias.id_farmacias",
				"farmacias.farmacia",
				"farmacias.endereco",
				"farmacias.latitude",
				"farmacias.longitude",
				"farmacias.manipulacao",
				"farmacias.farmaciapopular",
				"farmacias.teleentrega",
				"farmacias.aceitacartao",
				"cidade.nome",
				"cidade.uf"
			],[
				"AND" => [
					"farmacias.id_cidade[=]" => "4308508",
					"farmacias.teleentrega[=]" => "1"
				],
				"ORDER" => ['farmacias.farmacia DESC']
			]);
		}else{}
		foreach($farmacias as $data){
			$id_farmacias = $data['id_farmacias'];
		?>
		{
            "id": <?php echo $id_farmacias; ?>,
            "nome": "<?php echo $data['farmacia']; ?>",
            "endereco": "<?php echo $data['endereco']; ?>, Frederico Westphalen - RS, Brasil",
            "latitude": "<?php echo $data['latitude']; ?>",
            "longitude": "<?php echo $data['longitude']; ?>",
            "extra": {
                "manipulacao": "<?php if($data['manipulacao'] == 1){echo 'sim';}else{echo 'nao';} ?>",
                "farmaciapopular": "<?php if($data['farmaciapopular'] == 1){echo 'sim';}else{echo 'nao';} ?>",
                "teleentrega": "<?php if($data['teleentrega'] == 1){echo 'sim';}else{echo 'nao';} ?>",
                "aceitacartao": "<?php if($data['aceitacartao'] == 1){echo 'sim';}else{echo 'nao';} ?>"
            },
            "telefone": [
				<?php
				$counttelefone = $database->count("telefone", ["id_farmacias[=]" => "".$id_farmacias.""]);
				$telefone = $database->select("telefone", [
					"ddd",
					"telefone",
					"complemento"
				],[
					"id_farmacias[=]" => "".$id_farmacias.""
				]);
				if($counttelefone==0){}else{
				foreach($telefone as $data){
				?>
                {
                    "ddd": <?php echo $data['ddd']; ?>,
                    "numero": "<?php echo $data['telefone']; ?>",
                    "tipo": "<?php echo $data['complemento']; ?>"
				<?php
				$counttelefone=$counttelefone-1;
				if($counttelefone==0){echo "}";}else{echo "},";}
				}}
				?>
            ],
            "funcionamento": [
				<?php $domingo = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$id_farmacias."","diasemana[=]" => "0"]]); ?>
                {
                    "diasemana": "0",
					"abertura": "<?php echo $domingo[0]['abertura']; ?>",
					"fechamento": "<?php echo $domingo[0]['fechamento']; ?>"
                },
				<?php $segunda = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$id_farmacias."","diasemana[=]" => "1"]]); ?>
                {
                    "diasemana": "1",
					"abertura": "<?php echo $segunda[0]['abertura']; ?>",
					"fechamento": "<?php echo $segunda[0]['fechamento']; ?>"
                },
				<?php $terca = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$id_farmacias."","diasemana[=]" => "2"]]); ?>
                {
                    "diasemana": "2",
					"abertura": "<?php echo $terca[0]['abertura']; ?>",
					"fechamento": "<?php echo $terca[0]['fechamento']; ?>"
                },
				<?php $quarta = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$id_farmacias."","diasemana[=]" => "3"]]); ?>
				{
                    "diasemana": "3",
					"abertura": "<?php echo $quarta[0]['abertura']; ?>",
					"fechamento": "<?php echo $quarta[0]['fechamento']; ?>"
                },
				<?php $quinta = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$id_farmacias."","diasemana[=]" => "4"]]); ?>
				{
                    "diasemana": "4",
					"abertura": "<?php echo $quinta[0]['abertura']; ?>",
					"fechamento": "<?php echo $quinta[0]['fechamento']; ?>"
                },
				<?php $sexta = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$id_farmacias."","diasemana[=]" => "5"]]); ?>
				{
                    "diasemana": "5",
					"abertura": "<?php echo $sexta[0]['abertura']; ?>",
					"fechamento": "<?php echo $sexta[0]['fechamento']; ?>"
                },
				<?php $sabado = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$id_farmacias."","diasemana[=]" => "6"]]); ?>
				{
                    "diasemana": "6",
					"abertura": "<?php echo $sabado[0]['abertura']; ?>",
					"fechamento": "<?php echo $sabado[0]['fechamento']; ?>"
                }
            ]
		<?php
		$countfarmacias=$countfarmacias-1;
		if($countfarmacias==0){echo "}";}else{echo "},";}
		}
		?>
    ]
}

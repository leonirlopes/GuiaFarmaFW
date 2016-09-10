<!DOCTYPE html><html lang="pt-BR"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>GuiaFarmaFW</title><!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--><link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cosmo/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"><!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script><script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]--></head><body><div class="container"><div class="row text-center"><div class="col-md-12"><h1>[ GUIA FARMA FW ]</h1></div></div></div><div class="container"><div class="row">
<?php
require 'medoo.min.php'; // framework Medoo.in
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
if($_GET['pagina']==''){
?>
<div class="col-md-8">
	<a href="?pagina=cadastrar" class="btn btn-primary btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Cadastrar Farmácia</a>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Farmácia</th>
					<th>Cidade</th>
					<th>Ações</th>
				</tr>
				<tbody>
				<?php
					$farmacias = $database->select("farmacias", [
						"[>]cidade" => ["id_cidade" => "id_cidade"]
					],[
						"farmacias.id_farmacias",
						"farmacias.farmacia",
						"cidade.nome",
						"cidade.uf"
					],["ORDER" => ['cidade.uf ASC', 'cidade.nome ASC', 'farmacias.farmacia ASC']]);
					foreach($farmacias as $data){
						echo '<tr><th scope="row">'.$data["id_farmacias"].'</th><td>'.$data["farmacia"].'</td><td>'.$data["nome"].'/'.$data["uf"].'</td><td><a href="?pagina=visualizar&farmacia='.$data["id_farmacias"].'" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-eye-open"></span> Visualizar</a> <a href="?pagina=editar&farmacia='.$data["id_farmacias"].'" class="btn btn-primary btn-info"><span class="glyphicon glyphicon-pencil"></span> Editar</a> <a href="?pagina=excluir&farmacia='.$data["id_farmacias"].'" class="btn btn-primary btn-danger"><span class="glyphicon glyphicon-trash"></span> Excluir</a></td></tr>';
					}
				?>
				</tbody>
			</thead>
		</table>
	</div>
</div>
<div class="col-md-4"><?php print_r($_GET); ?></div>
<?php } elseif ($_GET['pagina']=='cadastrar'){ ?>
<div class="col-md-8">
<h2>CADASTRAR FARMÁCIA</h2>
<?php if($_POST){
	$ultima_farmacia = $database->insert("farmacias", [
		"farmacia" => "".$_POST['farmacia']."",
		"endereco" => "".$_POST['endereco']."",
		"latitude" => "".$_POST['latitude']."",
		"longitude" => "".$_POST['longitude']."",
		"teleentrega" => "".$_POST['teleentrega']."",
		"farmaciapopular" => "".$_POST['farmaciapopular']."",
		"manipulacao" => "".$_POST['manipulacao']."",
		"aceitacartao" => "".$_POST['aceitacartao']."",
		"id_cidade" => "".$_POST['id_cidade'].""
	]);
	if($ultima_farmacia<>0){
		if($_POST['ddda']<>'' && $_POST['telefonea']<>''){
			if($_POST['complementoa']==''){$complemento;}else{$complemento = "".$_POST['complementoa']."";}
			$database->insert("telefone", [
				"ddd" => "".$_POST['ddda']."",
				"telefone" => "".$_POST['telefonea']."",
				"complemento" => $complemento,
				"id_farmacias" => "".$ultima_farmacia.""
			]);
		}
		if($_POST['dddb']<>'' && $_POST['telefoneb']<>''){
			if($_POST['complementob']==''){$complemento;}else{$complemento = "".$_POST['complementob']."";}
			$database->insert("telefone", [
				"ddd" => "".$_POST['dddb']."",
				"telefone" => "".$_POST['telefoneb']."",
				"complemento" => $complemento,
				"id_farmacias" => "".$ultima_farmacia.""
			]);
		}
		if($_POST['dddc']<>'' && $_POST['telefonec']<>''){
			if($_POST['complementoc']==''){$complemento;}else{$complemento = "".$_POST['complementoc']."";}
			$database->insert("telefone", [
				"ddd" => "".$_POST['dddc']."",
				"telefone" => "".$_POST['telefonec']."",
				"complemento" => $complemento,
				"id_farmacias" => "".$ultima_farmacia.""
			]);
		}
		if($_POST['diasemana0']<>'' && $_POST['abertura0']<>'' && $_POST['fechamento0']<>''){
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "".$_POST['diasemana0']."","abertura" => "".$_POST['abertura0']."","fechamento" => "".$_POST['fechamento0'].""]);
		} else {
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "0","abertura" => "0000","fechamento" => "0000"]);
		}
		if($_POST['diasemana1']<>'' && $_POST['abertura1']<>'' && $_POST['fechamento1']<>''){
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "".$_POST['diasemana1']."","abertura" => "".$_POST['abertura1']."","fechamento" => "".$_POST['fechamento1'].""]);
		} else {
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "1","abertura" => "0000","fechamento" => "0000"]);
		}
		if($_POST['diasemana2']<>'' && $_POST['abertura2']<>'' && $_POST['fechamento2']<>''){
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "".$_POST['diasemana2']."","abertura" => "".$_POST['abertura2']."","fechamento" => "".$_POST['fechamento2'].""]);
		} else {
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "2","abertura" => "0000","fechamento" => "0000"]);
		}
		if($_POST['diasemana3']<>'' && $_POST['abertura3']<>'' && $_POST['fechamento3']<>''){
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "".$_POST['diasemana3']."","abertura" => "".$_POST['abertura3']."","fechamento" => "".$_POST['fechamento3'].""]);
		} else {
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "3","abertura" => "0000","fechamento" => "0000"]);
		}
		if($_POST['diasemana4']<>'' && $_POST['abertura4']<>'' && $_POST['fechamento4']<>''){
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "".$_POST['diasemana4']."","abertura" => "".$_POST['abertura4']."","fechamento" => "".$_POST['fechamento4'].""]);
		} else {
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "4","abertura" => "0000","fechamento" => "0000"]);
		}
		if($_POST['diasemana5']<>'' && $_POST['abertura5']<>'' && $_POST['fechamento5']<>''){
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "".$_POST['diasemana5']."","abertura" => "".$_POST['abertura5']."","fechamento" => "".$_POST['fechamento5'].""]);
		} else {
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "5","abertura" => "0000","fechamento" => "0000"]);
		}
		if($_POST['diasemana6']<>'' && $_POST['abertura6']<>'' && $_POST['fechamento6']<>''){
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "".$_POST['diasemana6']."","abertura" => "".$_POST['abertura6']."","fechamento" => "".$_POST['fechamento6'].""]);
		} else {
			$database->insert("funcionamento", ["id_farmacias" => "".$ultima_farmacia."","diasemana" => "6","abertura" => "0000","fechamento" => "0000"	]);
		}
		echo "FARMÁCIA CADASTRADA";
	} else {echo var_dump($database->error());}
} else { ?>
<form method="POST" action="/admin/?pagina=cadastrar" accept-charset="utf-8">
	<label>Farmácia: </label><input type="text" name="farmacia" value="" class="form-control" id="farmacia" required>
	<label>Endereço: </label><input type="text" name="endereco" value="" class="form-control" id="endereco" required>
	<label>Cidade/UF: </label>
	<select id="id_cidade" name="id_cidade" class="form-control">
	<?php $cidade = $database->select("cidade", ["id_cidade","nome","uf"]);
	foreach($cidade as $data){echo '<option value="'.$data['id_cidade'].'">'.$data['nome'].'/'.$data['uf'].'</option>';}
	?>
	</select>
	<hr>
	<label>Tele-Entrega: </label>
	<div class="radio">
		<label>
			<input type="radio" name="teleentrega" value="0" checked="checked" id="teleentrega"> Não
		</label><br>
		<label>
			<input type="radio" name="teleentrega" value="1" id="teleentrega"> Sim
		</label>
	</div>
	<label>Farmácia Popular: </label>
	<div class="radio">
		<label>
			<input type="radio" name="farmaciapopular" value="0" checked="checked" id="farmaciapopular"> Não
		</label><br>
		<label>
			<input type="radio" name="farmaciapopular" value="1" id="farmaciapopular"> Sim
		</label>
	</div>
	<label>Manipulação de Medicamentos:: </label>
	<div class="radio">
		<label>
			<input type="radio" name="manipulacao" value="0" checked="checked" id="manipulacao"> Não
		</label><br>
		<label>
			<input type="radio" name="manipulacao" value="1" id="manipulacao"> Sim
		</label>
	</div>
	<label>Aceita Cartão de Crédito/Débito: </label>
	<div class="radio">
		<label>
			<input type="radio" name="aceitacartao" value="0" checked="checked" id="aceitacartao"> Não
		</label><br>
		<label>
			<input type="radio" name="aceitacartao" value="1" id="aceitacartao"> Sim
		</label>
	</div>
	<hr>
    <label>Latitude: </label><input type="text" name="latitude" value="" class="form-control" placeholder="Ex.: -27.356978974971824" id="latitude" required>
    <label>Longitude: </label><input type="text" name="longitude" value="" class="form-control" placeholder="Ex.: -53.39530262765879" id="longitude" required>
    <hr>
	<label>DDD: </label><input type="text" name="ddda" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="ddda">
	<label>Número do Telefone: </label><input type="text" name="telefonea" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonea">
	<label>Complemento do Telefone: </label><input type="text" name="complementoa" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoa"><br>
	<label>DDD: </label><input type="text" name="dddb" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddb">
	<label>Número do Telefone: </label><input type="text" name="telefoneb" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefoneb">
	<label>Complemento do Telefone: </label><input type="text" name="complementob" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementob"><br>
	<label>DDD: </label><input type="text" name="dddc" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddc">
	<label>Número do Telefone: </label><input type="text" name="telefonec" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonec">
	<label>Complemento do Telefone: </label><input type="text" name="complementoc" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoc"><br>
	<hr>
	<label>Domingo</label><br><input type="hidden" name="diasemana0" value="0" class="form-control" id="diasemana0">
	<label>Abertura: </label><input type="number" name="abertura0" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 1400" id="abertura0">
	<label>Fechamento: </label><input type="number" name="fechamento0" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1900" id="fechamento0">
	<label>Segunda-Feira</label><br><input type="hidden" name="diasemana1" value="1" id="diasemana1">
	<label>Abertura: </label><input type="number" name="abertura1" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura1">
	<label>Fechamento: </label><input type="number" name="fechamento1" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento1">
	<label>Terça-Feira</label><br><input type="hidden" name="diasemana2" value="2" id="diasemana2">
	<label>Abertura: </label><input type="number" name="abertura2" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura2">
	<label>Fechamento: </label><input type="number" name="fechamento2" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento2">
	<label>Quarta-Feira</label><br><input type="hidden" name="diasemana3" value="3" id="diasemana3">
	<label>Abertura: </label><input type="number" name="abertura3" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura3">
	<label>Fechamento: </label><input type="number" name="fechamento3" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento3">
	<label>Quinta-Feira</label><br><input type="hidden" name="diasemana4" value="4" id="diasemana4">
	<label>Abertura: </label><input type="number" name="abertura4" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura4">
	<label>Fechamento: </label><input type="number" name="fechamento4" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento4">
	<label>Sexta-Feira</label><br><input type="hidden" name="diasemana5" value="5" id="diasemana5">
	<label>Abertura: </label><input type="number" name="abertura5" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura5">
	<label>Fechamento: </label><input type="number" name="fechamento5" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento5">
	<label>Sábado</label><br><input type="hidden" name="diasemana6" value="6" id="diasemana6">
	<label>Abertura: </label><input type="number" name="abertura6" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura6">
	<label>Fechamento: </label><input type="number" name="fechamento6" value="" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento6">
	<br>
	<input type="submit" name="cadastrar" value="Cadastrar" id="btnCadCat" class="btn btn-large btn-primary btn-block">
</form>
<?php } ?>
</div>
<div class="col-md-4"><a href="/admin" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Voltar</a><br><?php print_r($_GET); ?></div>
<?php } elseif ($_GET['pagina']=='visualizar'){ ?>
<div class="col-md-8"><h2>FARMÁCIA</h2><hr><?php if($database->has("farmacias", ["id_farmacias" => "".$_GET['farmacia'].""])){
	$farmacias = $database->select("farmacias",["[>]cidade" => ["id_cidade" => "id_cidade"]], ["farmacias.id_farmacias","farmacias.farmacia","farmacias.endereco","farmacias.latitude","farmacias.longitude","farmacias.teleentrega","farmacias.farmaciapopular","farmacias.manipulacao","farmacias.aceitacartao","cidade.nome","cidade.uf"], ["id_farmacias[=]" => "".$_GET['farmacia'].""]);if($farmacias[0]['teleentrega']=='1'){$teleentrega="sim";}else{$teleentrega="não";}if($farmacias[0]['farmaciapopular']=='1'){$farmaciapopular="sim";}else{$farmaciapopular="não";}if($farmacias[0]['manipulacao']=='1'){$manipulacao="sim";}else{$manipulacao="não";}if($farmacias[0]['aceitacartao']=='1'){$aceitacartao="sim";}else{$aceitacartao="não";}echo "<strong>ID:</strong> ".$farmacias[0]['id_farmacias']."<br><strong>FARMÁCIA:</strong> ".$farmacias[0]['farmacia']."<br><strong>ENDEREÇO:</strong> ".$farmacias[0]['endereco']." - ".$farmacias[0]['nome']."/".$farmacias[0]['uf']."<hr><strong>FARMÁCIA POPULAR:</strong> ".$farmaciapopular."<br><strong>TELE-ENTREGA:</strong> ".$teleentrega."<br><strong>FARMÁCIA DE MANIPULAÇÃO:</strong> ".$manipulacao."<br><strong>ACEITA CARTÃO DE CRÉDITO/DÉBITO:</strong> ".$aceitacartao."<hr><strong>LATITUDE:</strong> ".$farmacias[0]['latitude']."<br><strong>LONGITUDE:</strong> ".$farmacias[0]['longitude']."<br><strong>MAPA:</strong><br><img src=\"https://maps.googleapis.com/maps/api/staticmap?center=".$farmacias[0]['latitude'].",+".$farmacias[0]['longitude']."&zoom=16&scale=1&size=640x250&maptype=roadmap&sensor=false&key=AIzaSyBHpHj013C06Ptmgoip56fjXGVrUnvhePE&format=png&visual_refresh=true&markers=icon:http://oi58.tinypic.com/ka4d2o.jpg|".$farmacias[0]['latitude'].",".$farmacias[0]['longitude']."\" class=\"img-responsive\"><hr>";$telefone = $database->select("telefone", ["ddd","telefone","complemento"], ["id_farmacias[=]" => "".$farmacias[0]['id_farmacias'].""]);foreach($telefone as $data){if($data['complemento']<>NULL){$complemento=" - ".$data['complemento'];}else{$complemento='';}echo "<strong>TELEFONE</strong> ".$data["ddd"]." ".$data["telefone"].$complemento."<br>";}echo "<hr>";$telefone = $database->select("telefone", ["ddd","telefone","complemento"], ["id_farmacias[=]" => "".$farmacias[0]['id_farmacias'].""]);$funcionamento = $database->select("funcionamento", ["diasemana","abertura","fechamento"], ["id_farmacias[=]" => "".$farmacias[0]['id_farmacias']."","ORDER" => ['diasemana ASC', 'abertura ASC']]);
	foreach($funcionamento as $data){
	if($data['diasemana']==0){$diasemana="Domingo";}elseif($data['diasemana']==1){$diasemana="Segunda-Feira";}elseif($data['diasemana']==2){$diasemana="Terça-Feira";}elseif($data['diasemana']==3){$diasemana="Quarta-Feira";}elseif($data['diasemana']==4){$diasemana="Quinta-Feira";}elseif($data['diasemana']==5){$diasemana="Sexta-Feira";}else{$diasemana="Sábado";}
		echo "<strong>".$diasemana."</strong> ".$data['abertura']." - ".$data['fechamento']."<br>";
	}
echo "<hr>";} else {echo "Ops!";} ?></div>
<div class="col-md-4"><a href="/admin" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Voltar</a><br><?php print_r($_GET); ?></div>
<?php } elseif ($_GET['pagina']=='editar'){ ?>
<div class="col-md-8">

<?php if ($database->has("farmacias", ["id_farmacias" => "".$_GET['farmacia'].""])){?>
<h2>EDITAR FARMÁCIA</h2>
<?php if($_POST){
	$database->update("farmacias", [
		"farmacia" => "".$_POST['farmacia']."",
		"endereco" => "".$_POST['endereco']."",
		"latitude" => "".$_POST['latitude']."",
		"longitude" => "".$_POST['longitude']."",
		"teleentrega" => "".$_POST['teleentrega']."",
		"farmaciapopular" => "".$_POST['farmaciapopular']."",
		"manipulacao" => "".$_POST['manipulacao']."",
		"aceitacartao" => "".$_POST['aceitacartao']."",
		"id_cidade" => "".$_POST['id_cidade'].""
	], ["id_farmacias[=]" => "".$_POST['id_farmacias'].""]);
	$ultima_farmacia = $_POST['id_farmacias'];
	$database->delete("telefone", ["id_farmacias[=]" => "".$ultima_farmacia.""]);
	if($ultima_farmacia<>0){
		if($_POST['ddda']<>'' && $_POST['telefonea']<>''){
			if($_POST['complementoa']==''){$complemento;}else{$complemento = "".$_POST['complementoa']."";}
			$database->insert("telefone", [
				"ddd" => "".$_POST['ddda']."",
				"telefone" => "".$_POST['telefonea']."",
				"complemento" => $complemento,
				"id_farmacias" => "".$ultima_farmacia.""
			]);
		}
		if($_POST['dddb']<>'' && $_POST['telefoneb']<>''){
			if($_POST['complementob']==''){$complemento;}else{$complemento = "".$_POST['complementob']."";}
			$database->insert("telefone", [
				"ddd" => "".$_POST['dddb']."",
				"telefone" => "".$_POST['telefoneb']."",
				"complemento" => $complemento,
				"id_farmacias" => "".$ultima_farmacia.""
			]);
		}
		if($_POST['dddc']<>'' && $_POST['telefonec']<>''){
			if($_POST['complementoc']==''){$complemento;}else{$complemento = "".$_POST['complementoc']."";}
			$database->insert("telefone", [
				"ddd" => "".$_POST['dddc']."",
				"telefone" => "".$_POST['telefonec']."",
				"complemento" => $complemento,
				"id_farmacias" => "".$ultima_farmacia.""
			]);
		}
		if($_POST['diasemana0']<>'' && $_POST['abertura0']<>'' && $_POST['fechamento0']<>''){
			$database->update("funcionamento", ["abertura" => "".$_POST['abertura0']."","fechamento" => "".$_POST['fechamento0'].""],["AND" => ["diasemana"=> 0, "id_farmacias" => "".$ultima_farmacia.""]]);
		} else {
			$database->update("funcionamento", ["abertura" => "0000","fechamento" => "0000"],["AND" => ["diasemana"=> 0, "id_farmacias" => "".$ultima_farmacia.""]]);
		}
		if($_POST['diasemana1']<>'' && $_POST['abertura1']<>'' && $_POST['fechamento1']<>''){
			$database->update("funcionamento", ["abertura" => "".$_POST['abertura1']."","fechamento" => "".$_POST['fechamento1'].""],["AND" => ["diasemana"=> 1, "id_farmacias" => "".$ultima_farmacia.""]]);
		} else {
			$database->update("funcionamento", ["abertura" => "0000","fechamento" => "0000"],["AND" => ["diasemana"=> 1, "id_farmacias" => "".$ultima_farmacia.""]]);
		}
		if($_POST['diasemana2']<>'' && $_POST['abertura2']<>'' && $_POST['fechamento2']<>''){
			$database->update("funcionamento", ["abertura" => "".$_POST['abertura2']."","fechamento" => "".$_POST['fechamento2'].""],["AND" => ["diasemana"=> 2, "id_farmacias" => "".$ultima_farmacia.""]]);
		} else {
			$database->update("funcionamento", ["abertura" => "0000","fechamento" => "0000"],["AND" => ["diasemana"=> 2, "id_farmacias" => "".$ultima_farmacia.""]]);
		}
		if($_POST['diasemana3']<>'' && $_POST['abertura3']<>'' && $_POST['fechamento3']<>''){
			$database->update("funcionamento", ["abertura" => "".$_POST['abertura3']."","fechamento" => "".$_POST['fechamento3'].""],["AND" => ["diasemana"=> 3, "id_farmacias" => "".$ultima_farmacia.""]]);
		} else {
			$database->update("funcionamento", ["abertura" => "0000","fechamento" => "0000"],["AND" => ["diasemana"=> 3, "id_farmacias" => "".$ultima_farmacia.""]]);
		}
		if($_POST['diasemana4']<>'' && $_POST['abertura4']<>'' && $_POST['fechamento4']<>''){
			$database->update("funcionamento", ["abertura" => "".$_POST['abertura4']."","fechamento" => "".$_POST['fechamento4'].""],["AND" => ["diasemana"=> 4, "id_farmacias" => "".$ultima_farmacia.""]]);
		} else {
			$database->update("funcionamento", ["abertura" => "0000","fechamento" => "0000"],["AND" => ["diasemana"=> 4, "id_farmacias" => "".$ultima_farmacia.""]]);
		}
		if($_POST['diasemana5']<>'' && $_POST['abertura5']<>'' && $_POST['fechamento5']<>''){
			$database->update("funcionamento", ["abertura" => "".$_POST['abertura5']."","fechamento" => "".$_POST['fechamento5'].""],["AND" => ["diasemana"=> 5, "id_farmacias" => "".$ultima_farmacia.""]]);
		} else {
			$database->update("funcionamento", ["abertura" => "0000","fechamento" => "0000"],["AND" => ["diasemana"=> 5, "id_farmacias" => "".$ultima_farmacia.""]]);
		}
		if($_POST['diasemana6']<>'' && $_POST['abertura6']<>'' && $_POST['fechamento6']<>''){
			$database->update("funcionamento", ["abertura" => "".$_POST['abertura6']."","fechamento" => "".$_POST['fechamento6'].""],["AND" => ["diasemana"=> 6, "id_farmacias" => "".$ultima_farmacia.""]]);
		} else {
			$database->update("funcionamento", ["abertura" => "0000","fechamento" => "0000"	],["AND" => ["diasemana"=> 6, "id_farmacias" => "".$ultima_farmacia.""]]);
		}
		echo "FARMÁCIA ATUALIZADA";
	} else {echo var_dump($database->error());}
} else { ?>
<form method="POST" action="/admin/?pagina=editar&farmacia=<?php echo $_GET['farmacia']; ?>" accept-charset="utf-8">
<?php
$farmacias = $database->select("farmacias", ["farmacia","endereco","latitude","longitude","teleentrega","farmaciapopular","manipulacao","aceitacartao","id_cidade"], ["id_farmacias" => "".$_GET['farmacia'].""]);
?>
	<input id="id_farmacias" name="id_farmacias" type="hidden" value="<?php echo $_GET['farmacia']; ?>">
	<label>Farmácia: </label><input type="text" name="farmacia" value="<?php echo $farmacias[0]['farmacia']; ?>" class="form-control" id="farmacia" required>
	<label>Endereço: </label><input type="text" name="endereco" value="<?php echo $farmacias[0]['endereco']; ?>" class="form-control" id="endereco" required>
	<label>Cidade/UF: </label>
	<select id="id_cidade" name="id_cidade" class="form-control">
	<?php $cidade = $database->select("cidade", ["id_cidade","nome","uf"]);
	foreach($cidade as $data){
		if($data['id_cidade']==$farmacias[0]['id_cidade']){$selecionado="selected";}else{$selecionado="";}
		echo '<option value="'.$data['id_cidade'].'" '.$selecionado.'>'.$data['nome'].'/'.$data['uf'].'</option>';
	}
	?>
	</select>
	<hr>
	<label>Tele-Entrega: </label>
	<div class="radio">
		<label>
			<?php if($farmacias[0]['teleentrega']=='0'){$teleentregan='checked="checked"';}else{$teleentregan='';} ?>
			
			<input type="radio" name="teleentrega" value="0" <?php echo $teleentregan; ?> id="teleentrega"> Não
		</label><br>
		<label>
			<?php if($farmacias[0]['teleentrega']=='1'){$teleentregas='checked="checked"';}else{$teleentregas='';} ?>
			<input type="radio" name="teleentrega" value="1" <?php echo $teleentregas; ?> id="teleentrega"> Sim
		</label>
	</div>
	<label>Farmácia Popular: </label>
	<div class="radio">
		<label>
			<?php if($farmacias[0]['farmaciapopular']=='0'){$farmaciapopularn='checked="checked"';}else{$farmaciapopularn='';} ?>
			<input type="radio" name="farmaciapopular" value="0" <?php echo $farmaciapopularn; ?> id="farmaciapopular"> Não
		</label><br>
		<label>
			<?php if($farmacias[0]['farmaciapopular']=='1'){$farmaciapopulars='checked="checked"';}else{$farmaciapopulars='';} ?>
			<input type="radio" name="farmaciapopular" value="1" <?php echo $farmaciapopulars; ?> id="farmaciapopular"> Sim
		</label>
	</div>
	<label>Manipulação de Medicamentos:: </label>
	<div class="radio">
		<label>
			<?php if($farmacias[0]['manipulacao']=='0'){$manipulacaon='checked="checked"';}else{$manipulacaon='';} ?>
			<input type="radio" name="manipulacao" value="0" <?php echo $manipulacaon; ?> id="manipulacao"> Não
		</label><br>
		<label>
			<?php if($farmacias[0]['manipulacao']=='1'){$manipulacaos='checked="checked"';}else{$manipulacaos='';} ?>
			<input type="radio" name="manipulacao" value="1" <?php echo $manipulacaos; ?> id="manipulacao"> Sim
		</label>
	</div>
	<label>Aceita Cartão de Crédito/Débito: </label>
	<div class="radio">
		<label>
			<?php if($farmacias[0]['aceitacartao']=='0'){$aceitacartaon='checked="checked"';}else{$aceitacartaon='';} ?>
			<input type="radio" name="aceitacartao" value="0" <?php echo $aceitacartaon; ?> id="aceitacartao"> Não
		</label><br>
		<label>
			<?php if($farmacias[0]['aceitacartao']=='1'){$aceitacartaos='checked="checked"';}else{$aceitacartaos='';} ?>
			<input type="radio" name="aceitacartao" value="1" <?php echo $aceitacartaos; ?> id="aceitacartao"> Sim
		</label>
	</div>
	<hr>
    <label>Latitude: </label><input type="text" name="latitude" value="<?php echo $farmacias[0]['latitude']; ?>" class="form-control" placeholder="Ex.: -27.356978974971824" id="latitude" required>
    <label>Longitude: </label><input type="text" name="longitude" value="<?php echo $farmacias[0]['longitude']; ?>" class="form-control" placeholder="Ex.: -53.39530262765879" id="longitude" required>
	<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $farmacias[0]['latitude']; ?>,+<?php echo $farmacias[0]['longitude']; ?>&zoom=16&scale=1&size=640x250&maptype=roadmap&sensor=false&key=AIzaSyBHpHj013C06Ptmgoip56fjXGVrUnvhePE&format=png&visual_refresh=true&markers=icon:http://oi58.tinypic.com/ka4d2o.jpg|<?php echo $farmacias[0]['latitude']; ?>,<?php echo $farmacias[0]['longitude']; ?>" class="img-responsive">
    <hr>
	<?php $count = $database->count("telefone", ["id_farmacias" => "".$_GET['farmacia'].""]);
		if($count==0){ ?>
	<label>DDD: </label><input type="text" name="ddda" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="ddda">
	<label>Número do Telefone: </label><input type="text" name="telefonea" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonea">
	<label>Complemento do Telefone: </label><input type="text" name="complementoa" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoa"><br>
	<label>DDD: </label><input type="text" name="dddb" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddb">
	<label>Número do Telefone: </label><input type="text" name="telefoneb" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefoneb">
	<label>Complemento do Telefone: </label><input type="text" name="complementob" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementob"><br>
	<label>DDD: </label><input type="text" name="dddc" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddc">
	<label>Número do Telefone: </label><input type="text" name="telefonec" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonec">
	<label>Complemento do Telefone: </label><input type="text" name="complementoc" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoc"><br>
	<?php } elseif($count==1){
	$telefone = $database->select("telefone", ["ddd","telefone","complemento"], ["id_farmacias[=]" => "".$_GET['farmacia'].""]); ?>
	<label>DDD: </label><input type="text" name="ddda" value="<?php echo $telefone[0]['ddd']; ?>" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="ddda">
	<label>Número do Telefone: </label><input type="text" name="telefonea" value="<?php echo $telefone[0]['telefone']; ?>" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonea">
	<label>Complemento do Telefone: </label><input type="text" name="complementoa" value="<?php echo $telefone[0]['complemento']; ?>" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoa"><br>
	<label>DDD: </label><input type="text" name="dddb" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddb">
	<label>Número do Telefone: </label><input type="text" name="telefoneb" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefoneb">
	<label>Complemento do Telefone: </label><input type="text" name="complementob" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementob"><br>
	<label>DDD: </label><input type="text" name="dddc" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddc">
	<label>Número do Telefone: </label><input type="text" name="telefonec" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonec">
	<label>Complemento do Telefone: </label><input type="text" name="complementoc" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoc"><br>
		<?php } elseif($count==2){
	$telefone = $database->select("telefone", ["ddd","telefone","complemento"], ["id_farmacias[=]" => "".$_GET['farmacia'].""]);
	foreach($telefone as $data){
		if($count==2){
	echo '<label>DDD: </label><input type="text" name="ddda" value="'.$data['ddd'].'" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="ddda">
	<label>Número do Telefone: </label><input type="text" name="telefonea" value="'.$data['telefone'].'" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonea">
	<label>Complemento do Telefone: </label><input type="text" name="complementoa" value="'.$data['complemento'].'" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoa"><br>';}else{
	echo '<label>DDD: </label><input type="text" name="dddb" value="'.$data['ddd'].'" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddb">
	<label>Número do Telefone: </label><input type="text" name="telefoneb" value="'.$data['telefone'].'" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefoneb">
	<label>Complemento do Telefone: </label><input type="text" name="complementob" value="'.$data['complemento'].'" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementob"><br>';}
	$count=$count-1;
} ?>
	<label>DDD: </label><input type="text" name="dddc" value="" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddc">
	<label>Número do Telefone: </label><input type="text" name="telefonec" value="" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonec">
	<label>Complemento do Telefone: </label><input type="text" name="complementoc" value="" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoc"><br>
		<?php } else {
	$telefone = $database->select("telefone", ["ddd","telefone","complemento"], ["id_farmacias[=]" => "".$_GET['farmacia'].""]);
	foreach($telefone as $data){
		if($count==3){
	echo '<label>DDD: </label><input type="text" name="ddda" value="'.$data['ddd'].'" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="ddda">
	<label>Número do Telefone: </label><input type="text" name="telefonea" value="'.$data['telefone'].'" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonea">
	<label>Complemento do Telefone: </label><input type="text" name="complementoa" value="'.$data['complemento'].'" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoa"><br>';}elseif($count==2){
	echo '<label>DDD: </label><input type="text" name="dddb" value="'.$data['ddd'].'" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddb">
	<label>Número do Telefone: </label><input type="text" name="telefoneb" value="'.$data['telefone'].'" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefoneb">
	<label>Complemento do Telefone: </label><input type="text" name="complementob" value="'.$data['complemento'].'" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementob"><br>';}else{
	echo '<label>DDD: </label><input type="text" name="dddc" value="'.$data['ddd'].'" class="form-control" placeholder="DDD do Telefone da Farmácia - 55" id="dddc">
	<label>Número do Telefone: </label><input type="text" name="telefonec" value="'.$data['telefone'].'" class="form-control" placeholder="Número do Telefone da Farmácia - 3744-xxxx" id="telefonec">
	<label>Complemento do Telefone: </label><input type="text" name="complementoc" value="'.$data['complemento'].'" class="form-control" placeholder="Complemento do Telefone da Farmácia - Ramal xx - Fax - Operadora x - Telefone de Emergência" id="complementoc"><br>';
	}
	$count=$count-1;
} ?>
		<?php } ?>
	<hr>
	<?php $domingo = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$_GET['farmacia']."","diasemana[=]" => "0"]]); ?>
	<label>Domingo</label><br><input type="hidden" name="diasemana0" value="0" class="form-control" id="diasemana0">
	<input type="hidden" name="id_funcionamento0" value="<?php echo $domingo[0]['fechamento']; ?>" class="form-control" id="id_funcionamento0">
	<label>Abertura: </label><input type="number" name="abertura0" value="<?php echo $domingo[0]['abertura']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 1400" id="abertura0">
	<label>Fechamento: </label><input type="number" name="fechamento0" value="<?php echo $domingo[0]['fechamento']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1900" id="fechamento0">
	<?php $segunda = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$_GET['farmacia']."","diasemana[=]" => "1"]]); ?>
	<label>Segunda-Feira</label><br><input type="hidden" name="diasemana1" value="1" id="diasemana1">
	<label>Abertura: </label><input type="number" name="abertura1" value="<?php echo $segunda[0]['abertura']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura1">
	<label>Fechamento: </label><input type="number" name="fechamento1" value="<?php echo $segunda[0]['fechamento']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento1">
	<?php $terca = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$_GET['farmacia']."","diasemana[=]" => "2"]]); ?>
	<label>Terça-Feira</label><br><input type="hidden" name="diasemana2" value="2" id="diasemana2">
	<label>Abertura: </label><input type="number" name="abertura2" value="<?php echo $terca[0]['abertura']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura2">
	<label>Fechamento: </label><input type="number" name="fechamento2" value="<?php echo $terca[0]['fechamento']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento2">
	<?php $quarta = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$_GET['farmacia']."","diasemana[=]" => "3"]]); ?>
	<label>Quarta-Feira</label><br><input type="hidden" name="diasemana3" value="3" id="diasemana3">
	<label>Abertura: </label><input type="number" name="abertura3" value="<?php echo $quarta[0]['abertura']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura3">
	<label>Fechamento: </label><input type="number" name="fechamento3" value="<?php echo $quarta[0]['fechamento']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento3">
	<?php $quinta = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$_GET['farmacia']."","diasemana[=]" => "4"]]); ?>
	<label>Quinta-Feira</label><br><input type="hidden" name="diasemana4" value="4" id="diasemana4">
	<label>Abertura: </label><input type="number" name="abertura4" value="<?php echo $quinta[0]['abertura']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura4">
	<label>Fechamento: </label><input type="number" name="fechamento4" value="<?php echo $quinta[0]['fechamento']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento4">
	<?php $sexta = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$_GET['farmacia']."","diasemana[=]" => "5"]]); ?>
	<label>Sexta-Feira</label><br><input type="hidden" name="diasemana5" value="5" id="diasemana5">
	<label>Abertura: </label><input type="number" name="abertura5" value="<?php echo $sexta[0]['abertura']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura5">
	<label>Fechamento: </label><input type="number" name="fechamento5" value="<?php echo $sexta[0]['fechamento']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento5">
	<?php $sabado = $database->select("funcionamento", ["id_funcionamento","abertura","fechamento"], ["AND" => ["id_farmacias[=]" => "".$_GET['farmacia']."","diasemana[=]" => "6"]]); ?>
	<label>Sábado</label><br><input type="hidden" name="diasemana6" value="6" id="diasemana6">
	<label>Abertura: </label><input type="number" name="abertura6" value="<?php echo $sabado[0]['abertura']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora da abertura do Turno - 0800" id="abertura6">
	<label>Fechamento: </label><input type="number" name="fechamento6" value="<?php echo $sabado[0]['fechamento']; ?>" pattern="^\d{4}$" class="form-control" placeholder="Hora do fechamento do Turno - 1200" id="fechamento6">
	<br>
	<input type="submit" name="editar" value="Editar" id="btnCadCat" class="btn btn-large btn-primary btn-block">
</form>
<?php }} else {header('HTTP/1.1 404 Not Found');header('Location: /admin');} ?>

</div>
<div class="col-md-4"><a href="/admin" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Voltar</a><br><?php print_r($_GET); ?></div>
<?php } elseif ($_GET['pagina']=='excluir'){ ?>
<div class="col-md-8"><h2>EXCLUIR FARMÁCIA</h2><?php if($_POST){
	$database->delete("telefone", ["id_farmacias[=]" => "".$_POST['id_farmacias'].""]);
	$database->delete("funcionamento", ["id_farmacias[=]" => "".$_POST['id_farmacias'].""]);
	$database->delete("farmacias", ["id_farmacias[=]" => "".$_POST['id_farmacias'].""]);
	echo "EXCLUÍDO";
}else{ ?><form method="POST" action="/admin/?pagina=excluir&farmacia=<?php echo $_GET['farmacia']; ?>"><input id="id_farmacias" name="id_farmacias" type="hidden" value="<?php echo $_GET['farmacia']; ?>"><button class="btn btn-lg btn-danger" name="excluir" type="submit"><span class="glyphicon glyphicon-trash"></span> Excluir</button></form><?php } ?></div><div class="col-md-4"><a href="/admin" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Voltar</a><br><?php print_r($_GET); ?></div>
<?php } ?>
</div><div class="row text-center"><div class="col-md-12"><h4>[ Bootstrap ] [ Bootswatch ] [ PHP ] [ Medoo ] [ MySQL ] - [ JSON ] [ Google Maps ] [ jQuery ] - [ Intel XDK ] [ App Framework ] [ Font Awesome ]</h4></div></div></div><script async defer src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><script async defer src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<html>
	<head>
		<meta charset="utf-8">
		<title>Knihovna</title>
		<link rel="stylesheet" href="style.css">	
	</head>
	<body>
<!-- formular pro ctenare-->		
<!-- konec formulare pro ctenare-->	
<!-- tabulka s ctenari-->
<div id="table">
<fieldset><legend>KAFE</legend>
	<?php
		include("connection.php");	//connection
		$sql="select types.typ, count(types.typ), people.name
		from drinks 
		INNER JOIN people
		ON people.ID = drinks.id_people
		INNER JOIN types
		ON types.ID = drinks.id_types
		group by people.name, types.typ;";	//sql select
		$result=$conn->query($sql);	//fetch data from db to result
	?>
	<table>
	<tr><th>Typ drinku</th><th>Počet</th><th>Jmeno</th>

	</tr>
	
	<?php
	if($result->num_rows>0){		//kontrola,zda jsme něco načetli
	while($row=$result->fetch_assoc()){
	?>
	<tr>
	<td><?php echo $row["typ"];?></td>
	<td><?php echo $row["count(types.typ)"];?></td>
	<td><?php echo $row["name"];?></td>
	</tr>
	<?php
		}	//konec while
	}else{					//konec podmínky if
		echo "0 results";
	}
	?>
	</table>
	<table>
	<tr><th>Typ drinku</th><th>Pocet</th><th>Datum</th><th>Kolik propil</th>
	<?php
		$sql = "select * from people;";
		$result=$conn->query($sql);
		$people="<select name = 'people'>";
		while($row=$result->fetch_assoc()){
			$people .= "<option value='".$row["name"]."'>".$row["name"]."</option>"; 
		}
		$people.="</select>";?>
		<form method = "POST">	
			<?php echo $people;?><br>
	  <input type="month" name="month" id="month" value=10>
	  <input type="submit" name="submit" id="submit">
		</form>
	  <?php
	 	 $mesic = explode("-", $_POST['month']);
		 $sql = "select people.name, count(types.typ), drinks.date, types.typ from drinks
		 inner join people on people.id = drinks.id_people
		 inner join types on types.id = drinks.id_types
		 where ".$mesic[1]." = (SELECT EXTRACT(MONTH FROM drinks.date)) and people.name = '".$_POST['people']."'
		 group by types.typ
		 order by typ;";
		
	 $result=$conn->query($sql);
	 
	?>
	<?php
		$drinks = "select types.typ from types group by types.typ;";
			$d=$conn->query($drinks);	
			while($row=$result->fetch_assoc()){
				$rowd=$d->fetch_assoc();
				if($row["typ"]=='MlĂ©ko'){
				$Mléko = $row["count(types.typ)"] * 50/1000*300;
				}
				if($row["typ"]=='Coffe'){
				$Coffe = $row["count(types.typ)"] * 14/1000*300;
				}
				if($row["typ"]=='Doppio+'){
				$Doppio = $row["count(types.typ)"] *21/1000*300;
				}
				if($row["typ"]=='Espresso'){
				$Espresso = $row["count(types.typ)"] * 7/1000*300;
				}
				if($row["typ"]=='Long'){
				$Long = $row["count(types.typ)"] * 14/1000*300;
				}
					

	?>
	<tr>
	<td><?php echo $row["typ"];?></td>
	<td><?php echo $row["count(types.typ)"];?></td>
	<td><?php echo $row["date"];?></td>
	<td>
		<?php
			if($rowd["typ"]=='MlĂ©ko'){
				echo $Mléko."Kč";
			}	
			if($rowd["typ"]=='Coffe'){
				echo $Coffe."Kč";
			}
			if($rowd["typ"]=='Doppio+'){
				echo $Doppio."Kč";
			}
			if($rowd["typ"]=='Espresso'){
				echo $Espresso."Kč";
			}
			if($rowd["typ"]=='Long'){
				echo $Long."Kč";
			}
		}	
		?>
	</td>
		</tr>		
</table>
</fieldset>
</div>
<!-- konec tabulky s ctenari-->

</body>
</html>
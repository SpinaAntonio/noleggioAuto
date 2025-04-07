<!DOCTYPE html>
<html>
<head>
	<title>cancella</title>
</head>
<body>
<?php
    $connection = mysqli_connect("localhost","root","","disneyland");
    $query = "SELECT nome FROM personaggi ORDER BY nome";
    $result = mysqli_query($connection,$query);
    if(mysqli_num_rows($result) !=0)
        {
     echo "<form action = 'cancella.php' method='GET'><br>";
     echo "Personaggio da eliminare:<br>";
     echo "<select name ='personaggio'>";
       while($row = mysqli_fetch_array($result))
       	  echo "<option value ='$row[nome]'>$row[nome]</option>";
     echo "</select><br><br>";
     echo "<input type = 'submit' value ='Cancella'>";
     echo "</form>";
    }
    else 
    	echo "nessun personaggio presente nel database";
    ?>
</body>
</html>
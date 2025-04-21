<!-- filepath: c:\wamp64\www\noleggioAuto\inserisciNoleggio.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Inserimento Noleggio</title>
    <link rel="stylesheet" href="stile.css">

</head>
<body>
    <?php
    // Connessione al database
    $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

    // Controllo connessione
    if (!$connection) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    // Recupero dei dati dal modulo
    $idNoleggio = $_POST['idNoleggio'];
    $targa = mysqli_real_escape_string($connection, $_POST['targaAuto']);;
    $CF = $_POST['codiceFiscale'];
    $dataInizio = $_POST['dataInizio'];
    $dataFine = $_POST['dataFine'];
    $restituita = isset($_POST['restituita']) ? 1 : 0; // Se la checkbox è selezionata, restituita = 1, altrimenti 0

    // Query per inserire il noleggio
    $query = "INSERT INTO Noleggi VALUES ('$idNoleggio', '$targa', '$CF', '$dataInizio', '$dataFine', '$restituita')";

    if (mysqli_query($connection, $query)) {
        echo "<p>Auto noleggiata con successo!</p>";
        echo "<table border='2'>";
        echo "<tr>";
        echo "<th>Codice Noleggio</th>";
        echo "<th>Targa</th>";
        echo "<th>Codice Fiscale</th>";
        echo "<th>Data Inizio</th>";
        echo "<th>Data Fine</th>";
        echo "<th>Restituita</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>$idNoleggio</td>";
        echo "<td>$targa</td>";
        echo "<td>$CF</td>";
        echo "<td>$dataInizio</td>";
        echo "<td>$dataFine</td>";
        echo "<td>" . ($restituita ? "Sì" : "No") . "</td>";
        echo "</tr>";
        echo "</table>";
    } else {
        echo "<p>Errore durante l'inserimento del noleggio: " . mysqli_error($connection) . "</p>";
    }

    // Chiusura connessione
    mysqli_close($connection);
    ?>
</body>
<a href="menu.html">Torna alla home</a>
</html>
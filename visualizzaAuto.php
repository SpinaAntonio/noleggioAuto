<!-- filepath: c:\wamp64\www\noleggioAuto\visualizzaAuto.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Auto Disponibili</title>
</head>
<body>
    <?php
    // Connessione al database
    $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

    // Controllo connessione
    if (!$connection) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    // Recupero delle date dal modulo
    $dataInizio = $_GET['dataInizio'];
    $dataFine = $_GET['dataFine'];

    // Query per trovare le auto disponibili
    $query = "
        SELECT a.targa, a.modello, a.marca
        FROM auto a
        WHERE a.targa NOT IN (
            SELECT n.auto
            FROM noleggi n
            WHERE (n.inizio <= '$dataInizio' AND n.fine >= '$dataInizio')
               OR (n.inizio <= '$dataFine' AND n.fine >= '$dataFine')
               OR (n.inizio >= '$dataInizio' AND n.fine <= '$dataFine')
        )
    ";

    $result = mysqli_query($connection, $query);

    // Visualizzazione delle auto disponibili
    if (mysqli_num_rows($result) != 0) {
        echo "<h1>Auto disponibili dal $dataInizio al $dataFine</h1>";
        echo "<table border='2'>";
        echo "<tr>";
        echo "<th>Targa</th>";
        echo "<th>Marca</th>";
        echo "<th>Modello</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>$row[targa]</td>";
            echo "<td>$row[marca]</td>";
            echo "<td>$row[modello]</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nessuna auto disponibile per il periodo selezionato.</p>";
    }
    
    // Chiusura connessione
    mysqli_close($connection);
    ?>
</body>
<a href="menu.html">Torna alla home</a>
</html>
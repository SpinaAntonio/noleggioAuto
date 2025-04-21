<?php
// Connessione al database
$connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

if (!$connection) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Recupero delle date e del socio dal modulo
$dataInizio = mysqli_real_escape_string($connection, $_GET['dataInizio']);
$dataFine = mysqli_real_escape_string($connection, $_GET['dataFine']);
$socioID = mysqli_real_escape_string($connection, $_GET['socioID']);

// Query per trovare i noleggi effettuati dal socio nel periodo
$query = "
    SELECT n.codice_noleggio, n.inizio, n.fine, a.marca, a.modello
    FROM noleggi n
    JOIN auto a ON n.auto = a.targa
    WHERE n.socio = '$socioID'
      AND n.inizio <= '$dataFine'
      AND n.fine >= '$dataInizio'
";

$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Noleggi effettuati dal socio $socioID dal $dataInizio al $dataFine</h1>";
    echo "<table border='2'>";
    echo "<tr>
            <th>Codice Noleggio</th>
            <th>Data Inizio</th>
            <th>Data Fine</th>
            <th>Marca Auto</th>
            <th>Modello Auto</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['codice_noleggio']}</td>";
        echo "<td>{$row['inizio']}</td>";
        echo "<td>{$row['fine']}</td>";
        echo "<td>{$row['marca']}</td>";
        echo "<td>{$row['modello']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p><strong>Nessun noleggio effettuato dal socio <code>$socioID</code> nel periodo selezionato.</strong></p>";
}

// Chiudi connessione
mysqli_close($connection);
?>
<a href="menu.html">Torna alla home</a>

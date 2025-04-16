<!-- filepath: c:\wamp64\www\noleggioAuto\modificaStatoAuto.php -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Auto</title>
</head>
<body>
    <h1>Elenco delle Auto</h1>

    <?php
    // Connessione al database
    $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

    // Controllo connessione
    if (!$connection) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    // Controllo se il modulo è stato inviato
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['autoDisponibili'])) {
        $autoDisponibili = $_POST['autoDisponibili'];

        // Aggiorna lo stato di disponibilità per le auto selezionate
        foreach ($autoDisponibili as $targa) {
            $queryUpdate = "UPDATE noleggi SET auto_restituita = 1 WHERE auto = '$targa'";
            mysqli_query($connection, $queryUpdate);
        }

        echo "<p>Disponibilità aggiornata con successo!</p>";
    }

    // Query per ottenere tutte le auto e il loro stato di disponibilità
    $query = "
        SELECT a.targa, a.marca, a.modello,
               CASE
                   WHEN n.auto_restituita = 1 OR n.auto_restituita IS NULL THEN 'Sì'
                   ELSE 'No'
               END AS disponibile
        FROM auto a
        LEFT JOIN noleggi n ON a.targa = n.auto
        ORDER BY a.targa
    ";

    $result = mysqli_query($connection, $query);
    ?>

    <form action="" method="POST">
        <table border="2">
            <tr>
                <th>Targa</th>
                <th>Marca</th>
                <th>Modello</th>
                <th>Disponibile</th>
                <th>Aggiorna Disponibilità</th>
            </tr>
            <?php
            // Visualizzazione dei risultati
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['targa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['modello']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['disponibile']) . "</td>";
                    echo "<td><input type='checkbox' name='autoDisponibili[]' value='" . htmlspecialchars($row['targa']) . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nessuna auto trovata</td></tr>";
            }

            // Chiusura connessione
            mysqli_close($connection);
            ?>
        </table>
        <br>
        <button type="submit">Aggiorna Disponibilità</button>
    </form>
    <br> <a href="menu.html">Torna alla home</a>
</body>
</html>
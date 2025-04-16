<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleziona Periodo</title>
</head>
<body>
    <h1>Seleziona il periodo di noleggio</h1>
    <form action="http://localhost/noleggioAuto/visualizzaNoleggio.php" method="GET">
        <label for="socioID">Seleziona Socio:</label>
        <select id="socioID" name="socioID" required>
            <?php
            // Connessione al database
            $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

            // Controllo connessione
            if (!$connection) {
                die("Connessione al database fallita: " . mysqli_connect_error());
            }

            // Query per ottenere i codici fiscali dei soci
            $query = "SELECT CF, nome, cognome FROM soci";
            $result = mysqli_query($connection, $query);

            // Popolamento del menu a tendina
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $cf = htmlspecialchars($row['CF']);
                    $nome = htmlspecialchars($row['nome']);
                    $cognome = htmlspecialchars($row['cognome']);
                    echo "<option value='$cf'>$cf - $cognome $nome</option>";
                }
            } else {
                echo "<option value=''>Nessun socio disponibile</option>";
            }

            // Chiusura connessione
            mysqli_close($connection);
            ?>
        </select>
        <br><br>
        <label for="dataInizio">Data Inizio:</label>
        <input type="date" id="dataInizio" name="dataInizio" required>
        <br><br>
        <label for="dataFine">Data Fine:</label>
        <input type="date" id="dataFine" name="dataFine" required>
        <br><br>
        <button type="submit">Visualizza Noleggio</button>
    </form>
</body>
</html>

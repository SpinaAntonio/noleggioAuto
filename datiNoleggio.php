<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inserisci i dati del noleggio</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>
    <h1>Inserisci i dati del noleggio</h1>
    <form action="http://localhost/noleggioAuto/inserisciNoleggio.php" method="post">
        <label for="idNoleggio">Codice Noleggio:</label><br>
        <input type="text" id="idNoleggio" name="idNoleggio" required><br><br>

        <select id="targaAuto" name="targaAuto" required>
        <?php
        // Connessione al database
        $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

        // Controllo connessione
        if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
        }

        // Query per ottenere i codici fiscali dei soci
        $query = "SELECT targa, modello, marca FROM auto";
        $result = mysqli_query($connection, $query);

        // Popolamento del menu a tendina
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $cf = htmlspecialchars($row['targa']);
                $nome = htmlspecialchars($row['modello']);
                $cognome = htmlspecialchars($row['marca']);
                echo "<option value='$cf'>$cf - $cognome $nome</option>";
            }
        } else {
            echo "<option value=''>Nessuna auto disponibile</option>";
        }

        // Chiusura connessione
        mysqli_close($connection);
        ?>
    </select><br><br>

        <label for="codiceFiscale">Codice Fiscale Socio:</label><br>
        <input type="text" id="codiceFiscale" name="codiceFiscale" required><br><br>

        <label for="dataInizio">Data Inizio:</label><br>
        <input type="date" id="dataInizio" name="dataInizio" required><br><br>

        <label for="dataFine">Data Fine:</label><br>
        <input type="date" id="dataFine" name="dataFine" required><br><br>

        <label for="restituita">Auto Restituita:</label>
        <input type="checkbox" id="restituita" name="restituita" value="S"><br><br>

        <input type="submit" value="Inserisci Noleggio">
    </form>
</body>
</html>
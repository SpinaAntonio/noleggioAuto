<!-- filepath: c:\wamp64\www\noleggioAuto\calcolaConto.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Calcolo Noleggio</title>
    <link rel="stylesheet" href="stile.css">
    <style>
        textarea {
            width: 300px; /* Larghezza fissa */
            height: 100px; /* Altezza fissa */
            resize: none; /* Disabilita il ridimensionamento */
        }
    </style>
</head>
<body>
<form action="http://localhost/noleggioAuto/conto.php" method="GET">
    Seleziona l'auto da restituire:
    <br>
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
    </select>
    <br><br>
    <label for="codiceNoleggio">Codice Noleggio:</label> <br>
    <input type="text" id="codiceNoleggio" name="codiceNoleggio" required>
    <br><br>
    <label for="dataRestituzione">Data di restituzione:</label> <br>
    <input type="date" id="dataRestituzione" name="dataRestituzione" required>
    <br><br>
    <label for="descrizione">Descrizione (facoltativa, max 50 caratteri):</label> <br>
    <textarea id="descrizione" name="descrizione" maxlength="50" placeholder="Inserisci una descrizione..."></textarea>
    <br><br>
    <button type="submit">Mostra conto</button>
</form>
<br><a href="menu.html">Torna alla home</a>
</body>
</html>
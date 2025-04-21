<!-- filepath: c:\wamp64\www\NOLEGGIOAUTO\riepilogo.php -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riepilogo Noleggio</title>
    <link rel="stylesheet" href="stile.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .summary-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 600px;
        }

        .summary-container img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            margin-bottom: 20px;
        }

        .summary-container h3 {
            margin: 0;
            font-size: 24px;
            color: #0056b3;
        }

        .summary-container p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #0056b3;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #003d80;
        }
    </style>
</head>
<body>
    <div class="summary-container">
        <img src="images/<?php echo strtolower($_GET['marca']); ?>.jpg" alt="Immagine auto">
        <h3><?php echo htmlspecialchars($_GET['marca'] . ' ' . $_GET['modello']); ?></h3>
        <p><?php echo htmlspecialchars($_GET['descrizione']); ?></p>
        <p><strong>Codice Noleggio:</strong> <?php echo htmlspecialchars($_GET['codiceNoleggio']); ?></p>
        <p><strong>Periodo:</strong> <?php echo htmlspecialchars($_GET['dataInizio']); ?> - <?php echo htmlspecialchars($_GET['dataFine']); ?></p>
        <a href="visualizzaAuto.php" class="back-btn">Torna alla selezione</a>
    </div>
</body>
</html>
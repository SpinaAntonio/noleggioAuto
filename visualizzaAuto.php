<!-- filepath: c:\wamp64\www\NOLEGGIOAUTO\visualizzaAuto.php -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Disponibili</title>
    <link rel="stylesheet" href="stile.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .car-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            gap: 20px;
        }

        .car-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        .car-image {
            width: 25%;
            height: auto;
            transition: transform 0.5s ease, opacity 0.5s ease;
            object-fit: contain;
            position: relative;
        }

        .car-image.center {
            transform: scale(1.2);
            z-index: 2;
            opacity: 1;
        }

        .car-image.left, .car-image.right {
            transform: scale(0.8);
            z-index: 1;
            opacity: 0.3;
        }

        .car-caption {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 14px;
            display: none;
        }

        .car-image.center .car-caption {
            display: block;
        }

        .navigation {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .navigation .dot {
            width: 15px;
            height: 15px;
            background-color: #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .navigation .dot.active {
            background-color: #0056b3;
        }

        .navigation button {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .navigation button:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }
    </style>
</head>
<body>
    <?php
    // Connessione al database
    $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

    // Controllo connessione
    if (!$connection) {
        die("<p class='error'>Connessione al database fallita: " . mysqli_connect_error() . "</p>");
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
    $cars = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cars[] = [
                'targa' => htmlspecialchars($row['targa']),
                'marca' => htmlspecialchars($row['marca']),
                'modello' => htmlspecialchars($row['modello']),
                'descrizione' => "Questa è una fantastica {$row['marca']} {$row['modello']} perfetta per ogni occasione!"
            ];
        }
    }

    // Chiusura connessione
    mysqli_close($connection);

    // Passa i dati delle auto a JavaScript
    echo "<script>const cars = " . json_encode($cars) . ";</script>";
    ?>

    <div class="car-container">
        <div class="car-display">
            <!-- Le immagini delle auto saranno generate dinamicamente -->
        </div>

        <div class="navigation">
            <button id="prev-btn">&lt;</button>
            <div id="dots-container"></div>
            <button id="next-btn">&gt;</button>
        </div>
    </div>

    <a href="menu.html" style="position: absolute; top: 20px; left: 20px; color: black; text-decoration: none;">Torna alla home</a>

    <script>
        let currentIndex = 0;

        function updateCarDisplay() {
            const carDisplay = document.querySelector('.car-display');
            const dotsContainer = document.getElementById('dots-container');
            carDisplay.innerHTML = '';
            dotsContainer.innerHTML = '';

            const prevIndex = (currentIndex - 1 + cars.length) % cars.length;
            const nextIndex = (currentIndex + 1) % cars.length;

            const carPositions = [
                { index: prevIndex, className: 'car-image left' },
                { index: currentIndex, className: 'car-image center' },
                { index: nextIndex, className: 'car-image right' }
            ];

            carPositions.forEach(pos => {
                const car = cars[pos.index];
                const imagePath = `images/${car.marca.toLowerCase()}.jpg`;
                const defaultImage = "images/default.jpg";

                const img = document.createElement('img');
                img.src = imagePath;
                img.alt = `${car.marca} ${car.modello}`;
                img.className = pos.className;
                img.onerror = () => img.src = defaultImage;

                if (pos.className === 'car-image center') {
                    const caption = document.createElement('div');
                    caption.className = 'car-caption';
                    caption.textContent = car.descrizione;
                    img.appendChild(caption);
                }

                carDisplay.appendChild(img);
            });

            // Aggiungi i puntini di navigazione
            cars.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.className = 'dot';
                if (index === currentIndex) {
                    dot.classList.add('active');
                }
                dotsContainer.appendChild(dot);
            });
        }

        document.getElementById('prev-btn').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + cars.length) % cars.length;
            updateCarDisplay();
        });

        document.getElementById('next-btn').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % cars.length;
            updateCarDisplay();
        });

        // Inizializza la visualizzazione
        if (cars.length > 0) {
            updateCarDisplay();
        } else {
            document.querySelector('.car-display').innerHTML = "<p class='error'>Nessuna auto disponibile per il periodo selezionato.</p>";
        }
    </script>
</body>
</html>
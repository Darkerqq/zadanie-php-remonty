<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <header>
        <h1>Malowanie i gipsowanie</h1>
    </header>

    <main>
        <nav>
            <a href="kontakt.html">Kontakt</a>
            <a href="https://remonty.pl" target="_blank">Partnerzy</a>
        </nav>

        <aside>
            <img src="pliki5/pliki5/tapeta_lewa.png" alt="usługi">
            <img src="pliki5/pliki5/tapeta_prawa.png"  alt="usługi">

            <img src="pliki5/pliki5/tapeta_lewa.png" alt="usługi">
        </aside>

        <section id="lewa">
            <h2>Dla klientów</h2>
            <form action="zlecenia.php" method="post">
                <label for="pracownicy">Ilu co najmniej pracowników potrzebujesz?</label><br>
                <input type="number" id="pracownicy" name='pracownicy'>
                <button type="submit">Szukaj firm</button>
            </form>
            <?php
            // Skrypt 1
            $conn = new mysqli("127.0.0.1", "root", "", "remonty");
            
            // Sprawdzenie czy formularz z lewej sekcji został wysłany
            if (isset($_POST['pracownicy']) && !empty($_POST['pracownicy'])) {
                $number = $_POST['pracownicy'];
                echo $number;
            }
            ?>
        </section>

        <section id="srodkowa">
            <h2>Dla wykonawców</h2>

            <form action="zlecenia.php" method="post">
                <select name="miasto">
                    <?php
                    // Skrypt 2
                    $q3 = "SELECT miasto FROM klienci GROUP BY miasto ORDER BY miasto ASC;";
                    $res3 = $conn->query($q3);
                    
                    if ($res3) {
                        while ($row3 = $res3->fetch_assoc()) {
                            echo "<option value='" . $row3['miasto'] . "'>" . $row3['miasto'] . "</option>";
                        }
                    }
                    ?>
                </select><br>
                
                <input type="radio" id="malowanie" name="wykonanie" value="malowanie" checked>
                <label for="malowanie">Malowanie</label><br>
                <input type="radio" id="gipsowanie" name="wykonanie" value="gipsowanie">
                <label for="gipsowanie">Gipsowanie</label><br>

                <input type="submit" value="Szukaj klientów">
            </form>

            <ul>
                <?php
                // Skrypt 3
                // Wykonuje się tylko, gdy wysłano dane z formularza "Dla wykonawców"
                if (isset($_POST['miasto']) && isset($_POST['wykonanie'])) {
                    $wybrane_miasto = $_POST['miasto'];
                    $wybrany_rodzaj = $_POST['wykonanie'];

                    // Zapytanie 4 - zmodyfikowane o zmienne z formularza i poprawioną relację
                    $q4 = "SELECT imie, cena FROM klienci 
                           JOIN zlecenia ON klienci.id_klienta = zlecenia.id_klienta 
                           WHERE miasto = '$wybrane_miasto' AND rodzaj = '$wybrany_rodzaj';";
                    
                    $res4 = $conn->query($q4);

                    if ($res4) {
                        while ($row4 = $res4->fetch_assoc()) {
                            echo "<li>" . $row4['imie'] . " - " . $row4['cena'] . "</li>";
                        }
                    }
                }
                ?>
            </ul>
        </section>
    </main>

    <footer>
        <p><strong>Stronę wykonał: </strong></p>
    </footer>

    <?php
    $conn->close();
    ?>
</body>
</html>

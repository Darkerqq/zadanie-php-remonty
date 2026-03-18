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
            <!-- poniżej powinna być tapeta_prawa.png -->
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
            // <!-- tutaj skrypt 1 -->
            $conn = new mysqli("127.0.0.1", "myroot", "1234", "remonty");
            $number = $_POST['pracownicy'];
            
            if (!empty($number)) {

                $query = "SELECT nazwa_firmy, liczba_pracownikow FROM wykonawcy WHERE liczba_pracownikow >= $number";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo "<p>" . $row['nazwa_firmy'] . ", " . $row['liczba_pracownikow'] . " pracowników</p>";
                }
            }
            ?>
            

        </section>

        <section id="srodkowa">
            <h2>Dla wykonawców</h2>

            <form action="zlecenia.php" method="post">
                <!-- tutaj będzie skrypt 2 -->
                <select name="miasto">
                    <?php
                    $query = "SELECT klienci.miasto FROM klienci GROUP BY miasto ASC";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['miasto'] . '">' . $row['miasto'] . '</option>';
                    }
                    ?>            
                </select><br>
                <input type="radio" id="malowanie" name="wykonianie" value="malowanie" checked>
                <label for="malowanie">Malowanie</label><br>
                
                <input type="radio" id="gipsowanie"  name="wykonianie" value="gipsowanie">
                <label for="gipsowanie">Gipsowanie</label><br>

                <input type="submit" value="Szukaj klientów">
            </form>

            <ul>
                <!-- tutaj będzie skrypt 3 -->
                <?php
                    if (isset($_POST['miasto']) && isset($_POST['wykonianie'])) {

                        $miasto = $_POST['miasto'];
                        $rodzaj = $_POST['wykonianie'];

                        $zapytanie = "SELECT imie, cena FROM klienci JOIN zlecenia ON klienci.id_klienta = zlecenia.id_zlecenia WHERE miasto = '$miasto' AND rodzaj = '$rodzaj'";

                        $wynik = $conn->query($zapytanie);

                        while ($wiersz = $wynik->fetch_assoc()) {
                            echo "<li>" . $wiersz['imie'] . " - " . $wiersz['cena'] . "</li>";
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
    $conn->close()
    ?>
</body>
</html>

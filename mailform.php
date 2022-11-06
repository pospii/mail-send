<?php
mb_internal_encoding("UTF-8"); // Nastavení kódovaní, abychom mohli používat funkci mb_ a mail se správně odeslal.

$hlaska = ''; // vložíme hlášku pro uživatele v případě, že se validace nepovedla. Tu později vypíšeme v HTML části skriptu.

// Validace
if (isset($_GET['uspech']))
    $hlaska = 'Email byl úspěšně odeslán, brzy vám odpovíme.';
if ($_POST)  // V poli _POST něco je, odeslal se formulář. Pokud se nic neodeslalo, není co zpracovávat. 
{
    if (
        isset($_POST['jmeno']) && $_POST['jmeno'] && // Další složená podmínka kontroluje, zda byla odeslána jednotlivá pole a zda v nich je nějaký text.
        isset($_POST['email']) && $_POST['email'] &&
        isset($_POST['zprava']) && $_POST['zprava'] &&
        isset($_POST['rok']) && $_POST['rok'] == date('Y') //  U roku kontrolujeme, zda je aktuální.
    ) {
        // Do několika proměnných si připravíme hlavičku, adresu, kam se má email odeslat a předmět.
        $hlavicka = 'From:' . $_POST['email']; // Jak vypadá hlavička je dané a nemusíte nad tím přemýšlet, podstatná je jen proměnná v prvním řádku, 
        $hlavicka .= "\nMIME-Version: 1.0\n"; // která určuje odesílatele emailu. Email potom vypadá jako že přišel z této adresy, i když ho odeslalo PHP z vašich stránek.
        $hlavicka .= "Content-Type: text/html; charset=\"utf-8\"\n";
        $adresa = 'vas@email.cz';
        $predmet = 'Nová zpráva z mailformu';
        $uspech = mb_send_mail($adresa, $predmet, $_POST['zprava'], $hlavicka); // Funkce mb_send_mail() vrací true pokud se odeslání podařilo a false pokud selhalo.
        if ($uspech) {
            $hlaska = 'Email byl úspěšně odeslán, brzy vám odpovíme.';
            /*
            Pokud je zpracování formuláře dokončeno, měli bychom provést přesměrování. Přesměrujeme na tu samou adresu, na které je formulář. 
            Díky přesměrování se ovšem ztratí data v $_POST. Následné obnovení stránky tak již nic neodešle.

            Přesměrování provedeme pomocí funkce header(). Ta odešle tzv. hlavičku prohlížeči. 
            Právě hlavička může obsahovat informaci o přesměrování a to pomocí slova Location.
            */
            header('Location: mailform.php?uspech=ano');
            exit; // Funkcí exit() ukončíme běh skriptu, jelikož samotné přesměrování ho nezastaví, jen pošle prohlížeči návštěvníka informaci o tom, že se má přesunout na jinou lokaci.
        } else
            $hlaska = 'Email se nepodařilo odeslat. Zkontrolujte adresu.';
    } else
        $hlaska = 'Formulář není správně vyplněný!';
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Kontaktní formulář</title>
</head>

<body>
    <p>Můžete mě kontaktovat pomocí formuláře níže.</p>

    <?php
    if ($hlaska)
        echo ('<p>' . htmlspecialchars($hlaska) . '</p>'); // vypíšeme proměnnou $hlaska, pokud v ní něco je

    // naplníme proměnné $jmeno, $email a $zprava hodnotami z $_POST. 
    // To můžeme udělat samozřejmě jen v případě, když v POST tyto hodnoty jsou. Pokud ne, dáme do proměnných prázdné řetězce.

    /*
    Proto si uvedeme tzv. ternární výraz. Jedná se o zkrácenou podobu if ... else. 
    Ternání výraz vždy vrací nějakou hodnotu, nedá se tedy použít jen místo podmínky. Skládá se ze tří části. 
    V první části uvedeme podmínku, dále znak ? a poté hodnotu, kterou má výraz vrátit, pokud podmínka platí. Za ní uvedeme : a hodnotu, která se má vrátit, když podmínka neplatí.
    */
    $jmeno = (isset($_POST['jmeno'])) ? $_POST['jmeno'] : ''; // Pokud v POST existuje daný klíč, vložíme tuto hodnotu do proměnné $jmeno. Pokud ne, vložíme tam prázdný textový řetězec, což jsou jednoduše uvozovky, mezi kterými nic není.
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $zprava = (isset($_POST['zprava'])) ? $_POST['zprava'] : '';
    ?>

    <form method="POST">
        <table>
            <tr>
                <td>Vaše jméno</td>
                <td><input name="jmeno" type="text" value="<?= htmlspecialchars($jmeno) ?>" /></td>
            </tr> <!-- Ta převede špičaté HTML závorky a pár dalších znaků na tzv. HTML entity. Případný škodlivý kód je potom braný jen jako obyčejný text a prohlížeč ho nezpracuje jako HTML kód. -->
            <tr>
                <td>Váš email</td>
                <td><input name="email" type="email" value="<?= htmlspecialchars($email) ?>" /></td>
            </tr>
            <tr>
                <td>Aktuální rok</td>
                <td><input name="rok" type="number" /></td>
            </tr>
        </table>
        <textarea name="zprava"><?= htmlspecialchars($zprava) ?></textarea>
        <br />

        <input type="submit" value="Odeslat" />
    </form>

</body>

</html>

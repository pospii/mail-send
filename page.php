<!DOCTYPE html>

<html lang="cs-cz">
    <head>    
        <meta charset="utf-8" /> 
        <title>Adam Pospíšek</title>   
        <link rel="stylesheet" href="styl.css" type="text/css" />
        <meta content="width=device-width, viewport-fit=cover" name="viewport" />
        <meta name="description" content="Zkušební stránky s prací ze školy od Adama Pospíška" />
        <meta name="keywords" content="portfolio, programátor, Pospi" />
        <meta name="author" content="Pospi" />
        <link rel="shortcut icon" href="obrazky/ikona.ico" />
    </head>

    <body>
        <header>
            <h1>Pospi</h1>
            <nav>
                <ul>
                    <!-- Všechny odkazy tedy vedou na soubor s layoutem, kterému předávají v parametru název stránky, 
                    která se do něj má vložit. Tyto HTML stránky si vložíme do podsložky podstranky/ se stejným názvem a příponou .php. -->                    
                    <a href="index.php?stranka=domu"><li>Domů</li></a>
                    <a href="index.php?stranka=dovednosti"><li>Dovednosti</li></a>
                    <a href="index.php?stranka=reference"><li>Reference</li></a>
                    <a href="index.php?stranka=kontakt"><li>Kontakt</li></a>
                    <a href="index.php?stranka=skola"><li><strong>PHP</strong></li></a>
                    <a href="index.php?stranka=javascript"><li><strong>JS</strong></li></a>
                    <a href="index.php?stranka=oop"><li><strong>OOP</strong></li></a>
                </ul>
            </nav>
        </header>
        
        <article>                
                    <?php
                    mb_internal_encoding("UTF-8");
                    if (isset($_GET['stranka']))
                        $stranka = $_GET['stranka'];
                    else
                        $stranka = 'domu'; // pokud není parametr zadaný, zobrazí se strána domů
                        // k ověření řetězce pomocí regulárního výrazu slouží PHP funkce preg_match(), která vrátí 1 pokud text odpovídá.
                        if (preg_match('/^[a-z0-9]+$/', $stranka))
                    {
                        // Funkce bere jako parametr opět cestu k souboru a obsah hned vypíše. Pokud je v souboru nějaká PHP sekvence, tak ji spustí.
                        $vlozeno = include('podstranky/' . $stranka . '.php');
                        if (!$vlozeno)
                            echo('Podstránka nenalezena');
                    }
                    else
                        echo('Neplatný parametr.');
                    ?>           
        </article>
        
        <footer>
            Vytvořil &copy;Pospi 2020.        
        </footer>
    </body>
</html>

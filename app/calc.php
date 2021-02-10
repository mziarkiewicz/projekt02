<?php
// KONTROLER strony kalkulatora kredytowego
require_once dirname(__FILE__).'/../config.php';

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

// pobranie parametrów
function getParams(&$amo,&$yr,&$pct) {
    $amo = isset($_REQUEST ['amo']) ? $_REQUEST ['amo'] : null;
    $yr = isset($_REQUEST ['yr']) ? $_REQUEST ['yr'] : null;
    $pct = isset($_REQUEST ['pct']) ? $_REQUEST ['pct'] : null;
}

// walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$amo,&$yr,&$pct,&$messages){
    // sprawdzenie, czy parametry zostały przekazane
    if ( ! (isset($amo) && isset($yr) && isset($pct))) {
        //sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
        //$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
        // teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń:
        return false;
    }
    // sprawdzenie, czy potrzebne wartości zostały przekazane
    if ( $amo == "") {
        $messages [] = 'Nie podano kwoty kredytu';
    }
    if ( $yr == "") {
        $messages [] = 'Nie podano lat spłaty kredytu';
    }
    if ( $pct == "") {
        $messages [] = 'Nie podano oprocentowania kredytu';
    }

    //nie ma sensu walidować dalej gdy brak parametrów
    if (count ( $messages ) != 0) return false;

    // sprawdzenie, czy $amo, $yr, $pct są liczbami i czy są dodatnie
    if (! is_numeric( $amo )) {
        $messages [] = 'Podana kwota jest niepoprawna';
    } else  if ( doubleval($amo) < 0) {
        $messages [] = 'Kwota kredytu nie może być ujemna';
    }

    if (! is_numeric( $yr )) {
        $messages [] = 'Podana liczba lat spłaty kredytu jest niepoprawna';
    } else if (intval($yr) <= 0) {
        $messages [] = 'Liczba lat spłaty kredytu musi być dodatnia';
    }

    if (! is_numeric( $pct )) {
        $messages [] = 'Podane oprocentowanie jest niepoprawne';
    } else if( doubleval($pct) < 0) {
        $messages [] = 'Oprocentowanie musi być liczbą nieujemną';
    }

    if (count ( $messages ) != 0) return false;
    else return true;
}

// wykonaj zadanie jeśli wszystko w porządku
function process(&$amo,&$yr,&$pct,&$messages,&$result){
    global $role;

    //konwersja parametrów na odpowiedni format
    $amo = doubleval($amo);
    $yr = intval($yr);
    $pct = doubleval($pct);

    if ($pct == 0 && $role != 'admin'){
        $messages [] = 'Tylko administrator może dostać zerowe oprocentowanie!';
    }

    //wykonanie operacji
    $result = ($amo / ($yr * 12)) * (1 + $pct/100) ;

}

//definicja zmiennych kontrolera
$x = null;
$y = null;
$operation = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($amo,$yr,$pct);
if ( validate($amo,$yr,$pct,$messages) ) { // gdy brak błędów
    process($amo,$yr,$pct,$messages,$result);
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$amo,$yr,$pct,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
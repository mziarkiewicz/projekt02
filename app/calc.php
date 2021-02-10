<?php
// KONTROLER strony kalkulatora kredytowego
require_once dirname(__FILE__).'/../config.php';

// 1. pobranie parametrów

$amo = $_REQUEST ['amo'];
$yr = $_REQUEST ['yr'];
$pct = $_REQUEST ['pct'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($amo) && isset($yr) && isset($pct))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
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
if (empty( $messages )) {
	
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

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na odpowiedni format
	$amo = doubleval($amo);
	$yr = intval($yr);
    $pct = doubleval($pct);
	
	//wykonanie operacji
    $result = ($amo / ($yr * 12)) * (1 + $pct/100) ;
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$amo,$yr,$pct,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
<?php

 Class Parse_NPC extends Arena {

    var $npc_string;
	 
    function Parse_NPC($difficulty){
        $this->difficulty = $difficulty;

        if ($difficulty == 1){
            $this->maxv = 6;
        } elseif ($difficulty == 2){
            $this->maxv = 8;
        } elseif ($difficulty == 3){
            $this->maxv = 10;
        }

       $this->npc_string = $this->GetName().'/'.$this->GetLastName().'/'.$this->GetGender().'/'.$this->Species();       
       $this->Generate();
    }

    function Roll($high){
        return mt_rand(1, $high);
    }

    function RollName(){
        return mt_rand(3, 8);
    }
    
    function Generate(){
	    $sheet = new Sheet();
	    for ($i = 1; $i <= 11; $i++){
	    	$field = new Field($i);
	    	foreach($sheet->GetStats($i) as $stat){
		    	if ($stat->isint()){
		    		$this->npc_string .= '/'.$this->Roll($this->maxv);
	    		}
	    	}
	    	foreach($sheet->GetSkills($i) as $skills){
		    	if ($stat->isint()){
		    		$this->npc_string .= '/'.$this->Roll($this->maxv);
	    		}
	    	}
    	}
	}

function letters_in_set($word, $letters) {
    for ($i = 0; $i < strlen($word); $i++) {
        if (!strchr($letters, substr($word, $i, 1))) return false;
    }
    return true;
}

function lookup_initial_consonant($a, $b) {
    $table = array(
        array('m', 'n', 'n', 'r', 'l', ''),
        array('p', 't', 't', 'ch', 'k', ''),
        array('p', 'd', 't', 'j', 'g', ''),
        array('b', 'd', 's', 's', 's', ''),
        array('f', 'f', 'th', 'th', 'kh', ''),
        array('', '', '', '', '', ''));
    return $table[$b - 1][$a - 1];
}

function lookup_vowel($c) {
    $table = array('i', 'e', '', 'a', 'o', 'u');
    do {
        $c = mt_rand(1, 6);
        $vowel = $table[$c - 1];
    }
    while (strlen($vowel) == 0);
    return $vowel;
}

function lookup_final_consonant($d, $e) {
    $table = array(
        array('m', 'n', 'n', 'r', 'r', 'l'),
        array('m', 'n', 'n', 'r', 'r', 'l'),
        array('p', 't', 't', 'ch', 'k', 'k'),
        array('f', 'th', 's', 's', 's', 'kh'),
        array('', '', '', '', '', ''),
        array('', '', '', '', '', ''));
    return $table[$e - 1][$d - 1];
}

function generate_syllable($letters, $tick_freq, $start, $end, $prev_word) {
    /* Roll our dice. We're assuming someone else has seeded the random
     * number generator.
     *
     * Actually, I've moved rolling further down, for a very good reason.
     * We may need to reroll.
     */

    // Work out the initial consonant.
    do {
        $dice[0] = mt_rand(1, 6);
        $dice[1] = mt_rand(1, 6);
        $dice[2] = mt_rand(1, 6);
        $ic = $this->lookup_initial_consonant($dice[0], $dice[1]);
    }
    while (!$this->letters_in_set($ic, $letters));

    // Work out the vowel, and whether it's OK.
    do $vowel = $this->lookup_vowel($dice[2]);
    while (!$this->letters_in_set($vowel, $letters));
    if (strlen($ic) == 0) {
        if (substr($prev_word, -1, 1) == $vowel || $this->letters_in_set(substr($prev_word, -2, 2) . $vowel, "aeiou")) {
            do $ic = $this->lookup_initial_consonant($dice[0], $dice[1]);
            while (!$this->letters_in_set($ic, $letters));
        }
    }

    // Now the final consonant.
    do {
        $dice[3] = mt_rand(1, 6);
        $dice[4] = mt_rand(1, 6);
        $fc = $this->lookup_final_consonant($dice[3], $dice[4]);
    }
    while (!$this->letters_in_set($fc, $letters));

    // Do we need to alter the previous syllable?
    if (strlen($prev_word) && $dice[4] <= 2) {
        $last_letter = substr($prev_word, -1, 1);
        $rest_prev_word = substr($prev_word, 0, strlen($prev_word) - 1);
        if ($last_letter == 'm') {
            switch ($ic) {
                case 'n': case 't': case 'd': case 'ch': case 'j': case 'th':
                    $last_letter = 'n';
            }
        }
        elseif ($last_letter == 'n') {
            switch ($ic) {
                case 'm': case 'p': case 'b': case 'f':
                    $last_letter = 'm';
            }
        }
        elseif ($last_letter == 'r' && $ic == 'l') $last_letter = 'l';
        elseif ($last_letter == 'l' && $ic == 'r') $last_letter = 'r';
    }
    else {
        $last_letter = '';
        $rest_prev_word = $prev_word;
    }

    // Check if we need to drop the final consonant.
    if (!$end && ($dice[4] == 3 || $dice[4] == 4)) {
        switch ($fc) {
            case 'p': case 't': case 'ch': case 'k': case 'f': case 'th': case 's': case 'kh':
                $fc = '';
        }
    }

    // Is there an apostrophe?
    if (!$end && $tick_freq && mt_rand(0, 100) <= $tick_freq) $fc .= "'";

    // Construct the word and return it.
    return $rest_prev_word . $last_letter . $ic . $vowel . $fc;
}

function generate_word($min_syllables = 1, $max_syllables = 3, $letters = "abcdefghijklmnopqrstuvwxyz", $tick_freq = 0, $tick_word_end = 0) {
    mt_srand((double) microtime() * 1000000);

    $syllables = mt_rand($min_syllables, $max_syllables);

    $word = '';
    
    for ($i = 0; $i < $syllables; $i++) {
        $word = $this->generate_syllable($letters, $tick_freq, $i == 0, $i == ($syllables - 1), $word);
    }

    if ($tick_freq && $tick_word_end) {
        if (mt_rand(0, 100) <= $tick_freq) {
            $word .= "'";
        }
    }

    return $word;
}

    function Species(){
        $roll = $this->Roll(6);
        if ($roll > 2){
            $species = "Human";
        } else {

        $specie = $this->Roll(25);

        if ($specie == 1){
            $species = "Advozsec";
        } elseif ($specie == 2){
            $species = "Aleena";
        } elseif ($specie == 3){
            $species = "Anx";
        } elseif ($specie == 4){
            $species = "Anzat";
        } elseif ($specie == 5){
            $species = "Aqualish";
        } elseif ($specie == 6){
            $species = "Arcona";
        } elseif ($specie == 7){
            $species = "Bith";
        } elseif ($specie == 8){
            $species = "Bothan";
        } elseif ($specie == 9){
            $species = "Cerean";
        } elseif ($specie == 10){
            $species = "Chadra-Fan";
        } elseif ($specie == 11){
            $species = "Chagrian";
        } elseif ($specie == 12){
            $species = "Chiss";
        } elseif ($specie == 13){
            $species = "Cthon";
        } elseif ($specie == 14){
            $species = "Dashade";
        } elseif ($specie == 15){
            $species = "Devaronian";
        } elseif ($specie == 16){
            $species = "Dug";
        } elseif ($specie == 17){
            $species = "Duro";
        } elseif ($specie == 18){
            $species = "Elom";
        } elseif ($specie == 19){
            $species = "Gamorrean";
        } elseif ($specie == 20){
            $species = "Geonosian";
        } elseif ($specie == 21){
            $species = "Glymphid";
        } elseif ($specie == 22){
            $species = "Gossam";
        } elseif ($specie == 23){
            $species = "Gotal";
        } elseif ($specie == 24){
            $species = "Gran";
        } elseif ($specie == 25){
            $species = "Gungan";
        }
    }
    
    return $species;

    }

    function GetName(){
        return mb_convert_case($this->generate_word(), MB_CASE_TITLE, "UTF-8");
    }

    function GetGender(){
        $roll = $this->Roll(6);
        if ($roll > 3){
            return "Male";
        } else {
            return "Female";
        }
    }

    function GetLastName(){
        return mb_convert_case($this->generate_word(), MB_CASE_TITLE, "UTF-8");
    }

    function GetString(){
        return $this->npc_string;
    }

 }
?>

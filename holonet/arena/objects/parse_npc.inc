<?php

 Class Parse_NPC extends Arena {

    var $difficulty;
    var $physical;
    var $mental;
    var $talents;
    var $skills;
    var $knowledges;
    var $history;
    var $appearance;
    var $dexterity;
    var $senses;
    var $stamina;
    var $strength;
    var $conscience;
    var $courage;
    var $selfcontrol;
    var $allies;
    var $alternate;
    var $contacts;
    var $name;
    var $alertness;
    var $brawl;
    var $dodge;
    var $intimidation;
    var $manipulation;
    var $stealth;
    var $subterfuge;
    var $demolitions;
    var $marksmanship;
    var $melee;
    var $piloting;
    var $repair;
    var $security;
    var $tracking;
    var $education;
    var $linguistics;
    var $medicine;
    var $poison;
    var $politics;
    var $science;
    var $technology;
    var $species;
    var $homeworld;
    var $language;
    var $phymax;
    var $stamax;
    var $gender;
    var $first;
    var $last;

    function Parse_NPC($difficulty){
        $this->difficulty = $difficulty;

        if ($difficulty == 1){
            $this->phymax = 6;
            $this->stamax = 6;
        } elseif ($difficulty == 2){
            $this->phymax = 8;
            $this->stamax = 8;
        } elseif ($difficulty == 3){
            $this->phymax = 10;
            $this->stamax = 10;
        }

        $physical_generate = $this->Physical();
        $mental_generate = $this->Mental();
        $history_generate = $this->History();
        $talents_generate = $this->Talents();
        $skills_generate = $this->Skills();
        $knowledges_generate = $this->Knowledges();
        $species_generate = $this->Species();

    }

    function Roll($high){
        return mt_rand(1, $high);
    }

    function RollName(){
        return mt_rand(3, 8);
    }

    function RollPhysical(){
        return mt_rand(3, $this->phymax);
    }

    function RollStats(){
        return mt_rand(0, $this->stamax);
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

    function Physical(){
        $this->dexterity = $this->RollPhysical();
        $this->strength = $this->RollPhysical();
        $this->senses = $this->RollPhysical();
        $this->stamina = $this->RollPhysical();
        $this->appearance = $this->RollPhysical();
    }

    function Mental(){
        $this->conscience = $this->RollStats();
        $this->selfcontrol = $this->RollStats();
        $this->courage = $this->RollStats();
    }

    function Talents(){
        $this->dodge = $this->RollStats();
        $this->brawl = $this->RollStats();
        $this->alertness = $this->RollStats();
        $this->intimidation = $this->RollStats();
        $this->stealth = $this->RollStats();
        $this->subterfuge = $this->RollStats();
        $this->manipulation = $this->RollStats();
    }

    function Skills(){
        $this->melee = $this->RollStats();
        $this->marksmanship = $this->RollStats();
        $this->piloting = $this->RollStats();
        $this->security = $this->RollStats();
        $this->repair = $this->RollStats();
        $this->demolitions = $this->RollStats();
        $this->tracking = $this->RollStats();
    }

    function Knowledges(){
        $this->education = $this->RollStats();
        $this->poison = $this->RollStats();
        $this->science = $this->RollStats();
        $this->medicine = $this->RollStats();
        $this->technology = $this->RollStats();
        $this->politics = $this->RollStats();
        $this->linguistics = $this->RollStats();
    }

    function History(){
        $this->allies = $this->RollStats();
        $this->alternate = $this->RollStats();
        $this->contacts = $this->RollStats();
    }

    function Species(){
        $roll = $this->Roll(6);
        if ($roll > 2){
            $this->species = "Human";
        } else {

        $specie = $this->Roll(25);

        if ($specie == 1){
            $this->species = "Advozsec";
        } elseif ($specie == 2){
            $this->species = "Aleena";
        } elseif ($specie == 3){
            $this->species = "Anx";
        } elseif ($specie == 4){
            $this->species = "Anzat";
        } elseif ($specie == 5){
            $this->species = "Aqualish";
        } elseif ($specie == 6){
            $this->species = "Arcona";
        } elseif ($specie == 7){
            $this->species = "Bith";
        } elseif ($specie == 8){
            $this->species = "Bothan";
        } elseif ($specie == 9){
            $this->species = "Cerean";
        } elseif ($specie == 10){
            $this->species = "Chadra-Fan";
        } elseif ($specie == 11){
            $this->species = "Chagrian";
        } elseif ($specie == 12){
            $this->species = "Chiss";
        } elseif ($specie == 13){
            $this->species = "Cthon";
        } elseif ($specie == 14){
            $this->species = "Dashade";
        } elseif ($specie == 15){
            $this->species = "Devaronian";
        } elseif ($specie == 16){
            $this->species = "Dug";
        } elseif ($specie == 17){
            $this->species = "Duro";
        } elseif ($specie == 18){
            $this->species = "Elom";
        } elseif ($specie == 19){
            $this->species = "Gamorrean";
        } elseif ($specie == 20){
            $this->species = "Geonosian";
        } elseif ($specie == 21){
            $this->species = "Glymphid";
        } elseif ($specie == 22){
            $this->species = "Gossam";
        } elseif ($specie == 23){
            $this->species = "Gotal";
        } elseif ($specie == 24){
            $this->species = "Gran";
        } elseif ($specie == 25){
            $this->species = "Gungan";
        }
    }

    }

    function GetSpecies(){
        return $this->species;
    }

    function GetName(){
        $this->first = $this->generate_word();
        return mb_convert_case($this->first, MB_CASE_TITLE, "UTF-8");;
    }

    function GetGender(){
        $roll = $this->Roll(6);
        if ($roll > 3){
            $this->gender = "Male";
            return "Male";
        } else {
            $this->gender = "Female";
            return "Female";
        }
    }

    function GetLastName(){
        $this->last = $this->generate_word();
        return mb_convert_case($this->last, MB_CASE_TITLE, "UTF-8");
    }

    function GetAppearance(){
        return $this->appearance;
    }

    function GetStrength(){
        return $this->strength;
    }

    function GetDexterity(){
        return $this->dexterity;
    }

    function GetStamina(){
        return $this->stamina;
    }

    function GetSenses(){
        return $this->senses;
    }

    function GetCourage(){
        return $this->courage;
    }

    function GetSelfControl(){
        return $this->selfcontrol;
    }

    function GetConscience(){
        return $this->conscience;
    }

    function GetAllies(){
        return $this->allies;
    }

    function GetContacts(){
        return $this->contacts;
    }

    function GetAlternateID(){
        return $this->alternate;
    }

    function GetAlertness(){
        return $this->alertness;
    }

    function GetBrawl(){
        return $this->brawl;
    }

    function GetDodge(){
        return $this->dodge;
    }

    function GetManipulate(){
        return $this->manipulation;
    }

    function GetStealth(){
        return $this->stealth;
    }

    function GetSubterfuge(){
        return $this->subterfuge;
    }

    function GetIntimidation(){
        return $this->intimidation;
    }

    function GetMelee(){
        return $this->melee;
    }

    function GetMarksmanship(){
        return $this->marksmanship;
    }

    function GetDemolitions(){
        return $this->demolitions;
    }

    function GetSecurity(){
        return $this->security;
    }

    function GetTracking(){
        return $this->tracking;
    }

    function GetRepair(){
        return $this->repair;
    }

    function GetPiloting(){
        return $this->piloting;
    }

    function GetEducation(){
        return $this->education;
    }

    function GetLinguistics(){
        return $this->linguistics;
    }

    function GetMedicine(){
        return $this->medicine;
    }

    function GetPoison(){
        return $this->poison;
    }

    function GetPolitics(){
        return $this->politics;
    }

    function GetScience(){
        return $this->science;
    }

    function GetTechnology(){
        return $this->technology;
    }

    function GetString(){
        $string = $this->species."/".$this->GetGender()."/".$this->appearance."/".$this->strength."/".$this->dexterity."/".$this->stamina."/".$this->senses."/".$this->courage
                ."/".$this->selfcontrol."/".$this->conscience."/".$this->allies."/".$this->contacts."/".$this->alternate."/".$this->alertness."/".$this->brawl
                ."/".$this->dodge."/".$this->manipulation."/".$this->stealth."/".$this->subterfuge."/".$this->intimidation."/".$this->melee."/".$this->marksmanship
                ."/".$this->demolitions."/".$this->security."/".$this->tracking."/".$this->repair."/".$this->piloting."/".$this->education."/".$this->linguistics
                ."/".$this->medicine."/".$this->poison."/".$this->politics."/".$this->science."/".$this->technology."/".$this->GetName()."/".$this->GetLastName();

        return $string;
    }

 }

?>

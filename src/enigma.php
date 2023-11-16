<?php
$firstRotor='EKMFLGDQVZNTOWYHXUSPAIBRCJ';
$secondRotor='AJDKSIRUXBLHWTMCQGZNPYFVOE';
$thirdRotor='BDFHJLCPRTXVZNYEIWGAKMUSQO';
$reflector='YRUHQSLDPXNGOKMIEBFZCWVJAT';
$rotor1Pos=0;
$rotor2Pos=0;
$rotor3Pos=0;

function encryptLetter($letter, $rotor, $position){
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pos = strpos($alphabet, $letter);
    $newPos = ($pos + $position) % 26;
    return $rotor[$newPos];
}

function decryptLetter($letter, $rotor, $position){
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pos = strpos($rotor, $letter);
    $newPos = ($pos - $position + 26) % 26; 
    return $alphabet[$newPos];
}

function plugboard($letter, $plugPairs){
    foreach ($plugPairs as $pair) {
        if(strlen($pair)>0){
            if ($letter == $pair[0]) {
                return $pair[1];
            }
            if ($letter == $pair[1]) {
                return $pair[0];
            }
        }
    }
    return $letter;
}

function enigmaDecrypt($inputText,$plugPairs){
    global $firstRotor;
    global $secondRotor;
    global $thirdRotor;
    global $reflector ; 
    global $rotor1Pos;
    global $rotor2Pos;
    global $rotor3Pos;
   
    $decryptedText = '';
    $inputText = strtoupper($inputText);
    for ($i = strlen($inputText); $i >=0; $i--) {
        $letter = $inputText[$i];
        if (ctype_alpha($letter)) {
            $letter = plugboard($letter, $plugPairs);
            $letter = decryptLetter($letter, $firstRotor, $rotor1Pos);
            $letter = decryptLetter($letter, $secondRotor, $rotor2Pos);
            $letter = decryptLetter($letter, $thirdRotor, $rotor3Pos);
            $letter = decryptLetter($letter, $reflector, $rotor1Pos);
            $letter = decryptLetter($letter, $thirdRotor, $rotor3Pos);
            $letter = decryptLetter($letter, $secondRotor, $rotor2Pos);
            $letter = decryptLetter($letter, $firstRotor, $rotor1Pos);
            $letter = plugboard($letter, $plugPairs);

            $decryptedText.=$letter;

            if ($i>0) {
                if ($rotor1Pos<=0){$rotor1Pos=25;$rotor2Pos--;
                    if($rotor2Pos<=0){$rotor2Pos=25;$rotor3Pos--;
                        if($rotor3Pos<=0){$rotor3Pos=25;
                        }else{$rotor3Pos--;}
                    }else{$rotor2Pos--;}
                }else{$rotor1Pos--;}
            }

        } else {
            $decryptedText.=$letter;
        }
    }
    return $decryptedText;
}
function enigmaEncrypt($inputText,$plugPairs){
    global $firstRotor;
    global $secondRotor;
    global $thirdRotor;
    global $reflector;
    global $rotor1Pos;
    global $rotor2Pos;
    global $rotor3Pos;

    $encryptedText = '';
    $inputText = strtoupper($inputText);

    for ($i = 0; $i < strlen($inputText); $i++){
        $letter = $inputText[$i];
        if (ctype_alpha($letter)) {
            $letter = plugboard($letter, $plugPairs);
            $letter = encryptLetter($letter, $firstRotor, $rotor1Pos);
            $letter = encryptLetter($letter, $secondRotor, $rotor2Pos);
            $letter = encryptLetter($letter, $thirdRotor, $rotor3Pos);
            $letter = encryptLetter($letter, $reflector, $rotor1Pos);
            $letter = encryptLetter($letter, $thirdRotor, $rotor3Pos);
            $letter = encryptLetter($letter, $secondRotor, $rotor2Pos);
            $letter = encryptLetter($letter, $firstRotor, $rotor1Pos);
            $letter = plugboard($letter, $plugPairs);
            $encryptedText .= $letter;

            if ($i < strlen($inputText)-1){
                if ($rotor1Pos>=25){$rotor1Pos=0;$rotor2Pos++;
                    if($rotor2Pos>=25){$rotor2Pos=0;$rotor3Pos++;
                        if($rotor3Pos>=25){$rotor3Pos=0;
                        }else{$rotor3Pos++;}
                    }else{$rotor2Pos++;}
                }else{$rotor1Pos++;}

               // DA CONTROLLARE MEGLIO DOMANI 
               // if ($rotor1Pos==25 && $rotor2Pos==25 && $rotor3Pos==25) {$rotor1Pos=0;$rotor2Pos=0;$rotor3Pos=0;}
            }
        }else{$encryptedText.= $letter;}
    }
    return $encryptedText;
}

function setupTheRotor($rotor1setup,$rotor2setup,$rotor3setup){ 
   
global $firstRotor ;
global $secondRotor;
global $thirdRotor;
$rotor1 = 'EKMFLGDQVZNTOWYHXUSPAIBRCJ';
$rotor2 = 'AJDKSIRUXBLHWTMCQGZNPYFVOE';
$rotor3 = 'BDFHJLCPRTXVZNYEIWGAKMUSQO';
$rotor4 = 'ESOVPZJAYQUIRHXLNFTGKDCMWB';
$rotor5 = 'VZBRGITYUPSDNHLXAWMJQOFECK';
    switch ($rotor1setup) {
        case 'I':$firstRotor=$rotor1; break;
        case 'II':$firstRotor=$rotor2; break;
        case 'III':$firstRotor=$rotor3; break;
        case 'IV':$firstRotor=$rotor4; break;
        case 'V':$firstRotor=$rotor5; break;
    }

    switch ($rotor2setup) {
        case 'I':$secondRotor=$rotor1; break;
        case 'II':$secondRotor=$rotor2; break;
        case 'III':$secondRotor=$rotor3; break;
        case 'IV':$secondRotor=$rotor4; break;
        case 'V':$secondRotor=$rotor5; break;
    }
    switch ($rotor3setup) {
        case 'I':$thirdRotor=$rotor1; break;
        case 'II':$thirdRotor=$rotor2; break;
        case 'III':$thirdRotor=$rotor3; break;
        case 'IV':$thirdRotor=$rotor4; break;
        case 'V':$thirdRotor=$rotor5; break;
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    global $rotor1Pos;
    global $rotor2Pos;
    global $rotor3Pos;

    $rotor1setup=$_POST["setupRotor1"];
    $rotor2setup=$_POST["setupRotor2"];
    $rotor3setup=$_POST["setupRotor3"];

    $rotor1Pos = isset($_POST["rotor1"]) ? $_POST["rotor1"] % 26 : 0;
    $rotor2Pos = isset($_POST["rotor2"]) ? $_POST["rotor2"] % 26 : 0;
    $rotor3Pos = isset($_POST["rotor3"]) ? $_POST["rotor3"] % 26 : 0;

    $inputText = isset($_POST["inputText"]) ? $_POST["inputText"] : '';
    $plugPairs = isset($_POST["plugPairs"]) ? explode(" ", $_POST["plugPairs"]) : '';

    $avalaibleLetterForPlugboard = "";
    
    setupTheRotor($rotor1setup,$rotor2setup,$rotor3setup);

    if ($_POST["radio-10"]==1){
        $encryptedText = enigmaEncrypt($inputText, $plugPairs);
    }

    if ($_POST["radio-10"]==2){
        $encryptedText = strrev(enigmaDecrypt($inputText, $plugPairs));

    }

    $avalaibleLetter = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $plugIn = str_split($_POST["plugPairs"]);
    for ($i=0; $i < count($plugIn); $i++) { 
        for ($j=0; $j < count($avalaibleLetter); $j++) { 
            if ($avalaibleLetter[$j] === $plugIn[$i]) {unset($avalaibleLetter[$j]);}
        }
    }

    $avalaibleLetterForPlugboard = implode('', $avalaibleLetter );

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enigma Machine Simulator</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.3/dist/full.css" rel="stylesheet" type="text/css" />
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<link href="/ste/dist/output.css" rel="stylesheet">
<body class="h-full">

<div class="navbar bg-gray-200 rounded-lg">

  <div class="flex-1">
    <a class="btn btn-ghost normal-case text-xl">Enigma Machine</a>
  </div>
  
  <div class="flex-none">
    <button class="btn btn-square btn-ghost">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
    </button>
  </div>

</div>

<div id="app" class="md:grid md:grid-cols-3 gap-4 ">

    <div> </div>

    <form class="w-full max-w-sm mx-auto flex item-center justify-center " method="post"  name = "post">
        <div class=" w-2/3 ">
     
            <div class="grid grid-cols-3 gap-2 flex item-center justify-center">

                <div>
                    <p>rotor 1</p>
                    <select class="select  w-full max-w-xs bg-gray-200 " v-model="OptionRotor1" @change="updateRotorOption()" name="setupRotor1">
                    <option v-for="option in filteredOptions1" :value="option">{{ option }}</option>
                    </select>
                </div>

                <div>
                    <p>rotor 2</p>
                    <select class="select  w-full max-w-xs bg-gray-200 " v-model="OptionRotor2" @change="updateRotorOption()" name="setupRotor2">
                    <option v-for="option in filteredOptions2" :value="option">{{ option }}</option>
                    </select>
                </div>

                <div>
                    <p>rotor 3</p>
                    <select class="select  w-full max-w-xs bg-gray-200 " v-model="OptionRotor3" @change="updateRotorOption()" name="setupRotor3">            
                    <option v-for="option in filteredOptions3" :value="option">{{ option }}</option>
                    </select>
                </div>

            </div>

            <div class="pt-1 pb-4">
                <p class="text-xs md:text-base">Rotor 1 Position (0-25):</p>
                <input  v-model="rotor1" name="rotor1" min="0" max="25" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-password" type="number" >
            </div>

            <div class="pt-1 pb-4">
                <p class="text-xs md:text-base">Rotor 2 Position (0-25):</p>
                <input  v-model="rotor2" name="rotor2" min="0" max="25" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-password" type="number"  >
            </div>

            <div class="pt-1 pb-4">
                <p class="text-xs md:text-base">Rotor 3 Position (0-25):</p>
                <input  v-model="rotor3"  name="rotor3" min="0" max="25" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-password" type="number" >
            </div>

            <div class="pt-1 pb-4">
                <p class="text-xs md:text-base">Plugboard Pairs (e.g., AB CD EF):</p>
                <div class="relative" v-on:click="showKeyboard = !showKeyboard">
                    <input v-model="plugBoard" readonly  name="plugPairs" placeholder="Enter pairs" class=" bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-password" type="text">
                    <div v-if="showKeyboard" class="absolute bg-white border border-gray-300 rounded-lg p-4" style="top: 40px;" >
                        <button v-for="letter in availableLetters" @click="addLetter(letter)" :key="letter" class="px-2 py-1 m-1 rounded">{{ letter }}</button>
                    </div>
                </div>
            </div>
           
            <div class="pt-1 pb-4 " id="c1">
            <p class="text-xs md:text-base">Input Text: </p>
            <input name="inputText" placeholder="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-password" type="text" value="<?= isset($inputText) ? $inputText : '' ?>">
            </div>

            <div><p class="text-base "></p></div>

            <div class="pt-1 pb-4 grid grid-cols-2 gap-2">

                <label class="label cursor-pointer">
                    <span class="label-text">Encrypt</span>
                    <input type="radio" name="radio-10" class="radio checked:bg-purple-500" checked value="1" />
                </label>

                <label class="label cursor-pointer">
                    <span class="label-text">Decrypt</span>
                    <input type="radio" name="radio-10" class="radio checked:bg-purple-500" checked value="2"/>
                </label>

            </div>

            <div>
                <div class="flex item-center justify-center" >
                    <div class="">
                        <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit" value="Encript">
                            Click Me!!
                        </button>
                    </div>
                </div>
            </div>
</form>
        </div>
    <div><?php if (isset($encryptedText)): ?>
        <h2>Encrypted Text: <?= $encryptedText ?> </h2>
        <h2>with this option</h2>
        <h2>rotor1 <?php echo $rotor1setup; ?></h2>
        <h2>rotor2 <?php echo $rotor2setup; ?></h2>
        <h2>rotor3 <?php echo $rotor3setup; ?></h2>
        <h2>rotor1 position <?php echo $rotor1Pos;?></h2>
        <h2>rotor2 position <?php echo $rotor2Pos; ?></h2>
        <h2>rotor3 position <?php echo $rotor3Pos; ?></h2>
        <h2>plugboard pair <?php echo implode(" ", $plugPairs); ?></h2>
    <?php endif; ?></div>



    
</div>

    


    <script>
    const app = Vue.createApp({

        data() {
            return {
                rotor1: <?= isset($rotor1Pos) ? $rotor1Pos : 0; ?>,
                rotor2: <?= isset($rotor2Pos) ? $rotor2Pos : 0; ?>,
                rotor3: <?= isset($rotor3Pos) ? $rotor3Pos : 0; ?>,
                OptionRotor1: '<?= isset($rotor1setup) ? $rotor1setup :"I"; ?>',
                OptionRotor2: '<?= isset($rotor2setup) ? $rotor2setup : "II"; ?>',
                OptionRotor3: '<?= isset($rotor3setup) ? $rotor3setup : "III"; ?>',
                plugBoard: '<?= isset($plugPairs) ? implode(" ", $plugPairs) :"";?>',
                options: ['I', 'II', 'III', 'IV', 'V'],
                filteredOptions1: ['I', 'II', 'III', 'IV', 'V'], 
                filteredOptions2: ['I', 'II', 'III', 'IV', 'V'],
                filteredOptions3: ['I', 'II', 'III', 'IV', 'V'],
                showKeyboard: false,
                availableLetters: '<?= isset($avalaibleLetterForPlugboard)?  $avalaibleLetterForPlugboard :  "ABCDEFGHIJKLMNOPQRSTUVWXYZ" ?>',
            }
        },

        watch: {
        plugBoard(newVal) {
            if (newVal.length % 3 === 2) {this.plugBoard += ' ';}
        },


    },
        methods: {

            updateRotor1Pos() {
                // Perform any additional logic when rotor1Pos changes
                console.log('Rotor 1 Position updated:', this.rotor1);
                console.log('Rotor 2 Position updated:', this.rotor2);
                console.log('Rotor 3 Position updated:', this.rotor3);
            },

            updateRotorOption() {
                const selectedRotor1 = this.OptionRotor1;
                const selectedRotor2 = this.OptionRotor2;
                const selectedRotor3 = this.OptionRotor3;
                this.filteredOptions1 = this.options.filter(option => option !== selectedRotor2 && option !== selectedRotor3) ;
                this.filteredOptions2 = this.options.filter(option => option !== selectedRotor1 && option !== selectedRotor3);
                this.filteredOptions3 = this.options.filter(option => option !== selectedRotor2 && option !== selectedRotor1);
            },

            addLetter(letter) {
            // Function to add a letter to the plugBoard input
            if (this.plugBoard.length < 38 && !this.plugBoard.includes(letter)) {
                this.plugBoard += letter;
                console.log(this.availableLetters);
                this.availableLetters = this.availableLetters.split('').filter((char) => char != letter).join('');
                console.log(this.availableLetters);
            }
            this.showKeyboard = false; // Hide the keyboard after clicking a letter
        },

        },

        mounted() {

            this.updateRotor1Pos();
            this.updateRotorOption();
           
        }
    }).mount('#app');


    </script>
</body>
</html>

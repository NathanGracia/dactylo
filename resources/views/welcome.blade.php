@extends('layout')
@section('body')
<form style="display: none" action="/score" method="POST" id="form">
    @csrf
    <input type="hidden" id="goodWords" name="goodWords" value="OUI"/>
    <input type="hidden" id="badWords" name="badWords" value="non"/>
</form>
    <div class="d-flex col-md-12 align-middle" style="">




        <div class="d-flex flex-column col-md-12 align-self-center">
            <hr style="margin-top: 10%">
            <div class="d-flex "style="">
                <h1 class="col-md-4 text-right" id="previousWord" style=" opacity: 0.5;"> Mot précedent </h1>
                <h1 class="col-md-4 " id="targetword">Dactylo</h1>
                <h1 class="col-md-4" id="nextWord" style="text-align: left; opacity: 0.5;"> Mot suivant </h1>
            </div>
            <hr style="margin-top: 1%">
            <div class="flex-row d-flex justify-content-center">
                <input type="text" id="main" class="form-control col-md-4">
            </div>
            <hr style="margin-bottom: 10%">
            <div class="d-flex col-md-12">
                <h1 class="col-md-6" id="badWords" style=" color: #FAA18E"> Mots incorrects</h1>
               
                <h1 class="col-md-6"id="goodWords"  style=" color: #66FA4F">Mots validés</h1>
            </div>
            <hr style="margin-bottom: 1%">
            <div class="d-flex col-md-12">
                
                <h1 class="col-md-12" id="" style=" color: #969696"><label id="minutes">00</label>:<label id="seconds">00</label></h1>
                
            </div>

        </div>

        



    </div>

@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
    <script>
        //init
        $.get("js/words.json", function(data) {
          
            targetWords = data['words'];
            init(targetWords);
        });

        function init(targetWords = ['banane', 'pomme', 'cerise', 'oui']) {
           
        
        

            shuffle(targetWords);
            let wordOffset = 0;
            let result = {};
            let currentTargetWord = targetWords[0];
            $('#targetword').html(currentTargetWord);
            let nextTargetWord = targetWords[1];
            $('#nextWord').html(nextTargetWord);

            let goodWords = 0;
            let badWords = 0;
      





            $("#main").on("input", function() {
                input = $(this).val();

                // Print entered value in a div box

                let equality = checkEquality(input, currentTargetWord);
                //console.log(input + " " + currentTargetWord)
                //check si c'est un espace, si oui on change de mot
                if (input[input.length - 1] == " ") {
                    
                    nextWord(input);
                }

                if (equality) {

                    $('#main').attr('style', 'color: #32CD32	;');
                } else {
                    $('#main').attr('style', 'color: red;');
                }
                console.log(result);

                function nextWord(input) {
                    scoreWord(checkFinalEquality(jQuery.trim(input).substring(0, input.length - 1), true));
                    changeWord();
                    updateScore();

                }
            });
            function shuffle(a) {
                var j, x, i;
                for (i = a.length - 1; i > 0; i--) {
                    j = Math.floor(Math.random() * (i + 1));
                    x = a[i];
                    a[i] = a[j];
                    a[j] = x;
                }
                return a;
            }
            function checkEquality(string) {

                targetWord = currentTargetWord;
                var shortText = jQuery.trim(targetWord).substring(0, string.length)

                return isEgal(shortText, string);
            }

            function checkFinalEquality(string) {

                targetWord = currentTargetWord;
                return isEgal(targetWord, string);
            }


            function isEgal(string, otherString) {

                if (string == otherString) {
                    return true;
                } else {
                    return false;
                }
            }


            function changeWord() {
                console.log($("#goodWords").attr('teeeest', 'oui'));
                console.log('oui');
                wordOffset++;
                currentTargetWord = targetWords[wordOffset];

                previousWord = targetWords[wordOffset - 1];
                nextWord = targetWords[wordOffset + 1];
                $('#targetword').html(currentTargetWord);
                $('#previousWord').html(previousWord);
                if (result[previousWord]) {
                    $('#previousWord').attr('style', 'color: #32CD32; ')
                } else {
                    $('#previousWord').attr('style', 'color: red; ')
                }
                $('#nextWord').html(nextWord);
                $('#main').val("");

            }

            function scoreWord(equality) {

                result[currentTargetWord] = equality;
                if(equality){
                    goodWords ++;
                }
                else{
                    badWords ++;
                }
            }
            function updateScore(){
                $('#badWords').html(badWords);
                $('#goodWords').html(goodWords);
            }

         
        }
        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        var totalSeconds = 0;
        setInterval(setTime, 1000);

        function setTime() {
            ++totalSeconds;
            secondsLabel.innerHTML = pad(totalSeconds % 60);
            minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
            if(totalSeconds==6){
                $("#goodWords").attr('test','test2');
                $("#badWords").val(badWords);
                
            }
         
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }
        
    </script>
    

@endsection

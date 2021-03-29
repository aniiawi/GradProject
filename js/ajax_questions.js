var allQuestions = null;
var xmlhttp = new XMLHttpRequest();
$("#labname").show();

var data = fetch('questions/questions_lab1_odnom.json')
	.then(response => response.json());

//var mydata = JSON.parse(data);
//var others = data["choices"];

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        allQuestions = JSON.parse(this.responseText);
        console.log(allQuestions);

        var currentPage = -1;
        var totalScore = 0;
        var review = false;

        $(document).ready(function () {
            $("#labname").show();
            $("#quiz").hide();
            $("#alert").hide();
            $("#nextButton").html("Начать тест");


            $("#nextButton").click(function(){
                $("#nextButton").html("Далее");

                var answerArray = $("#myForm").serializeArray();

                // check if question has been answered
                if(answerArray.length==0 && currentPage>=0 && review==true) {
                    $("#alert").html("Пожалуйста, выберите ответ");
                    $("#alert").fadeIn('fast');
                } else {
                    $("#alert").hide();

                    if(review) {
                        // evaluate question answered and add to score
                        $("input[type=radio]").attr('disabled', true);
                        $(".a"+allQuestions[currentPage].correctAnswer).addClass("correctAnswer");
                        if(answerArray[0].value == allQuestions[currentPage].correctAnswer) {
                            totalScore++;
                        } else {
                         $(".a"+answerArray[0].value).addClass("wrongAnswer");
                        }

                        review = false; // review completed
                    } else {
                        $("#content").fadeOut('slow',function(){
                            currentPage++; // iterate to next question
                            if(currentPage==allQuestions.length){ // Show Score
                                // quiz is over
                                $("p").show();
                                $("#quiz").hide();
                                $("#nextButton").hide();
                                $("p").html("Вы правильно ответили на <span class='score'>"+totalScore+"/"+allQuestions.length+"</span> вопросов!");
                            } else {
                                review = true; // turn review on for next question
                                var thisQ = allQuestions[currentPage];
                                // display a question
                                $("p").hide();
                                $("#quiz").show();
                                $("#form-question").html(thisQ.question);
                                $("#form-answers").empty();
                                var choiceArray = thisQ.choices;
                                for(var i=0; i<choiceArray.length; i++) {
                                	
                                    $("#form-answers").append('<div class="form-radio a'+i+'"><input type="radio" name="q'+currentPage+'" value="'+i+'"> ' + choiceArray[i] + '</div>');
                                }
                            }
                        });
                        $("#content").fadeIn('slow');
                    }

                }
            })
        });
        
    } 
};
xmlhttp.open("GET", "questions/questions_lab1_odnom.json", true);
xmlhttp.send();
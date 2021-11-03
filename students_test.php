<?php
//include_once 'compile_all.php';
/**
 * Created by PhpStorm.
 * User: mv09061997
 * Date: 25-Nov-20
 * Time: 6:08 PM
 */
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">


<script>
    $(document).ready(function () {
        alert('Hi')

//          question1||option1|option2|option3|option4||answeroption|||question2||option1|option2|option3|option4||answeroption

        required_format='';

        var url = 'https://opentdb.com/api.php?amount=10&category=27&difficulty=easy&type=multiple';
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, false);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response=JSON.parse(xhr.responseText);
                var json_results=response.results;
                var Questions=[];
                var options=[];
                var answers_option=[];

                $(json_results).each(function (i,j) {
                    Questions.push(j.question);

                    var opt=j.incorrect_answers;
                    opt.push(j.correct_answer);
                    var up_to=[];
                    for( var i=0;i < 50;i++ ){
                        var random_num=Math.floor(Math.random() * 4);
                        if((up_to.indexOf(random_num))=='-1'){
                            up_to.push(random_num);
                        }
                    }
                    var option_temp=[opt[up_to[0]],opt[up_to[1]],opt[up_to[2]],opt[up_to[3]]];
                    var corrent_answer=j.correct_answer;
                    var need_to_push_options='';

                    $(option_temp).each(function (l, m) {

                        if(m==corrent_answer){
                            answers_option.push((l+1));
                        }
                        if(l==0){
                            need_to_push_options +=m;
                        }else {
                            need_to_push_options +='|'+m;
                        }
                    });
                    options.push(need_to_push_options);
                });


                $(Questions).each(function (key, value) {
                    if(key==0){
                        required_format +=Questions[key]+'||'+options[key]+'||'+answers_option[key];
                    }else {
                        required_format +='|||'+Questions[key]+'||'+options[key]+'||'+answers_option[key];
                    }
                });
//                console.log(required_format);


            }
        };
        xhr.send();

        single_question=required_format.split('|||');

        function find_right_option(question_number) {
//            resquest question_number
//            response answer option
            var arr=[];
            var answer=[];
            $(single_question).each(function (i, j) {

                var ans=j.split('||')[2];
                arr.push(ans);

                var option=j.split('||')[1];
                var option_choose=option.split('|');

                $(option_choose).each(function (i, j) {
                    if(ans==(i+1)){
                        answer.push(j);
                    }
                })
            });
            console.log(answer);
            return arr[(question_number-1)]+'|'+answer[(question_number-1)];

        }

        function start_time() {
            var one_sec=((Date.now())+1)-((Date.now()));
            var p_hidden=parseInt($('.countdown').html());
            var add=p_hidden+1;
            $('.countdown').html(add);

            var count_final='';

            var hours  =Math.floor(add / 3600);
            var mins =Math.floor((add % 3600) / 60);
            var secs =Math.floor(add % 60);

            if(mins == 0){
                count_final +='00';
            }else if(mins > 9){
                count_final +=mins;
            }else {
                count_final +='0'+mins;
            }

            if(secs < 10){
                count_final +=':0'+secs;
            }else {
                count_final +=':'+secs;
            }


            $('.time').html(count_final);
        };

        $(document).on('click','.pagination_click',function (e) {

            var click=$(this).data('use');

            $('.pag'+(click+1)).addClass('disabled');
            var click_question=single_question[click];
            var Question=click_question.split('||')[0];
            var options=click_question.split('||')[1];
            var answer=click_question.split('||')[2];
            var q=(click+1)+' . '+Question;
            var four_options=options.split('|');
            var req_append_q='<span style="font-family: Cambria;font-size: 20px">'+q+'</span><br>';
            var temp='';
            $(four_options).each(function (i, j) {
                temp +="<label class='radio parenchoose_"+(click+1)+"-"+(i+1)+"' style='margin: 5px'><input type='radio' class='choose choose_"+(click+1)+"-"+(i+1)+" choosenumber"+(click+1)+"' data-question_number="+(click+1)+" name='radio"+(click+1)+"'  data-option="+(i+1)+">"+j+"</label><br>";
            });
            req_append_q +=temp;
            $('.question_part').html(req_append_q);


        });

        $(document).on('click','.choose',function () {

            var question_number=$(this).data('question_number');
            var choosed_option=$(this).data('option');


            var answer_string=find_right_option(question_number);
            var correct_option=answer_string.split('|')[0];
            var correct_value=answer_string.split('|')[1];
            var click_class=($(this).attr('class').split(' ')[1]).split('_')[1];

            if(choosed_option != correct_option){
                $('.parenchoose_'+click_class).after('<span style="color: red" class="req_shake">Wrong answer correct answer is <b style="color: #1c7430">('+correct_value+')</b></span>');
                $('.req_shake').effect('shake');

            }
            else {

                $('.parenchoose_'+click_class).after('<span style="color: darkgreen" class="req_shake">Correct answer</span>');

                var prev_mark=parseInt($('.marks').html());
                $('.marks').html(prev_mark+1);

            }

            $('.choosenumber'+question_number).each(function () {
                $(this).attr('disabled',true);
            });
        });

        $(document).on('click','.start_btn',function () {
            $('.need_remove').remove();
            $('.start').each(function () {
                $(this).css('display','block');
            });

            setInterval(start_time, 1000);
        });

        $(document).on('click','.next_btn',function () {
            var r = confirm("Please Ensure you have attended all the Questions");
            if(r==true){
//               time mark
                var final_time=$('.time').html();
                var final_answer=$('.marks').html();
                $('.start').each(function () {
                    $(this).html('');
                });

//                alert(final_answer);

                var final='<div class="form-group"><p>You have taken <b style="color: #1c7430">'+final_time+'</b> to complete the exam</p></div><div class="form-group"><p>You obtained marks is : <b style="color: #1c7430">'+final_answer+'</b> good luck ...!</p><a href="index.php">GO to login </div>';


                $('.final').html(final);

            }else {
                return false;
            }


        });

        $('.first_pag').trigger('click');

    })
</script>
<div class="need_remove">
    <button type="button" class="btn btn-block btn-info start_btn">Click to start the test</button><br>
    <div class="container">
        <b>Instructions : </b><br>

        <ol>
        <li>Click the above button to start the test </li>
        <li>Once you click the <b>pagination</b> (Question number sequence) it will going to disable</li>
        <li>Once you attended the question Again you cannot do this </li>
    </ol>
    </div>
</div>

<div class="container start final" style="background-color: whitesmoke;height: 400px;display: none;margin-top: 5%">
        <nav class="navbar navbar-light" style="background-color: whitesmoke;">
            <span style="color: #86cfda;text-align: center">WELCOME TO XYZ PUBLIC SCHOOL</span>
        </nav>
        <div class="row">
            <div class="col-8 question_part"></div>
            <div class="col-4 answer_part">
                <p style="color:red">Count down  : <span class="time" style="color: red">00:00</span><span class="countdown" hidden>0</span></p>
                <p style="color:green">Your marks is : <span class="marks" style="color: green">0</span></p></div>
        </div>
    </div>
<div class="container start" style="display: none">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">

                <li class="page-item pag1"><a class="page-link pagination_click first_pag" href="#" data-use="0">1</a></li>
                <li class="page-item pag2"><a class="page-link pagination_click" href="#" data-use="1" >2</a></li>
                <li class="page-item pag3"><a class="page-link pagination_click" href="#" data-use="2">3</a></li>
                <li class="page-item pag4"><a class="page-link pagination_click" href="#" data-use="3">4</a></li>
                <li class="page-item pag5"><a class="page-link pagination_click" href="#" data-use="4">5</a></li>
                <li class="page-item pag6"><a class="page-link pagination_click" href="#" data-use="5">6</a></li>
                <li class="page-item pag7"><a class="page-link pagination_click" href="#" data-use="6">7</a></li>
                <li class="page-item pag8"><a class="page-link pagination_click" href="#" data-use="7">8</a></li>
                <li class="page-item pag9"><a class="page-link pagination_click" href="#" data-use="8">9</a></li>
                <li class="page-item pag10"><a class="page-link pagination_click" href="#" data-use="9">10</a></li>
            </ul>
        </nav>
        <button type="button" class="btn btn-primary next_btn start" style="margin-left: 45%;display: none;text-align: center">Submit</button>

    </div>




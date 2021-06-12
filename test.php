<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajax Test</title>
</head>
<body>
<!-- Trial 5 .load()
<button id='tr5-list-questions'>List Questions</button>
<div id='tr5-result-pane'>Message here!</div>
<script>
    $(document).ready(function() {
        $('#tr5-list-questions').click(function () {
            tr5_list_questions();
        });
    });
    // When the button is clicked, list_questions().

    function tr5_list_questions() {
        var controller = "truqa_list_questions.php";
        var query="page='MainPage'&command='ListQuestions'";
        $('#tr5-result-pane').load(controller, query, function(
            response,status, xhr){}
        );
    };
</script>
-->
<button type='button' id='tr6-list-questions'>List Questions</button>
<div id='tr6-result-pane'>Message here!</div>
<script>
    //trial 6 post
    $(document).ready(function(){
        $('#tr6-list-questions').click(function(){
            tr6_query();
        });
    });


    function tr6_query() {
        var controller = "truqa_list_questions.php";

        $.post(controller,   // jQuery post() to the above controller
        {
            page: 'MainPage',
            command: 'ListQuestions'  // page and command in an object
        },
        function(data, status) {  // a callback function
            //$('#tr6-result-pane').append(data)  // display it into '#tr6-result-pane'
        }   $('#tr6-result-pane').html(data);
        );
        };

</script>



</body>
</html>

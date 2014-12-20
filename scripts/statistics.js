$(document).ready(function(){
    var questionTable = $('#questions_table');
    var limit = { bottom: 0, number: 15 };
    var loadingImg = $('#loading_div');
    var nextBtn = document.getElementsByClassName('listButton')[0];
    var prevBtn = document.getElementsByClassName('listButton')[1];

    nextBtn.onclick = function(){
        limit.bottom += 15;
        questionTable.html(loadingImg.html());
        setTableWidth(true);
        loadData(questionTable);
    };

    prevBtn.onclick = function(){
        if(limit.bottom - 15 >= 0) {
            limit.bottom -= 15;
            questionTable.html(loadingImg.html());
            setTableWidth(true);
            loadData(questionTable);
        }
    };

    var loadData = function(obj) {
        $.ajax({
            url: 'ReadAnswerList.php?bottom=' + limit.bottom + '&number=' + limit.number,
            type: "GET",
            cache: false,
            success: function (html) {
                obj.html(html);
                loadingImg.hide();
                setTableWidth(false);
            }
        });
    };

    var setTableWidth = function(variable){
        if(variable == true){
            questionTable.width('auto');
            questionTable.height(500);
            return 0;
        }

        questionTable.width('auto');
        questionTable.height('auto');
    };

    questionTable.html(loadingImg.html());
    setTableWidth(true);
    loadData(questionTable);
});

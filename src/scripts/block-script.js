document.addEventListener('DOMContentLoaded', function () {
    let typingTimer;
    let doneTypingInterval = 1000;
    let searchKeyword  = document.getElementById('filterText');
    let selectCategory = document.getElementById('filterOption');
    const ajaxTarget = localized_filter_book_form.admin_ajax_url;
    const ajaxNonce = localized_filter_book_form.nonce;
    searchKeyword.addEventListener('keyup', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(filterBookData, doneTypingInterval);
    });

    selectCategory.addEventListener('change', ()=>{
        clearTimeout(typingTimer);
        filterBookData();
    });

    function filterBookData () {
        const tbody = document.getElementById("bookDetails").getElementsByTagName('tbody')[0];
        tbody.innerHTML = "";
        const searchText = searchKeyword.value;
        const bookCategory = selectCategory.value;
        const request = new XMLHttpRequest();
        request.open('POST', ajaxTarget, true); //eslint-disable-line
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8'); //eslint-disable-line
        request.onload = function ajaxLoad() {
            const response = request.responseText;
            const returnJson = JSON.parse(response);
            if (request.status === 200 && returnJson.data.tableData !== 'none') {
                const tableData = returnJson.data.tableData;
                for (let i = 0; i < tableData.length; i++) {
                    tbody.innerHTML +='<tr><td class="bookImg"><img src="'+tableData[i].thumbnail+'"</td><td>'+tableData[i].title+'</td><td>'+tableData[i].author+'</td><td>'+tableData[i].description+'</td></tr>';
                };
            } else {
                tbody.innerHTML +='<tr class="noData"><td>Sorry! No book data found according to filter</td></tr>';
            }
        }
        request.send(`action=filter_book_result&searchText=${searchText}&bookCategory=${bookCategory}&_ajaxnonce=${ajaxNonce}`); //eslint-disable-line
    }
});
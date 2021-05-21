$(document).ready(function() {
    // emplement my table with the component DataTable 
    // that help to filtered pagined and more
    const table = $('#myTable').DataTable({

        "scrollX":true,
        dom: 'p t r',
        "pageLength": 5,
        "language": {
            url: 'http://cdn.datatables.net/plug-ins/1.10.24/i18n/fr_fr.json'
        },

    })
    // add listener to use DataTable wen key up on the search input 
    $('input#search').on('keyup click', function() {
        table.search(
            $(this).val(),
        ).draw();
    });
    // set time out befor slide sucecces mesage up
    setTimeout(function() {
        $('#sucess_message').slideUp("slow");
    }, 5000);
});
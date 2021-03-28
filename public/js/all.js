$(document).ready(function() {
    function filterGlobal() {
        $('#myTable').DataTable().search(
            $('#search').val(),
        ).draw();
    }

    const table = $('#myTable').DataTable({
        dom: 'p t r',
        "pageLength": 5,
        "language": {
            url: 'http://cdn.datatables.net/plug-ins/1.10.24/i18n/fr_fr.json'
        }
    });

    $('input#search').on('keyup click', function() {
        console.log('tap');
        table.search(
            $(this).val(),
        ).draw();
        // filterGlobal();
    });
    setTimeout(function() {
        console.log('dddd')
        $('#sucess_message').slideUp("slow");
    }, 5000);
});
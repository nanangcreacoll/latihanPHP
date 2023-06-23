$(document).ready(function () {
    $('#tombol-cari').hide();

    $('#keyword').on('keyup', function () {
        $('.loading-icon').show();

        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data) {
            $('#container').html(data);
            $('.loading-icon').hide();
        });
        // $('#container').load('./ajax/mahasiswa.php?keyword=' + $('#keyword').val()); 
    });
});
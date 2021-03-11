$(document).ready(function() {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image_link").change(function() {
        alert('toto')
        readURL(this);
    });

    let barUrl = $("#add-image").data("url");
    console.log(barUrl)
    $('#deleteImg').click(function(e) {
        e.preventDefault();
        let entity = {}
        if ($(this).data('idrecipe')) {
            entity['recipe'] = $(this).data('idrecipe')
        } else {
            entity['article'] = $(this).data('idarticle');
        }
        let data = $(this).data('idrecipe') ? 'recipe' : 'article';
        alert(data)
        $.post(barUrl + '/' + data + '/addImage', {
            entity,
        }, (response) => {
            addImage(response)
            alert(response)
        });
    })

    $('#recipeImg').on('submit', function(e) {
        e.preventDefault();
        var recipe = $('#add-image').data("id");
        let barUrl = $(this).data("url");
        var formData = new FormData(this);
        if (recipe) {
            alert($('#img-url').html())
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log("success");
                    console.log(data);
                    if (data == "FILE_TYPE_ERROR") {
                        alert("le type de fichier est incorrect")
                    } else if (data == "FILE_SIZE_ERROR") {
                        alert("le fichier est trop volumineux")
                    } else {
                        addImage(data)
                        alert(data);
                    }
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        } else {
            alert("Veuillez d'abord céer une recette")
        }


        // $.post(barUrl + '/recipe/addImage', {
        //     "recipe": formData,
        // }, (response) => {
        //     console.log("success");
        //     console.log(response);
        //     if (response == "FILE_TYPE_ERROR") {
        //         alert("le type de fichier est incorrect")
        //     } else if (response == "FILE_SIZE_ERROR") {
        //         alert("le fichier est trop volumineux")
        //     } else {
        //         $('#img-url').html(response)
        //         $('#image').attr('src', response);
        //         alert(response);
        //     }
        // });

    })

    function addImage(data) {
        var imgUrl = data.split("/");

        $('#img-url').html(imgUrl[imgUrl.length - 1])
        $('#image').attr('src', data);
    }

})
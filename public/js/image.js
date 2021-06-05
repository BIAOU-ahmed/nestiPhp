$(document).ready(function() {
    //  this function is to display dinamicly the image selected in the file input 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    // listener to change the image when the input file changed 
    $("#image_link").change(function() {
        readURL(this);
    });

    let barUrl = $("#add-image").data("url");
    // listener to delete the image 
    $('#deleteImg').click(function(e) {
        e.preventDefault(); //abort the default action
        let entity = {}
        if ($(this).data('idrecipe')) {
            entity['recipe'] = $(this).data('idrecipe') // add the id recipe
        } else {
            entity['article'] = $(this).data('idarticle'); // add the id article
        }
        let data = $(this).data('idrecipe') ? 'recipe' : 'article';
        // alert(data)
            // send the ajax request with id recipe or id article
        $.post(barUrl + '/' + data + '/addImage', {
            entity,
        }, (response) => {
            addImage(response)
            // alert(response)
        });
    })

    // listener to add new image
    $('#recipeImg').on('submit', function(e) {
        e.preventDefault();
        var recipe = $('#add-image').data("id");
        let barUrl = $(this).data("url");
        var formData = new FormData(this);
        if (recipe) {
            // ajax request to the endpoint to add the new Image
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == "FILE_TYPE_ERROR") {
                        alert("le type de fichier est incorrect")
                    } else if (data == "FILE_SIZE_ERROR") {
                        alert("le fichier est trop volumineux")
                    } else {
                        addImage(data)
                    }
                },
                error: function(data) {
                    alert("Une erreur est survenue lors de l'ajout de l'image");
                }
            });
        } else {
            alert("Veuillez d'abord céer une recette")
        }


    })

    // change the src of the image by the data
    function addImage(data) {
        var imgUrl = data.split("/");

        $('#img-url').html(imgUrl[imgUrl.length - 1])
        $('#image').attr('src', data);
    }

})
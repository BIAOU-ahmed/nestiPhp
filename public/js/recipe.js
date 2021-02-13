$(document).ready(function() {
    $('#add-image').click(function() {
        $('#recipe-image').html("")
        var order = $(this).data("id");
        let barUrl = $(this).data("url");
        // console.log(order)
        // console.log(barUrl)
        // if (order != "") {
        $.ajax({
                type: 'POST',
                url: barUrl + '/recipe/addImage',
                data: 'order=1',
                success: function(data) {
                    if (data != "") {

                        $('#recipe-image').append(data);

                    }

                }

            })
            // }
    })

    $('#addprep').click(function() {
        $('#modal').removeClass('hidden')
    })

    $('#add-preparation').click(function() {
        // $('#ingredient-list').html("")
        var recipe = $(this).data("id");
        let barUrl = $(this).data("url");
        let preparationContent = $("#preparationsContent").val();

        // console.log(recipe)
        // console.log(barUrl)
        if (recipe != "") {


            $.post(barUrl + '/recipe/addPreparations', {
                "recipe": encodeURIComponent(recipe),
                "preparationContent": preparationContent
            }, (response) => {
                // let array = PSON.parse(response);
                // $('#new-content').val(response);
                addParagraph(response);

            });

        }
    })



    $('#add-ingredient').click(function() {
        // $('#ingredient-list').html("")
        var recipe = $(this).data("id");
        let barUrl = $(this).data("url");
        let ingredientName = $("#ingredient").val();
        let unitName = $("#unit").val();
        let quantity = $("#quantity").val();
        // console.log(recipe)
        // console.log(barUrl)
        if (recipe != "") {


            $.post(barUrl + '/recipe/addIngredient', {
                "recipe": encodeURIComponent(recipe),
                "ingredientName": encodeURIComponent(ingredientName),
                "unitName": encodeURIComponent(unitName),
                "quantity": encodeURIComponent(quantity)
            }, (response) => {
                // let array = PSON.parse(response);
                addIngredientRecipe(response);
            });

        }
    })
    var recipe = $("#add-ingredient").data("id");
    let barUrl = $("#add-ingredient").data("url");
    // console.log(recipe)
    // console.log("url" + barUrl)
    $.post(barUrl + '/recipe/addIngredient', {
        "load": encodeURIComponent(recipe),
    }, (response) => {
        // alert(response);
        addIngredientRecipe(response);
    });

    $.post(barUrl + '/recipe/addPreparations', {
        "load": encodeURIComponent(recipe),
    }, (response) => {
        // alert(response);
        addParagraph(response);
    });

    function addIngredientRecipe(data) {
        // alert(data)
        if (data == false) {
            alert("test")
        } else {
            $('#ingredient-list').html("")
                // alert(data)
            let n = JSON.parse(data)
                // console.log(n)

            for (var k in n) {
                let item = '<div class="flex justify-between mb-2"> <li  >' + n[k].quantity + " " + n[k].unitName + " de " + n[k].ingredientName + '</li> <button  data-idrecipe="' + n[k].idRecipe + '" data-idproduct="' + n[k].idProduct + '" class="deleteIngredient md:ml-2 md:w-1/6 lg:w-1/12 bg-indigo-500 text-gray-100  rounded">' +
                    'X' +
                    '</button> </div>';
                $('#ingredient-list').append(item)
            }
        }

        $('.deleteIngredient').click(function() {
            // $('#ingredient-list').html("")

            var el = $(this)
                // let button = el[0].querySelector('button')
            var recipe = $(this).data("idrecipe");
            var product = $(this).data("idproduct");
            // console.log(barUrl)
            $.post(barUrl + '/recipe/addIngredient', {
                "recipe": encodeURIComponent(recipe),
                "idProduct": encodeURIComponent(product),
            }, (response) => {
                // let array = PSON.parse(response);
                // alert(response)
                addIngredientRecipe(response);
            });

            console.log($(this))
            console.log(recipe)
            console.log(product)

        })

        $("#ingredient").val("");
        $("#unit").val("");
        $("#quantity").val("");
    }

    function addParagraph(data) {
        $('#paragraph-container').html("")
            // alert(data)
        let n = JSON.parse(data)
        for (var k in n) {
            let maxpreparation = Object.keys(n).length;
            // console.log(Object.keys(n)[0])
            // console.log(Object.keys(n)[maxpreparation-1])
            let content = ' <div class="flex mr-1 mb-5 ">' +
                '<div class="inline-block h-full self-center mr-3">';
            if (Object.keys(n)[0] != k) {
                content += '<button  class="moveParagraph block my-2"data-idRecipe="' + recipe + '" data-id="' + n[k].id + '"data-action="up"><i class="text-center bg-yellow-500 text-white pt-1 text-3xl h-10 w-10 border block fas fa-arrow-up "></i> </button>'
            }
            if (Object.keys(n)[maxpreparation - 1] != k) {
                content += '<button class="moveParagraph block my-2" data-idRecipe="' + recipe + '" data-id="' + n[k].id + '"data-action="down"><i class="text-center bg-yellow-400 text-white pt-1 text-3xl h-10 w-10 border block fas fa-arrow-down "></i></button>';
            }

            content += '  <div x-data="{ showModal: false }" :class="{' + "'overflow-y-hidden': showModal }" + '">' +
                '<main class="flex flex-col sm:flex-row justify-center items-center">' +

                '<button  @click="showModal = true" class="block"><i class="rounded text-center pt-1 text-3xl h-10 w-10 bg-red-600 border text-white block fas fa-trash-alt my-2"></i></button>' +

                '</main>' +


                '<div class="fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">' +
                '<div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">' +
                '<div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal = false" x-show="showModal" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">' +



                '<header class="w-full h-40 grid mb-5 flex items-center  ">' +
                '<div class=" w-full   grid  bg-white h-20">' +

                '<h2 class=" font-semibold text-center justify-self-center self-center "><i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i> Voulez-vous vraiment supprimer l' + "'element: " + n[k].id + " ?</h2>" +

                "</div>" +

                '</header>' +
                '<main class="  h-20 grid   p-2 text-center">' +
                '<p class="w-2/3 justify-self-center bg-white rounded-md">' +
                'Cette action est définitive et irréversible' +
                '</p>' +
                '</main>' +
                '<footer class="">' +

                '<div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">' +
                '<button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal = false">' +
                '<span class="text-lg"> Annuller </span>' +
                '</button>' +

                '<div class="bg-green-500 ml-5 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">' +
                '<button @click="showModal = false" name="delete" type="submit" value="1" class="deletePara text-lg text-center  block lg:inline-block lg:mt-0" data-idrecipe="' + recipe + '" data-id="' + n[k].id + '"+>' +
                'Confirmer </button>' +


                '</div>' +
                '</div>' +
                '</footer>' +



                '</div>' +
                '</div>' +
                '</div>' +

                '</div>' +



                '</div>' +
                '<div class="inline-block w-full">' +
                '<textarea id="para"   class=" resize-none w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="5" data-idRecipe="' + recipe + '" data-id="' + n[k].id + '">' + n[k].content + '</textarea>' +
                '</div>' +

                '</div>';
            $('#paragraph-container').append(content)
            $("#preparationsContent").val("");

        }
        // $("textarea#para").css('user-select', 'none').bind("selectstart", false);
        // $("textarea#para").dblclick(function() {
        //     $("textarea#para").prop('readonly', false);
        //     // alert($(this).val())
        //     // alert("Handler for .dblclick() called.");
        // });
        $("textarea#para").focusout(function() {
            var recipe = $(this).data("idrecipe");
            var idPrep = $(this).data("id");
            var newValue = $(this).val();
            $.post(barUrl + '/recipe/addPreparations', {
                "update": encodeURIComponent(idPrep),
                "recipe": encodeURIComponent(recipe),
                "newValue": newValue,
            }, (response) => {
                // alert(response);
                addParagraph(response);
            });
            // $(this).css("background-color", "#FFFFCC");
            // alert($(this).val())
            // $("textarea#para").prop('readonly', true);
        });

        $('.moveParagraph').click(function() {
            // $('#ingredient-list').html("")

            var recipe = $(this).data("idrecipe");
            var para = $(this).data("id");
            var action = $(this).data("action");
            console.log(recipe)
                // let barUrl = $(this).data("url");
                // let preparationContent = $("#preparationsContent").val();

            // console.log(recipe)
            // console.log(barUrl)
            if (recipe != "") {


                $.post(barUrl + '/recipe/movePreparations', {
                    "recipe": encodeURIComponent(recipe),
                    "action": encodeURIComponent(action),
                    "id": encodeURIComponent(para)
                }, (response) => {
                    // let array = PSON.parse(response);
                    // $('#new-content').val(response);
                    // alert(response)
                    addParagraph(response);

                });

            }
        })

        $('.deletePara').click(function() {
            // $('#ingredient-list').html("")

            var recipe = $(this).data("idrecipe");
            var para = $(this).data("id");
            console.log(recipe)
                // let barUrl = $(this).data("url");
                // let preparationContent = $("#preparationsContent").val();

            // console.log(recipe)
            // console.log(barUrl)
            if (recipe != "") {


                $.post(barUrl + '/recipe/addPreparations', {
                    "recipe": encodeURIComponent(recipe),
                    "deletedPara": encodeURIComponent(para)
                }, (response) => {
                    // let array = PSON.parse(response);
                    // $('#new-content').val(response);
                    alert(response)
                        // addParagraph(response);

                });

            }
        })

    }












})
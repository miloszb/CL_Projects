var formLegendAdd = 'Nowa książka';
var formLegendUpdate = 'Zmiana danych';
var buttonTextAdd = 'Dodaj książkę';
var buttonTextUpdate = 'Wprowadź zmiany';
var formUpdateMode = false;

function setFormUpdateMode(updateMode) {
    var bookForm = $('#bookForm');
    if (updateMode) {
        bookForm.find('fieldset').css('background-color', '#eee');
        bookForm.find('legend').text(formLegendUpdate);
        bookForm.find('button').text(buttonTextUpdate);
        return true;
    } else {
        bookForm.find('fieldset').css('background-color', 'white');
        bookForm.find('legend').text(formLegendAdd);
        bookForm.find('button').text(buttonTextAdd);
        bookForm.find('[name="title"]').val('');
        bookForm.find('[name="author"]').val('');
        bookForm.find('[name="description"]').val('');
        return false;
    }
}

function listBooks(json) {
    json.forEach(function(book) {
        var bookEntry = '<br><h4 class="bookEntry" data-book="' 
                + book.id + '">' 
                + book.author + ': ' 
                + book.title + '</h4> ';
        var updateLink = '<a href="" class="bookUpdate" data-update="' 
                + book.id + '">Edytuj</a>';
        var deleteLink = '<a href="" class="bookDelete" data-delete="' 
                + book.id + '">Usuń</a>';
        $('#bookCatalog').append($(bookEntry + updateLink + deleteLink));
    });
}

$(function(){
    var bookForm = $('#bookForm');
    $.ajax({
            url:'api/books.php',
            method: 'GET'
    }).done(listBooks);
    $('#bookCatalog').on('click', '.bookEntry', function() {
        var bookId = $(this).data('book');
        var bookLink = $(this).next('a').next('a');
        $.ajax({
                url:'api/books.php',
                method: 'GET',
                data: {
                    id: bookId
                }
        }).done(function(response) {
            var descrDiv = $('[data-descr="'+bookId+'"]');
            if (!descrDiv.length) {
                var descr = response.description;
                bookLink.after($('<div class="bookDescr" data-descr="' 
                        + bookId + '">' + descr + '</div>'));
            } else {
                descrDiv.remove();
            }
        });
    });
    $('#bookCatalog').on('click', '.bookDelete', function() {
        var bookId = $(this).data('delete');
        $.ajax({
                url:'api/books.php',
                method: 'DELETE',
                data: {
                    id: bookId
                }
        }).done(function(response) {
            if (response === 'BOOK SUCCESSFULLY DELETED') {
                $('#bookCatalog').empty();
                $.ajax({
                        url:'api/books.php',
                        method: 'GET'
                }).done(listBooks);
            } else {
                $('<div>' + response + '</div>').appendTo('#bookCatalog');
            }
        });
        return false;
    });
    $('#bookCatalog').on('click', '.bookUpdate', function() {
        formUpdateMode = setFormUpdateMode(true);
        var bookId = $(this).data('update');
        $.ajax({
                url:'api/books.php',
                method: 'GET',
                data: {
                    id: bookId
                }
        }).done(function(response) {
            if (response.id && (response.id != -1)) {
                bookForm.find('[name="title"]').val(response.title);
                bookForm.find('[name="author"]').val(response.author);
                bookForm.find('[name="description"]').val(response.description);
                bookForm.data('currentId', response.id);
            } else {
                $('<div>' + response + '</div>').appendTo('#bookCatalog');
            }
        });
        return false;
    });
    bookForm.find('button').on('click', function () {
        var id = parseInt(bookForm.data('currentId'));
        var author = bookForm.find('[name="author"]').val();
        var title = bookForm.find('[name="title"]').val();
        var description = bookForm.find('[name="description"]').val();
        if (!author || !title) {
            alert('Proszę podać autora i tytuł');
            return false;
        }
        if (formUpdateMode) {
            $.ajax({
                    url:'api/books.php',
                    method: 'PUT',
                    data: {
                        id: id,
                        title: title,
                        author: author,
                        description: description
                    }
            }).done(function(response) {
                if (response === 'BOOK SUCCESSFULLY UPDATED') {
                    $('#bookCatalog').empty();
                    $.ajax({
                            url:'api/books.php',
                            method: 'GET'
                    }).done(listBooks);
                    formUpdateMode = setFormUpdateMode(false);
                } else {
                    console.log(response);
                    console.log(response.responseText);
                    $('<div>' + response + '</div>').appendTo('#bookCatalog');
                }
            });
        } else {
            $.ajax({
                    url:'api/books.php',
                    method: 'POST',
                    data: {
                        title: title,
                        author: author,
                        description: description
                    }
            }).done(function(response) {
                if (response === 'BOOK SUCCESSFULLY ADDED') {
                    $('#bookCatalog').empty();
                    $.ajax({
                            url:'api/books.php',
                            method: 'GET'
                    }).done(listBooks);
                } else {
                    $('<div>' + response + '</div>').appendTo('#bookCatalog');
                }
            });
        }
        return false;
    });
});

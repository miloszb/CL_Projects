function listBooks(json) {
    json.forEach(function(book) {
        $('<br><h4 class="bookEntry" data-book="' + book.id + '">' 
                + book.author + ': ' + book.title + '</h4> '
                + '<a href="" class="bookDelete" data-delete="' 
                + book.id + '">Usuń</a>'
                ).appendTo('#bookCatalog');
    });
}
$(function(){
    $.ajax({
            url:'http://localhost/CL_Projects/REST_API/api/books.php',
            method: 'GET'
    }).done(listBooks);
    $('#bookCatalog').on('click', '.bookEntry', function() {
        var bookId = $(this).data('book');
        var bookLink = $(this).next('a');
        $.ajax({
                url:'http://localhost/CL_Projects/REST_API/api/books.php',
                method: 'GET',
                data: {
                    id: bookId
                }
        }).done(function(response) {
            var descrDiv = $('[data-descr="'+bookId+'"]');
            if (!descrDiv.length) {
                var descr = response.description;
                bookLink.after($('<div class="bookDescr" data-descr="' 
                        + bookId +'">' + descr + '</div>'));
            } else {
                descrDiv.remove();
            }
        });
    });
    $('#bookCatalog').on('click', '.bookDelete', function() {
        var bookId = $(this).data('delete');
        $.ajax({
                url:'http://localhost/CL_Projects/REST_API/api/books.php',
                method: 'DELETE',
                data: {
                    id: bookId
                }
        }).done(function(response) {
            if (response === 'BOOK SUCCESSFULLY DELETED') {
                $('#bookCatalog').empty();
                $.ajax({
                        url:'http://localhost/CL_Projects/REST_API/api/books.php',
                        method: 'GET'
                }).done(listBooks);
            } else {
                $('<div>' + response + '</div>').appendTo('#bookCatalog');
            }
        });
        return false;
    });
    $('#addBook').find('button').on('click', function () {
        var author = $('#addBook').find('[name="author"]').val();
        var title = $('#addBook').find('[name="title"]').val();
        var description = $('#addBook').find('[name="description"]').val();
        if (!author || !title) {
            alert('Proszę podać autora i tytuł');
        } else {
            $.ajax({
                    url:'http://localhost/CL_Projects/REST_API/api/books.php',
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
                            url:'http://localhost/CL_Projects/REST_API/api/books.php',
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

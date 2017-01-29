<!DOCTYPE html>
<html>
<head>
    <title>REST API</title>
    <meta charset="UTF-8">
    <style>
        .bookEntry {
            cursor: pointer;
            display: inline-block;
            margin-right: 0.5em;
            margin-top: 0;
            margin-bottom: 0.5em;
        }
        .catTitle {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
<form id="addBook" action="#" method="post">
    <fieldset>
        <legend>Nowa książka</legend>
        <label>
            Autor:
            <br><input type="text" name="author">
        </label>
        <br><label>
            Tytuł:
            <br><input type="text" name="title">
        </label>
        <br><label>
            Opis:
            <br><textarea name="description" rows="5" cols="33"></textarea>
        </label>
        <br><button type="submit" name="add">Dodaj książkę</button>
    </fieldset>
</form>
<h3 class="catTitle">Księgozbiór</h3>
<div id="bookCatalog">

</div>
</body>
<script
    src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
    crossorigin="anonymous"></script>
<script src="api/src/app.js"></script>
</html>

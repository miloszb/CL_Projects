<?php
class Book implements JsonSerializable
{
    private $id;
    private $title;
    private $author;
    private $description;

    private $books = [];
    //stores the result of "get all" request
    
    public function __construct() 
    {
        $this->id = -1;
        $this->title = '';
        $this->author = '';
        $this->description = '';
    }
    public function getId() 
    {
        return $this->id;
    }
    public function getTitle() 
    {
        return $this->title;
    }
    public function setTitle($title) 
    {
        $this->title = $title;
        return $this;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function setAuthor($author) 
    {
        $this->author = $author;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description) 
    {
        $this->description = $description;
        return $this;
    }

    public function save(Connection $db)
    // covers both "create" and "update" functionalities
    {
        if ($this->id == -1) {
            $sql = sprintf(
                    'INSERT INTO book (id, title, author, description) '
                        . 'VALUES(NULL, "%s", "%s", "%s")',
                    $this->title,
                    $this->author,
                    $this->description
            );
            $db->query($sql);
            $this->id = $db->getInsertId();
            return $this->get($db, $this->id);
        } else {
            $sql = sprintf(
                'UPDATE book SET title = "%s", author = "%s" description = "%s"'
                        . ' WHERE id = %s',
                $this->title,
                $this->author,
                $this->description,
                $this->id
            );
            $db->query($sql);
            return $this;
        }
    }

    public function get(Connection $db, $id){
        $this->books=[];
        
        $sql = 'SELECT * FROM book WHERE id='.$id;
        $db->query($sql);
        $row = $db->getResult()->fetch_assoc();
        if($row['id']){
            $this->id = ($row['id']);
            $this->setTitle($row['title']);
            $this->setAuthor($row['author']);
            $this->setDescription($row['description']);
            return $this;
        }
        return false;
    }
    public function getAll(Connection $db) {
    // does not retrieve book descriptions
        $this->books = [];
        $sql = 'SELECT id, title, author FROM book';
        $db->query($sql);
        foreach($db->getresult() as $row) {
            $book = new Book();
            $book->id = $row['id'];
            $book->setTitle($row['title']);
            $book->setAuthor($row['author']);
            $this->books[] = $book;
        }
        return $this->books;
    }
    public static function delete(Connection $db, $id) 
    {
        $sql = 'DELETE FROM book WHERE id = ' . $id;
        $db->query($sql);
        if ($db->getAffectedRows() == 0) {
            return false;
        } else {
            return true;
        }
    }
    private function getBookAsTable(Book $book) {
        return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description
            ];
    }
    public function jsonSerialize() {
        if (count($this->books)) {
            $books = [];
            foreach($this->books as $book){
                $books[] = $this->getBookAsTable($book);
            }
            return $books;
        } else {
            return $this->getBookAsTable($this);
        }
    }
}
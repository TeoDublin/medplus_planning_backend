<?php
    function Sql(): Sql{
        return new Sql();
    }
    function Select(string $select):Select{
        return new Select($select);
    }
    function Insert(array $insert):Insert{
        return new Insert($insert);
    }
    function Update(string $table):Update{
        return new Update($table);
    }
    function Enum(string $table,string $column):Enum{
        return new Enum($table,$column);
    }
    function Delete(string $id):Delete{
        return new Delete($id);
    }
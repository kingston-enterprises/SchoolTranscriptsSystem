<?php

class m0009_insert_teacher_role {
    public function up()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "INSERT INTO roles (
            title,
            description
        ) VALUES (
            'teacher',
            'teachers have course related permissions'
            )";

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "DELETE FROM roles WHERE `title` = 'teacher';";
        $db->pdo->exec($SQL);
    }
}

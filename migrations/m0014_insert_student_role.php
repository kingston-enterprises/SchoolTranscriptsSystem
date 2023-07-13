<?php

class m0014_insert_student_role {
    public function up()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "INSERT INTO roles (
            title,
            description
        ) VALUES (
            'student',
            'students have registration related permisssions'
            )";

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "DELETE FROM roles WHERE `title` = 'student';";
        $db->pdo->exec($SQL);
    }
}

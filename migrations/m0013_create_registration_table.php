<?php

class m0013_create_registration_table {
    public function up()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS registration (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT,
            course_id INT,
            FOREIGN KEY (student_id) REFERENCES users (id),
            FOREIGN KEY (course_id) REFERENCES courses (id)
        );";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "DROP TABLE IF EXISTS registration;";
        $db->pdo->exec($SQL);
    }
}

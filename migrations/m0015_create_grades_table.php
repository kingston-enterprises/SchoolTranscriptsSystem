<?php

class m0015_create_grades_table {
    public function up()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS grades (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT,
            course_id INT,
            grade INT,
            FOREIGN KEY (course_id) REFERENCES courses (id)
        );";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "DROP TABLE IF EXISTS grades;";
        $db->pdo->exec($SQL);
    }
}

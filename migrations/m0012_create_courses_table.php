<?php

class m0012_create_courses_table {
    public function up()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS courses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            code VARCHAR(100) NOT NULL,
            instructor INT,
            FOREIGN KEY (instructor) REFERENCES users (id)
        );";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "DROP TABLE IF EXISTS courses;";
        $db->pdo->exec($SQL);
    }
}

<?php

class m0010_alter_users_table {
    public function up()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "ALTER TABLE users ADD id_number INT(10) NOT NULL;";

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = kingston\icarus\Application::$app->db;
        $SQL = "ALTER TABLE users DROP id_number;";
        $db->pdo->exec($SQL);
    }
}

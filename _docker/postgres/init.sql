   SELECT 1
   FROM pg_database 
   WHERE datname = 'test_task_db_testing';

   CREATE DATABASE test_task_db_testing;

   GRANT ALL PRIVILEGES ON DATABASE test_task_db_testing TO test_task_admin;
# docker/database

These SQL files were dumped from the BLIS database that shipped with the 
standalone version 3.72.

They are used to seed the database in the Docker containers.

If you want to update them:

1. Create the database state locally that you want to be the basis of the devcontainer
2. Dump the databases using `mysqldump`.
3. Make sure that each database dump includes a section like this at the top:

   ```sql
   CREATE TABLE IF NOT EXISTS table_name;
   USE table_name;
   ```

   If it doesn't, then add one yourself.

4. _Delete the SQL files in this directory_
5. Add the files you created
6. The files won't be executed by the MySQL container if it already exists (see [the MySQL container documentation](https://hub.docker.com/_/mysql/)). Recreate the MySQL container (`docker compose down db` or similar)
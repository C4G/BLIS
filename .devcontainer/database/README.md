# .devcontainer/database

These SQL files were dumped from the BLIS database that shipped with the 
standalone version 3.72.

They are used to seed the devcontainer.

If you want to update them:

1. Create the database state locally that you want to be the basis of the devcontainer
2. Dump the databases
3. _Delete the SQL files in this directory_
4. Add the files you created
5. Update `post-create-command.sh` with the new dumps
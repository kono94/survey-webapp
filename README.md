Set up environment with ``apache-webserver``, ``mysql-database`` and ``phpmyadmin``.
(Use ``--force-recreate`` flag to rebuild mysql container and copy ``import.sql`` into init.d entrypoint
to recreate the schema and all tables!)
```docker-compose up -d --force-recreate```


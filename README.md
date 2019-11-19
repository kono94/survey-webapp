Set up environment with ``apache-webserver``, ``mysql-database`` and ``phpmyadmin``.
(Use ``--force-recreate`` flag to rebuild mysql container and copy ``import.sql`` into init.d entrypoint
to recreate the schema and all tables!)
```docker-compose up -d --force-recreate```


Conventions:

- Table and column names are snake case (question_answer_option_id)
- Correct foreign key constraints (ON UPDATE cascade/ restrict) to reduce boilerplate querying while deleting a survey for example because votes will automatically be deleted as well for deleted survey!
- use shortcuts aliases in SQL-Queries "FROM survey_result AS sr"
- php variables are camel case
- prepared statements when user input is involved, simple "mysqli_query" if all parameters are intern
- seperated queries in iteration instead of big single query
- avoiding html-echoing as much as possible, using shortcuts like "<?= $var ?>" or "while():", "endwhile;"



weaknesses:
- Excessive Querying in loops instead of bigger statements and mapping afterwards
- no mechanism to block spamming surveys (cookies, authentification/login system)
- no admin authentifaction method
- inline css

stenghts:
- somewhat flexible ERM (multiple question types possible, comments/free text feature, binding question answer tuple to surveys)
- 
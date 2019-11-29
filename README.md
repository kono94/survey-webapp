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
- deleting of category is forbidden if already category is present in
at least one survey, because a survey must have a category

weaknesses:
- Excessive Querying in loops instead of bigger statements and mapping afterwards
- no mechanism to block spamming surveys (cookies, authentification/login system)
- no admin authentifaction method
- inline css

stenghts:
- somewhat flexible ERM (multiple question types possible, comments/free text feature, binding question answer tuple to surveys)
- 


Konvetionen:
- Allgemein wurde versucht alle Variablen auf Englisch zu bennenen
- SQL: Tabellen- und Spaltennamen sind singular und "snake case" (Kleinschreibung mit Unterstrichen), Beispiel "survey_answer_option"
- PHP: Variablennamen sind "camel case" (erster Buchstabe eines neuen Wortes groß, erster Buchstabe klein), Beispiel "surveySelectionQuery"
- In den meisten SQL-Queries wurden den Tabellennamen Kurzformen zugeschrieben, Beispiel: "FROM survey_voting_answer AS sva"

Stärken der Anwendung:
- Die Datenbankstruktur ist sehr flexibel, dadurch, dass Umfragen nicht direkt mit Antwortmäglichkeiten verknüpft sind. Nicht 1:N sondern N:M.
  Das macht die Abfragen etwas komplizierter, aber dafür könnte eine Antwort mehreren Umfragen zugeordnet werden und man müsste nicht für
  jede Umfrage immer und immer wieder quasi die selbe Antwort erstellen.
- Die meisten Fremdschlüssel haben in ihrer Beziehung "ON DELETE cascade" definiert. Das bedeutet, dass sich Zeilen mit dem Fremdschlüssel
  automatisch mitlöschen, wenn ihr referenzierter Primärschlüssel gelöscht wird. Das macht das Löschen von Umfragen und all seinen abgebenen Stimmen extrem einfach, denn man muss nur den Eintrag aus der Tabelle "survey" löschen. Alle referenzierten Zeilen in den anderen Tabellen 
  löschen sich automatisch mit.
- Im PHP Code werden "prepared statements" verwendet, immer wenn der Benutzer den Input für eine Variable gegeben hat, z.B. durch
  URL-Parameter vote.php?id=XXX. Damit nicht schädlicher SQL Code einfach in ein Query geparsed wird, verwendet man "prepared statements".
  Hinzu kommt, dass man angeben kann, was für einen Typ eine jeweilige Variable haben muss. Z.B. kann man für die ID nur ganze Zahlen eingeben.
- Anstatt den ganzen HTML-Code mit php echo auszugeben, wurde versucht immer wieder den php code zu schließen. Das sieht für uns     übersichtlicher aus und die HTML-Tags werden in Notepad richtig markiert. Durch den Shortcut <?php=$variable?> kann man direkt den Inhalt
einer Variablen ausgeben.
- Umfragen können sowohl Single-Select als auch Multi-Select sein und es kann jederzeit zwischen den beiden Optionen gewechselt werden.
- Es gibt relativ wenig .php files, da die Forms und das, was beim Auslösen dieser passieren soll, in einer Datei ist.

Schwächen:
- An vielen Stellen wurde CSS direkt in den HTML Code eingefügt. Besser wäre es jeglichen Style-Code in die style.css Datei auszulagern.
- Es existiert keinerlei Authentifizierung für den Adminbereich und generell kein Login-System
- Es gibt kein Mechanismus, der verhindert, dass Benutzer eine Umfrage immer und immer wieder beantworten.
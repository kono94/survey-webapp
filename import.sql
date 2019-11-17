CREATE DATABASE test;
USE test;
create table if not exists answer
(
    id    bigint auto_increment
        primary key,
    title text not null
);

create table if not exists category
(
    id   bigint auto_increment
        primary key,
    name varchar(255) not null
);

create table if not exists question_type
(
    id   bigint auto_increment
        primary key,
    name varchar(255) null
);

create table if not exists question
(
    id               bigint auto_increment
        primary key,
    title            text   null,
    question_type_id bigint not null,
    constraint question_question_type_id_fk
        foreign key (question_type_id) references question_type (id)
            on update cascade
);

create table if not exists question_answer_option
(
    id          bigint auto_increment
        primary key,
    question_id bigint not null,
    answer_id   bigint not null,
    constraint question_answer_option_answer_id_fk
        foreign key (answer_id) references answer (id)
            on update cascade on delete cascade,
    constraint question_answer_option_question_id_fk
        foreign key (question_id) references question (id)
            on update cascade on delete cascade
);

create table if not exists survey
(
    id               bigint auto_increment
        primary key,
    title            text                                not null,
    start_date       timestamp default CURRENT_TIMESTAMP not null,
    end_date         timestamp default CURRENT_TIMESTAMP not null,
    category_id      bigint                              not null,
    description_text mediumtext                          null,
    constraint survey_category_id_fk
        foreign key (category_id) references category (id)
            on update cascade
);

create table if not exists survey_question
(
    id          bigint auto_increment
        primary key,
    question_id bigint not null,
    survey_id   bigint not null,
    constraint survey_question_question_id_fk
        foreign key (question_id) references question (id)
            on update cascade,
    constraint survey_question_survey_id_fk
        foreign key (survey_id) references survey (id)
            on update cascade
);

create table if not exists survey_result
(
    id                        bigint auto_increment
        primary key,
    survey_id                 bigint not null,
    question_answer_option_id bigint not null,
    constraint survey_result_question_answer_option_id_fk
        foreign key (question_answer_option_id) references question_answer_option (id)
            on update cascade on delete cascade,
    constraint survey_result_survey_id_fk
        foreign key (survey_id) references survey (id)
            on update cascade on delete cascade
);

create table if not exists survey_result_comment
(
    id          bigint auto_increment
        primary key,
    survey_id   bigint     not null,
    question_id bigint     not null,
    value       mediumtext null,
    constraint survey_comment_question_id_fk
        foreign key (question_id) references question (id),
    constraint survey_comment_survey_id_fk
        foreign key (survey_id) references survey (id)
            on update cascade on delete cascade
);


INSERT INTO test.question_type (id, name) VALUES (1, 'Radio-Button Singleselect');
INSERT INTO test.question_type (id, name) VALUES (2, 'Freitexteingabe');
INSERT INTO test.category (id, name) VALUES (1, 'Sport');
INSERT INTO test.category (id, name) VALUES (2, 'Politik');
INSERT INTO test.category (id, name) VALUES (3, 'Lifestyle');
INSERT INTO test.category (id, name) VALUES (4, 'Marketing');
INSERT INTO test.category (id, name) VALUES (5, 'Technik');
INSERT INTO test.answer (id, title) VALUES (1, 'SPD');
INSERT INTO test.answer (id, title) VALUES (2, 'CDU');
INSERT INTO test.answer (id, title) VALUES (3, 'FDP');
INSERT INTO test.answer (id, title) VALUES (4, 'Die Linke');
INSERT INTO test.answer (id, title) VALUES (5, 'AfD');
INSERT INTO test.answer (id, title) VALUES (6, 'Grüne/B90');
INSERT INTO test.answer (id, title) VALUES (7, '1x Die Woche');
INSERT INTO test.answer (id, title) VALUES (8, '2x Die Woche');
INSERT INTO test.answer (id, title) VALUES (9, '3x Die Woche');
INSERT INTO test.answer (id, title) VALUES (10, 'Jeden Tag, wenn es geht');
INSERT INTO test.answer (id, title) VALUES (11, 'Gar nicht');
INSERT INTO test.answer (id, title) VALUES (12, 'Fitness');
INSERT INTO test.answer (id, title) VALUES (13, 'Vereinssport');
INSERT INTO test.answer (id, title) VALUES (14, 'Joggen');
INSERT INTO test.answer (id, title) VALUES (15, 'Yoga');
INSERT INTO test.question (id, title, question_type_id) VALUES (1, 'Welche Partei würden Sie wählen?', 1);
INSERT INTO test.question (id, title, question_type_id) VALUES (2, 'Wie oft treiben Sie Sport?', 1);
INSERT INTO test.question (id, title, question_type_id) VALUES (3, 'Welche Art der Bewegung treiben Sie am meisten?', 1);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (1, 1, 1);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (2, 1, 2);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (3, 1, 3);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (4, 1, 4);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (5, 1, 5);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (6, 1, 6);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (7, 2, 7);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (8, 2, 8);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (9, 2, 9);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (10, 2, 10);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (11, 2, 11);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (13, 3, 12);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (14, 3, 13);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (15, 3, 14);
INSERT INTO test.question_answer_option (id, question_id, answer_id) VALUES (16, 3, 15);
INSERT INTO test.survey (id, title, start_date, end_date, category_id, description_text) VALUES (1, 'Bewegungsumfrage', '2019-11-17 07:47:57', '2019-12-17 07:47:57', 1, 'Kurze Umfrage, um herauszufinden, wie oft sich die Befragten körperlich aktiv sind.');
INSERT INTO test.survey (id, title, start_date, end_date, category_id, description_text) VALUES (2, 'Sonntagsfrage Bundestagswahl', '2019-11-17 07:49:59', '2019-11-17 07:49:59', 2, 'enn am nächsten Sonntag Bundestagswahl wäre...');
INSERT INTO test.survey_question (id, question_id, survey_id) VALUES (1, 1, 2);
INSERT INTO test.survey_question (id, question_id, survey_id) VALUES (2, 2, 1);
INSERT INTO test.survey_question (id, question_id, survey_id) VALUES (3, 3, 1);

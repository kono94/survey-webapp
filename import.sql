CREATE DATABASE test;
USE test;
create table if not exists answer
(
    id    bigint auto_increment
        primary key,
    title text not null,
    description_text mediumtext null
);

create table if not exists category
(
    id   bigint auto_increment
        primary key,
    name varchar(255) not null,
    color varchar(50) DEFAULT '#000000'
);

create table if not exists survey
(
    id               bigint auto_increment
        primary key,
    title            text                                not null,
    start_date       date                                not null,
    end_date         date                                not null,
    category_id      bigint                              not null,
    description_text mediumtext                          null,
    single_select    TINYINT(1)     DEFAULT 1,
    constraint survey_category_id_fk
        foreign key (category_id) references category (id)
            on update cascade
);


create table if not exists survey_answer_option
(
    id          bigint auto_increment
        primary key,
    survey_id   bigint not null,
    answer_id   bigint not null,
    constraint survey_answer_option_answer_id_fk
        foreign key (answer_id) references answer (id)
            on update cascade on delete cascade,
    constraint qsurvey_answer_option_survey_id_fk
        foreign key (survey_id) references survey (id)
            on update cascade on delete cascade
);

create table if not exists survey_voting
(
     id                       bigint auto_increment
     primary key,
     survey_id                bigint not null,
     voting_timestamp         timestamp DEFAULT CURRENT_TIMESTAMP,
     constraint survey_voting_survey_id_fk
        foreign key (survey_id) references survey (id)
            on update cascade on delete cascade
);

create table if not exists survey_voting_answer
(
  id                       bigint auto_increment
  primary key,
  survey_voting_id  bigint not null,
  survey_answer_option_id     bigint not null,
  constraint survey_voting_answer_survey_voting_id_fk
        foreign key (survey_voting_id) references survey_voting (id)
            on update cascade on delete cascade,
    constraint survey_voting_answer_survey_answer_option_id_fk
        foreign key (survey_answer_option_id) references survey_answer_option (id)
            on update cascade on delete cascade
);



INSERT INTO `answer` (`id`, `title`, `description_text`) VALUES
(1, 'M1', 'ah ja'),
(2, 'M2', 'ee'),
(3, 'The Wire', ''),
(4, 'The Sopranos', ''),
(5, 'Breaking Bad', ''),
(6, 'Lost', ''),
(7, 'Dexter', ''),
(8, 'Scrubs', ''),
(9, 'Game Of Thrones', ''),
(10, 'Dr. House', ''),
(11, 'Januar', ''),
(12, 'Februar', ''),
(13, 'MÃ¤rz', ''),
(14, 'April', ''),
(15, 'Mai', ''),
(16, 'Juni', ''),
(17, 'Juli', ''),
(18, 'August', ''),
(19, 'September', ''),
(20, 'Oktober', ''),
(21, 'November', ''),
(22, 'Dezember', ''),
(23, '300 Liter', ''),
(27, '600 Liter', ''),
(28, '1000 Liter', ''),
(29, '1700 Liter', ''),
(30, '2500 Liter', '');


INSERT INTO `category` (`id`, `name`, `color`) VALUES
(4, 'Lifestyle', '#ff62f5'),
(5, 'Sport', '#00ff18'),
(6, 'Wissen', '#3922f9'),
(7, 'Abgabe', '#ff0038'),
(8, 'Technik', '#fdd65b');


INSERT INTO `survey` (`id`, `title`, `start_date`, `end_date`, `category_id`, `description_text`, `single_select`) VALUES
(2, 'Aktive Umfrage fÃ¼r Bewertung', '2019-12-12', '2020-01-25', 4, 'Ihr Lieblingsmonat?\r\n(Single-Select)', 1),
(3, 'Inaktive Umfrage fÃ¼r Bewertung (November)', '2019-11-01', '2019-11-30', 4, 'Welche Serien haben Sie bereits gesehen?\r\n(Multi-Select)', 0),
(4, 'Inaktive Umfrage fÃ¼r Bewertung (Februar/MÃ¤rz)', '2020-02-01', '2020-03-31', 6, 'Wie viel Liter Kunstblut gingen fÃ¼r beide Teile des Kultfilms \"Kill Bill\" drauf?\r\n(Single-Select)', 1);





INSERT INTO `survey_answer_option` (`id`, `survey_id`, `answer_id`) VALUES
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 3, 9),
(10, 3, 10),
(11, 2, 11),
(12, 2, 12),
(13, 2, 13),
(14, 2, 14),
(15, 2, 15),
(16, 2, 16),
(17, 2, 17),
(18, 2, 18),
(19, 2, 19),
(20, 2, 20),
(21, 2, 21),
(22, 2, 22),
(23, 4, 23),
(27, 4, 27),
(28, 4, 28),
(29, 4, 29),
(30, 4, 30);

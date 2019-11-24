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


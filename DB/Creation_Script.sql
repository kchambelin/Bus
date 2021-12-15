drop table if exists tokens;
drop table if exists permissions;
drop table if exists operations;
drop table if exists user_details;
drop table if exists users;


CREATE TABLE users (
    iduser int not null,
    email varchar(100),
    grade int not null,
    password varchar(200)
);

CREATE TABLE user_details (
    iduser_detail int not null,
    users_iduser int not null,
    firstname varchar(50),
    lastname varchar(50)
);

CREATE TABLE operations (
    idoperation INT NOT NULL,
    name VARCHAR(255),
    description VARCHAR(255),
    route VARCHAR(255)
);

CREATE TABLE permissions (
    idpermission INT NOT NULL,
    grade INT,
    operations_idoperation INT
);

CREATE TABLE tokens (
    idtoken INT NOT NULL,
    users_iduser INT,
    token VARCHAR(255)
);

ALTER TABLE operations ADD CONSTRAINT pk_operations PRIMARY KEY (idoperation);

ALTER TABLE permissions ADD CONSTRAINT pk_permissions PRIMARY KEY (idpermission);
ALTER TABLE permissions ADD CONSTRAINT fk_permissions_operations FOREIGN KEY (operations_idoperation) REFERENCES operations(idoperation);

ALTER TABLE tokens ADD CONSTRAINT pk_tokens PRIMARY KEY (idtoken);
ALTER TABLE tokens ADD CONSTRAINT fk_tokens_users FOREIGN KEY (users_iduser) REFERENCES users(iduser);
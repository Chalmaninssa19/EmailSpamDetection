create database email;

.\c email;

create sequence idProfilSeq START WITH 1 INCREMENT BY 1;
create sequence idEmailRecuSeq START WITH 1 INCREMENT BY 1;
create sequence idEmailEnvoyeSeq START WITH 1 INCREMENT BY 1;
create sequence idNewDonneeSeq START WITH 1 INCREMENT BY 1;

create table profil (
    id_profil INTEGER DEFAULT nextval('idProfilSeq'::regclass) NOT NULL PRIMARY KEY,
    nom varchar(30),
    prenom varchar(30),
    mdp varchar(30),
    mail varchar(30),
    photo varchar(30)
);

create table email_envoye(
    id_email_envoye INTEGER DEFAULT nextval('idEmailEnvoyeSeq'::regclass) NOT NULL PRIMARY KEY,
    profile_destinataire INTEGER,
    profile_source INTEGER,
    sujet VARCHAR(200),
    text TEXT,
    FOREIGN KEY (profile_destinataire) REFERENCES profil(id_profil),
    FOREIGN KEY (profile_source) REFERENCES profil(id_profil)
);

create table email_recu(
    id_email_recu INTEGER DEFAULT nextval('idEmailRecuSeq'::regclass) NOT NULL PRIMARY KEY,
    profile_destinataire INTEGER,
    profile_source INTEGER,
    sujet VARCHAR(200),
    text TEXT,
    etat INTEGER,
    isSpam INTEGER,
    FOREIGN KEY (profile_destinataire) REFERENCES profil(id_profil),
    FOREIGN KEY (profile_source) REFERENCES profil(id_profil)
);

create table new_donnee (
    id_new_donnee INTEGER DEFAULT nextval('idNewDonneeSeq'::regclass) NOT NULL PRIMARY KEY,
    sujet varchar(200),
    isSpam INTEGER
);

INSERT INTO profil VALUES (DEFAULT, 'Inssa', 'Chalman', 'chalman', 'chalman@gmail.com', 'pdp.jpg'); 
INSERT INTO profil VALUES (DEFAULT, 'Mamiarilaza', 'To', 'To', 'to@gmail.com', 'pdp.jpg'); 
INSERT INTO profil VALUES (DEFAULT, 'Rakoto', 'Frederic', 'frederic', 'frederic@gmail.com', 'pdp.jpg'); 

-- create database systeme_gestion_vehicule;
-- grant all privileges on database systeme_gestion_vehicule to admin;
-- psql -d systeme_gestion_vehicule -U admin -W 


create extension pgcrypto;


create table if not exists administrateur(
	id_admin int not null,
	username_admin varchar(100) not null,
	mdp_admin varchar(100) not null,
	primary key(id_admin)
);
insert into administrateur values(1, 'administrateur@gmail.com', encode(digest('Admin2022!','sha1'),'hex'));


create table if not exists type_vehicule(
	id_type_vehicule int not null,
	type_vehicule varchar(50) not null,
	primary key(id_type_vehicule)
);
insert into type_vehicule values(1, 'Legère');
insert into type_vehicule values(2, 'SUV');
insert into type_vehicule values(3, 'Utilitaire');
insert into type_vehicule values(4, 'Camion');


create table if not exists vehicule(
	id_vehicule serial not null,
	numero varchar(30) not null,
	marque varchar(50) not null,
	model varchar(50) not null,
	type int not null,
	primary key(id_vehicule),
	foreign key(type) references type_vehicule(id_type_vehicule)
);
insert into vehicule values(default, '3412TBA', 'Mercedes', 'Sprinter', 1);
insert into vehicule values(default, '1245TBA', 'Mercedes', 'Poid lourd', 4);


create table if not exists chauffeur(
	id_chauffeur serial not null,
	nom_chauffeur varchar(100) not null,
	username varchar(100) not null,
	mot_de_passe varchar(100) not null,
	primary key(id_chauffeur)
);
insert into chauffeur values(default, 'RAKOTO Jean', 'chauffeur1@gmail.com', encode(digest('chauffeur1','sha1'),'hex'));
insert into chauffeur values(default, 'RAKOTOSON James', 'chauffeur2@gmail.com', encode(digest('chauffeur2','sha1'),'hex'));


create table if not exists type_carburant(
	id_type_carburant int not null,
	type_carburant varchar(50) not null,
	primary key(id_type_carburant)
);
insert into type_carburant values(1, 'Essence');
insert into type_carburant values(2, 'Gasoil');


create table if not exists deatls_type_carburant(
	id_details_type_carburant serial not null,
	id_type_carburant int not null,
	prix_par_litre decimal(10,4) not null,
	date_details_carburant date not null,
	primary key(id_details_type_carburant),
	foreign key(id_type_carburant) references type_carburant(id_type_carburant)
);
insert into deatls_type_carburant values(default, 1, 4100, '2022-05-19');
insert into deatls_type_carburant values(default, 2, 3500, '2022-05-19');



create table if not exists carburant(
	id_carburant serial not null,
	id_type_carburant int not null,
	quantite decimal(10,4) not null,
	montant decimal(10,4) not null,
	vehicule int not null,
	date_carburant date not null,
	primary key(id_carburant),
	foreign key(vehicule) references vehicule(id_vehicule),
	foreign key(id_type_carburant) references type_carburant(id_type_carburant)
);
insert into carburant values(default, 2, 100, 200000, 1, '2022-05-19');



create table if not exists trajet(
	id_trajet serial not null,
	type_trajet varchar(50) not null,
	lieu varchar(100) not null,
	kilometrage int not null,
	date_trajet date not null,
	heure_trajet time not null,
	vehicule int not null,
	chauffeur int not null,
	motif varchar(100) not null,
	primary key(id_trajet),
	foreign key(vehicule) references vehicule(id_vehicule),
	foreign key(chauffeur) references chauffeur(id_chauffeur)
);
insert into trajet values(default, 'Départ', 'Toamasina', 1000, '2022-05-18', '08:00:00', 1, 1, 'Livraison des marchandises');
insert into trajet values(default, 'Arrivé', 'Antananarivo', 1400, '2022-05-18', '21:04:45', 1, 1, 'Livraison des marchandises');


create table if not exists echeance(
	id_echeance int not null,
	type_echeance varchar(50) not null,
	primary key(id_echeance)
);
insert into echeance values(1, 'Assurance');
insert into echeance values(2, 'Visite technique');


create table if not exists details_echeance(
	id_details_echeance serial not null,
	id_echeance int not null,
	id_vehicule int not null,
	date_fin date not null,
	primary key(id_details_echeance),
	foreign key(id_echeance) references echeance(id_echeance),
	foreign key(id_vehicule) references vehicule(id_vehicule)
);
insert into details_echeance values(default, 1, 1, '2022-11-23');
insert into details_echeance values(default, 2, 1, '2022-08-23');


create table if not exists elements(
	id_elements int not null,
	elements varchar(50) not null,
	contrainte int not null,
	primary key(id_elements)
);
insert into elements values(1, 'Vindange', 5000);
insert into elements values(2, 'Pneu', 2000);


create table if not exists maintenance(
	id_maintenance serial not null,
	id_elements int not null,
	id_vehicule int not null,
	date_maintenace date not null,
	primary key(id_maintenance),
	foreign key(id_elements) references elements(id_elements),
	foreign key(id_vehicule) references vehicule(id_vehicule)
);
insert into maintenance values(default, 1, 1, '2022-05-19');
insert into maintenance values(default, 2, 1, '2022-05-19');



create view views_maintenance as select 
	elements.id_elements,
	elements.elements,
	elements.contrainte,
	maintenance.id_maintenance,
	maintenance.id_vehicule,
	maintenance.date_maintenace
from elements join maintenance on elements.id_elements = maintenance.id_elements order by maintenance.id_maintenance desc;
































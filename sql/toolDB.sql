# ---------------------------------------------------------------------- #
# Target DBMS:           MySQL 5                                         #
# Project name:          Tools                                           #
# Author:                Magdiel Castillo                                #
# Created on:            2023-01-08 06:00                                #
# ---------------------------------------------------------------------- #

DROP VIEW IF EXISTS registersum;

DROP TABLE IF EXISTS register;

DROP TABLE IF EXISTS color;

DROP TABLE IF EXISTS `location`;


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #
# ---------------------------------------------------------------------- #
# Add table "location"                                                   #
# ---------------------------------------------------------------------- #


create table location (
id_location int not null auto_increment,
location varchar(50) not null unique,
primary key (id_location)
);

# ---------------------------------------------------------------------- #
# Add table "Color"                                                      #
# ---------------------------------------------------------------------- #

create table color (
id_color int not null auto_increment,
color varchar(15) not null unique,
primary key(id_color)
);

# ---------------------------------------------------------------------- #
# Add table "register"                                                   #
# ---------------------------------------------------------------------- #

create table register (
id int not null auto_increment,
quantity int not null,
tools varchar(40) not null,
id_location int not null,
id_color int not null,
`description` text,
fecha timestamp default current_timestamp,
primary key (id),
constraint fk_register_location foreign key (id_location) references location (id_location),
constraint fk_register_color foreign key (id_color) references color (id_color),
constraint CHK_Register CHECK (quantity<=50 AND quantity>0)
);

# ---------------------------------------------------------------------- #
# Add info into "color"                                                  #
# ---------------------------------------------------------------------- #

INSERT INTO
	color (color)
VALUES
	('rojo'), ('verde'), ('rosado'), ('amarillo'),
    ('azul'), ('blanco'), ('negro'), ('plateado'), ('dorado'), ('morado'),
	('naranja'), ('gris'), ('marrón');
    
# ---------------------------------------------------------------------- #
# Add info into "location"                                               #
# ---------------------------------------------------------------------- #

INSERT INTO
	`location` (location)
VALUES
	('caja de herramientas'), ('gaveta grande'), ('gaveta pequeña de medio'), ('mochila'), ('bulto móvil pequeño'), ('pulto grande');


# ---------------------------------------------------------------------- #
# Add VIEW "registersum"                                                 #
# ---------------------------------------------------------------------- #

CREATE VIEW registersum AS

SELECT r.id as `id`, concat_ws(' ', r.tools, 'en', l.location) as `tools`, c.color as `color`
        , r.quantity as `quantity`, r.description as `description`, r.fecha as `fecha` FROM register as r inner join `location` as l on 
        r.id_location = l.id_location inner join color as c on
        c.id_color = r.id_color;
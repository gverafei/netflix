DROP DATABASE IF EXISTS netflix;
CREATE DATABASE netflix CHARACTER SET utf8mb4;
USE netflix;

CREATE TABLE IF NOT EXISTS tipo (
  idtipo INT UNSIGNED PRIMARY KEY, 
  nombre VARCHAR(60) NOT NULL
);

CREATE TABLE IF NOT EXISTS categoria (
  idcategoria INT UNSIGNED PRIMARY KEY,
  nombre VARCHAR(60) NOT NULL
);

CREATE TABLE IF NOT EXISTS pelicula (
  idpelicula INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  idtipo INT UNSIGNED NOT NULL,
  titulo VARCHAR(255) NOT NULL,
  imagen VARCHAR(255) NOT NULL,
  CONSTRAINT fk_idtipo FOREIGN KEY (idtipo) 
  REFERENCES tipo(idtipo) 
  ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS pelicula_categoria (
  idpelicula INT UNSIGNED NOT NULL,
  idcategoria INT UNSIGNED NOT NULL,
  CONSTRAINT fk_idpelicula FOREIGN KEY (idpelicula) REFERENCES pelicula(idpelicula) 
  ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_idcategria FOREIGN KEY (idcategoria) REFERENCES categoria(idcategoria) 
  ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT pk_pelicula_categoria PRIMARY KEY (idpelicula, idcategoria)
);

INSERT INTO tipo VALUES(1,'Películas');
INSERT INTO tipo VALUES(2,'Series');

INSERT INTO categoria VALUES(1,'Acción');
INSERT INTO categoria VALUES(2,'Tendencias');
INSERT INTO categoria VALUES(3,'Originales de Netflix');
INSERT INTO categoria VALUES(4,'Populares de Netflix');
INSERT INTO categoria VALUES(5,'Joyas ocultas');
INSERT INTO categoria VALUES(6,'Ciencia ficción');
INSERT INTO categoria VALUES(7,'Terror');
INSERT INTO categoria VALUES(8,'Aventuras emocionantes');

INSERT INTO pelicula VALUES (2,1,'Matrix','uploads/matrix.jpg'),(3,1,'300','uploads/300.jpg'),(4,1,'Anabelle','uploads/annabelle.jpg'),(5,1,'Batam V Superman','uploads/batmanvsuperman.jpg'),(6,2,'Breaking Bad','uploads/breakingbad.jpg'),(7,2,'Cobra Kai','uploads/cobrakai.jpg'),(8,1,'Constantine','uploads/constantine.jpg'),(9,1,'Al filo del mañana','uploads/edge.jpg'),(10,1,'El conjuro','uploads/elconjuro.jpg'),(11,1,'El silencio','uploads/elsilencio.jpg'),(12,1,'Gambito de dama','uploads/gambitodedama.jpg'),(13,1,'Guerra mundial Z','uploads/guerramundialz.jpg'),(14,1,'Indiana Jones 3','uploads/indiana3.jpg'),(15,1,'Eso','uploads/it.jpg'),(16,1,'La casa de papel','uploads/lacasadepapel.jpg'),(17,2,'Luis Miguel','uploads/luismiguel.jpg'),(18,2,'The Witcher','uploads/thewitcher.jpg'),(19,1,'Matrix 3','uploads/matrix3.jpg'),(20,1,'Mujer Maravilla','uploads/mujermaravilla.jpg'),(21,1,'Spiderman 2','uploads/spiderman2.jpg'),(22,2,'The Crown','uploads/thecrown.jpg'),(23,2,'The Walking Dead','uploads/thewalkingdead.jpg'),(24,1,'Volver al futuro 3','uploads/volveralfuturo3.jpg');

INSERT INTO pelicula_categoria VALUES (2,1),(3,1),(5,1),(9,1),(14,1),(19,1),(6,2),(12,2),(19,2),(20,2),(22,2),(24,2),(7,3),(11,3),(16,3),(17,3),(18,3),(22,3),(6,4),(13,4),(16,4),(20,4),(23,4),(24,4),(2,5),(8,5),(13,5),(16,5),(21,5),(24,5),(2,6),(5,6),(9,6),(21,6),(23,6),(24,6),(4,7),(10,7),(15,7),(3,8),(9,8),(14,8),(20,8),(21,8),(24,8);
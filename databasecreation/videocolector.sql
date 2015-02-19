--
-- Database: `videocolector`
--

CREATE TABLE coments (
  idComent SERIAL NOT NULL,
  coment text NOT NULL,
  idUsuario integer NOT NULL unique,
  idVideo integer NOT NULL unique,
  warnings integer NULL,
  PRIMARY KEY (idComent)
);



CREATE TABLE Usuario (
  idUsuario SERIAL NOT NULL,
  UserName text NOT NULL,
  UserEmail text NOT NULL,
  avatar text NULL,
  pass text NOT NULL,
  PRIMARY KEY (idUsuario)
);



CREATE TABLE video (
  idVideo SERIAL NOT NULL,
  VideoName text NOT NULL,
  Puntuacion integer NOT NULL,
  Votes integer NOT NULL,
  Description text NOT NULL,
  idUsuario integer NOT NULL,
  VideoType text NOT NULL,
  warnings integer NOT NULL,
  UpDate date NOT NULL,
  PRIMARY KEY (idVideo)
);


ALTER TABLE coments
  ADD CONSTRAINT fk_usuario_coment FOREIGN KEY (idUsuario) REFERENCES video (idUsuario),
  ADD CONSTRAINT fk_video_coment FOREIGN KEY (idVideo) REFERENCES video (idVideo);



ALTER TABLE video
  ADD CONSTRAINT fk_usuario_video FOREIGN KEY (idUsuario) REFERENCES Usuario (idUsuario);


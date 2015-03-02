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


CREATE TABLE video
(
  idvideo serial NOT NULL,
  videoname text NOT NULL,
  upvotes integer NOT NULL,
  downvotes integer NOT NULL,
  description text NOT NULL,
  idusuario integer NOT NULL,
  videotype text NOT NULL,
  warnings integer NOT NULL,
  update date NOT NULL,
  CONSTRAINT video_pkey PRIMARY KEY (idvideo),
  CONSTRAINT fk_usuario_video FOREIGN KEY (idusuario)
      REFERENCES usuario (idusuario) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE votexuser
(
  idvotexuser serial NOT NULL,
  idusuario integer NOT NULL,
  idvideo integer NOT NULL,
  vote boolean NOT NULL, --true equal positive vote.
  CONSTRAINT votex_pkey PRIMARY KEY (idvideo),
  CONSTRAINT fk_usuario_votex FOREIGN KEY (idusuario)
    REFERENCES usuario (idusuario) MATCH SIMPLE,
  CONSTRAINT fk_video_votex FOREIGN KEY (idvideo)
    REFERENCES video (idvideo) MATCH SIMPLE

);

ALTER TABLE coments
  ADD CONSTRAINT fk_usuario_coment FOREIGN KEY (idUsuario) REFERENCES video (idUsuario),
  ADD CONSTRAINT fk_video_coment FOREIGN KEY (idVideo) REFERENCES video (idVideo);


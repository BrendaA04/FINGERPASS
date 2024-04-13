CREATE TABLE IF NOT EXISTS estudiantes_aceptados(
  folio int PRIMARY KEY
  nombre TEXT,
  apellido1 TEXT,
  apellido2 TEXT,
  periodo TEXT
);
CREATE TABLE IF NOT EXISTS Documentos_ingreso(
  id_documento PRIMARY KEY AUTOINCREMENT,
  folio int REFERENCES estudiantes_aceptados(folio),
  Tipo_Documento TEXT,
  Fecha_Subida
);

CREATE TABLE IF NOT EXISTS pagos_aceptados(
  folio_pago int PRIMARY KEY,
  folio int REFERENCES estudiantes_aceptados(folio),
  folio_banco int  REFERENCES folios_banco(referencias),
  verificacion BOOLEAN
);

CREATE TABLE IF NOT EXISTS folios_banco(
  referencias int PRIMARY KEY,
  fecha_pago DATE
);
 
CREATE TABLE IF NOT EXISTS matriculas_nuevas (
  matricula int PRIMARY KEY,
  folio_pago int REFERENCES pagos_aceptados(folio_pago), 
);

CREATE TABLE estudiantes_inscritos(
  ID_Estudiante INTEGER REFERENCES matriculas_nuevas(matricula),
  Nombre TEXT,
  Apellido1 TEXT,
  Apellido2 TEXT,
  Fecha_Nacimiento TEXT,
  Estado TEXT
);


CREATE TABLE Maestros (
  ID_Maestro INTEGER PRIMARY KEY,
  Nombre TEXT,
  Apellido1 TEXT,
  Apellido2 TEXT,
  Estado TEXT,
  Especialidad TEXT
);

-- 
CREATE TABLE Clases (
  ID_Clase INTEGER PRIMARY KEY,
  Asignatura TEXT,
  ID_Maestro INTEGER REFERENCES Maestros(ID_Maestro)
);


CREATE TABLE Asistencias (
  ID_Asistencia INTEGER PRIMARY KEY AUTOINCREMENT,
  ID_Estudiante INTEGER REFERENCES Estudiantes(ID_Estudiante),
  ID_Clase INTEGER REFERENCES Clases(ID_Clase),
  Fecha TEXT,
  Estado_Asistencia BOOLEAN
);


CREATE TABLE Documentos (
  ID_Documento INTEGER PRIMARY KEY,
  ID_Estudiante INTEGER REFERENCES Estudiantes(ID_Estudiante),
  Tipo_Documento TEXT,
  Fecha_Emision TEXT
);


CREATE TABLE Calificaciones (
  ID_Calificacion INTEGER PRIMARY KEY,
  ID_Estudiante INTEGER REFERENCES Estudiantes(ID_Estudiante),
  ID_Clase INTEGER REFERENCES Clases(ID_Clase),
  Calificacion REAL,
  Fecha_Calificacion TEXT
);


CREATE TABLE Padres (
  ID_Padre INTEGER PRIMARY KEY,
  Nombre TEXT,
  Apellido1 TEXT,
  Apellido2 TEXT,
  Estado TEXT
);

CREATE TABLE Documentos_Padres (
  ID_Documento INTEGER PRIMARY KEY,
  ID_Estudiante INTEGER REFERENCES Estudiantes(ID_Estudiante),
  ID_Padre INTEGER REFERENCES Padres(ID_Padre),
  Tipo_Documento TEXT,
  documento,
  Fecha_Subida TEXT
);


CREATE TABLE Reportes (
  ID_Reporte INTEGER PRIMARY KEY,
  ID_Estudiante INTEGER REFERENCES Estudiantes(ID_Estudiante),
  Tipo_Reporte TEXT,
  Fecha_Generacion TEXT
);


CREATE TABLE Padres_Estudiantes (
  ID_Padre_Estudiante INTEGER PRIMARY KEY,
  ID_Padre INTEGER REFERENCES Padres(ID_Padre),
  ID_Estudiante INTEGER REFERENCES Estudiantes(ID_Estudiante)
);

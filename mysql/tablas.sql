

-- Table: estudiantes_aceptados
CREATE TABLE IF NOT EXISTS estudiantes_aceptados (
  folio_estudiante INT PRIMARY KEY,
  nombre TEXT,
  apellido1 TEXT,
  apellido2 TEXT,
  periodo TEXT,
  correo TEXT
);

-- Table: folios_banco
CREATE TABLE IF NOT EXISTS folios_banco (
  folio_banco INT PRIMARY KEY,
  fecha_pago DATE
);

-- Table: pagos_aceptados
CREATE TABLE IF NOT EXISTS pagos_aceptados (
  folio_pago INT PRIMARY KEY,
  folio_estudiante INT,
  folio_banco INT,
  verificacion INT,
  FOREIGN KEY (folio_estudiante) REFERENCES estudiantes_aceptados(folio_estudiante),
);

-- Table: matriculas_nuevas
CREATE TABLE IF NOT EXISTS matriculas_nuevas (
  matricula INT PRIMARY KEY,
  folio_pago INT,
  FOREIGN KEY (folio_pago) REFERENCES pagos_aceptados(folio_pago)
);
CREATE TABLE IF NOT EXISTS documentos_ingreso (
  id_documento INT AUTO_INCREMENT PRIMARY KEY,
  matricula INT,
  tipo_documento TEXT,
  documento TEXT,
  fecha_subida TEXT,
  FOREIGN KEY (matricula) REFERENCES matriculas_nuevas(matricula)
);
-- Table: estudiantes_inscritos
CREATE TABLE IF NOT EXISTS estudiantes_inscritos (
  matricula INT,
  nombre TEXT,
  apellido1 TEXT,
  apellido2 TEXT,
  fecha_nacimiento TEXT,
  residencia TEXT,
  FOREIGN KEY (matricula) REFERENCES matriculas_nuevas(matricula)
);

-- Table: maestros
CREATE TABLE IF NOT EXISTS maestros (
  id_maestro INT PRIMARY KEY,
  nombre TEXT,
  apellido1 TEXT,
  apellido2 TEXT,
  estado_residencia TEXT,
  especialidad TEXT
);

-- Table: clases
CREATE TABLE IF NOT EXISTS clases (
  id_clase INT PRIMARY KEY,
  asignatura TEXT,
  id_maestro INT,
  FOREIGN KEY (id_maestro) REFERENCES maestros(id_maestro)
);

-- Table: asistencias
CREATE TABLE IF NOT EXISTS asistencias (
  id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
  matricula INT,
  id_clase INT,
  fecha TEXT,
  estado_asistencia BOOLEAN,
  FOREIGN KEY (matricula) REFERENCES estudiantes_inscritos(matricula),
  FOREIGN KEY (id_clase) REFERENCES clases(id_clase)
);

-- Table: calificaciones
CREATE TABLE IF NOT EXISTS calificaciones (
  id_calificacion INT PRIMARY KEY,
  matricula INT,
  id_clase INT,
  calificacion REAL,
  fecha_calificacion TEXT,
  FOREIGN KEY (matricula) REFERENCES estudiantes_inscritos(matricula),
  FOREIGN KEY (id_clase) REFERENCES clases(id_clase)
);

-- Table: padres
CREATE TABLE IF NOT EXISTS padres (
  id_padre INT PRIMARY KEY,
  nombre TEXT,
  apellido1 TEXT,
  apellido2 TEXT,
  estado_residencia TEXT
);

-- Table: reportes
CREATE TABLE IF NOT EXISTS reportes (
  id_reporte INT PRIMARY KEY,
  matricula INT,
  tipo_reporte TEXT,
  fecha_generacion TEXT,
  FOREIGN KEY (matricula) REFERENCES estudiantes_inscritos(matricula)
);

-- Table: padres_estudiantes
CREATE TABLE IF NOT EXISTS padres_estudiantes (
  id_padre_estudiante INT PRIMARY KEY,
  id_padre INT,
  matricula INT,
  FOREIGN KEY (id_padre) REFERENCES padres(id_padre),
  FOREIGN KEY (matricula) REFERENCES estudiantes_inscritos(matricula)
);

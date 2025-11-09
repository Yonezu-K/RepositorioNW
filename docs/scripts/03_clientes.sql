CREATE TABLE clientes(  
    codigo VARCHAR(10) NOT NULL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(15),
    correo VARCHAR(100),
    estado CHAR(3) DEFAULT 'ACT',
    evaluacion INT CHECK (evaluacion >= 0 AND evaluacion <= 100)
)
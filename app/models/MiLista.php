<?php

class MiLista
{
    private $db;

    public function __construct(mysqli $mysqli)
    {
        $this->db = $mysqli;
    }

    public function existe($idPerfil, $idContenido)
    {
        $stmt = $this->db->prepare("
            SELECT 1 FROM mi_lista
            WHERE id_perfil = ? AND id_contenido = ?
        ");
        $stmt->bind_param("ii", $idPerfil, $idContenido);
        $stmt->execute();
        $stmt->store_result();

        $existe = $stmt->num_rows > 0;
        $stmt->close();

        return $existe;
    }

    public function agregar($idPerfil, $idContenido)
    {
        $stmt = $this->db->prepare("
            INSERT INTO mi_lista (id_perfil, id_contenido)
            VALUES (?, ?)
        ");
        $stmt->bind_param("ii", $idPerfil, $idContenido);
        $stmt->execute();
        $stmt->close();
    }

    public function quitar($idPerfil, $idContenido)
    {
        $stmt = $this->db->prepare("
            DELETE FROM mi_lista
            WHERE id_perfil = ? AND id_contenido = ?
        ");
        $stmt->bind_param("ii", $idPerfil, $idContenido);
        $stmt->execute();
        $stmt->close();
    }
}

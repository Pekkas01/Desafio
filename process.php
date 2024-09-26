<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    try {
        // Verificando se o e-mail já está cadastrado
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            echo "E-mail já existe.";
        } else {
            // Inserindo um novo usuário
            $sql = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            echo "Cadastro com sucesso!";
        }
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

    $conn = null;
}
?>
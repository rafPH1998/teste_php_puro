<?php
require_once "./classes/User.php";
session_start();

class UserController 
{

    public function __construct(
        protected User $user
    ) { }

    public function create(array $data): bool
    {
        try {
            $validationErrors = $this->validate($data);

            if (!empty($validationErrors)) {
                $_SESSION['errors'] = $validationErrors;
                return false; 
            }

            $this->user->create($data['name'], $data['email']);

            $_SESSION['success'] = "Usuário criado com sucesso!";

            return true;

        } catch (Exception $e) {
            $_SESSION['errors'] = ["Erro ao criar o usuário: " . $e->getMessage()];
            return false; 
        }
    }


    public function update($data) {
        $validationErrors = $this->validate($data);
        if (!empty($validationErrors)) {
            return $validationErrors;
        }

        $this->user->update($data['id'], $data['name'], $data['email']);
        return null;
    }

    public function delete(int $id) {
        if (empty($id) || !is_numeric($id)) {
            return ["ID inválido para exclusão."];
        }

        // Chama a função de exclusão
        $this->user->delete($id);
        return null;
    }

    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = "O nome é obrigatório.";
        }

        if (empty($data['email'])) {
            $errors[] = "O e-mail é obrigatório.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "O e-mail fornecido não é válido.";
        }

        return $errors;
    }
}

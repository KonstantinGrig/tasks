<?php


namespace App\Entity;


use Respect\Validation\Validator as RespectValidator;

class Task
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $imagePath;

    /**
     * @var bool
     */
    private $executed = false;


    public function getId() {
        return (int)$this->id;
    }

    public function setId($id) {
        $this->id = (int)$id;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getExecuted() {
        return (bool)$this->executed;
    }

    public function setExecuted($executed) {
        $this->executed = (bool)$executed;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }

    /**
     * @return array
     */
    public function getValidators() {
        return [
            "userName" => [
                "validator" => RespectValidator::length(3, 15),
                "message" => "Имя пользователя не должно содержать пробелов, длина должа быть 1-15 симворлов"
            ],
            "email" => [
                "validator" => RespectValidator::email(),
                "message" => "Ожидается корректный email"
            ],
            "text" => [
                "validator" => RespectValidator::length(5, 300),
                "message" => "Длина текста должа быть 5-300 симворлов"
            ]
        ];
    }
}
<?php


namespace App\Entity;


use Respect\Validation\Validator as RespectValidator;

class Task
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $imagePath;

    /**
     * @var bool
     */
    public $executed = false;

    /**
     * @return array
     */
    public function getValidators() {
        return [
            "userName" => [
                "validator" => RespectValidator::length(3, 15),
                "message" => "Имя пользователя не должно содержать пробелов, длина должа быть 3-15 симворлов"
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
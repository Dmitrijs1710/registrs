<?php
namespace App;

class Firm{
    private string $registrationCode;
    private string $name;
    private array $data;

    public function __toString()
    {
        return $this->getRegistrationCode() . ' | ' . $this->getName() . ' | ' . implode(' | ',$this->data);
    }

    public function __construct(string $registrationCode, string $name,array $data)
    {
        $this->registrationCode = $registrationCode;
        $this->name = $name;
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRegistrationCode(): string
    {
        return $this->registrationCode;
    }
}
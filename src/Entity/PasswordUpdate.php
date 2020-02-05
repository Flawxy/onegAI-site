<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    /**
     * Represents the password the user wants to change
     *
     * @var string
     */
    private $oldPassword;

    /**
     * @Assert\Length(
     *     min=8,
     *     minMessage="Le mot de passe doit faire au moins 8 caractères"
     * )
     * @Assert\NotBlank(
     *     normalizer="trim",
     *     message="Vous devez renseigner ce champ"
     * )
     * @var string
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(
     *     propertyPath="newPassword",
     *     message="Les deux mots de passe indiqués ne correspondent pas"
     * )
     * @Assert\NotBlank(
     *     normalizer="trim",
     *     message="Vous devez renseigner ce champ"
     * )
     * @var string
     */
    private $confirmPassword;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}

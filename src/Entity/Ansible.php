<?php

namespace App\Entity;

use App\Repository\AnsibleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnsibleRepository::class)]
class Ansible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    public function installer($nomService):void {
        shell_exec('ansible-playbook ../../playbooks/install/' . $nomService . '.yml --ask-become-pass');
    }

    public function desinstaller($nomService):void {
        shell_exec('ansible-playbook ../../playbooks/uninstall/' . $nomService . '.yml --ask-become-pass');
    }
}

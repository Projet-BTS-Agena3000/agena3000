<?php

namespace App\Entity;

use App\Repository\AnsibleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnsibleRepository::class)]
class Ansible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    public function installer($nomService)
    {
        $password = 'BtsSn2022';
        $output = shell_exec('ansible-playbook ../../playbooks/install/' . $nomService . '.yml --ask-become-pass');
        if($output == 'BECOME PASSWORD:'){
            shell_exec($password);
        }
    }
}

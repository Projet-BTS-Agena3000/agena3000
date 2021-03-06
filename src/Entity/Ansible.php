<?php

namespace App\Entity;

use App\Repository\AnsibleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnsibleRepository::class)]
class Ansible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    public function installer ($nomService) {
        $output = shell_exec('ansible-playbook ../../playbooks/install/' . $nomService . '.yml --ask-become-pass \ -e "ansible_become_pass=BtsSn2022"');
        return $output;
    }

    public function desinstaller ($nomService) {
        $output = shell_exec('ansible-playbook ../../playbooks/uninstall/' . $nomService . '.yml --ask-become-pass');
        return $output;
    }
}
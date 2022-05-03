<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnsibleRepository;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

#[ORM\Entity(repositoryClass: AnsibleRepository::class)]
class Ansible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    public function installer ($nomService) {
        $process = new Process([shell_exec('ansible-playbook ../../playbooks/install/' . $nomService . '.yml --ask-become-pass')]);
        $process->start();
        sleep(5);
        shell_exec('BtsSn2022');

        return 0;
    }

    public function desinstaller ($nomService) {
        $output = shell_exec('ansible-playbook ../../playbooks/uninstall/' . $nomService . '.yml --ask-become-pass');
        return $output;
    }
}
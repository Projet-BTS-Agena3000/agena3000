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
        $output = shell_exec('ansible-playbook ../../playbooks/install/' . $nomService . '.yml --ask-become-pass');
        $err = ' ';
        $err = explode(' ', $output);
        $tailleTab = count($err);
        for($cpt = 0; $cpt < $tailleTab; $cpt++) {
            if($err[$cpt] == 'FAILED!') {
                $e = explode('"', $output);
                $err = $e[3];
                $cpt = $tailleTab;
            } elseif ($err[$cpt] == 'changed=0'){
                $err = 'Wireshark est déjà installé';
                $cpt = $tailleTab;
            }
            elseif($err[$cpt] == 'changed=1'){
                $err = '0';
            }
        }    
        
        return $err;
    }

    public function desinstaller ($nomService) {
        shell_exec('ansible-playbook ../../playbooks/uninstall/' . $nomService . '.yml --ask-become-pass');
    }
}
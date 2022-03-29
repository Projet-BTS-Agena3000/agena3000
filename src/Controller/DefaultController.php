<?php

namespace App\Controller;

use App\Entity\Ansible;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class DefaultController extends AbstractController{
    #[Route('/', name: 'default')]
    public function index(){
        return $this->render('accueil.html.twig');
    }

    #[Route('/connexion', name: 'connexion')]
    public function formConnexion(){
        return $this->render('connexion.html.twig');
    }

    #[Route('/accueil-membre', name: 'accueilMembre')]
    public function accueilMembre(){
        return $this->render('membre/accueil_membre.html.twig');
    }


    #[Route('/creation-machine/ConfigurationMachines', name: 'ConfigurationMachines')]
    public function choixOS(Request $request){

        $systemesDexploitation = [
            'Windows 10' => 'Windows 10',
            'Windows Server' => 'Windows Server',
            'Debian' => 'Debian',
            'Ubuntu' => 'Ubuntu',
            'Ubuntu Server' => 'Ubuntu Server',
            
        ];

        
        $form = $this->createFormBuilder()
            ->add("ChoixOs", ChoiceType::class, [
                "choices" => $systemesDexploitation,
                'attr' => ['class' => 'selectOs'],
                'label_attr' => ['class' => 'labelSelectOs']
            ])
            -> add('DNS', TextType::class, [
                'attr' => ['class' => 'TexteDNS'],
                'label' => 'DNS',
                'label_attr' => ['class' => 'labelText']
            ])
            -> add('Vlan', IntegerType::class, [
                'label' => 'N° VLAN',
                'attr' => ['class' => 'vlan'],
                'label_attr' => ['class' => 'labelText']
            ])
            ->add("NbCoeurs", RangeType::class,[
                "label" => "Nombre de Coeurs",
                'attr' => [
                    'min' => 1,
                    'max' => 4,
                    'class' => 'nbCoeurs'
                ],
                'label_attr' => ['class' => 'labelText']
            ])
            ->add("TailleDisque", RangeType::class,[
                "label" => "Taille du disque",
                'attr' => [
                    'min' => 1,
                    'max' => 20,
                    'class' => 'tailleDisque'
                ],
                'label_attr' => ['class' => 'labelText']
            ])
            ->add("TailleRAM", RangeType::class,[
                "label" => "Taille Mémoire RAM",
                'attr' => [
                    'min' => 1,
                    'max' => 8,
                    'class' => 'tailleRAM'
                ],
                'label_attr' => ['class' => 'labelText']
            ])
            ->add("NbInterfaces", IntegerType::class,[
                'attr' => ['class' => 'nbInterfaces'],
                'label' => "Nombres d'Interfaces Réseaux",
                'label_attr' => ['class' => 'labelText']
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'bouton']
            ])
            
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            return $this->render('membre/creation_machine/machineCree.html.twig', $form->getData());
        }

        return $this->render('membre/creation_machine/ConfigurationMachines.html.twig', [
            'myform' => $form->createView()
        ]);
    }

    #[Route('/etat-machines', name: 'etatMachines')]
    public function etatMachines() {
        return $this->render('membre/etat_machines/etat_machines.html.twig');
    }

    #[Route('/gerer_fonctionnalites', name: 'gestionFonctionnalites')]
    public function gererFonctionnalites() {
        return $this->render('membre/etat_machines/fonctionnalites.html.twig');
    }

    #[Route('/gerer_fonctionnalites/installation/wireshark', name: 'installerWireshark')]
    public function installerWireshark() {
        $installation = new Ansible;
        $e = $installation->installer('wireshark'); 
        if($e == '0'){
            return $this->render('membre/etat_machines/installs/wireshark.html.twig');
        }
        return $this->render('membre/etat_machines/erreur.html.twig', array('erreur' => $e));
    }

    #[Route('/gerer_fonctionnalites/desinstallation/wireshark', name: 'desinstallerWireshark')]
    public function desinstallerWireshark(){
        $desinstallation = new Ansible;
        $desinstallation->desinstaller('wireshark');
        return $this->render('membre/etat_machines/uninstalls/wireshark.html.twig');
    }

    #[Route('/gerer_fonctionnalites/installation/git', name: 'installerGit')]
    public function installerGit(){
        $installation = new Ansible;
        $installation->installer('git');
        return $this->render('membre/etat_machines/installs/git.html.twig');
    }

    #[Route('/gerer_fonctionnalites/desinstallation/git', name: 'desinstallerGit')]
    public function desinstallerGit(){
        $desinstallation = new Ansible;
        $desinstallation->desinstaller('git');
        return $this->render('membre/etat_machines/uninstalls/git.html.twig');
    }


    #[Route('gerer_fonctionnalites/installation/nginx', name: 'installerNginx')]
    public function installerNginx(){
        return $this->render('membre/etat_machines/installs/nginx.html.twig');
    }
}
